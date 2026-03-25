<?php
/**
 * AJAX Handler for Virtual Librarian
 */

if (!defined('ABSPATH')) exit;

class VL_AJAX_Handler {

    public function init() {
        add_action('wp_ajax_vl_ai_chat', array($this, 'handle_chat'));
        add_action('wp_ajax_nopriv_vl_ai_chat', array($this, 'handle_chat'));
        add_action('wp_ajax_vl_ai_docx', array($this, 'handle_docx'));
        add_action('wp_ajax_vl_ai_email', array($this, 'handle_email'));
        add_action('wp_ajax_vl_ai_compile_draft', array($this, 'handle_compile_draft'));
        add_action('wp_ajax_vl_ai_draft', array($this, 'handle_draft'));
        add_action('wp_ajax_vl_ai_upload', array($this, 'handle_upload'));
        add_action('wp_ajax_vl_voice_feedback', array($this, 'handle_voice_feedback'));
        add_action('wp_ajax_vl_get_map_shortcode', array($this, 'handle_get_map'));
    }

    public function handle_chat() {
        check_ajax_referer('vl_chat_nonce', 'nonce');

        $api_key = get_option('vl_openrouter_api_key', '');
        $model = get_option('vl_ai_model', 'google/gemini-2.0-flash-001');
        $fallback_model = get_option('vl_ai_model_fallback', 'openai/gpt-4o-mini');

        $user_message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';
        $user_name = isset($_POST['user_name']) ? sanitize_text_field($_POST['user_name']) : 'Пользователь';
        $is_logged_in = isset($_POST['is_logged_in']) && $_POST['is_logged_in'] === 'true';
        $image_data = isset($_POST['image_data']) ? $_POST['image_data'] : '';
        $pdf_images = isset($_POST['pdf_images']) ? json_decode(stripslashes($_POST['pdf_images']), true) : array();
        $history = isset($_POST['history']) ? json_decode(stripslashes($_POST['history']), true) : array();
        $persistent_context = isset($_POST['persistent_context']) ? sanitize_textarea_field($_POST['persistent_context']) : '';

        if (empty($user_message) && empty($image_data) && empty($pdf_images)) {
            wp_send_json_error(array('reply' => 'Пожалуйста, введите сообщение.'));
        }

        if (empty($api_key)) {
            wp_send_json_error(array('reply' => 'Извините, библиотекарь временно недоступен (API ключ не настроен).'));
        }

        $clean_msg = trim(mb_strtolower($user_message));

        // 1. Static Commands
        if ($clean_msg === '/emoji') {
            $emoji_list = "📚 📖 📗 📘 📙 📓 📔 📒 📕 🕮 📜 📄 📃 📑 🔖 🏷️ ✍️ 🖋️ 🖊️ 🖌️ 🖍️ 📝 ✏️ 📏 📐 🧮 🎓 🏫 🏛️ 🏢 🧑‍🎓 👩‍🎓 👨‍🎓 👨‍🏫 👩‍🏫 🧑‍🏫 💡 🧠 👁️ 🤓 🥸 🧐 🤯 🗂️ 📁 📂 🗄️ 📇 📋 📆 📅 ⌚ ⏳ ⌛ 🕰️ 🏆 🏅 🎖️ 🥇 🥈 🥉 🎭 🎨 🖼️ 🧵 🧶 🎼 🎵 🎶 🎤 🎧 📻 📺 📼 📸 📷 📹 📽️ 🎞️ 🎬 🧩 🎲 ♟️ 🎮 🧸 🪀 🪁 🎈 🪄 🔮 💻 🖥️ 🖨️ 🖱️ 🖲️ 💾 💽 💿 📀 📱 ☎️ 📞 📟 📠 ✉️ 📧 📨 📩 📤 📥 📦 📪 📭 📬 📮 📰 🗞️ 📢 📣 📯 🔔 🔕 🔍 🔎 🔬 🔭 📡 💡 🔦 🏮 🕯️";
            wp_send_json_success(array('reply' => "### 📚 Библиотечные и канцелярские эмодзи\n\n<div class=\"text-2xl mt-4 leading-loose tracking-widest break-words bg-slate-50 p-4 rounded-xl border border-slate-200\">" . $emoji_list . "</div>"));
        }

        if ($clean_msg === '/stat') {
            global $wpdb;
            $posts = $wpdb->get_results("SELECT post_title, post_date FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date DESC LIMIT 5");
            $reply = "📊 **Последние новости:**\n";
            foreach($posts as $p) $reply .= "- " . esc_html($p->post_title) . " (" . date('d.m.Y', strtotime($p->post_date)) . ")\n";
            wp_send_json_success(array('reply' => $reply));
        }

        // 2. Build Context
        $persona = get_option('vl_ai_persona_prompt', 'Ты Виртуальный библиотекарь. Пиши только на русском.');
        if (!empty($persistent_context)) $persona .= "\n\nИНСТРУКЦИИ ИЗ ФАЙЛОВ:\n" . $persistent_context;

        $messages = array(array("role" => "system", "content" => $persona));

        if (!empty($history)) {
            foreach (array_slice($history, -3) as $h) {
                $messages[] = array('role' => $h['role'], 'content' => $h['content']);
            }
        }

        // 3. User Content (Multimodal or Text)
        if (!empty($image_data) || !empty($pdf_images)) {
            $model = 'google/gemini-2.0-flash-001';
            $content = array(array("type" => "text", "text" => $user_message));
            if (!empty($image_data)) $content[] = array("type" => "image_url", "image_url" => array("url" => $image_data));
            foreach ($pdf_images as $img) $content[] = array("type" => "image_url", "image_url" => array("url" => $img));
            $messages[] = array('role' => 'user', 'content' => $content);
        } else {
            $messages[] = array('role' => 'user', 'content' => $user_message);
        }

        // 4. API Request with Fallback
        $args = array(
            'headers' => array('Authorization' => 'Bearer ' . $api_key, 'Content-Type' => 'application/json', 'HTTP-Referer' => home_url()),
            'body' => wp_json_encode(array('model' => $model, 'messages' => $messages)),
            'timeout' => 45
        );

        $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', $args);

        if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            // Attempt Fallback
            $args['body'] = wp_json_encode(array('model' => $fallback_model, 'messages' => $messages));
            $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', $args);
        }

        if (is_wp_error($response)) wp_send_json_error(array('reply' => 'Сервер ИИ недоступен.'));

        $data = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($data['choices'][0]['message']['content'])) {
            wp_send_json_success(array('reply' => $data['choices'][0]['message']['content']));
        } else {
            wp_send_json_error(array('reply' => 'Ошибка обработки ответа ИИ.'));
        }
    }

    public function handle_docx() {
        check_ajax_referer('vl_chat_nonce', 'nonce');
        $content = "<html><head><meta charset='utf-8'></head><body>" . wpautop($_POST['content']) . "</body></html>";
        wp_send_json_success(array('html' => base64_encode($content)));
    }

    public function handle_email() {
        check_ajax_referer('vl_chat_nonce', 'nonce');
        $sent = wp_mail(sanitize_email($_POST['email']), 'Ответ от Виртуального Библиотекаря', $_POST['content']);
        if ($sent) wp_send_json_success(); else wp_send_json_error('Ошибка отправки');
    }

    public function handle_compile_draft() {
        check_ajax_referer('vl_chat_nonce', 'nonce');
        $combined = "<h1>Сборник материалов ИИ</h1>" . implode('<hr>', (array)$_POST['content']);
        if ($_POST['format'] === 'docx') wp_send_json_success(array('base64' => base64_encode($combined), 'filename' => 'draft.doc'));
        else wp_send_json_success(array('html' => $combined));
    }

    public function handle_draft() {
        check_ajax_referer('vl_chat_nonce', 'nonce');
        if (!current_user_can('edit_posts')) wp_send_json_error('Нет прав');
        $pid = wp_insert_post(array('post_title' => $_POST['title'], 'post_content' => $_POST['content'], 'post_status' => 'draft'));
        if ($pid) wp_send_json_success(array('edit_link' => get_edit_post_link($pid, '')));
        else wp_send_json_error('Ошибка');
    }

    public function handle_upload() {
        check_ajax_referer('vl_chat_nonce', 'nonce');
        $file = $_FILES['file']; $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','webp'])) {
            wp_send_json_success(array('data_url' => 'data:image/'.$ext.';base64,'.base64_encode(file_get_contents($file['tmp_name'])), 'filename' => $file['name']));
        } else {
            wp_send_json_success(array('text' => mb_substr(file_get_contents($file['tmp_name']), 0, 15000), 'filename' => $file['name']));
        }
    }

    public function handle_voice_feedback() { wp_send_json_success(); }
    public function handle_get_map() { wp_send_json_success(array('html' => '<div class="p-4">Карта загружается...</div>')); }
}

new VL_AJAX_Handler();
