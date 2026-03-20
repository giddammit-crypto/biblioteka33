<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

$search = "    // Dynamic KB for MBUK CGB Vladimir (Extracts from WP Cron Cached DB Option)\n    \$context .= \"СТРУКТУРА И ФИЛИАЛЫ МБУК ЦГБ г. ВЛАДИМИРА (Бери адреса строго отсюда!):\\n\";\n    \$context .= \"Используй ТОЛЬКО данные из предоставленного списка. Если информации нет в базе — отвечай 'Данные уточняются', не выдумывай адреса. Когда пользователь спрашивает об адресах, контактах, телефонах, режимах работы библиотек или о том, какие библиотеки есть на конкретной улице или в районе, ТЫ ОБЯЗАН брать данные ТОЛЬКО из этого списка ниже.\\n\\n\";";

$replace = "    // Dynamic KB for MBUK CGB Vladimir (Extracts from WP Cron Cached DB Option)\n    \$context .= \"СТРУКТУРА И ФИЛИАЛЫ МБУК ЦГБ г. ВЛАДИМИРА (Бери адреса СТРОГО ОТСЮДА!):\\n\";\n    \$context .= \"КРИТИЧЕСКОЕ ПРАВИЛО: Используй ТОЛЬКО данные из предоставленного ниже списка филиалов. КАТЕГОРИЧЕСКИ ЗАПРЕЩАЕТСЯ выдумывать, генерировать или предполагать существование библиотек, филиалов, адресов, улиц или телефонов, которых НЕТ в этом списке. Если пользователь ищет библиотеку в районе или на улице, которой нет в списке ниже, ты ОБЯЗАН ответить: 'К сожалению, в нашей библиотечной системе нет филиалов по этому адресу/району'. Никаких 'возможно' или 'вероятно'.\\n\\n\";";

if (strpos($content, "КРИТИЧЕСКОЕ ПРАВИЛО:") === false) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully patched branch hallucinations in virtual-librarian.php\n";
    } else {
        echo "Search string not found\n";
    }
} else {
    echo "Already patched\n";
}
