<?php
$file = 'wp-content/themes/city-library/js/ai-chat.js';
$content = file_get_contents($file);

$search = "                        <a href=\"data:text/plain;charset=utf-8,\${encodedText}\" download=\"Ответ_Виртуального_Библиотекаря.txt\" class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium\">\n                            <span class=\"material-symbols-outlined text-[14px]\">download</span> Скачать (TXT)\n                        </a>";

$replace = "                        <button class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-pdf-btn\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[14px]\">picture_as_pdf</span> PDF\n                        </button>\n                        <button class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-docx-btn\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[14px]\">description</span> DOCX\n                        </button>";

if (strpos($content, "ai-pdf-btn") === false) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully added PDF/DOCX buttons.\n";
    } else {
        echo "Search string not found.\n";
    }
} else {
    echo "Already patched.\n";
}
