<?php
$file = 'wp-content/themes/city-library/js/ai-chat.js';
$content = file_get_contents($file);

$search = "                        <button class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-email-btn\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[14px]\">mail</span> На почту\n                        </button>\n                    </div>\n                `;";

$replace = "                        <button class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-email-btn\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[14px]\">mail</span> На почту\n                        </button>\n                        \${text.toLowerCase().includes('годы жизни') && text.length > 500 ? `\n                        <button class=\"text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-save-draft-btn bg-slate-100/50 px-2 py-1 rounded-md ml-auto border border-slate-200 shadow-sm\" data-text=\"\${escapeHtml(text)}\">\n                            <span class=\"material-symbols-outlined text-[14px]\">note_add</span> Сохранить как черновик\n                        </button>\n                        ` : ''}\n                    </div>\n                `;";

if (strpos($content, "ai-save-draft-btn") === false) {
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
