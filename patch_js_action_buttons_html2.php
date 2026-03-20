<?php
$file = 'wp-content/themes/city-library/js/ai-chat.js';
$content = file_get_contents($file);

$search1 = "                // Generate a base64 encoded text string for the data URI\n                const encodedText = encodeURIComponent(text);\n                actionButtons = `\n                    <div class=\"flex gap-2 mt-3 pt-3 border-t border-slate-100/50 justify-end\">\n                        <button class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-copy-btn\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[14px]\">content_copy</span> Копировать\n                        </button>\n                        <a href=\"data:text/plain;charset=utf-8,\${encodedText}\" download=\"Ответ_Виртуального_Библиотекаря.txt\" class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium\">\n                            <span class=\"material-symbols-outlined text-[14px]\">download</span> Скачать (TXT)\n                        </a>\n                    </div>\n                `;";

$replace1 = "                // Generate a base64 encoded text string for the data URI\n                const encodedText = encodeURIComponent(text);\n                actionButtons = `\n                    <div class=\"flex gap-2 mt-3 pt-3 border-t border-slate-100/50 justify-end flex-wrap\">\n                        <button class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-copy-btn\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[14px]\">content_copy</span> Копировать\n                        </button>\n                        <a href=\"data:text/plain;charset=utf-8,\${encodedText}\" download=\"Ответ_Виртуального_Библиотекаря.txt\" class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium\">\n                            <span class=\"material-symbols-outlined text-[14px]\">download</span> Скачать (TXT)\n                        </a>\n                        <button class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-pdf-btn\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[14px]\">picture_as_pdf</span> PDF\n                        </button>\n                        <button class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-docx-btn\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[14px]\">description</span> DOCX\n                        </button>\n                        <button class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-email-btn\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[14px]\">mail</span> На почту\n                        </button>\n                        \${text.toLowerCase().includes('источники') && text.length > 500 ? `\n                        <button class=\"text-xs text-slate-500 hover:text-primary transition-colors flex items-center gap-1 font-bold ai-save-draft-btn bg-slate-100 hover:bg-slate-200 px-2.5 py-1.5 rounded-lg border border-slate-200 ml-auto\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[16px]\">note_add</span> Сохранить черновик в WP\n                        </button>\n                        ` : ''}\n                    </div>\n                `;";

if (strpos($content, "ai-pdf-btn") === false) {
    if (strpos($content, $search1) !== false) {
        $content = str_replace($search1, $replace1, $content);
        echo "Successfully patched Action Buttons HTML.\n";
    } else {
        echo "Search string 1 not found.\n";
    }
}

// And fix avatar src while we are at it
$search2 = "                    <img src=\"https://api.dicebear.com/7.x/avataaars/svg?seed=Nala&backgroundColor=e2e8f0&accessories=prescription02\" alt=\"AI Avatar\" class=\"w-full h-full object-cover\">";
$replace2 = "                    <img src=\"\${cl_ai_ajax.avatar_url}\" alt=\"AI Avatar\" class=\"w-full h-full object-cover\">";
if (strpos($content, "\${cl_ai_ajax.avatar_url}") === false) {
    if (strpos($content, $search2) !== false) {
        $content = str_replace($search2, $replace2, $content);
        echo "Successfully patched Avatar Source.\n";
    }
}

file_put_contents($file, $content);
