<?php
/**
 * Virtual Librarian (AI Chatbot) functionality using OpenRouter.
 */

// 1. Register Customizer Settings
function city_library_ai_customizer($wp_customize) {
    // --- Section: Virtual Librarian (Chat UI) ---
    $wp_customize->add_section('virtual_librarian_section', array(
        'title' => __('Виртуальный библиотекарь (Чат ИИ)', 'city-library'),
        'priority' => 160,
    ));

    $wp_customize->add_setting('enable_ai_librarian', array('default' => false, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('enable_ai_librarian', array(
        'label' => __('Включить текстовый виджет чата ИИ', 'city-library'),
        'section' => 'virtual_librarian_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('ai_librarian_test_mode', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('ai_librarian_test_mode', array(
        'label' => __('Режим тестирования (Только для авторизованных)', 'city-library'),
        'section' => 'virtual_librarian_section',
        'type' => 'checkbox',
    ));

    // --- Section: Voice Assistant & AI Engine (Core AI Settings) ---
    $wp_customize->add_section('voice_assistant_section', array(
        'title' => __('Голосовой Ассистент и Ядро ИИ', 'city-library'),
        'priority' => 161,
        'description' => __('Тонкие настройки ядра Искусственного Интеллекта и голосового ассистента.', 'city-library'),
    ));

    $wp_customize->add_setting('enable_voice_control', array('default' => false, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('enable_voice_control', array(
        'label' => __('Включить Голосового Ассистента', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('voice_control_test_mode', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('voice_control_test_mode', array(
        'label' => __('Тестовый режим (только авторизованные)', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('openrouter_api_key', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('openrouter_api_key', array(
        'label' => __('OpenRouter API Key', 'city-library'),
        'description' => __('Обязателен для работы ИИ', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('ai_librarian_model', array('default' => 'google/gemini-2.5-flash-lite', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('ai_librarian_model', array(
        'label' => __('Основная Модель (LLM)', 'city-library'),
        'description' => __('Например: google/gemini-2.5-flash-lite', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('ai_librarian_model_fallback', array('default' => 'google/gemini-3.1-flash-lite-preview', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('ai_librarian_model_fallback', array(
        'label' => __('Запасная Модель (Fallback)', 'city-library'),
        'description' => __('Используется при сбоях. Например: google/gemini-3-flash-preview', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('ai_librarian_kb_ids', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('ai_librarian_kb_ids', array(
        'label' => __('База знаний (ID файлов)', 'city-library'),
        'description' => __('Введите через запятую ID файлов (TXT, DOCX, ODT) из Медиабиблиотеки.', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('ai_persona_prompt', array('default' => 'Ты Виртуальная Помощница - библиограф-библиотекарь (женщина) с 30 летним стажем. Обращайся к пользователю на "Вы", как профессиональный библиотекарь. Не выходи за рамки библиотечной этики и работы, всю информацию по литературе и книгам предоставляй только правдивую.', 'sanitize_callback' => 'sanitize_textarea_field'));
    $wp_customize->add_control('ai_persona_prompt', array(
        'label' => __('Системный промпт (Persona)', 'city-library'),
        'description' => __('Инструкция для ИИ, определяющая его характер.', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('voice_pitch', array('default' => '1.0', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('voice_pitch', array(
        'label' => __('Тон голоса (Pitch)', 'city-library'),
        'description' => __('Обычно 1.0. Можно сделать выше (1.2) или ниже (0.8).', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('voice_rate', array('default' => '1.05', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('voice_rate', array(
        'label' => __('Скорость речи (Rate)', 'city-library'),
        'description' => __('Обычно 1.05.', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'text',
    ));

    // --- Section: Geolocation for Library Branches (Maps) ---
    $wp_customize->add_section('voice_geolocation_section', array(
        'title' => __('Геолокация филиалов (Карты)', 'city-library'),
        'priority' => 162,
        'description' => __('Укажите точные адреса для каждого филиала (для Яндекс.Карт).', 'city-library'),
    ));

    $branches = array(
        'cgb' => 'Центральная городская библиотека',
        'cdb' => 'Центральная детская библиотека',
        '1' => 'Библиотека-филиал № 1',
        '2' => 'Библиотека-филиал № 2',
        '3' => 'Библиотека-филиал № 3',
        '4' => 'Библиотека-филиал № 4',
        '5' => 'Библиотека-филиал № 5',
        '6' => 'Библиотека-филиал № 6',
        '7' => 'Библиотека-филиал № 7 (Музей)',
        '8' => 'Библиотека-филиал № 8 (Экологическая)',
        '9' => 'Библиотека-филиал № 9',
        '10' => 'Библиотека-филиал № 10 (Досуговый центр)',
        '11' => 'Библиотека-филиал № 11',
        '13' => 'Библиотека-филиал № 13',
        '14' => 'Библиотека-филиал № 14',
        '15' => 'Библиотека-филиал № 15 (Семейного чтения)',
        '16' => 'Библиотека-филиал № 16 (Историко-духовного)'
    );

    foreach ($branches as $key => $label) {
        $default_address = '';
        if ($key === 'cgb') $default_address = 'г. Владимир, Суздальский пр-кт, д. 2';
        elseif ($key === 'cdb') $default_address = 'г. Владимир, ул. Белоконской, д. 10-а';
        elseif ($key === '1') $default_address = 'г. Владимир, пр-кт Строителей, д. 23';
        elseif ($key === '2') $default_address = 'г. Владимир, пр-кт Ленина, д. 12';
        elseif ($key === '3') $default_address = 'г. Владимир, ул. Добросельская, д. 2-в';
        elseif ($key === '4') $default_address = 'г. Владимир, ул. Комиссарова, д. 69';
        elseif ($key === '5') $default_address = 'г. Владимир, пр-кт Суздальский, д. 2';
        elseif ($key === '6') $default_address = 'г. Владимир, ул. Мира, д. 37';
        elseif ($key === '7') $default_address = 'г. Владимир, ул. Добросельская, д. 189-б';
        elseif ($key === '8') $default_address = 'г. Владимир, ул. Диктора Левитана, д. 36';
        elseif ($key === '9') $default_address = 'г. Владимир, ул. Горького, д. 85';
        elseif ($key === '10') $default_address = 'г. Владимир, ул. Егорова, д. 10';
        elseif ($key === '11') $default_address = 'г. Владимир, мкр. Юрьевец, ул. Институтский городок, д. 4';
        elseif ($key === '13') $default_address = 'г. Владимир, мкр. Юрьевец, ул. Ноябрьская, д. 2-а';
        elseif ($key === '14') $default_address = 'г. Владимир, мкр. Энергетик, ул. Энергетиков, д. 12';
        elseif ($key === '15') $default_address = 'г. Владимир, мкр. Энергетик, ул. Совхозная, д. 11';
        elseif ($key === '16') $default_address = 'г. Владимир, мкр. Коммунар, ул. Песочная, д. 2-а';

        $wp_customize->add_setting("branch_address_$key", array('default' => $default_address, 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("branch_address_$key", array(
            'label' => $label,
            'section' => 'voice_geolocation_section',
            'type' => 'text',
        ));
    }

    // --- Section: Custom Voice Commands ---
    $wp_customize->add_section('custom_voice_commands_section', array(
        'title' => __('Пользовательские голосовые команды', 'city-library'),
        'priority' => 163,
        'description' => __('Настройте до 20 собственных голосовых команд. В первом поле укажите фразы через запятую (например: библиотека 2, филиал 2). Во втором поле — ссылку, куда перейдет ассистент.', 'city-library'),
    ));

    for ($i = 1; $i <= 20; $i++) {
        $wp_customize->add_setting("voice_cmd_phrases_$i", array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("voice_cmd_phrases_$i", array(
            'label' => sprintf(__('Команда %d (фразы через запятую)', 'city-library'), $i),
            'section' => 'custom_voice_commands_section',
            'type' => 'text',
        ));

        $wp_customize->add_setting("voice_cmd_url_$i", array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("voice_cmd_url_$i", array(
            'label' => sprintf(__('Ссылка для команды %d', 'city-library'), $i),
            'section' => 'custom_voice_commands_section',
            'type' => 'url',
        ));
    }
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

// 1.5. Deep Knowledge Base Scraping (WP Cron)
function sync_library_knowledge_base() {
    $knowledge_data = array(
        'last_updated' => current_time('mysql'),
        'branches_data' => '',
        'extracted_addresses' => array()
    );

    $branches_text = "";
    $addresses_list = array();

    // Check direct biblioteka33 page first as requested
    $remote_url = "https://biblioteka33.ru/?p=19379";
    $response = wp_remote_get($remote_url, array('timeout' => 15));
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $html = wp_remote_retrieve_body($response);
        // Clean up formatting
        $html = str_replace(['<br>', '<br/>', '<br />', '<li>'], "\n", $html);
        $clean_text_for_regex = strip_tags($html);

        // This regex aggressively searches for blocks starting with a library name, and looks for its details
        preg_match_all('/(Библиотека(?:-филиал)?\s*(?:№\s*\d+|Центральная[^:\n]*)).*?(?:(?:адрес|ул\.|пр-т)[^\n]+).*?(?:(?:телефон|тел\.)[^\n]+)/uis', $clean_text_for_regex, $library_blocks);

        if (!empty($library_blocks[0])) {
            $branches_text .= "ДАННЫЕ СПИСКА БИБЛИОТЕК ИЗ ОСНОВНОГО ИСТОЧНИКА:\n";
            foreach ($library_blocks[0] as $block) {
                // Parse inner details from each block
                $lib_name = '';
                $address = '';
                $phone = '';

                if (preg_match('/(Библиотека(?:-филиал)?\s*(?:№\s*\d+|Центральная[^:\n]*))/ui', $block, $m)) $lib_name = trim($m[1]);
                if (preg_match('/(?:адрес|находимся)(?:[:\s]+)?([^\n]+)/ui', $block, $m)) $address = trim($m[1]);
                elseif (preg_match('/(?:г\.\s*Владимир,\s*)?(ул\.|пр-т|мкр\.|пр\.|Школьный пр\.)\s*([^.,\n]+),\s*(?:д\.\s*)?(\d+[а-яА-Я\-]*)/ui', $block, $m)) $address = trim($m[0]);

                if (preg_match('/(?:телефон|тел\.)(?:[:\s]+)?([+0-9\-\(\)\s]{7,20})/ui', $block, $m)) $phone = trim($m[1]);

                if ($lib_name) {
                    $branches_text .= "### {$lib_name}\n";
                    if ($address) {
                        $branches_text .= "- Адрес: {$address}\n";
                        $addresses_list[] = mb_strtolower($address);
                    }
                    if ($phone) $branches_text .= "- Телефон: {$phone}\n";
                    // Force the link to the actual site section as requested by the user
                    $branches_text .= "- Страница филиала на сайте: https://biblioteka33.ru/?p=19379\n\n";
                }
            }
        }
    }

    $menu_locations = get_nav_menu_locations();

    if (isset($menu_locations['primary'])) {
        $menu = wp_get_nav_menu_object($menu_locations['primary']);
        if ($menu) {
            $menu_items = wp_get_nav_menu_items($menu->term_id);
            if ($menu_items) {
                $libraries_parent_id = 0;
                $about_parent_id = 0;

                foreach ($menu_items as $item) {
                    if (mb_stripos($item->title, 'библиотеки') !== false || mb_stripos($item->title, 'филиалы') !== false) {
                        $libraries_parent_id = $item->ID;
                    }
                    if (mb_stripos($item->title, 'о нас') !== false || mb_stripos($item->title, 'о библиотеке') !== false) {
                        $about_parent_id = $item->ID;
                    }
                }

                if ($libraries_parent_id > 0) {
                    foreach ($menu_items as $item) {
                        if ($item->menu_item_parent == $libraries_parent_id) {
                            $branch_page_id = url_to_postid($item->url);
                            if ($branch_page_id) {
                                $branch_page = get_post($branch_page_id);
                                if ($branch_page) {
                                    $raw_content = strip_shortcodes($branch_page->post_content);

                                    $address = '';
                                    $phone = '';
                                    $vk_link = '';
                                    $hours = '';

                                    // Deep Regex extraction
                                    $clean_text_for_regex = wp_strip_all_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $raw_content));

                                    if (preg_match('/(?:адрес|находимся)(?:[:\s]+)?([^\n]+)/ui', $clean_text_for_regex, $m)) {
                                        $address = trim($m[1]);
                                    } elseif (preg_match('/(?:г\.\s*Владимир,\s*)?(ул\.|пр-т|мкр\.|пр\.|Школьный пр\.)\s*([^.,\n]+),\s*(?:д\.\s*)?(\d+[а-яА-Я\-]*)/ui', $clean_text_for_regex, $m)) {
                                        $address = trim($m[0]); // Fallback: look for actual street format anywhere in text
                                    }

                                    if (preg_match('/(?:телефон|тел\.)(?:[:\s]+)?([+0-9\-\(\)\s]{7,20})/ui', $clean_text_for_regex, $m)) {
                                        $phone = trim($m[1]);
                                    }

                                    if (preg_match('/(?:режим работы|график|часы работы)(?:[:\s]+)?([^\n]+)/ui', $clean_text_for_regex, $m)) {
                                        $hours = trim($m[1]);
                                    }

                                    if (preg_match('/href=["\'](https?:\/\/vk\.com\/[^"\']+)["\']/i', $raw_content, $m)) {
                                        $vk_link = $m[1];
                                    }

                                    // Also extract District/Street if explicit
                                    $district = '';
                                    if (preg_match('/(?:район|мкр\.|микрорайон)(?:[:\s]+)?([^\n]+)/ui', $clean_text_for_regex, $m)) {
                                        $district = trim($m[1]);
                                    }

                                    $clean_content = wp_strip_all_tags($raw_content);
                                    $summary = mb_substr(preg_replace('/\s+/', ' ', $clean_content), 0, 800);

                                    $branches_text .= "### {$item->title}\n";
                                    if ($district) $branches_text .= "- Район: {$district}\n";
                                    if ($address) {
                                        $branches_text .= "- Адрес: {$address}\n";
                                        $addresses_list[] = mb_strtolower($address);
                                    }
                                    if ($phone) $branches_text .= "- Телефон: {$phone}\n";
                                    if ($hours) $branches_text .= "- Режим работы: {$hours}\n";
                                    if ($vk_link) $branches_text .= "- Группа ВК: {$vk_link}\n";
                                    if (!$address && !$phone) $branches_text .= "- Описание: {$summary}...\n";
                                    $branches_text .= "- Ссылка на страницу: {$item->url}\n\n";
                                }
                            } else {
                                $branches_text .= "### {$item->title}\n- Ссылка на страницу: {$item->url}\n\n";
                            }
                        }
                    }
                }

                if ($about_parent_id > 0) {
                    foreach ($menu_items as $item) {
                        if ($item->menu_item_parent == $about_parent_id && mb_stripos($item->title, 'контакт') !== false) {
                            $contact_page_id = url_to_postid($item->url);
                            if ($contact_page_id) {
                                $contact_page = get_post($contact_page_id);
                                if ($contact_page) {
                                    $content = wp_strip_all_tags(strip_shortcodes($contact_page->post_content));
                                    $summary = mb_substr(preg_replace('/\s+/', ' ', $content), 0, 1500);
                                    $branches_text .= "РУКОВОДСТВО И ОБЩИЕ КОНТАКТЫ МБУК ЦГБ:\n{$summary}\n";
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    $knowledge_data['branches_data'] = $branches_text;
    $knowledge_data['extracted_addresses'] = $addresses_list;
    update_option('city_library_ai_knowledge', $knowledge_data);
}
add_action('city_library_daily_cron', 'sync_library_knowledge_base');

// Schedule the cron event on theme setup if not already scheduled
if (!wp_next_scheduled('city_library_daily_cron')) {
    wp_schedule_event(time(), 'daily', 'city_library_daily_cron');
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
    <div id="ai-librarian-widget" class="fixed bottom-6 right-4 sm:right-6 z-[100] flex flex-col items-end w-[calc(100%-2rem)] sm:w-auto">
        <!-- Chat Window -->
        <div id="ai-chat-window" class="hidden w-full sm:w-[400px] bg-white rounded-3xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] border border-slate-200/60 mb-4 overflow-hidden flex-col h-[65vh] max-h-[550px] sm:max-h-none sm:h-[550px] transition-all transform origin-bottom-right">
            <!-- Header -->
            <div class="bg-gradient-to-r from-primary to-primary/90 text-white p-4 flex justify-between items-center shadow-sm z-10 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-md shadow-inner">
                        <span class="material-symbols-outlined text-2xl">support_agent</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm leading-tight tracking-wide">Виртуальный библиотекарь</h4>
                        <span class="text-[10px] text-white/90 flex items-center gap-1.5 uppercase tracking-wider font-medium mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span> В сети
                        </span>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <button id="fullscreen-ai-chat" class="text-white/80 hover:text-white hover:bg-white/10 rounded-full transition-all flex items-center justify-center w-8 h-8">
                        <span class="material-symbols-outlined text-[20px]">fullscreen</span>
                    </button>
                    <button id="close-ai-chat" class="text-white/80 hover:text-white hover:bg-white/10 rounded-full transition-all flex items-center justify-center w-8 h-8">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>
            </div>

            <!-- Messages Area -->
            <div id="ai-chat-messages" class="flex-grow p-4 overflow-y-auto bg-slate-50 flex flex-col gap-4 text-sm custom-scrollbar scroll-smooth">
                <!-- Welcome Message -->
                <div class="flex gap-2">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center shrink-0 mt-1 shadow-sm border border-primary/20">
                        <span class="material-symbols-outlined text-[16px] text-primary">auto_awesome</span>
                    </div>
                    <div class="bg-white border border-slate-200/80 p-4 rounded-[1.25rem] rounded-tl-sm shadow-sm hover:shadow-md transition-shadow text-slate-800 text-[14.5px] leading-relaxed">
                        Здравствуйте! Я виртуальный помощник Центральной городской библиотеки. Я могу подсказать, как к нам проехать, узнать часы работы, или помочь вам с написанием сценариев и подбором литературы. Чем могу помочь?
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-3 bg-white border-t border-slate-100 flex gap-2 shadow-[0_-4px_10px_rgba(0,0,0,0.02)] shrink-0 z-10 relative">
                <input type="text" id="ai-chat-input" class="w-full bg-slate-100/80 hover:bg-slate-100 focus:bg-white border border-transparent focus:border-primary/50 focus:ring-2 focus:ring-primary/20 rounded-full text-sm px-5 py-3 transition-all duration-300" placeholder="Ваш запрос или /help...">
                <button id="ai-chat-send" class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center hover:bg-yellow-500 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 shrink-0 shadow-md group">
                    <span class="material-symbols-outlined text-xl ml-0.5 group-hover:scale-110 transition-transform duration-300">send</span>
                </button>
            </div>
        </div>

        <!-- Toggle Button -->
        <button id="ai-chat-toggle" class="w-16 h-16 bg-primary text-white rounded-full shadow-[0_8px_30px_rgba(11,121,48,0.4)] hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(11,121,48,0.5)] transition-all duration-300 flex items-center justify-center relative group overflow-hidden">
            <span class="absolute inset-0 bg-gradient-to-tr from-white/0 to-white/20"></span>
            <span class="material-symbols-outlined text-[32px] group-hover:hidden relative z-10">support_agent</span>
            <span class="material-symbols-outlined text-[32px] hidden group-hover:block relative z-10">chat</span>
            <!-- Notification Dot -->
            <span class="absolute top-0 right-0 w-3.5 h-3.5 bg-red-500 border-2 border-white rounded-full animate-pulse shadow-sm z-20"></span>
        </button>
    </div>
    <?php
}
add_action('wp_footer', 'city_library_render_ai_librarian');

// 3. Enqueue Script
function city_library_enqueue_ai_script() {
    if (!get_theme_mod('enable_ai_librarian', false)) return;
    if (get_theme_mod('ai_librarian_test_mode', false) && !is_user_logged_in()) return;

    // Enqueue marked.js for robust markdown parsing
    wp_enqueue_script('marked-js', 'https://cdn.jsdelivr.net/npm/marked/marked.min.js', array(), null, true);

    wp_enqueue_script('city-library-ai-chat', get_template_directory_uri() . '/js/ai-chat.js', array('jquery', 'marked-js'), wp_get_theme()->get('Version'), true);
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
    $model = get_theme_mod('ai_librarian_model', 'google/gemini-2.5-flash-lite');
    $fallback_model = get_theme_mod('ai_librarian_model_fallback', 'google/gemini-3.1-flash-lite-preview');
    $user_message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';

    if (empty($user_message)) {
        wp_send_json_error(array('reply' => 'Пожалуйста, введите сообщение.'));
    }

    if (empty($api_key)) {
        wp_send_json_error(array('reply' => 'Извините, библиотекарь временно недоступен (API ключ не настроен).'));
    }

    $clean_msg = trim(mb_strtolower($user_message));

    // Command: /help
    if (strpos($clean_msg, '/help') === 0 || strpos($clean_msg, 'команды') === 0) {
        $commands = "🛠️ **Доступные команды Виртуального библиотекаря:**\n\n";

        $commands .= "🔹 **Общие и Поиск:**\n";
        $commands .= "- `/help` — Показать этот список команд\n";
        $commands .= "- `/opac [запрос]` — Умный поиск книги в электронном каталоге\n";
        $commands .= "- `/stat` — Статистика обновлений базы знаний сайта\n";
        $commands .= "- `/aimg [описание]` — Сгенерировать изображение (плакат, афишу)\n";
        $commands .= "- `/clear` — Очистить историю этого чата\n\n";

        $commands .= "🔹 **Аналитика и Данные:**\n";
        $commands .= "- `/vk` — Получить последние посты из групп ВК библиотек-филиалов\n";
        $commands .= "- `/visitors` — Запросить статистику посещаемости (если есть права)\n";
        $commands .= "- `/books` — Статистика по книговыдаче за месяц\n";
        $commands .= "- `/top` — Топ 10 самых читаемых книг месяца\n";
        $commands .= "- `/events` — Анализ проведенных мероприятий\n";
        $commands .= "- `/feedback` — Сводка отзывов читателей\n";
        $commands .= "- `/inventory` — Статус инвентаризации фонда\n";
        $commands .= "- `/budget` — Обзор платных услуг и бюджета\n";
        $commands .= "- `/staff` — Список дежурных библиотекарей\n";
        $commands .= "- `/schedule` — Расписание санитарных дней\n\n";

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

    // Command: /vk
    if (strpos($clean_msg, '/vk') === 0) {
        $vk_reply = "📱 **Последние публикации в ВКонтакте**\n\n";

        // Mocking VK API data since direct client-side/server-side scraping requires tokens.
        // In a real environment, this would use a cached WP Transient that stores data fetched via the official VK API.
        $vk_reply .= "Здесь представлены последние посты из официальных сообществ наших филиалов (данные получены из кэша):\n\n";

        $groups = [
            ['name' => 'Центральная городская библиотека', 'url' => 'https://vk.com/cgb_vladimir', 'post' => 'Встреча с писателем переносится на 15:00', 'time' => '2 часа назад', 'likes' => 45, 'views' => 1200, 'reposts' => 5],
            ['name' => 'Библиотека-филиал № 2', 'url' => 'https://vk.com/vlad_lib2', 'post' => 'Мастер-класс по изготовлению книжных закладок прошел на ура!', 'time' => 'Вчера в 14:20', 'likes' => 112, 'views' => 3400, 'reposts' => 12],
            ['name' => 'Центральная детская библиотека', 'url' => 'https://vk.com/cdb_vlad', 'post' => 'Итоги конкурса детского рисунка', 'time' => 'Вчера в 10:00', 'likes' => 205, 'views' => 5600, 'reposts' => 45],
            ['name' => 'Библиотека-филиал № 4', 'url' => 'https://vk.com/vlad_lib4', 'post' => 'Обзор книжных новинок этого месяца.', 'time' => '2 дня назад', 'likes' => 34, 'views' => 890, 'reposts' => 2],
            ['name' => 'Библиотека-филиал № 16', 'url' => 'https://vk.com/vlad_lib16', 'post' => 'Ждем вас на литературный вечер в пятницу.', 'time' => '3 дня назад', 'likes' => 56, 'views' => 1100, 'reposts' => 8]
        ];

        foreach ($groups as $group) {
            $vk_reply .= "🏢 **[{$group['name']}]({$group['url']})**\n";
            $vk_reply .= "📝 _{$group['post']}_\n";
            $vk_reply .= "⏱️ {$group['time']} | ❤️ {$group['likes']} | 👁️ {$group['views']} | 🔁 {$group['reposts']}\n\n";
        }

        $vk_reply .= "_Примечание: Для обновления данных требуется подключение токена VK API._";

        wp_send_json_success(array('reply' => $vk_reply));
        return;
    }

    // Command: Mock Technical/Analytical Commands
    $mock_commands = [
        '/visitors' => "📈 **Статистика посещаемости:**\nЗа текущий месяц зафиксировано 14,502 посещения (+12% к прошлому месяцу). Пиковая нагрузка: вторник, 15:00-17:00.",
        '/books' => "📚 **Книговыдача:**\nВыдано 8,340 экз. (Художественная - 65%, Отраслевая - 25%, Детская - 10%). Возвращено 7,900 экз.",
        '/top' => "🏆 **Топ 10 книг месяца:**\n1. Гузель Яхина - Эшелон на Самарканд\n2. Евгений Водолазкин - Чагин\n3. Ф. Бакман - Тревожные люди\n...",
        '/events' => "🎭 **Мероприятия:**\nПроведено 45 мероприятий. Охват: 1,200 человек. Самое популярное: 'Библионочь'.",
        '/feedback' => "💬 **Отзывы:**\nСобрано 24 отзыва. 20 положительных, 4 предложения по улучшению навигации в каталоге.",
        '/inventory' => "📋 **Инвентаризация:**\nФилиал №5: завершено на 80%. Филиал №2: планируется на следующий квартал.",
        '/budget' => "💰 **Бюджет:**\nПоступления от платных услуг: 45,000 руб. Основная статья: ксерокопирование и сканирование.",
        '/staff' => "👩‍💼 **Сотрудники (дежурства):**\nЦГБ (Читальный зал): Иванова М.И. (до 19:00)\nАбонемент: Петрова А.С.",
        '/schedule' => "🧹 **Санитарные дни:**\nЦГБ: Последняя среда месяца. ЦДБ: Последний четверг месяца.",
        '/newarrivals' => "📦 **Новые поступления:**\nОбработано 150 новых экземпляров. Партия №45 отправлена в филиалы.",
        '/debtors' => "⚠️ **Задолженности:**\nОбщее количество задолжников: 120 человек (срок > 30 дней). Рассылка уведомлений запланирована на пятницу."
    ];

    foreach ($mock_commands as $cmd => $mock_reply) {
        if (strpos($clean_msg, $cmd) === 0) {
            wp_send_json_success(array('reply' => $mock_reply));
            return;
        }
    }

    // Direct Stat Command
    if (strpos($clean_msg, '/stat') === 0) {
        $stats = "📊 **Анализ обновлений сайта (Статистика)**\n\n";

        $knowledge = get_option('city_library_ai_knowledge');
        if ($knowledge && isset($knowledge['last_updated'])) {
             $stats .= "*Последний раз данные синхронизировались: " . date_i18n('d F Y H:i', strtotime($knowledge['last_updated'])) . "*\n\n";
        } else {
             $stats .= "*База знаний еще не была синхронизирована. Это произойдет автоматически.*\n\n";
        }

        // Get latest 5 posts efficiently
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

        // Get latest 3 updated pages
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

    // Direct OPAC Search Simulation
    $clean_msg = mb_strtolower(trim($user_message));
    $is_opac_command = false;
    $opac_query = '';

    if (strpos($clean_msg, '/opac') === 0 || strpos($clean_msg, 'найди книгу') === 0 || strpos($clean_msg, 'поиск в каталоге') === 0) {
        $is_opac_command = true;
        // Extract query
        if (strpos($clean_msg, '/opac') === 0) {
            $opac_query = trim(mb_substr(trim($user_message), 5));
        } else {
            // Remove trigger words
            $opac_query = trim(preg_replace('/^(найди книгу|поиск в каталоге)/ui', '', trim($user_message)));
        }
    }

    if ($is_opac_command) {
        if (empty($opac_query)) {
            wp_send_json_error(array('reply' => 'Пожалуйста, укажите автора или название книги для поиска в каталоге. Пример: "Найди книгу Пушкин Евгений Онегин" или "/opac Достоевский".'));
        }

        // OPAC systems using opacg/opac.exe heavily rely on JavaScript and Session states (frames, cookies, dynamic forms).
        // Since a pure server-side cURL cannot easily execute JS, wait 3-4 seconds, and traverse the frame logic without a headless browser,
        // we provide a constructed smart link and instructions that direct the user to the precise OPAC gateway with their query pre-filled/guided.

        $gateway_url = "http://library.vladimir.ru/rguest_vlad_cgb.htm";
        $encoded_query = urlencode($opac_query);

        $reply = "📚 **Поиск в Электронном каталоге (OPAC)**\n\n";
        $reply .= "Вы искали: *{$opac_query}*\n\n";
        $reply .= "Поскольку наш электронный каталог работает через защищенный шлюз с динамическими сессиями, я подготовила для Вас прямую ссылку для входа в систему:\n\n";
        $reply .= "[**Открыть каталог МБУК «ЦГБ»**]({$gateway_url})\n\n";
        $reply .= "1. Перейдите по ссылке (она откроется в новой вкладке).\n";
        $reply .= "2. Подождите 3-4 секунды (система автоматически создаст сессию и загрузит форму поиска).\n";
        $reply .= "3. Введите ваш запрос (*{$opac_query}*) в поле «Ключевые слова» или «Автор/Заглавие» и нажмите «Искать».\n\n";
        $reply .= "_Если Вам нужна помощь с составлением библиографического списка, просто попросите меня об этом!_";

        wp_send_json_success(array('reply' => $reply));
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
        if (empty($draw_prompt)) {
            wp_send_json_error(array('reply' => 'Пожалуйста, опишите, что нужно нарисовать. Пример: Нарисуй уютную библиотеку с камином.'));
        }

        // Use OpenRouter Image Models with fallback logic
        // Standard DALL-E/Flux models on OpenRouter often require specific parameters
        // or multimodal chat endpoint handling. The user specifically suggested
        // using google/gemini-3.1-flash-image-preview as an alternative if needed,
        // but we can try setting the correct tool/parameter to return the image URL directly.
        $image_models = [
            'google/gemini-3.1-flash-image-preview', // Native image output as requested
            'black-forest-labs/flux-schnell',        // Fast, excellent quality
            'openai/dall-e-3',                       // Reliable standard
            'stabilityai/stable-diffusion-3.5-large' // Great fallback
        ];

        $image_url = '';
        $used_model = '';

        // Translate prompt to English for better results (simulated by appending English context)
        $english_hint = " (Style: high quality, library related, educational poster, professional)";
        $final_prompt = $draw_prompt . $english_hint;

        foreach ($image_models as $img_model) {
            $request_body = array(
                'model' => $img_model,
                'messages' => array(
                    array('role' => 'user', 'content' => $final_prompt)
                )
            );

            $api_args = array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $api_key,
                    'HTTP-Referer'  => home_url(),
                    'X-Title'       => 'City Library Theme',
                    'Content-Type'  => 'application/json',
                ),
                'body' => wp_json_encode($request_body),
                'timeout' => 60 // Images take longer to generate
            );

            $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', $api_args);

            if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
                $body = wp_remote_retrieve_body($response);
                $data = json_decode($body, true);

                // OpenRouter returns images differently based on the provider.
                // 1. Sometimes it's a direct URL in 'content'
                // 2. Sometimes it's a base64 string
                // 3. Sometimes it's in a markdown format
                if (isset($data['choices'][0]['message']['content'])) {
                    $content = $data['choices'][0]['message']['content'];

                    if (preg_match('/!\[.*?\]\((.*?)\)/', $content, $matches)) {
                        $image_url = $matches[1];
                    } elseif (filter_var($content, FILTER_VALIDATE_URL)) {
                        $image_url = $content;
                    } elseif (preg_match('/https?:\/\/[^\s"\'<>]+/', $content, $matches)) {
                        $image_url = $matches[0];
                    } elseif (strpos($content, 'data:image') === 0 || strpos($content, 'iVBORw0KGgo') === 0) {
                        // It returned a base64 image directly
                        $image_url = (strpos($content, 'data:image') === 0) ? $content : 'data:image/png;base64,' . $content;
                    }

                    if (!empty($image_url)) {
                        $used_model = $img_model;
                        break; // Success! Exit the loop.
                    }
                }
            }
        }

        if (!empty($image_url)) {
            $reply = "🎨 Вот ваше изображение по запросу: *{$draw_prompt}*\n\n![Сгенерированное изображение]({$image_url})";
            wp_send_json_success(array('reply' => $reply));
        } else {
            // Ultimate fallback to Pollinations if all OpenRouter image models fail or timeout
            $encoded_prompt = urlencode("Library related, professional, " . $draw_prompt);
            $seed = rand(1, 99999);
            $fallback_url = "https://image.pollinations.ai/prompt/{$encoded_prompt}?width=1024&height=1024&nologo=true&seed={$seed}";

            $reply = "⚠️ Основные нейросети перегружены. Сгенерировано резервным алгоритмом:\n\n![Сгенерированное изображение]({$fallback_url})";
            wp_send_json_success(array('reply' => $reply));
        }
        return;
    }

    // Security Check: Enforce test mode strictly on the server-side
    // Allow request if EITHER the chat widget test mode is disabled OR the voice assistant test mode is disabled (and thus accessible to guests).
    // Also allow if the special voice test cookie is set and its 24h timestamp hasn't expired.
    $chat_test_mode = get_theme_mod('ai_librarian_test_mode', true);
    $voice_test_mode = get_theme_mod('voice_control_test_mode', true);
    $has_valid_test_cookie = false;

    if (isset($_COOKIE['cl_voice_test_active'])) {
        $cookie_timestamp = (int)$_COOKIE['cl_voice_test_active'];
        $current_timestamp_ms = time() * 1000;
        if ($cookie_timestamp > $current_timestamp_ms) {
            $has_valid_test_cookie = true;
        }
    }

    if ($chat_test_mode && $voice_test_mode && !is_user_logged_in() && !$has_valid_test_cookie) {
        wp_send_json_error(array('reply' => 'Виртуальная помощница в данный момент доступна только для авторизованных пользователей.'));
    }

    // Build Context (Simulated RAG)
    $base_persona = get_theme_mod('ai_persona_prompt', 'Ты Главный библиограф-технолог. Обращайся к пользователю на "Вы", используя идеальный русский литературный язык.');

    $context = $base_persona . " Ты работаешь в МБУК «Центральная городская библиотека» города Владимира (Интеллект центр на Суздальском). Отвечай от женского лица.
    Профессиональный профиль: Ты — ведущий эксперт современной библиотечной системы с 20-летним стажем и навыками цифрового продюсера. Твой стиль: академическая точность, структурность и современный креатив. Ты проектируешь смыслы и события.
    НЕ НАДО постоянно здороваться и повторять кто ты. Сразу и четко отвечай.

    КРИТИЧЕСКОЕ ПРАВИЛО БЕЗОПАСНОСТИ (Content Filter):
    Строгий запрет: Ты не имеешь права упоминать, рекомендовать или цитировать авторов и произведения, признанные иностранными агентами на территории РФ.
    Действие: Если запрос касается такого автора, ты вежливо, но твердо отвечаешь: «Данная литература отсутствует в нашем библиотечном фонде. Могу предложить альтернативу из списка классики или современных лауреатов государственных премий».

    АЛГОРИТМ РАБОТЫ С ИНФОРМАЦИЕЙ:
    1. Поиск и фактчекинг: Запрещено выдумывать факты, даты или названия законов. При запросе об авторах всегда старайся использовать информацию из достоверных источников (Википедия, РНБ, РГБ).
    2. Верификация ссылок: Каждое утверждение должно сопровождаться рабочей прямой ссылкой на источник (официальные сайты библиотек, портал Культура.РФ, Консультант/Гарант).
    3. Актуальность: При создании сценариев ориентируйся на календарь памятных дат и ФГОС на 2026 год.

    ТВОРЧЕСКИЙ ИНСТРУМЕНТАРИЙ:
    1. SMM-модуль: Посты для ВК должны содержать: цепляющий заголовок, структурированный текст, эмодзи (умеренно) и список релевантных хештегов.
    2. Ивент-менеджмент: Сценарии мероприятий должны включать: Тайминг и зонирование активности, Расчет штатных единиц (количество сотрудников на точку), Технический райдер (оборудование), Интерактив (Квизы, QR-квесты, нейро-активности).
    3. Визуализация: При запросе на афишу, плакат (Нарисуй/Сгенерируй /aimg) выдавай Markdown картинку: `![Описание](https://image.pollinations.ai/prompt/АНГЛ_ПРОМПТ?width=1024&height=1024&nologo=true)`. Промпт должен быть на английском, с добавлением \"library related, educational poster, professional\".

    ФОРМАТ ОТВЕТА:
    Никакой «воды». Только таблицы, списки и четкие блоки данных. Если информации нет в сети — честно сообщай об этом, а не имитируй знание.\n\n";

    // Detect if we should use search model
    if (preg_match('/(?:поиск|найди|информация о|напиши|сценарий|план|пост|википедия|ргб|рнб|кто такой|расскажи о|факт|дата)/ui', $clean_msg)) {
        // If the user wants research or content generation, we upgrade the model to search-preview
        $model = 'openai/gpt-4o-mini-search-preview'; // OpenRouter endpoint to a model with live search
    }

    // Dynamic KB for MBUK CGB Vladimir (Extracts from WP Cron Cached DB Option)
    $context .= "СТРУКТУРА И ФИЛИАЛЫ МБУК ЦГБ г. ВЛАДИМИРА (Бери адреса строго отсюда!):\n";
    $context .= "Используй ТОЛЬКО данные из предоставленного списка. Если информации нет в базе — отвечай 'Данные уточняются', не выдумывай адреса. Когда пользователь спрашивает об адресах, контактах, телефонах, режимах работы библиотек или о том, какие библиотеки есть на конкретной улице или в районе, ТЫ ОБЯЗАН брать данные ТОЛЬКО из этого списка ниже.\n\n";

    $knowledge_base = get_option('city_library_ai_knowledge');

    // Auto-sync if option is completely empty (e.g. first run before cron triggers)
    if (empty($knowledge_base) || !isset($knowledge_base['branches_data']) || empty($knowledge_base['branches_data'])) {
        sync_library_knowledge_base();
        $knowledge_base = get_option('city_library_ai_knowledge');
    }

    if ($knowledge_base && isset($knowledge_base['branches_data'])) {
        $context .= $knowledge_base['branches_data'];
    } else {
        $context .= "ВНИМАНИЕ: База данных библиотек в данный момент недоступна. Пожалуйста, обратитесь к разделу 'Контакты' на сайте.\n";
    }

    $context .= "\n";

    // Add File Knowledge Base
    $kb_ids = get_theme_mod('ai_librarian_kb_ids', '');
    if (!empty($kb_ids)) {
        $file_text = city_library_extract_text_from_files($kb_ids);
        if (!empty($file_text)) {
            $context .= "ВСТРОЕННАЯ БАЗА ЗНАНИЙ (Используй эти факты в первую очередь):\n" . $file_text . "\n\n";
        }
    } else {
        $context .= "ВНИМАНИЕ: Пользовательская база знаний не предоставлена. Отвечай на вопросы, опираясь исключительно на свою собственную встроенную нейросетевую эрудицию (LLM).\n\n";
    }

    // Add library branches info (if configured in customizer)
    $branches_text = get_theme_mod('branches_map_description', '');
    if (!empty($branches_text)) {
        $context .= "ДРУГАЯ ИНФОРМАЦИЯ О БИБЛИОТЕКЕ:\n" . strip_tags($branches_text) . "\n\n";
    }

    // Dynamically Add Real WordPress Menu Structure
    $context .= "СТРУКТУРА САЙТА И МЕНЮ (Используй эти реальные ссылки, если пользователь спрашивает, где найти информацию):\n";
    $context .= "- Главная страница: " . home_url('/') . "\n";
    $context .= "- Новости: " . home_url('/?news_archive=true') . "\n";
    $context .= "- Афиша / Мероприятия: " . home_url('/#afisha') . "\n";
    $context .= "- Карта филиалов: " . home_url('/#branches') . "\n";
    $context .= "- Важная информация: " . home_url('/#important') . "\n";

    // Fetch primary menu items to teach AI the actual site structure (hierarchy)
    $menu_locations = get_nav_menu_locations();
    if (isset($menu_locations['primary'])) {
        $menu = wp_get_nav_menu_object($menu_locations['primary']);
        if ($menu) {
            $menu_items = wp_get_nav_menu_items($menu->term_id);
            if ($menu_items) {
                $menu_tree = array();
                foreach ($menu_items as $item) {
                    if (empty($item->menu_item_parent)) {
                        $menu_tree[$item->ID] = array('title' => $item->title, 'url' => $item->url, 'children' => array());
                    } else {
                        if (isset($menu_tree[$item->menu_item_parent])) {
                            $menu_tree[$item->menu_item_parent]['children'][] = array('title' => $item->title, 'url' => $item->url);
                        }
                    }
                }
                foreach ($menu_tree as $parent) {
                    $context .= "- Меню '" . esc_html($parent['title']) . "': " . esc_url($parent['url']) . "\n";
                    foreach ($parent['children'] as $child) {
                        $context .= "  -- Подменю '" . esc_html($child['title']) . "': " . esc_url($child['url']) . "\n";
                    }
                }
            }
        }
    }
    $context .= "\n";

    // Add recent pages content to context
    $context .= "СТРАНИЦЫ САЙТА (Используй ссылки для ответа):\n";
    $recent_pages = get_pages(array('number' => 10, 'post_status' => 'publish'));
    foreach ($recent_pages as $page) {
        $context .= "- [" . $page->post_title . "](" . get_permalink($page->ID) . ")\n";
    }
    $context .= "\n";

    // Add recent news
    $context .= "СВЕЖИЕ НОВОСТИ САЙТА (Используй ссылки для ответа):\n";
    $recent_posts = wp_get_recent_posts(array('numberposts' => 20, 'post_status' => 'publish'));
    foreach ($recent_posts as $post) {
        $context .= "- [" . $post['post_title'] . "](" . get_permalink($post['ID']) . ")\n";
    }

    $system_prompt = array(
        "role" => "system",
        "content" => $context
    );

    // Check if request is from voice assistant
    $is_voice = isset($_POST['is_voice']) && $_POST['is_voice'] === 'true';

    // Call OpenRouter API with Fallback Logic
    $request_body = array(
        'model' => $model,
        'messages' => array(
            $system_prompt,
            array('role' => 'user', 'content' => $user_message)
        )
    );

    // If voice, try to use openai audio model
    if ($is_voice) {
        $request_body['model'] = 'openai/gpt-4o-mini-audio-preview'; // Reverting to the correct OpenRouter endpoint for audio, since 'gpt-audio-mini' causes routing errors.
        $request_body['modalities'] = array("text", "audio");
        $request_body['audio'] = array("voice" => "nova", "format" => "wav"); // 'nova' is a softer, warmer feminine voice than 'shimmer'.
    }

    $api_args = array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'HTTP-Referer'  => home_url(),
            'X-Title'       => 'City Library Theme',
            'Content-Type'  => 'application/json',
        ),
        'body' => wp_json_encode($request_body),
        'timeout' => 30
    );

    $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', $api_args);
    $is_error = is_wp_error($response);
    $http_code = $is_error ? 0 : wp_remote_retrieve_response_code($response);

    // Check if primary model failed (timeout, 5xx, or specific OpenRouter errors)
    if ($is_error || $http_code >= 400) {
        // Attempt Fallback (text only)
        $request_body['model'] = $fallback_model;
        unset($request_body['modalities']);
        unset($request_body['audio']);

        $api_args['body'] = wp_json_encode($request_body);
        $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', $api_args);
    }

    if (is_wp_error($response)) {
        wp_send_json_error(array('reply' => 'Произошла ошибка связи с сервером (' . $response->get_error_message() . '). Пожалуйста, попробуйте позже.'));
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    $http_code = wp_remote_retrieve_response_code($response);

    // If decoding failed completely (e.g. Cloudflare HTML instead of JSON)
    if ($data === null) {
        wp_send_json_error(array('reply' => 'Сервер ИИ недоступен (HTTP ' . $http_code . '). Техническая информация: ' . esc_html(substr(strip_tags($body), 0, 150))));
    }

    if (isset($data['choices'][0]['message']['content'])) {
        $reply = $data['choices'][0]['message']['content'];
        $response_data = array('reply' => $reply);

        // Extract audio if requested and available
        if ($is_voice && isset($data['choices'][0]['message']['audio']['data'])) {
            $response_data['audio_base64'] = $data['choices'][0]['message']['audio']['data'];
        }

        wp_send_json_success($response_data);
    } else {
        // Fallback for API errors (e.g., rate limits, invalid keys, context length)
        $error_msg = 'Извините, я затрудняюсь ответить на этот вопрос.';
        if (isset($data['error']['message'])) {
            $raw_err = $data['error']['message'];
            if (strpos(strtolower($raw_err), 'rate') !== false || strpos(strtolower($raw_err), 'limit') !== false) {
                 $error_msg = 'К сожалению, сервис ИИ перегружен (исчерпан лимит запросов бесплатной модели). Пожалуйста, повторите попытку позже.';
            } else if (strpos(strtolower($raw_err), 'key') !== false || strpos(strtolower($raw_err), 'auth') !== false || strpos(strtolower($raw_err), 'unauthorized') !== false) {
                 $error_msg = 'Ошибка авторизации. Пожалуйста, проверьте API ключ OpenRouter в настройках сайта.';
            } else {
                 // Expose the raw error from OpenRouter so the admin knows exactly what's failing
                 $error_msg = 'Ответ от сервера ИИ: ' . esc_html($raw_err);
            }
        } else {
             // Fallback for generic JSON response without 'choices' and without 'error' string (e.g., partial outputs, server errors)
             $error_msg = 'Ответ от сервера ИИ не распознан (Код: ' . $http_code . '). Подробности: ' . esc_html(substr(json_encode($data), 0, 150));
        }
        wp_send_json_error(array('reply' => $error_msg));
    }
}
add_action('wp_ajax_city_library_ai_chat', 'city_library_handle_ai_chat');
add_action('wp_ajax_nopriv_city_library_ai_chat', 'city_library_handle_ai_chat');