<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

$search = "                <button class=\"ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm\" data-command=\"/stat\">\n                    <span class=\"material-symbols-outlined text-[14px]\">bar_chart</span>\n                    Статистика записей\n                </button>";

$replace = "                <button class=\"ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm\" data-command=\"/stat\">\n                    <span class=\"material-symbols-outlined text-[14px]\">bar_chart</span>\n                    Статистика записей\n                </button>\n                <button class=\"ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm\" data-command=\"/юбиляры\">\n                    <span class=\"material-symbols-outlined text-[14px]\">event</span>\n                    Юбиляры\n                </button>";

if (strpos($content, "data-command=\"/юбиляры\"") === false) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully added Jubilee button HTML.\n";
    } else {
        echo "Search string not found.\n";
    }
} else {
    echo "Already patched.\n";
}
