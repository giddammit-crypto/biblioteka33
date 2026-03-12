<?php
/**
 * Virtual Librarian (AI Chatbot) functionality using OpenRouter.
 */

// 1. Register Customizer Settings
function city_library_ai_customizer($wp_customize) {
    $wp_customize->add_section('virtual_librarian_section', array(
        'title' => __('Виртуальный библиотекарь (ИИ)', 'city-library'),
        'priority' => 160,
    ));

    $wp_customize->add_setting('enable_ai_librarian', array('default' => false, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('enable_ai_librarian', array(
        'label' => __('Включить Виртуального библиотекаря', 'city-library'),
        'section' => 'virtual_librarian_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('ai_librarian_test_mode', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('ai_librarian_test_mode', array(
        'label' => __('Режим тестирования (Только для авторизованных)', 'city-library'),
        'description' => __('Если включено, чат увидят только залогиненные администраторы/редакторы.', 'city-library'),
        'section' => 'virtual_librarian_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('openrouter_api_key', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('openrouter_api_key', array(
        'label' => __('OpenRouter API Key', 'city-library'),
        'section' => 'virtual_librarian_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('ai_librarian_model', array('default' => 'google/gemma-2-9b-it:free', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('ai_librarian_model', array(
        'label' => __('Модель ИИ', 'city-library'),
        'section' => 'virtual_librarian_section',
        'type' => 'select',
        'choices' => array(
            'google/gemma-2-9b-it:free' => 'Google: Gemma 2 9B (Free)',
            'google/gemma-7b-it:free' => 'Google: Gemma 7B (Free)',
            'arcee-ai/trinity-large-preview:free' => 'Trinity Large Preview (Free)',
            'mistralai/mistral-7b-instruct:free' => 'Mistral: 7B Instruct (Free)',
            'deepseek/deepseek-chat:free' => 'DeepSeek: Chat (Free)',
            'qwen/qwen-2-7b-instruct:free' => 'Qwen 2 7B Instruct (Free)',
        )
    ));

    $wp_customize->add_setting('ai_librarian_kb_ids', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('ai_librarian_kb_ids', array(
        'label' => __('База знаний (ID файлов)', 'city-library'),
        'description' => __('Введите через запятую ID файлов (TXT, DOCX, ODT) из Медиабиблиотеки для использования в качестве базы знаний ИИ. Пример: 12,34,56. (DOC не поддерживается, конвертируйте в DOCX)', 'city-library'),
        'section' => 'virtual_librarian_section',
        'type' => 'text',
    ));

    // Voice Control Settings
    $wp_customize->add_setting('enable_voice_control', array('default' => false, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('enable_voice_control', array(
        'label' => __('Включить Голосовое Управление', 'city-library'),
        'description' => __('Активация по двойному клику на кнопку версии для слабовидящих.', 'city-library'),
        'section' => 'virtual_librarian_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('voice_control_test_mode', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('voice_control_test_mode', array(
        'label' => __('Голосовое управление только для авторизованных', 'city-library'),
        'section' => 'virtual_librarian_section',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'city_library_ai_customizer');

// Clear KB cache when customizer is saved
function city_library_clear_ai_kb_cache() {
    delete_transient('city_library_ai_kb_text');
}
add_action('customize_save_after', 'city_library_clear_ai_kb_cache');

// Helper function to extract text from files
function city_library_extract_text_from_files($ids_string) {
    if (empty($ids_string)) return '';

    $cached_text = get_transient('city_library_ai_kb_text');
    if ($cached_text !== false) {
        return $cached_text;
    }

    $ids = array_map('intval', explode(',', $ids_string));
    $extracted_text = "";

    foreach ($ids as $id) {
        if (!$id) continue;

        $filepath = get_attached_file($id);
        if (!$filepath || !file_exists($filepath)) continue;

        $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));

        if ($ext === 'txt') {
            $text = file_get_contents($filepath);
            $extracted_text .= wp_strip_all_tags($text) . "\n\n";
        } elseif ($ext === 'docx' || $ext === 'odt') {
            if (class_exists('ZipArchive')) {
                $zip = new ZipArchive();
                if ($zip->open($filepath) === true) {
                    $xml_content = '';
                    if ($ext === 'docx' && ($index = $zip->locateName('word/document.xml')) !== false) {
                        $xml_content = $zip->getFromIndex($index);
                    } elseif ($ext === 'odt' && ($index = $zip->locateName('content.xml')) !== false) {
                        $xml_content = $zip->getFromIndex($index);
                    }
                    $zip->close();

                    if (!empty($xml_content)) {
                        // Replace XML tags with spaces to avoid word merging, then strip
                        $clean_text = strip_tags(str_replace(['<', '>'], [' <', '> '], $xml_content));
                        // Clean up excess whitespace
                        $clean_text = preg_replace('/\s+/', ' ', $clean_text);
                        $extracted_text .= trim($clean_text) . "\n\n";
                    }
                }
            }
        }
    }

    // Cache the extracted text for 12 hours (to avoid unzipping on every chat message)
    // Limit to ~20,000 characters to fit within most free model context windows safely
    $extracted_text = mb_substr($extracted_text, 0, 20000);
    set_transient('city_library_ai_kb_text', $extracted_text, 12 * HOUR_IN_SECONDS);

    return $extracted_text;
}

// 2. Render Frontend Chat Widget
function city_library_render_ai_librarian() {
    if (!get_theme_mod('enable_ai_librarian', false)) {
        return;
    }

    if (get_theme_mod('ai_librarian_test_mode', false) && !is_user_logged_in()) {
        return;
    }

    ?>
    <div id="ai-librarian-widget" class="fixed bottom-6 right-6 z-[100] flex flex-col items-end">
        <!-- Chat Window -->
        <div id="ai-chat-window" class="hidden w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 mb-4 overflow-hidden flex-col h-[500px] transition-all transform origin-bottom-right">
            <!-- Header -->
            <div class="bg-primary text-white p-4 flex justify-between items-center shadow-md z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <span class="material-symbols-outlined text-2xl">support_agent</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm leading-tight">Виртуальный библиотекарь</h4>
                        <span class="text-[10px] text-white/80 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> В сети
                        </span>
                    </div>
                </div>
                <button id="close-ai-chat" class="text-white/80 hover:text-white transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Messages Area -->
            <div id="ai-chat-messages" class="flex-grow p-4 overflow-y-auto bg-slate-50 flex flex-col gap-3 text-sm">
                <!-- Welcome Message -->
                <div class="flex gap-2">
                    <div class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center shrink-0 mt-1">
                        <span class="material-symbols-outlined text-[14px] text-primary">auto_awesome</span>
                    </div>
                    <div class="bg-white border border-slate-200 p-3 rounded-2xl rounded-tl-sm shadow-sm text-slate-700">
                        Здравствуйте! Я виртуальный помощник Центральной городской библиотеки. Я могу подсказать, как к нам проехать, узнать часы работы, или рассказать о свежих новостях. Чем могу помочь?
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-3 bg-white border-t border-slate-100 flex gap-2">
                <input type="text" id="ai-chat-input" class="w-full bg-slate-100 border-transparent focus:border-primary focus:ring-0 rounded-full text-sm px-4 py-2" placeholder="Введите ваш вопрос...">
                <button id="ai-chat-send" class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center hover:bg-yellow-600 transition-colors shrink-0 shadow-md">
                    <span class="material-symbols-outlined text-xl ml-1">send</span>
                </button>
            </div>
        </div>

        <!-- Toggle Button -->
        <button id="ai-chat-toggle" class="w-14 h-14 bg-primary text-slate-900 rounded-full shadow-2xl hover:-translate-y-1 transition-all flex items-center justify-center relative group">
            <span class="material-symbols-outlined text-2xl group-hover:hidden">support_agent</span>
            <span class="material-symbols-outlined text-2xl hidden group-hover:block">chat</span>
            <!-- Notification Dot -->
            <span class="absolute top-0 right-0 w-3.5 h-3.5 bg-red-500 border-2 border-white rounded-full animate-pulse"></span>
        </button>
    </div>
    <?php
}
add_action('wp_footer', 'city_library_render_ai_librarian');

// 3. Enqueue Script
function city_library_enqueue_ai_script() {
    if (!get_theme_mod('enable_ai_librarian', false)) return;
    if (get_theme_mod('ai_librarian_test_mode', false) && !is_user_logged_in()) return;

    wp_enqueue_script('city-library-ai-chat', get_template_directory_uri() . '/js/ai-chat.js', array('jquery'), wp_get_theme()->get('Version'), true);
    wp_localize_script('city-library-ai-chat', 'cl_ai_ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ai_chat_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'city_library_enqueue_ai_script');

// 4. AJAX Handler for OpenRouter
function city_library_handle_ai_chat() {
    check_ajax_referer('ai_chat_nonce', 'nonce');

    $api_key = get_theme_mod('openrouter_api_key', '');
    $model = get_theme_mod('ai_librarian_model', 'google/gemma-7b-it:free');
    $user_message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';

    if (empty($api_key)) {
        wp_send_json_error(array('reply' => 'Извините, библиотекарь временно недоступен (API ключ не настроен).'));
    }

    if (empty($user_message)) {
        wp_send_json_error(array('reply' => 'Пожалуйста, введите сообщение.'));
    }

    // Security Check: Enforce test mode strictly on the server-side
    if (get_theme_mod('ai_librarian_test_mode', true) && !is_user_logged_in()) {
        wp_send_json_error(array('reply' => 'Виртуальный библиотекарь в данный момент доступен только для авторизованных пользователей.'));
    }

    // Build Context (Simulated RAG)
    $context = "Ты профессиональный, вежливый и культурный Виртуальный Библиотекарь Центральной городской библиотеки (biblioteka33.ru). Твоя задача — помогать пользователям. Строго соблюдай этикет. Отвечай кратко и по делу. Не выдумывай факты. Используй ТОЛЬКО предоставленную ниже информацию из базы знаний и новостей.\n\n";

    // Add File Knowledge Base
    $kb_ids = get_theme_mod('ai_librarian_kb_ids', '');
    $file_text = city_library_extract_text_from_files($kb_ids);
    if (!empty($file_text)) {
        $context .= "БАЗА ЗНАНИЙ (Официальные документы):\n" . $file_text . "\n\n";
    }

    // Add library branches info (if configured in customizer)
    $branches_text = get_theme_mod('branches_map_description', 'Главный филиал находится в центре города. Время работы с 9:00 до 19:00.');
    $context .= "ИНФОРМАЦИЯ О БИБЛИОТЕКЕ:\n" . strip_tags($branches_text) . "\n\n";

    // Add Site Map for Navigation Links
    $context .= "СТРУКТУРА САЙТА (Используй эти ссылки, если пользователь спрашивает, где найти информацию):\n";
    $context .= "- Главная страница: " . home_url('/') . "\n";
    $context .= "- Новости: " . home_url('/?news_archive=true') . "\n";
    $context .= "- Афиша / Мероприятия: " . home_url('/#afisha') . "\n";
    $context .= "- Контакты / Филиалы: " . home_url('/#branches') . "\n";
    $context .= "- Важная информация / Услуги: " . home_url('/#important') . "\n\n";

    // Add recent news
    $context .= "СВЕЖИЕ НОВОСТИ:\n";
    $recent_posts = wp_get_recent_posts(array('numberposts' => 3, 'post_status' => 'publish'));
    foreach ($recent_posts as $post) {
        $context .= "- " . $post['post_title'] . "\n";
    }

    $system_prompt = array(
        "role" => "system",
        "content" => $context
    );

    // Call OpenRouter API
    $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'HTTP-Referer'  => home_url(),
            'X-Title'       => 'City Library Theme',
            'Content-Type'  => 'application/json',
        ),
        'body' => wp_json_encode(array(
            'model' => $model,
            'messages' => array(
                $system_prompt,
                array('role' => 'user', 'content' => $user_message)
            )
        )),
        'timeout' => 15
    ));

    if (is_wp_error($response)) {
        wp_send_json_error(array('reply' => 'Произошла ошибка связи. Пожалуйста, попробуйте позже.'));
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['choices'][0]['message']['content'])) {
        $reply = wp_kses_post(nl2br($data['choices'][0]['message']['content']));
        wp_send_json_success(array('reply' => $reply));
    } else {
        wp_send_json_error(array('reply' => 'Библиотекарь затрудняется ответить.'));
    }
}
add_action('wp_ajax_city_library_ai_chat', 'city_library_handle_ai_chat');
add_action('wp_ajax_nopriv_city_library_ai_chat', 'city_library_handle_ai_chat');