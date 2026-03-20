<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

// Find the exact string by breaking it down
$search = '<!-- Input Area -->
            <div class="p-3 bg-white border-t border-slate-100 flex gap-2 shadow-[0_-4px_10px_rgba(0,0,0,0.02)] shrink-0 z-10 relative">
                <input type="text" id="ai-chat-input" class="w-full bg-slate-100/80 hover:bg-slate-100 focus:bg-white border border-transparent focus:border-primary/50 focus:ring-2 focus:ring-primary/20 rounded-full text-sm px-5 py-3 transition-all duration-300" placeholder="Ваш запрос или /help...">';

$replace = '<!-- Quick Actions Bar -->
            <div class="px-4 py-2 bg-slate-50 border-t border-slate-100 flex gap-2 overflow-x-auto whitespace-nowrap scrollbar-hide shrink-0 text-xs shadow-inner">
                <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm" data-command="/emoji">
                    <span class="material-symbols-outlined text-[14px]">sentiment_satisfied</span>
                    Смайлики
                </button>
                <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 hover:text-primary hover:border-primary/50 hover:bg-primary/5 transition-all shadow-sm" data-command="/stat">
                    <span class="material-symbols-outlined text-[14px]">bar_chart</span>
                    Статистика записей
                </button>
            </div>

            <!-- Input Area -->
            <div class="p-3 bg-white border-t border-slate-100 flex gap-2 shadow-[0_-4px_10px_rgba(0,0,0,0.02)] shrink-0 z-10 relative items-center">
                <button id="ai-chat-attachment" class="w-10 h-10 text-slate-400 hover:text-primary hover:bg-slate-100 rounded-full flex items-center justify-center transition-colors shrink-0" title="Прикрепить файл (до 20МБ)">
                    <span class="material-symbols-outlined text-[20px]">attach_file</span>
                </button>
                <input type="text" id="ai-chat-input" class="w-full bg-slate-100/80 hover:bg-slate-100 focus:bg-white border border-transparent focus:border-primary/50 focus:ring-2 focus:ring-primary/20 rounded-full text-sm px-5 py-3 transition-all duration-300" placeholder="Ваш запрос или /help...">';

if (strpos($content, '<!-- Quick Actions Bar -->') === false) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully patched virtual-librarian.php\n";
    } else {
        echo "Search string not found in virtual-librarian.php\n";
    }
} else {
    echo "Already patched\n";
}
