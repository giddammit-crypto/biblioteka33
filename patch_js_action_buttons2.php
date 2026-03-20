<?php
$file = 'wp-content/themes/city-library/js/ai-chat.js';
$content = file_get_contents($file);

$search = "                        <a href=\"data:text/plain;charset=utf-8,\${encodedText}\" download=\"Ответ_Виртуального_Библиотекаря.txt\" class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium\">\n                            <span class=\"material-symbols-outlined text-[14px]\">download</span> Скачать (TXT)\n                        </a>\n                    </div>\n                `;";

$replace = "                        <a href=\"data:text/plain;charset=utf-8,\${encodedText}\" download=\"Ответ_Виртуального_Библиотекаря.txt\" class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium\">\n                            <span class=\"material-symbols-outlined text-[14px]\">download</span> Скачать (TXT)\n                        </a>\n                        <button class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-email-btn\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[14px]\">mail</span> На почту\n                        </button>\n                        \${text.toLowerCase().includes('источники') && text.length > 500 ? `\n                        <button class=\"text-xs text-slate-500 hover:text-primary transition-colors flex items-center gap-1 font-bold ai-save-draft-btn bg-slate-100 hover:bg-slate-200 px-2.5 py-1.5 rounded-lg border border-slate-200 ml-auto\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[16px]\">note_add</span> Сохранить черновик в WP\n                        </button>\n                        ` : ''}\n                    </div>\n                `;";

if (strpos($content, "Сохранить черновик в WP") === false) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully added Save Draft button HTML.\n";
    } else {
        echo "Search string not found.\n";
    }
} else {
    echo "Already patched HTML.\n";
}
