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

    $wp_customize->add_setting('ai_librarian_model', array('default' => 'google/gemini-2.0-flash-001', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('ai_librarian_model', array(
        'label' => __('Основная Модель (LLM)', 'city-library'),
        'description' => __('Например: google/gemini-2.0-flash-001', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('ai_librarian_model_fallback', array('default' => 'openai/gpt-4o-mini', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('ai_librarian_model_fallback', array(
        'label' => __('Запасная Модель (Fallback)', 'city-library'),
        'description' => __('Используется при сбоях. Например: openai/gpt-4o-mini', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('ai_librarian_image_model', array('default' => 'openai/dall-e-3', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('ai_librarian_image_model', array(
        'label' => __('Модель для генерации Изображений', 'city-library'),
        'description' => __('Например: openai/dall-e-3, black-forest-labs/flux-schnell', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'select',
        'choices' => array(
            'openai/dall-e-3' => 'DALL-E 3 (OpenAI)',
            'black-forest-labs/flux-schnell' => 'Flux Schnell (Fast)',
            'stabilityai/stable-diffusion-3.5-large' => 'Stable Diffusion 3.5',
            'custom' => 'Указать вручную (Custom)'
        )
    ));

    $wp_customize->add_setting('ai_librarian_image_model_custom', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('ai_librarian_image_model_custom', array(
        'label' => __('Пользовательская модель изображений', 'city-library'),
        'description' => __('Если выше выбрано "Указать вручную", впишите модель OpenRouter здесь.', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'text',
    ));

    // Chat Theme Selection
    $wp_customize->add_setting('ai_chat_theme', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('ai_chat_theme', array(
        'label'    => __('Стиль чата', 'city-library'),
        'section'  => 'virtual_librarian_section',
        'type'     => 'select',
        'choices'  => array(
            'default' => 'Библиотека (по умолчанию)',
            'vk'      => 'ВКонтакте (VK Style)',
            'tg'      => 'Telegram (Светлый)',
            'wa'      => 'WhatsApp (Классика)',
            'mac'     => 'macOS (iMessage)'
        ),
    ));

    // AI Avatar Preset Selection
    $wp_customize->add_setting('ai_librarian_avatar_preset', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('ai_librarian_avatar_preset', array(
        'label'    => __('Готовые Аватары Виртуального Библиотекаря', 'city-library'),
        'section'  => 'virtual_librarian_section',
        'type'     => 'select',
        'choices'  => array(
            'default' => 'Женщина-Библиотекарь 1 (По умолчанию)',
            'preset2' => 'Мужчина-Библиотекарь 1',
            'preset3' => 'Робот-Библиотекарь',
            'preset4' => 'Сова-Библиотекарь',
            'preset5' => 'Абстрактный ИИ',
            'custom'  => 'Своя картинка (ниже)'
        ),
    ));

    // AI Avatar URL
    $wp_customize->add_setting('ai_librarian_avatar', array(
        'default'           => get_template_directory_uri() . '/assets/images/ai-avatar.png',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ai_librarian_avatar', array(
        'label'    => __('Аватар Виртуального Библиотекаря', 'city-library'),
        'section'  => 'virtual_librarian_section',
        'settings' => 'ai_librarian_avatar',
    )));

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
        'description' => __('Инструкция для ИИ, определяющая его характер. Не рекомендуется полностью удалять.', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('ai_persona_prompt_extra', array('default' => '', 'sanitize_callback' => 'sanitize_textarea_field'));
    $wp_customize->add_control('ai_persona_prompt_extra', array(
        'label' => __('Дополнительный промпт (Расширение)', 'city-library'),
        'description' => __('Добавьте свои инструкции, правила и специализации к базовой персоне. Библиотекарь будет неукоснительно соблюдать их.', 'city-library'),
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
        <?php $chat_theme = get_theme_mod('ai_chat_theme', 'default'); ?>
        <div id="ai-chat-window" data-theme="<?php echo esc_attr($chat_theme); ?>" class="hidden w-full sm:w-[400px] bg-white rounded-3xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] border border-slate-200/60 mb-4 overflow-hidden flex-col h-[65vh] max-h-[550px] sm:max-h-none sm:h-[550px] transition-all transform origin-bottom-right theme-<?php echo esc_attr($chat_theme); ?>">
            <!-- Header -->
            <div class="bg-gradient-to-r from-primary to-primary/90 text-white p-4 flex justify-between items-center shadow-sm z-10 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-md shadow-inner overflow-hidden border border-white/20">
                        <img src="<?php echo esc_url(get_city_library_ai_avatar_url()); ?>" alt="Avatar" class="w-full h-full object-cover">
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
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">fullscreen</span>
                    </button>
                    <button id="close-ai-chat" class="text-white/80 hover:text-white hover:bg-white/10 rounded-full transition-all flex items-center justify-center w-8 h-8">
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">close</span>
                    </button>
                </div>
            </div>

            <!-- Messages Area -->
            <div id="ai-chat-messages" class="flex-grow p-4 overflow-y-auto bg-slate-50 flex flex-col gap-4 text-sm custom-scrollbar scroll-smooth">
                <!-- Welcome Message -->
                <div class="flex gap-2">
                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center shrink-0 mt-1 shadow-sm border border-slate-300 overflow-hidden relative">
                        <img src="<?php echo esc_url(get_city_library_ai_avatar_url()); ?>" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <div class="bg-white border border-slate-200/80 p-4 rounded-[1.25rem] rounded-tl-sm shadow-sm hover:shadow-md transition-shadow text-slate-800 text-[14.5px] leading-relaxed">
                        Здравствуйте! Я виртуальный помощник Центральной городской библиотеки. Я могу подсказать, как к нам проехать, узнать часы работы, или помочь вам с написанием сценариев и подбором литературы. Чем могу помочь?
                    </div>
                </div>
            </div>

            <!-- Quick Actions Bar -->
            <div class="px-4 py-2 bg-slate-50 border-t border-slate-100 flex gap-2 overflow-x-auto whitespace-nowrap scrollbar-hide shrink-0 text-xs shadow-inner">
                <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm" data-command="/anniversaries">
                    <span class="material-symbols-outlined text-[14px]" aria-hidden="true">cake</span>
                    Писатели юбиляры
                </button>
                <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm" data-command="/work_plan">
                    <span class="material-symbols-outlined text-[14px]" aria-hidden="true">calendar_today</span>
                    План работы
                </button>
                <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm" data-command="/social_post">
                    <span class="material-symbols-outlined text-[14px]" aria-hidden="true">share</span>
                    Пост в соцсети
                </button>
                <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm" data-command="/script">
                    <span class="material-symbols-outlined text-[14px]" aria-hidden="true">movie_edit</span>
                    Сценарий
                </button>
                <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm" data-command="/bib_list">
                    <span class="material-symbols-outlined text-[14px]" aria-hidden="true">format_list_bulleted</span>
                    Библ. список
                </button>
                <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm" data-command="/inventory">
                    <span class="material-symbols-outlined text-[14px]" aria-hidden="true">inventory</span>
                    Проверка фонда
                </button>
                <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm" data-command="/emoji">
                    <span class="material-symbols-outlined text-[14px]" aria-hidden="true">sentiment_satisfied</span>
                    Смайлики
                </button>
                <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm" data-command="/stat">
                    <span class="material-symbols-outlined text-[14px]" aria-hidden="true">bar_chart</span>
                    Статистика
                </button>
            </div>

            <!-- Input Area -->
            <div class="p-3 bg-white border-t border-slate-100 flex gap-2 shadow-[0_-4px_10px_rgba(0,0,0,0.02)] shrink-0 z-10 relative items-center">
                <input type="file" id="ai-chat-file-input" class="hidden" accept=".txt,.docx">
                <button id="ai-chat-attachment" class="w-10 h-10 text-slate-400 hover:text-primary hover:bg-slate-100 rounded-full flex items-center justify-center transition-colors shrink-0" title="Прикрепить файл (до 20МБ)">
                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">attach_file</span>
                </button>
                <input type="text" id="ai-chat-input" class="w-full bg-slate-100/80 hover:bg-slate-100 focus:bg-white border border-transparent focus:border-primary/50 focus:ring-2 focus:ring-primary/20 rounded-full text-sm px-5 py-3 transition-all duration-300" placeholder="Ваш запрос или /help...">
                <button id="ai-chat-send" class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center hover:bg-yellow-500 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 shrink-0 shadow-md group">
                    <span class="material-symbols-outlined text-xl ml-0.5 group-hover:scale-110 transition-transform duration-300" aria-hidden="true">send</span>
                </button>
            </div>
        </div>

        <!-- Toggle Button -->
        <button id="ai-chat-toggle" class="w-16 h-16 bg-primary text-white rounded-full shadow-[0_8px_30px_rgba(11,121,48,0.4)] hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(11,121,48,0.5)] transition-all duration-300 flex items-center justify-center relative group overflow-hidden">
            <span class="absolute inset-0 bg-gradient-to-tr from-white/0 to-white/20"></span>
            <span class="material-symbols-outlined text-[32px] group-hover:hidden relative z-10" aria-hidden="true">support_agent</span>
            <span class="material-symbols-outlined text-[32px] hidden group-hover:block relative z-10" aria-hidden="true">chat</span>
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
        'nonce' => wp_create_nonce('ai_chat_nonce'),
        'avatar_url' => get_city_library_ai_avatar_url(),
        'user_name' => is_user_logged_in() ? wp_get_current_user()->display_name : 'Гость',
        'is_logged_in' => is_user_logged_in() ? true : false
    ));
}
add_action('wp_enqueue_scripts', 'city_library_enqueue_ai_script');

// 4. AJAX Handler for OpenRouter
function city_library_handle_ai_chat() {
    check_ajax_referer('ai_chat_nonce', 'nonce');

    $api_key = get_theme_mod('openrouter_api_key', '');
    $model = get_theme_mod('ai_librarian_model', 'google/gemini-2.0-flash-001');
    $fallback_model = get_theme_mod('ai_librarian_model_fallback', 'openai/gpt-4o-mini');
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
        $emoji_list = "📚 📖 📗 📘 📙 📓 📔 📒 📕 🕮 📜 📄 📃 📑 🔖 🏷️ ✍️ 🖋️ 🖊️ 🖌️ 🖍️ 📝 ✏️ 📏 📐 🧮 🎓 🏫 🏛️ 🏢 🧑‍🎓 👩‍🎓 👨‍🎓 👨‍🏫 👩‍🏫 🧑‍🏫 💡 🧠 👁️ 🤓 🥸 🧐 🤯 🗂️ 📁 📂 🗄️ 📇 📋 📆 📅 ⌚ ⏳ ⌛ 🕰️ 🏆 🏅 🎖️ 🥇 🥈 🥉 🎭 🎨 🖼️ 🧵 🧶 🎼 🎵 🎶 🎤 🎧 📻 📺 📼 📸 📷 📹 📽️ 🎞️ 🎬 🧩 🎲 ♟️ 🎮 🧸 🪀 🪁 🎈 🪄 🔮 💻 🖥️ 🖨️ 🖱️ 🖲️ 💾 💽 💿 📀 📱 ☎️ 📞 📟 📠 ✉️ 📧 📨 📩 📤 📥 📦 📪 📭 📬 📮 📰 🗞️ 📢 📣 📯 🔔 🔕 🔍 🔎 🔬 🔭 📡 💡 🔦 🏮 🕯️";
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

        $commands .= "🔹 **Инструменты Библиотекаря:**\n";
        $commands .= "- `/anniversaries` — Список писателей-юбиляров на ближайшее время\n";
        $commands .= "- `/work_plan` — Помощь в составлении плана работы\n";
        $commands .= "- `/social_post` — Написать черновик поста для соцсетей\n";
        $commands .= "- `/script` — Создать сценарий мероприятия\n";
        $commands .= "- `/bib_list` — Составить библиографический список\n";
        $commands .= "- `/inventory` — Методическая помощь в проверке фонда\n\n";

        $commands .= "_Также вы можете общаться со мной на свободные темы, связанные с литературой и работой библиотеки!_";

        wp_send_json_success(array('reply' => $commands));
        return;
    }

    // Command: /anniversaries
    if (strpos($clean_msg, '/anniversaries') === 0) {
        $current_month = date_i18n('F');
        $next_month = date_i18n('F', strtotime('+1 month'));

        $user_message = "Ты — библиотекарь. Перечисли список известных русских и зарубежных писателей-юбиляров на {$current_month} и {$next_month} 2025 года.
        ОБЯЗАТЕЛЬНОЕ УСЛОВИЕ: Оформи каждое имя писателя в ответе как интерактивную кнопку HTML: <button class=\"ai-draft-btn bg-primary/10 text-primary px-2 py-1 rounded-md hover:bg-primary/20 transition-all font-bold my-1 block w-full text-left\" data-author=\"ИМЯ ПИСАТЕЛЯ\">ИМЯ ПИСАТЕЛЯ</button>.
        После списка добавь текст: 'Нажмите на имя писателя, чтобы я подготовила черновик статьи или сценария мероприятия о нём.'";
    }

    // Librarian Tools Shortcuts with Subject Support
    if (strpos($clean_msg, '/work_plan') === 0) {
        $subject = trim(mb_substr($user_message, 10));
        $user_message = "Помоги мне составить план работы библиотеки на следующий месяц" . ($subject ? " на тему: '{$subject}'" : "") . ". Предложи интересные темы выставок, мероприятий и онлайн-активностей.";
    }
    if (strpos($clean_msg, '/social_post') === 0) {
        $subject = trim(mb_substr($user_message, 12));
        $user_message = "Напиши интересный и вовлекающий пост для группы библиотеки ВКонтакте" . ($subject ? " про: '{$subject}'" : " о пользе чтения в современном мире") . ". Используй эмодзи и хештеги.";
    }
    if (strpos($clean_msg, '/script') === 0) {
        $subject = trim(mb_substr($user_message, 7));
        $user_message = "Составь подробный сценарий литературного вечера" . ($subject ? ", посвященного теме: '{$subject}'" : ", посвященного современной поэзии") . ". Включи тайминг, список оборудования и идеи для интерактива.";
    }
    if (strpos($clean_msg, '/bib_list') === 0) {
        $subject = trim(mb_substr($user_message, 9));
        $user_message = "Помоги составить библиографический список литературы" . ($subject ? " по теме: '{$subject}'" : " по теме 'История города Владимира'") . ". Укажи 5-7 основных источников с правильным оформлением.";
    }
    if (strpos($clean_msg, '/inventory') === 0) {
        $user_message = "Дай методические рекомендации по проведению плановой проверки библиотечного фонда. На что обратить внимание и какие документы подготовить?";
    }

    // Handle interactive Author Draft command
    if (strpos($clean_msg, '/author') === 0) {
        $author = trim(mb_substr($user_message, 7));
        $user_message = "Подготовь набросок статьи и краткий сценарий мероприятия, посвященного жизни и творчеству писателя: {$author}. Структурируй ответ.";
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
    $original_clean = mb_strtolower(trim(isset($_POST['message']) ? sanitize_text_field($_POST['message']) : ''));
    $is_opac_command = false;
    $opac_query = '';

    if (strpos($original_clean, '/opac') === 0 || strpos($original_clean, 'найди книгу') === 0 || strpos($original_clean, 'поиск в каталоге') === 0) {
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

    if (strpos($original_clean, '/aimg') === 0) {
        $is_draw_command = true;
        $draw_prompt = trim(mb_substr(trim($original_clean), 5));
    } else if (preg_match('/^(нарисуй|сгенерируй|создай картинку|нарисуй мне|сделай картинку)\s+(.+)/u', $original_clean, $matches)) {
        $is_draw_command = true;
        $draw_prompt = trim($matches[2]);
    }

    if ($is_draw_command) {
        if (empty($draw_prompt)) {
            wp_send_json_error(array('reply' => 'Пожалуйста, опишите, что нужно нарисовать. Пример: Нарисуй уютную библиотеку с камином.'));
        }

        // Get user preferred image model from customizer
        $selected_img_model = get_theme_mod('ai_librarian_image_model', 'google/gemini-3.1-flash-image-preview');
        if ($selected_img_model === 'custom') {
            $selected_img_model = get_theme_mod('ai_librarian_image_model_custom', '');
        }

        $image_models = [];
        if (!empty($selected_img_model)) {
            $image_models[] = $selected_img_model;
        }
        // Always add a reliable fallback chain
        $image_models = array_unique(array_merge($image_models, [
            'google/gemini-3.1-flash-image-preview',
            'black-forest-labs/flux-schnell',
            'openai/dall-e-3'
        ]));

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
    $extra_prompt = get_theme_mod('ai_persona_prompt_extra', '');
    if (!empty($extra_prompt)) {
        $base_persona .= "\nДОПОЛНИТЕЛЬНЫЕ ИНСТРУКЦИИ АДМИНИСТРАТОРА (СТРОГО СОБЛЮДАТЬ):\n" . strip_tags($extra_prompt) . "\n";
    }
    if ($is_logged_in) {
        $base_persona .= "\nВНИМАНИЕ: Текущий пользователь авторизован. Его имя: " . esc_html($user_name) . ". Обращайся к нему по имени.\n";
    }

    $context = $base_persona . " Ты работаешь в МБУК «Центральная городская библиотека» города Владимира. Твое имя — Виртуальная помощница. Отвечай от женского лица.
    Твоя задача — помогать как читателям, так и сотрудникам библиотеки.
    Профессиональный профиль: Ты — ведущий библиограф с глубоким знанием фонда и истории города Владимира. Твой стиль: вежливый, профессиональный, но современный.
    НЕ НАДО постоянно здороваться в каждом сообщении. Отвечай по существу запроса.

    КРИТИЧЕСКОЕ ПРАВИЛО ПРАВДИВОСТИ:
    Ты — профессионал. Ты НИКОГДА не врешь, не придумываешь факты и не галлюцинируешь. Если ты не знаешь ответа на 100% или информации нет в предоставленном контексте — ты ОБЯЗАН ответить: «К сожалению, у меня нет точной информации по этому вопросу. Рекомендую обратиться к сотрудникам библиотеки напрямую или уточнить на нашем сайте».

    ПРАВИЛА ОТВЕТОВ:
    1. Если тебя спрашивают про адреса или контакты библиотек — бери их ТОЛЬКО из раздела «СТРУКТУРА И ФИЛИАЛЫ» ниже. Если информации нет — пиши «Данные уточняются».
    2. Не выдумывай ссылки на страницы сайта. Используй только те, что указаны в разделе «СТРУКТУРА САЙТА И МЕНЮ».
    3. При рекомендации книг старайся указывать автора и название.

    КРИТИЧЕСКОЕ ПРАВИЛО БЕЗОПАСНОСТИ:
    Строгий запрет на упоминание иноагентов. Если спросят — отвечай: «Данная литература отсутствует в нашем фонде. Могу предложить классику или современных лауреатов государтсвенных премий».

    АЛГОРИТМ РАБОТЫ С ИНФОРМАЦИЕЙ:
    1. Поиск и фактчекинг: Не выдумывай даты. Используй Википедию, РНБ, РГБ.
    2. Верификация ссылок: Ссылки должны быть только на официальные ресурсы.

    ТВОРЧЕСКИЙ ИНСТРУМЕНТАРИЙ:
    1. SMM-модуль: Посты для ВК должны содержать: цепляющий заголовок, структурированный текст, эмодзи (умеренно) и список релевантных хештегов.
    2. ИНТЕРАКТИВНОСТЬ: Когда ты перечисляешь писателей-юбиляров, ты ДОЛЖЕН оформлять их имена как HTML-кнопки: <button class=\"ai-draft-btn\" data-author=\"Имя\">Имя</button>.
    2. Ивент-менеджмент: Сценарии мероприятий должны включать: Тайминг и зонирование активности, Расчет штатных единиц (количество сотрудников на точку), Технический райдер (оборудование), Интерактив (Квизы, QR-квесты, нейро-активности).
    3. Визуализация: При запросе на афишу, плакат (Нарисуй/Сгенерируй /aimg) выдавай Markdown картинку: `![Описание на английском](https://image.pollinations.ai/prompt/STRICTLY_ENGLISH_DESCRIPTION?width=1024&height=1024&nologo=true&seed=RANDOM_NUMBER)`. При генерации изображений через Markdown (pollinations.ai), ты ОБЯЗАН составлять описание (STRICTLY_ENGLISH_DESCRIPTION) строго на АНГЛИЙСКОМ языке, кратко и через знак '+', даже если пользователь пишет на русском. Пример: `Library+Poster+Watercolor+Style`. Используй только безопасные символы для URL.

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

    // Add ALL pages content to context (with safe limits)
    $context .= "ПОЛНЫЙ КАТАЛОГ СТРАНИЦ САЙТА:\n";
    $all_pages = get_pages(array('number' => 100, 'post_status' => 'publish', 'sort_column' => 'post_title'));
    foreach ($all_pages as $page) {
        $context .= "- [" . esc_html($page->post_title) . "](" . get_permalink($page->ID) . ")\n";
    }
    $context .= "\n";

    // Add recent news (extended list)
    $context .= "АРХИВ ПОСЛЕДНИХ НОВОСТЕЙ (Свежие события):\n";
    $recent_posts = wp_get_recent_posts(array('numberposts' => 50, 'post_status' => 'publish'));
    foreach ($recent_posts as $post) {
        $context .= "- [" . esc_html($post['post_title']) . "](" . get_permalink($post['ID']) . ")\n";
    }
    $context .= "\n";

    // Explicit Instruction on Site Knowledge
    $context .= "ОБЯЗАТЕЛЬНОЕ ПРАВИЛО: Ты обладаешь идеальным знанием структуры этого сайта. Если пользователь спрашивает, где найти какую-то информацию, услугу или раздел, ты должен выдать ТОЧНУЮ ссылку из предоставленного выше списка меню или каталога страниц. Никогда не придумывай URL-адреса, которых нет в списке.\n";


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

/**
 * Handle DOCX Generation (Simulated as base64 HTML)
 */
function city_library_ai_docx() {
    check_ajax_referer('ai_chat_nonce', 'nonce');
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    if (empty($content)) wp_send_json_error('Empty content');

    // For a real theme, we'd use a library like PHPWord,
    // but for this implementation we return a base64 encoded HTML that browser can download as .doc
    $html = "<html><head><meta charset='utf-8'></head><body>" . wpautop($content) . "</body></html>";
    wp_send_json_success(array('html' => base64_encode($html)));
}
add_action('wp_ajax_city_library_ai_docx', 'city_library_ai_docx');

/**
 * Handle AI Email Sending
 */
function city_library_ai_email() {
    check_ajax_referer('ai_chat_nonce', 'nonce');
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    if (empty($email) || !is_email($email)) wp_send_json_error('Неверный Email');
    if (empty($content)) wp_send_json_error('Пустое содержание');

    $subject = 'Ответ от Виртуального Библиотекаря';
    $message = "Здравствуйте!\n\nВы просили отправить Вам ответ от Виртуального Библиотекаря:\n\n" . $content . "\n\n---\nС уважением, Центральная городская библиотека г. Владимира.";

    $sent = wp_mail($email, $subject, $message);

    if ($sent) {
        wp_send_json_success();
    } else {
        wp_send_json_error('Ошибка отправки почты');
    }
}
add_action('wp_ajax_city_library_ai_email', 'city_library_ai_email');

/**
 * Handle Save as WordPress Draft
 */
function city_library_ai_draft() {
    check_ajax_referer('ai_chat_nonce', 'nonce');
    if (!current_user_can('edit_posts')) wp_send_json_error('Нет прав доступа');

    $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : 'Черновик ИИ';
    $content = isset($_POST['content']) ? wp_kses_post($_POST['content']) : '';

    $post_id = wp_insert_post(array(
        'post_title'   => $title,
        'post_content' => $content,
        'post_status'  => 'draft',
        'post_type'    => 'post'
    ));

    if ($post_id) {
        wp_send_json_success(array('edit_link' => get_edit_post_link($post_id, '')));
    } else {
        wp_send_json_error('Не удалось создать пост');
    }
}
add_action('wp_ajax_city_library_ai_draft', 'city_library_ai_draft');

/**
 * Handle Temporary File Analysis (Text Extraction)
 */
function city_library_ai_upload() {
    check_ajax_referer('ai_chat_nonce', 'nonce');

    if (empty($_FILES['file'])) {
        wp_send_json_error('Файл не получен');
    }

    $file = $_FILES['file'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $extracted_text = "";

    if ($ext === 'txt') {
        $extracted_text = file_get_contents($file['tmp_name']);
    } elseif ($ext === 'docx') {
        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            if ($zip->open($file['tmp_name']) === true) {
                if (($index = $zip->locateName('word/document.xml')) !== false) {
                    $xml_content = $zip->getFromIndex($index);
                    $zip->close();
                    $clean_text = strip_tags(str_replace(['<', '>'], [' <', '> '], $xml_content));
                    $extracted_text = preg_replace('/\s+/', ' ', $clean_text);
                }
            }
        }
    } else {
        wp_send_json_error('Неподдерживаемый формат файла. Пожалуйста, используйте .txt или .docx');
    }

    if (empty($extracted_text)) {
        wp_send_json_error('Не удалось извлечь текст из файла или файл пуст.');
    }

    // Limit text size for AI context safety
    $extracted_text = mb_substr(trim($extracted_text), 0, 15000);

    wp_send_json_success(array(
        'text' => $extracted_text,
        'filename' => $file['name']
    ));
}
add_action('wp_ajax_city_library_ai_upload', 'city_library_ai_upload');

// Helper function to get AI avatar URL based on customizer presets
function get_city_library_ai_avatar_url() {
    $preset = get_theme_mod('ai_librarian_avatar_preset', 'default');
    $custom = get_theme_mod('ai_librarian_avatar', '');

    if ($preset === 'custom' && !empty($custom)) {
        return esc_url($custom);
    }

    switch ($preset) {
        case 'preset2':
            return 'https://api.dicebear.com/7.x/avataaars/svg?seed=Jasper&backgroundColor=0b7930'; // Male Librarian
        case 'preset3':
            return 'https://api.dicebear.com/7.x/bottts/svg?seed=LibraryBot&backgroundColor=0b7930'; // Robot
        case 'preset4':
            return 'https://api.dicebear.com/7.x/thumbs/svg?seed=Owl&backgroundColor=0b7930'; // Owl/Mascot (fallback to thumbs if missing)
        case 'preset5':
            return 'https://api.dicebear.com/7.x/identicon/svg?seed=AI&backgroundColor=0b7930'; // Abstract
        case 'default':
        default:
            // Use Avery as specified in memory for the female librarian persona
            return 'https://api.dicebear.com/7.x/avataaars/svg?seed=Avery&backgroundColor=0b7930';
    }
}
