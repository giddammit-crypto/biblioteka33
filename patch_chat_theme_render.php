<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

$search = "        <!-- Chat Window -->\n        <div id=\"ai-chat-window\" class=\"hidden w-full sm:w-[400px] bg-white rounded-3xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] border border-slate-200/60 mb-4 overflow-hidden flex-col h-[65vh] max-h-[550px] sm:max-h-none sm:h-[550px] transition-all transform origin-bottom-right\">";

$replace = "        <!-- Chat Window -->\n        <?php \$chat_theme = get_theme_mod('ai_chat_theme', 'default'); ?>\n        <div id=\"ai-chat-window\" data-theme=\"<?php echo esc_attr(\$chat_theme); ?>\" class=\"hidden w-full sm:w-[400px] bg-white rounded-3xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] border border-slate-200/60 mb-4 overflow-hidden flex-col h-[65vh] max-h-[550px] sm:max-h-none sm:h-[550px] transition-all transform origin-bottom-right theme-<?php echo esc_attr(\$chat_theme); ?>\">";

if (strpos($content, "data-theme") === false) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully patched Chat Window render.\n";
    } else {
        echo "Search string not found.\n";
    }
} else {
    echo "Already patched.\n";
}
