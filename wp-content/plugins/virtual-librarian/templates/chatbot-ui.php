<?php
/**
 * Chatbot UI Template
 */
if (!defined('ABSPATH')) exit;

// Fetch settings via the plugin's settings handler (to be implemented)
$chat_theme = get_option('vl_chat_theme', 'default');
$avatar_url = Virtual_Librarian::get_avatar_url();
?>
<div id="ai-librarian-widget" class="hidden lg:landscape:flex fixed bottom-24 lg:landscape:bottom-8 right-4 sm:right-6 lg:landscape:right-8 z-[99999] flex-col items-end w-auto" style="visibility: visible !important; opacity: 1 !important; pointer-events: none;">
    <!-- Chat Window -->
    <div id="ai-chat-window" data-theme="<?php echo esc_attr($chat_theme); ?>" class="hidden w-[96vw] sm:w-[90vw] md:w-[680px] max-w-full bg-white/95 backdrop-blur-2xl rounded-[2.5rem] shadow-[0_30px_70px_-15px_rgba(0,0,0,0.3)] border border-white/40 mb-6 overflow-hidden flex-col h-[70vh] max-h-[750px] sm:max-h-none sm:h-[650px] transition-all duration-500 transform origin-bottom-right theme-<?php echo esc_attr($chat_theme); ?> pointer-events-auto">
        <!-- Header -->
        <div class="bg-gradient-to-br from-primary via-primary to-secondary text-white p-5 flex justify-between items-center shadow-lg z-20 shrink-0 border-b border-white/10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md shadow-xl overflow-hidden border border-white/30 rotate-3 hover:rotate-0 transition-transform duration-300">
                    <img src="<?php echo esc_url($avatar_url); ?>" alt="Avatar" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="font-black text-base leading-tight tracking-wide">Виртуальный библиотекарь</h4>
                    <span class="text-[11px] text-white/80 flex items-center gap-2 uppercase tracking-widest font-bold mt-1">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        В сети
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button id="fullscreen-ai-chat" class="text-white/70 hover:text-white hover:bg-white/20 rounded-xl transition-all flex items-center justify-center w-10 h-10 border border-white/10 shadow-sm focus-visible:ring-2 focus-visible:ring-white/50 focus-visible:outline-none" aria-label="Полный экран">
                    <span class="material-symbols-outlined text-[22px]" aria-hidden="true">fullscreen</span>
                </button>
                <button id="close-ai-chat" class="text-white/70 hover:text-white hover:bg-white/20 rounded-xl transition-all flex items-center justify-center w-10 h-10 border border-white/10 shadow-sm focus-visible:ring-2 focus-visible:ring-white/50 focus-visible:outline-none" aria-label="Закрыть чат">
                    <span class="material-symbols-outlined text-[22px]" aria-hidden="true">close</span>
                </button>
            </div>
        </div>

        <div class="flex flex-grow overflow-hidden relative">
            <!-- Sidebar (Desktop only or Drawer style) -->
            <div id="ai-chat-sidebar" class="hidden sm:flex flex-col w-[200px] bg-slate-900 text-slate-300 border-r border-slate-800 shrink-0 overflow-y-auto custom-scrollbar p-2 py-4 gap-1 z-10 shadow-xl">
                <div class="px-3 mb-4 flex flex-col gap-1">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Библиотекарь</span>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-white bg-primary hover:bg-primary/80 transition-all text-left shadow-lg shadow-primary/20 group" data-command="/help">
                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">help</span> Справка / Гид
                    </button>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-900 bg-yellow-400 hover:bg-yellow-500 transition-all text-left shadow-lg shadow-yellow-500/10" data-command="/aimg">
                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">palette</span> Генератор фото
                    </button>
                </div>

                <div class="px-3 flex flex-col gap-0.5">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-2 mt-2">Инструменты</span>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] hover:bg-white/5 hover:text-white transition-all text-left" data-command="/anniversaries">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">cake</span> Юбиляры
                    </button>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] hover:bg-white/5 hover:text-white transition-all text-left" data-command="/work_plan">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">calendar_today</span> План работы
                    </button>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] hover:bg-white/5 hover:text-white transition-all text-left" data-command="/social_post">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">share</span> Пост ВК
                    </button>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] hover:bg-white/5 hover:text-white transition-all text-left" data-command="/script">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">movie_edit</span> Сценарий
                    </button>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] hover:bg-white/5 hover:text-white transition-all text-left" data-command="/bib_list">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">format_list_bulleted</span> Библ. список
                    </button>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] hover:bg-white/5 hover:text-white transition-all text-left" data-command="/inventory">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">inventory</span> Фонд
                    </button>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] hover:bg-white/5 hover:text-white transition-all text-left" data-command="/gost">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">gavel</span> ГОСТ 7.0.100
                    </button>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] hover:bg-white/5 hover:text-white transition-all text-left" data-command="/exhibitions">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">stars</span> Выставки
                    </button>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] hover:bg-white/5 hover:text-white transition-all text-left" data-command="/vladimir_history">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">castle</span> Краеведение
                    </button>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] hover:bg-white/5 hover:text-white transition-all text-left" data-command="/prof_resources">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">school</span> Ресурсы
                    </button>
                </div>

                <div class="mt-auto px-3 pt-4 border-t border-slate-800 flex flex-col gap-0.5">
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] text-slate-500 hover:text-primary transition-all text-left" data-command="/emoji">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">sentiment_satisfied</span> Смайлики
                    </button>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] text-slate-500 hover:text-primary transition-all text-left" data-command="/stat">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">bar_chart</span> Статистика
                    </button>
                    <button class="ai-quick-action-btn w-full flex items-center gap-3 px-3 py-2 rounded-lg text-[11px] text-red-400 hover:bg-red-500/10 transition-all text-left" data-command="/clear">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">delete</span> Очистить чат
                    </button>
                </div>

                <div class="px-3 mt-4">
                    <button id="ai-collect-draft-btn" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-[11px] font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-all text-left shadow-lg shadow-indigo-600/20 group">
                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">library_add_check</span> Собрать черновик
                    </button>
                </div>
            </div>

            <!-- Main Chat Area -->
            <div class="flex-grow flex flex-col min-w-0 bg-slate-50 relative">
                <!-- Mobile Tools Toggle (Horizontal Scroll on Mobile) -->
                <div class="sm:hidden px-3 py-2 bg-white border-b border-slate-100 flex gap-2 overflow-x-auto whitespace-nowrap scrollbar-hide shrink-0 text-xs shadow-sm">
                    <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-primary text-white rounded-full transition-all shadow-sm font-bold" data-command="/help">
                        <span class="material-symbols-outlined text-[14px]" aria-hidden="true">help</span> Инфо
                    </button>
                    <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-yellow-400 text-slate-900 rounded-full transition-all shadow-sm font-bold" data-command="/aimg">
                        <span class="material-symbols-outlined text-[14px]" aria-hidden="true">palette</span> Фото
                    </button>
                    <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 transition-all" data-command="/anniversaries">Юбиляры</button>
                    <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 transition-all" data-command="/social_post">Пост ВК</button>
                    <button id="ai-collect-draft-btn-mobile" class="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 border border-indigo-200 rounded-full text-indigo-600 transition-all font-bold">
                        <span class="material-symbols-outlined text-[14px]">library_add_check</span> Собрать
                    </button>
                    <button class="ai-quick-action-btn flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-slate-600 transition-all" data-command="/clear">Очистить</button>
                </div>

                <!-- Selection Mode Toolbar (Moved outside to prevent deletion on clear) -->
                <div id="ai-selection-toolbar" class="hidden bg-indigo-600 text-white p-3 shadow-lg flex justify-between items-center z-30 animate-in slide-in-from-top duration-300 shrink-0">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">fact_check</span>
                        <span class="text-xs font-bold"><span id="ai-selected-count">0</span> выбрано</span>
                    </div>
                    <div class="flex gap-2">
                        <button id="ai-compile-pdf" class="bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded-lg text-[10px] font-bold flex items-center gap-1 transition-all">
                            <span class="material-symbols-outlined text-[14px]">picture_as_pdf</span> PDF
                        </button>
                        <button id="ai-compile-docx" class="bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded-lg text-[10px] font-bold flex items-center gap-1 transition-all">
                            <span class="material-symbols-outlined text-[14px]">description</span> DOCX
                        </button>
                        <button id="ai-cancel-selection" class="text-white/70 hover:text-white p-1">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>
                </div>

                <div id="ai-chat-messages" class="flex-grow p-4 sm:p-6 overflow-y-auto flex flex-col gap-6 text-sm custom-scrollbar scroll-smooth relative">
                    <!-- Welcome Message -->
                    <div class="flex gap-2">
                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center shrink-0 mt-1 shadow-sm border border-slate-300 overflow-hidden relative">
                            <img src="<?php echo esc_url($avatar_url); ?>" alt="Avatar" class="w-full h-full object-cover">
                        </div>
                        <div class="bg-white border border-slate-200/80 p-4 rounded-[1.25rem] rounded-tl-sm shadow-sm hover:shadow-md transition-shadow text-slate-800 text-[14.5px] leading-relaxed">
                            Здравствуйте! Я ваш виртуальный библиотекарь. 📚 Слева расположены быстрые инструменты для работы. Вы можете прикрепить документ или фото для анализа. Чем могу помочь?
                        </div>
                    </div>
                </div>

                <!-- Input Area -->
                <div class="p-4 bg-white border-t border-slate-100 flex gap-3 shadow-[0_-10px_25px_rgba(0,0,0,0.03)] shrink-0 z-10 relative items-end">
                    <input type="file" id="ai-chat-file-input" class="hidden" accept=".txt,.docx,.pdf,.jpg,.jpeg,.png,.webp" style="display: none !important;">
                    <button id="ai-chat-attachment" class="w-11 h-11 text-slate-400 hover:text-primary hover:bg-primary/5 rounded-2xl flex items-center justify-center transition-all shrink-0 border border-slate-100 shadow-sm" title="Прикрепить файл или фото (до 50МБ)" aria-label="Прикрепить файл">
                        <span class="material-symbols-outlined text-[22px]" aria-hidden="true">attach_file</span>
                    </button>
                    <div class="relative flex-grow">
                        <textarea id="ai-chat-input" rows="1" class="w-full bg-slate-50 hover:bg-slate-100/50 focus:bg-white border border-slate-200 focus:border-primary/50 focus:ring-4 focus:ring-primary/10 rounded-2xl text-[14px] px-5 py-3.5 transition-all duration-300 resize-none min-h-[50px] max-h-[180px] leading-relaxed custom-scrollbar shadow-inner" placeholder="Спросите что-нибудь..." aria-label="Текст запроса"></textarea>
                    </div>
                    <button id="ai-chat-send" class="w-12 h-12 bg-primary text-white rounded-2xl flex items-center justify-center hover:bg-secondary hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/20 transition-all duration-300 shrink-0 shadow-lg group active:scale-95 border-b-4 border-primary/20" aria-label="Отправить сообщение">
                        <span class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform duration-300" aria-hidden="true">keyboard_arrow_up</span>
                    </button>
                </div>

                <!-- Disclaimer -->
                <div class="px-4 pb-3 bg-white text-[10px] text-slate-400 text-center leading-tight">
                    ИИ может ошибаться! Всегда проверяйте полученные от ИИ данные!
                </div>
            </div> <!-- Close Main Chat Area -->
        </div> <!-- Close flex flex-grow container -->
    </div> <!-- Close ai-chat-window -->

    <!-- Toggle Button -->
    <button id="ai-chat-toggle" class="w-16 h-16 bg-primary text-white rounded-full shadow-[0_8px_30px_rgba(11,121,48,0.4)] hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(11,121,48,0.5)] transition-all duration-300 flex items-center justify-center relative group overflow-hidden shrink-0 pointer-events-auto focus-visible:ring-4 focus-visible:ring-primary/40 focus-visible:outline-none" aria-label="Чат с Виртуальным библиотекарем">
        <span class="absolute inset-0 bg-gradient-to-tr from-white/0 to-white/20"></span>
        <span class="material-symbols-outlined text-[32px] group-hover:hidden relative z-10" aria-hidden="true">support_agent</span>
        <span class="material-symbols-outlined text-[32px] hidden group-hover:block relative z-10" aria-hidden="true">chat</span>
        <!-- Notification Dot -->
        <span class="absolute top-0 right-0 w-3.5 h-3.5 bg-red-500 border-2 border-white rounded-full animate-pulse shadow-sm z-20"></span>
    </button>
</div>
