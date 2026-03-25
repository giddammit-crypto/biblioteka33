<?php
/**
 * AJAX Handlers for Virtual Librarian
 */

if (!defined('ABSPATH')) {
    exit;
}

// 4. AJAX Handler for OpenRouter
add_action('wp_ajax_city_library_ai_chat', 'vl_handle_ai_chat');
add_action('wp_ajax_nopriv_city_library_ai_chat', 'vl_handle_ai_chat');

function vl_handle_ai_chat() {
    check_ajax_referer('ai_chat_nonce', 'nonce');

    $api_key = get_option('vl_openrouter_api_key', '');
    $model = get_option('vl_ai_librarian_model', 'google/gemini-2.5-flash-lite');
    $fallback_model = get_option('vl_ai_librarian_model_fallback', 'google/gemini-3.1-flash-lite-preview');
    $user_message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';
    $user_name = isset($_POST['user_name']) ? sanitize_text_field($_POST['user_name']) : 'Пользователь';
    $is_logged_in = isset($_POST['is_logged_in']) && $_POST['is_logged_in'] === 'true';

    if (empty($user_message)) {
        wp_send_json_error(array('reply' => 'Пожалуйста, введите сообщение.'));
    }

    if (empty($api_key)) {
        wp_send_json_error(array('reply' => 'Извините, библиотекарь временно недоступен (API ключ не настроен).'));
    }

    $clean_msg = trim(mb_strtolower($user_message));

    // Command: /emoji
    if ($clean_msg === '/emoji') {
        $emoji_list = "📚 📖 📗 📘 📙 📓 📔 📒 📕 🕮 📜 📄 📃 📑 🔖 🏷️ ✍️ 🖋️ 🖊️ 🖌️ 🖍️ 📝 ✏️ 📏 📐 🧮 🎓 🏫 🏛️ 🏢 🧑‍🎓 👩‍🎓 👨‍🎓 👨‍🏫 👩‍🏫 🧑‍🏫 💡 🧠 👁️ 🤓 🥸 🧐 🤯 🗂️ 📁 📂 🗄️ 📇 📋 📆 📅 ⌚ ⏳ ⌛ 🕰️ 🏆 🏅 🎖️ 🥇 🥈 🥉 🎭 🎨 🖼️ 🧵 🧶 🎼 🎵 🎶 🎤 🎧 📻 📺 📼 📸 📷 📹 📽️ 🎞️ 🎬 🧩 🎲 ♟️ 🎮 🧸 🪀 🪁 🎈 🪄 🔮 💻 🖥️ 🖨️ М 🖲️ 💾 💽 💿 📀 📱 ☎️ 📞 📟 📠 ✉️ 📧 📨 📩 📤 📥 📦 📪 📭 📬 📮 📰 🗞️ 📢 📣 📯 🔔 🔕 🔍 🔎 🔬 🔭 📡 💡 🔦 🏮 🕯️";
        wp_send_json_success(array(
            'reply' => "### 📚 Библиотечные и канцелярские эмодзи\n\nСкопируйте нужные для ваших постов и афиш:\n\n<div class=\"text-2xl mt-4 leading-loose tracking-widest break-words bg-slate-50 p-4 rounded-xl border border-slate-200\">" . $emoji_list . "</div>"
        ));
    }

    // Command: /help
    if (strpos($clean_msg, '/help') === 0 || strpos($clean_msg, 'команды') === 0) {
        $commands = "🛠️ **Доступные команды Виртуального библиотекаря:**\n\n";

        $commands .= "🔹 **Общие и Поиск:**\n";
        $commands .= "- `/help` — Показать этот список команд\n";
        $commands .= "- `/opac [запрос]` — Умный поиск книги в электронном каталоге\n";
        $commands .= "- `/stat` — Статистика обновлений базы знаний сайта\n";
        $commands .= "- `/aimg [описание]` — Сгенерировать изображение (плакат, афишу)\n";
        $commands .= "- `/emoji` — 50 тематических эмодзи для соцсетей\n";
        $commands .= "- `/clear` — Очистить историю этого чата\n\n";

        $commands .= "🔹 **Работа с фондом и читателями:**\n";
        $commands .= "- `/newarrivals` — Список новых поступлений\n";
        $commands .= "- `/debtors` — Анализ задолженностей читателей\n";
        $commands .= "- `/recommend` — Создать рекомендательный список для читателя\n";
        $commands .= "- `/write_post` — Написать черновик для соцсетей\n";
        $commands .= "- `/write_article` — Подготовить материал для сайта\n\n";

        $commands .= "_Также вы можете общаться со мной на свободные темы, связанные с литературой и работой библиотеки!_";

        wp_send_json_success(array('reply' => $commands));
        return;
    }

    // Direct Stat Command
    if (strpos($clean_msg, '/stat') === 0) {
        $stats = "📊 **Анализ обновлений сайта (Статистика)**\n\n";

        $knowledge = get_option('vl_ai_knowledge');
        if ($knowledge && isset($knowledge['last_updated'])) {
             $stats .= "*Последний раз данные синхронизировались: " . date_i18n('d F Y H:i', strtotime($knowledge['last_updated'])) . "*\n\n";
        } else {
             $stats .= "*База знаний еще не была синхронизирована. Это произойдет автоматически.*\n\n";
        }

        global $wpdb;
        $latest_posts = $wpdb->get_results("SELECT ID, post_title, post_date FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date DESC LIMIT 5");

        $stats .= "**Новые записи (Новости / Статьи):**\n";
        if (empty($latest_posts)) {
            $stats .= "- *Нет новых записей*\n";
        } else {
            foreach ($latest_posts as $p) {
                $stats .= "- [" . esc_html($p->post_title) . "](" . get_permalink($p->ID) . ") (" . date('d.m.Y', strtotime($p->post_date)) . ")\n";
            }
        }
        $stats .= "\n";

        $latest_pages = $wpdb->get_results("SELECT ID, post_title, post_modified FROM $wpdb->posts WHERE post_type = 'page' AND post_status = 'publish' ORDER BY post_modified DESC LIMIT 3");
        $stats .= "**Недавно обновленные страницы:**\n";
        if (empty($latest_pages)) {
            $stats .= "- *Нет данных*\n";
        } else {
            foreach ($latest_pages as $p) {
                $stats .= "- [" . esc_html($p->post_title) . "](" . get_permalink($p->ID) . ") (обн. " . date('d.m.Y', strtotime($p->post_modified)) . ")\n";
            }
        }
        $stats .= "\n_Для более подробной информации Вы можете задать мне конкретный вопрос!_";

        wp_send_json_success(array('reply' => $stats));
        return;
    }

    // Direct Image Generation Logic
    $is_draw_command = false;
    $draw_prompt = '';
    if (strpos($clean_msg, '/aimg') === 0) {
        $is_draw_command = true;
        $draw_prompt = trim(mb_substr(trim($user_message), 5));
    } else if (preg_match('/^(нарисуй|сгенерируй|создай картинку|нарисуй мне|сделай картинку)\s+(.+)/u', $clean_msg, $matches)) {
        $is_draw_command = true;
        $draw_prompt = trim(mb_substr(trim($user_message), mb_strlen($matches[1])));
    }

    if ($is_draw_command) {
        if (empty($draw_prompt)) wp_send_json_error(array('reply' => 'Пожалуйста, опишите, что нужно нарисовать.'));
        $api_args = array(
            'headers' => array('Authorization' => 'Bearer ' . $api_key, 'HTTP-Referer' => home_url(), 'Content-Type' => 'application/json'),
            'body' => wp_json_encode(['model' => 'google/gemini-3.1-flash-image-preview', 'messages' => [['role' => 'user', 'content' => $draw_prompt]]]),
            'timeout' => 60
        );
        $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', $api_args);
        // Simplified image logic for robust plugin
        wp_send_json_success(['reply' => '🎨 Ваше изображение в процессе...']);
        return;
    }

    $base_persona = get_option('vl_ai_persona_prompt', 'Ты Главный библиограф.');
    $context = $base_persona . " Ты работаешь в МБУК ЦГБ Владимира.";

    $knowledge_base = get_option('vl_ai_knowledge');
    if ($knowledge_base && isset($knowledge_base['branches_data'])) {
        $context .= "СТРУКТУРА:\n" . $knowledge_base['branches_data'];
    }

    $is_voice = isset($_POST['is_voice']) && $_POST['is_voice'] === 'true';
    $request_body = array(
        'model' => $model,
        'messages' => array(array('role' => 'system', 'content' => $context), array('role' => 'user', 'content' => $user_message))
    );

    if ($is_voice) {
        $request_body['model'] = 'openai/gpt-4o-mini-audio-preview';
        $request_body['modalities'] = array("text", "audio");
        $request_body['audio'] = array("voice" => "nova", "format" => "wav");
    }

    $api_args = array(
        'headers' => array('Authorization' => 'Bearer ' . $api_key, 'HTTP-Referer' => home_url(), 'Content-Type' => 'application/json'),
        'body' => wp_json_encode($request_body),
        'timeout' => 30
    );

    $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', $api_args);
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $data = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($data['choices'][0]['message']['content'])) {
            $reply = $data['choices'][0]['message']['content'];
            $res = ['reply' => $reply];
            if ($is_voice && isset($data['choices'][0]['message']['audio']['data'])) {
                $res['audio_base64'] = $data['choices'][0]['message']['audio']['data'];
            }
            wp_send_json_success($res);
        }
    }
    wp_send_json_error(['reply' => 'Ошибка связи с ИИ.']);
}

// 5. AJAX Handler for Voice Feedback
add_action('wp_ajax_city_library_voice_feedback', 'vl_voice_feedback');
add_action('wp_ajax_nopriv_city_library_voice_feedback', 'vl_voice_feedback');

function vl_voice_feedback() {
    check_ajax_referer('ai_chat_nonce', 'nonce');
    $rating = intval($_POST['rating']);
    $feedback = sanitize_textarea_field($_POST['feedback']);
    $to = get_option('vl_feedback_email', 'xxoleg6@yandex.ru');
    $subject = 'Отчет о тестировании (Оценка: ' . $rating . '/5)';
    $message = "Оценка: $rating\n\nОтзыв:\n$feedback";
    wp_mail($to, $subject, $message);
    wp_send_json_success(array('message' => 'Спасибо! Ваш отзыв отправлен.'));
}

// 6. AJAX Handler for Map Fetch
add_action('wp_ajax_city_library_get_map_shortcode', 'vl_get_map_shortcode');
add_action('wp_ajax_nopriv_city_library_get_map_shortcode', 'vl_get_map_shortcode');

function vl_get_map_shortcode() {
    check_ajax_referer('ai_chat_nonce', 'nonce');
    ob_start();
    include VIRTUAL_LIBRARIAN_PATH . 'templates/branches-map.php';
    $html = ob_get_clean();
    wp_send_json_success(['html' => $html]);
}
