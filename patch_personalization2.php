<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

$search_prompt = "    ФОРМАТ ОТВЕТА:\n    Никакой «воды». Только таблицы, списки и четкие блоки данных. Если информации нет в сети — честно сообщай об этом, а не имитируй знание.\\n\\n\";";
$replace_prompt = "    ФОРМАТ ОТВЕТА:\n    Никакой «воды». Только таблицы, списки и четкие блоки данных. Если информации нет в сети — честно сообщай об этом, а не имитируй знание.\\n\\n\";\n    if (\$is_logged_in) {\n        \$context .= \"ВНИМАНИЕ: Текущий пользователь авторизован. Его имя: \" . esc_html(\$user_name) . \". Обращайся к нему по имени.\\n\\n\";\n    } else {\n        \$context .= \"ВНИМАНИЕ: Пользователь не авторизован (Гость).\\n\\n\";\n    }";

if (strpos($content, "\$is_logged_in) {") === false) {
     if (strpos($content, $search_prompt) !== false) {
        $content = str_replace($search_prompt, $replace_prompt, $content);
        echo "Patched system prompt.\n";
     } else {
         echo "Could not find system prompt string to patch.\n";
     }
}
file_put_contents($file, $content);
