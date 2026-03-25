<?php
/**
 * Voice Assistant Modals Template
 */
if (!defined('ABSPATH')) exit;
?>
<!-- Voice Test Welcome Modal -->
<div id="voice-test-welcome-modal" class="fixed inset-0 z-[110] bg-black/80 backdrop-blur-xl hidden flex items-center justify-center p-4 transition-all duration-500 opacity-0" role="dialog" aria-modal="true" aria-labelledby="voice-test-welcome-title">
    <div class="bg-white rounded-[2rem] w-full max-w-sm shadow-2xl overflow-hidden transform scale-90 transition-all duration-500 relative test-modal-content">
        <div class="p-8 text-center space-y-4">
            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-2">
                <span class="material-symbols-outlined text-primary text-3xl" aria-hidden="true">mic</span>
            </div>
            <h3 id="voice-test-welcome-title" class="text-2xl font-display font-bold text-slate-900 leading-tight">
                Тест Голосового Ассистента
            </h3>
            <p class="text-sm text-slate-600 leading-relaxed">
                Вы получили доступ к тестированию интеллектуального голосового помощника. Тест автоматически завершится через <strong>24 часа</strong>.
            </p>
            <div class="bg-slate-50 rounded-xl p-4 text-xs text-slate-500 text-left border border-slate-100">
                <span class="block font-bold text-slate-700 mb-1">Как использовать:</span>
                Нажмите на появившуюся кнопку микрофона и скажите <strong>«Что ты умеешь»</strong> или <strong>«Команды»</strong>, чтобы узнать о возможностях.
            </div>
            <button id="voice-test-start-btn" class="w-full mt-4 py-3.5 bg-primary hover:bg-yellow-600 text-white font-bold rounded-xl transition-all duration-300 shadow-md shadow-primary/20 active:scale-95">
                Хорошо, понятно
            </button>
        </div>
    </div>
</div>

<!-- Voice Test Feedback Modal -->
<div id="voice-test-feedback-modal" class="fixed inset-0 z-[110] bg-black/80 backdrop-blur-xl hidden flex items-center justify-center p-4 transition-all duration-500 opacity-0" role="dialog" aria-modal="true" aria-labelledby="voice-test-feedback-title">
    <div class="bg-white rounded-[2rem] w-full max-w-sm shadow-2xl overflow-hidden transform scale-90 transition-all duration-500 relative test-modal-content">
        <div class="p-8 text-center space-y-5">
            <h3 id="voice-test-feedback-title" class="text-2xl font-display font-bold text-slate-900 leading-tight">
                Время теста вышло!
            </h3>
            <p class="text-sm text-slate-600 leading-relaxed">
                Спасибо за участие в тестировании голосового ассистента. Пожалуйста, оцените его работу и опишите найденные ошибки, если они были.
            </p>

            <form id="voice-test-feedback-form" class="space-y-4">
                <div class="flex justify-center gap-2" id="voice-feedback-stars">
                    <span class="material-symbols-outlined text-4xl text-slate-300 cursor-pointer hover:text-yellow-400 transition-colors" data-value="1" aria-hidden="true">star</span>
                    <span class="material-symbols-outlined text-4xl text-slate-300 cursor-pointer hover:text-yellow-400 transition-colors" data-value="2" aria-hidden="true">star</span>
                    <span class="material-symbols-outlined text-4xl text-slate-300 cursor-pointer hover:text-yellow-400 transition-colors" data-value="3" aria-hidden="true">star</span>
                    <span class="material-symbols-outlined text-4xl text-slate-300 cursor-pointer hover:text-yellow-400 transition-colors" data-value="4" aria-hidden="true">star</span>
                    <span class="material-symbols-outlined text-4xl text-slate-300 cursor-pointer hover:text-yellow-400 transition-colors" data-value="5" aria-hidden="true">star</span>
                </div>
                <input type="hidden" name="rating" id="voice-feedback-rating-input" value="0">
                <textarea name="feedback" rows="3" placeholder="Опишите ошибки или пожелания..." class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm p-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary resize-none"></textarea>
                <button type="submit" id="voice-feedback-submit-btn" class="w-full py-3.5 bg-primary hover:bg-yellow-600 text-white font-bold rounded-xl transition-all duration-300 shadow-md shadow-primary/20 active:scale-95 disabled:opacity-50">
                    Отправить отчет
                </button>
            </form>
        </div>
    </div>
</div>

<!-- AI Answer Text Modal -->
<div id="voice-ai-answer-modal" class="fixed inset-0 z-[120] bg-black/60 backdrop-blur-md hidden flex items-center justify-center p-4 transition-all duration-500 opacity-0" role="dialog" aria-modal="true" aria-labelledby="voice-ai-answer-title">
    <div class="bg-white rounded-[2rem] w-full max-w-md shadow-2xl overflow-hidden transform scale-90 transition-all duration-500 relative flex flex-col border border-slate-100 ring-1 ring-black/5 voice-modal-content">
        <div class="relative bg-white px-6 py-4 shrink-0 border-b border-slate-100 flex items-center justify-between z-10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-primary text-xl" aria-hidden="true">auto_awesome</span>
                </div>
                <h3 id="voice-ai-answer-title" class="text-base font-display font-bold text-slate-900 tracking-tight leading-none">
                    Ответ ассистента
                </h3>
            </div>
            <button type="button" class="voice-ai-answer-close p-2 rounded-full text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary/50 group" aria-label="Закрыть">
                <span class="material-symbols-outlined text-xl group-hover:rotate-90 transition-transform duration-300" aria-hidden="true">close</span>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto custom-scrollbar bg-slate-50 max-h-[60vh]">
            <div id="voice-ai-answer-text" class="text-sm text-slate-700 leading-relaxed font-medium prose prose-sm prose-slate max-w-none"></div>
        </div>
    </div>
</div>

<!-- Voice Yandex Map Modal -->
<div id="voice-map-modal" class="fixed inset-0 z-[130] bg-black/90 hidden flex-col transition-all duration-300 opacity-0 lg:landscape:hidden w-full h-[100dvh]" role="dialog" aria-modal="true" aria-labelledby="voice-map-title">
    <div class="flex items-center justify-between px-4 py-3 safe-area-top bg-white shadow-md z-10 shrink-0">
        <h3 id="voice-map-title" class="text-lg font-bold text-slate-900 truncate flex-1">Карта филиалов</h3>
        <button type="button" id="voice-map-close" class="p-2 -mr-2 text-slate-500 hover:text-slate-900 focus:outline-none" aria-label="Закрыть карту">
            <span class="material-symbols-outlined text-2xl" aria-hidden="true">close</span>
        </button>
    </div>
    <div class="flex-1 w-full h-full relative overflow-hidden flex flex-col bg-white">
        <iframe id="voice-map-iframe" class="absolute inset-0 w-full h-full border-0 object-cover" src="" allowfullscreen="true" style="position:absolute; width:100%; height:100%;"></iframe>
        <div id="voice-custom-map-container" class="absolute inset-0 w-full h-full hidden overflow-y-auto bg-slate-50 custom-scrollbar pb-16"></div>
        <div id="voice-map-loader" class="absolute inset-0 flex flex-col items-center justify-center bg-white z-0 pointer-events-none transition-opacity duration-300">
            <div class="w-12 h-12 border-4 border-primary/30 border-t-primary rounded-full animate-spin mb-3"></div>
            <span class="text-sm text-slate-500 font-medium">Загрузка карты...</span>
        </div>
    </div>
</div>

<!-- Voice Commands Modal -->
<div id="voice-commands-modal" class="fixed inset-0 z-[120] bg-black/80 backdrop-blur-xl hidden flex items-center justify-center p-4 transition-all duration-500 opacity-0" role="dialog" aria-modal="true" aria-labelledby="voice-commands-title">
    <div class="bg-white rounded-[2.5rem] w-full max-w-md shadow-2xl overflow-hidden transform scale-90 transition-all duration-500 relative max-h-[90vh] flex flex-col border border-slate-100 ring-1 ring-black/5 voice-modal-content">
        <div class="relative bg-white px-8 py-6 shrink-0 border-b border-slate-100 flex items-center justify-between z-10">
            <div>
                <h3 id="voice-commands-title" class="text-2xl font-display font-bold text-slate-900 tracking-tight leading-none">
                    Голосовой помощник
                </h3>
                <p class="text-xs text-slate-500 font-medium mt-1 uppercase tracking-wider">Доступные команды</p>
            </div>
            <button type="button" class="voice-modal-close p-2 rounded-full text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary/50 group" aria-label="Закрыть">
                <span class="material-symbols-outlined text-2xl group-hover:rotate-90 transition-transform duration-300" aria-hidden="true">close</span>
            </button>
        </div>
        <div class="px-8 py-6 overflow-y-auto custom-scrollbar bg-slate-50 space-y-4">
            <p class="text-sm text-slate-600 mb-4 font-medium leading-relaxed">Нажмите кнопку с микрофоном и произнесите одну из команд:</p>
            <ul class="space-y-3">
                <li class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary mt-0.5" aria-hidden="true">article</span>
                    <div><strong class="text-sm text-slate-900 block font-bold">«Открой последние новости»</strong><span class="text-xs text-slate-500">Переход к свежим событиям</span></div>
                </li>
                <li class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary mt-0.5" aria-hidden="true">event</span>
                    <div><strong class="text-sm text-slate-900 block font-bold">«Афиша» или «Мероприятия»</strong><span class="text-xs text-slate-500">Показать расписание событий</span></div>
                </li>
                <li class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary mt-0.5" aria-hidden="true">auto_stories</span>
                    <div><strong class="text-sm text-slate-900 block font-bold">«Продление книг»</strong><span class="text-xs text-slate-500">Открыть форму продления онлайн</span></div>
                </li>
            </ul>
        </div>
    </div>
</div>
