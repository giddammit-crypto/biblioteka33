<?php
/**
 * AJAX Handlers for Virtual Librarian
 */

if (!defined('ABSPATH')) {
    exit;
}

// 4. AJAX Handler for OpenRouter
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

        $selected_img_model = get_option('vl_ai_librarian_image_model', 'google/gemini-3.1-flash-image-preview');
        if ($selected_img_model === 'custom') {
            $selected_img_model = get_option('vl_ai_librarian_image_model_custom', '');
        }

        $image_models = [];
        if (!empty($selected_img_model)) {
            $image_models[] = $selected_img_model;
        }
        $image_models = array_unique(array_merge($image_models, [
            'google/gemini-3.1-flash-image-preview',
            'black-forest-labs/flux-schnell',
            'openai/dall-e-3'
        ]));

        $image_url = '';
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
                    'X-Title'       => 'Virtual Librarian Plugin',
                    'Content-Type'  => 'application/json',
                ),
                'body' => wp_json_encode($request_body),
                'timeout' => 60
            );

            $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', $api_args);

            if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
                $body = wp_remote_retrieve_body($response);
                $data = json_decode($body, true);

                if (isset($data['choices'][0]['message']['content'])) {
                    $content = $data['choices'][0]['message']['content'];

                    if (preg_match('/!\[.*?\]\((.*?)\)/', $content, $matches)) {
                        $image_url = $matches[1];
                    } elseif (filter_var($content, FILTER_VALIDATE_URL)) {
                        $image_url = $content;
                    } elseif (preg_match('/https?:\/\/[^\s"\'<>]+/', $content, $matches)) {
                        $image_url = $matches[0];
                    } elseif (strpos($content, 'data:image') === 0 || strpos($content, 'iVBORw0KGgo') === 0) {
                        $image_url = (strpos($content, 'data:image') === 0) ? $content : 'data:image/png;base64,' . $content;
                    }

                    if (!empty($image_url)) break;
                }
            }
        }

        if (!empty($image_url)) {
            $reply = "🎨 Вот ваше изображение по запросу: *{$draw_prompt}*\n\n![Сгенерированное изображение]({$image_url})";
            wp_send_json_success(array('reply' => $reply));
        } else {
            $encoded_prompt = urlencode("Library related, professional, " . $draw_prompt);
            $seed = rand(1, 99999);
            $fallback_url = "https://image.pollinations.ai/prompt/{$encoded_prompt}?width=1024&height=1024&nologo=true&seed={$seed}";
            $reply = "⚠️ Основные нейросети перегружены. Сгенерировано резервным алгоритмом:\n\n![Сгенерированное изображение]({$fallback_url})";
            wp_send_json_success(array('reply' => $reply));
        }
        return;
    }

    $chat_test_mode = get_option('vl_ai_librarian_test_mode', 'yes') === 'yes';
    $voice_test_mode = get_option('vl_voice_control_test_mode', 'yes') === 'yes';
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

    // Build Context
    $base_persona = get_option('vl_ai_persona_prompt', 'Ты Главный библиограф-технолог. Обращайся к пользователю на "Вы", используя идеальный русский литературный язык.');
    $extra_prompt = get_option('vl_ai_persona_prompt_extra', '');
    if (!empty($extra_prompt)) {
        $base_persona .= "\nДОПОЛНИТЕЛЬНЫЕ ИНСТРУКЦИИ АДМИНИСТРАТОРА (СТРОГО СОБЛЮДАТЬ):\n" . strip_tags($extra_prompt) . "\n";
    }
    if ($is_logged_in) {
        $base_persona .= "\nВНИМАНИЕ: Текущий пользователь авторизован. Его имя: " . esc_html($user_name) . ". Обращайся к нему по имени.\n";
    }

    $context = $base_persona . " Ты работаешь в МБУК «Центральная городская библиотека» города Владимира. Твое имя — Виртуальная помощница. Отвечай от женского лица.
    Профессиональный профиль: Ты — ведущий библиограф с глубоким знанием фонда и истории города Владимира. Твой стиль: вежливый, профессиональный, но современный.
    НЕ НАДО постоянно здороваться в каждом сообщении. Отвечай по существу запроса.

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
    2. Ивент-менеджмент: Сценарии мероприятий должны включать: Тайминг и зонирование активности, Расчет штатных единиц (количество сотрудников на точку), Технический райдер (оборудование), Интектив (Квизы, QR-квесты, нейро-активности).
    3. Визуализация: При запросе на афишу, плакат (Нарисуй/Сгенерируй /aimg) выдавай Markdown картинку: `![Описание на английском](https://image.pollinations.ai/prompt/STRICTLY_ENGLISH_DESCRIPTION?width=1024&height=1024&nologo=true&seed=RANDOM_NUMBER)`. При генерации изображений через Markdown (pollinations.ai), ты ОБЯЗАН составлять описание (STRICTLY_ENGLISH_DESCRIPTION) строго на АНГЛИЙСКОМ языке, кратко и через знак '+', даже если пользователь пишет на русском.

    ФОРМАТ ОТВЕТА:
    Никакой «воды». Только таблицы, списки и четкие блоки данных. Если информации нет в сети — честно сообщай об этом, а не имитируй знание.\n\n";

    if (preg_match('/(?:поиск|найди|информация о|напиши|сценарий|план|пост|википедия|ргб|рнб|кто такой|расскажи о|факт|дата)/ui', $clean_msg)) {
        $model = 'openai/gpt-4o-mini-search-preview';
    }

    $knowledge_base = get_option('vl_ai_knowledge');
    if ($knowledge_base && isset($knowledge_base['branches_data'])) {
        $context .= "СТРУКТУРА И ФИЛИАЛЫ МБУК ЦГБ г. ВЛАДИМИРА:\n" . $knowledge_base['branches_data'];
    }

    $kb_ids = get_option('vl_ai_librarian_kb_ids', '');
    if (!empty($kb_ids)) {
        $plugin = new Virtual_Librarian();
        $file_text = $plugin->extract_text_from_files($kb_ids);
        if (!empty($file_text)) {
            $context .= "ВСТРОЕННАЯ БАЗА ЗНАНИЙ:\n" . $file_text . "\n\n";
        }
    }

    $system_prompt = array("role" => "system", "content" => $context);
    $is_voice = isset($_POST['is_voice']) && $_POST['is_voice'] === 'true';

    $request_body = array(
        'model' => $model,
        'messages' => array($system_prompt, array('role' => 'user', 'content' => $user_message))
    );

    if ($is_voice) {
        $request_body['model'] = 'openai/gpt-4o-mini-audio-preview';
        $request_body['modalities'] = array("text", "audio");
        $request_body['audio'] = array("voice" => "nova", "format" => "wav");
    }

    $api_args = array(
        'headers' => array('Authorization' => 'Bearer ' . $api_key, 'HTTP-Referer' => home_url(), 'X-Title' => 'Virtual Librarian Plugin', 'Content-Type' => 'application/json'),
        'body' => wp_json_encode($request_body),
        'timeout' => 30
    );

    $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', $api_args);
    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) >= 400) {
        $request_body['model'] = $fallback_model;
        unset($request_body['modalities']); unset($request_body['audio']);
        $api_args['body'] = wp_json_encode($request_body);
        $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', $api_args);
    }

    if (is_wp_error($response)) {
        wp_send_json_error(array('reply' => 'Произошла ошибка связи.'));
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['choices'][0]['message']['content'])) {
        $reply = $data['choices'][0]['message']['content'];
        $response_data = array('reply' => $reply);
        if ($is_voice && isset($data['choices'][0]['message']['audio']['data'])) {
            $response_data['audio_base64'] = $data['choices'][0]['message']['audio']['data'];
        }
        wp_send_json_success($response_data);
    } else {
        wp_send_json_error(array('reply' => 'Извините, сервис временно недоступен.'));
    }
}

add_action('wp_ajax_city_library_voice_feedback', 'vl_voice_feedback');
add_action('wp_ajax_nopriv_city_library_voice_feedback', 'vl_voice_feedback');

function vl_voice_feedback() {
    check_ajax_referer('ai_chat_nonce', 'nonce');
    $rating = intval($_POST['rating']);
    $feedback = sanitize_textarea_field($_POST['feedback']);
    $to = get_option('vl_feedback_email', 'xxoleg6@yandex.ru');
    $subject = 'Отчет о тестировании Голосового Ассистента (Оценка: ' . $rating . '/5)';
    $message = "Оценка: $rating из 5\n\nОтзыв/Ошибки:\n$feedback";
    wp_mail($to, $subject, $message);
    setcookie('cl_voice_test_active', '', time() - 3600, '/');
    wp_send_json_success(array('message' => 'Спасибо! Ваш отзыв отправлен.'));
}

add_action('wp_ajax_city_library_get_map_shortcode', 'vl_get_map_shortcode');
add_action('wp_ajax_nopriv_city_library_get_map_shortcode', 'vl_get_map_shortcode');

function vl_get_map_shortcode() {
    check_ajax_referer('ai_chat_nonce', 'nonce');
    ob_start();
    include VIRTUAL_LIBRARIAN_PATH . 'templates/branches-map.php';
    $html = ob_get_clean();
    wp_send_json_success(['html' => $html]);
}
