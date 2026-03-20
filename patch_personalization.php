<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

// Add user info to localized script
$search_localize = "        'nonce' => wp_create_nonce('ai_chat_nonce'),\n        'avatar_url' => get_theme_mod('ai_librarian_avatar', get_template_directory_uri() . '/assets/images/ai-avatar.png')\n    ));";
$replace_localize = "        'nonce' => wp_create_nonce('ai_chat_nonce'),\n        'avatar_url' => get_theme_mod('ai_librarian_avatar', get_template_directory_uri() . '/assets/images/ai-avatar.png'),\n        'user_name' => is_user_logged_in() ? wp_get_current_user()->display_name : 'Гость',\n        'is_logged_in' => is_user_logged_in() ? true : false\n    ));";

if (strpos($content, "'user_name'") === false) {
    if (strpos($content, $search_localize) !== false) {
        $content = str_replace($search_localize, $replace_localize, $content);
        echo "Patched localization.\n";
    } else {
        echo "Could not find localization string to patch.\n";
    }
}

// Pass user info in the AJAX handler
$search_handler = "    \$user_message = isset(\$_POST['message']) ? sanitize_text_field(\$_POST['message']) : '';";
$replace_handler = "    \$user_message = isset(\$_POST['message']) ? sanitize_text_field(\$_POST['message']) : '';\n    \$user_name = isset(\$_POST['user_name']) ? sanitize_text_field(\$_POST['user_name']) : 'Пользователь';\n    \$is_logged_in = isset(\$_POST['is_logged_in']) && \$_POST['is_logged_in'] === 'true';";

if (strpos($content, "\$user_name = isset(\$_POST['user_name'])") === false) {
    if (strpos($content, $search_handler) !== false) {
        $content = str_replace($search_handler, $replace_handler, $content);
        echo "Patched handler variables.\n";
    } else {
         echo "Could not find handler variables string to patch.\n";
    }
}

// Patch system prompt
$search_prompt = "    // Base Persona Setup\n    \$context = \$persona_prompt . \"\\n\\n\";";
$replace_prompt = "    // Base Persona Setup\n    \$context = \$persona_prompt . \"\\n\\n\";\n    if (\$is_logged_in) {\n        \$context .= \"ВНИМАНИЕ: Текущий пользователь авторизован. Его имя: \" . esc_html(\$user_name) . \". Обращайся к нему по имени.\\n\\n\";\n    } else {\n        \$context .= \"ВНИМАНИЕ: Пользователь не авторизован (Гость).\\n\\n\";\n    }";

if (strpos($content, "\$is_logged_in) {") === false) {
     if (strpos($content, $search_prompt) !== false) {
        $content = str_replace($search_prompt, $replace_prompt, $content);
        echo "Patched system prompt.\n";
     } else {
         echo "Could not find system prompt string to patch.\n";
     }
}

file_put_contents($file, $content);
