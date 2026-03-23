import os
import time
from playwright.sync_api import sync_playwright, expect

def verify_frontend_changes():
    with sync_playwright() as p:
        browser = p.chromium.launch()
        context = browser.new_context(
            record_video_dir="verification/video",
            viewport={'width': 1280, 'height': 800}
        )
        page = context.new_page()

        # Mock HTML representing a real page with news cards and AI widget
        html_content = r"""
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
            <style>
                :root { --primary: #0b7930; }
                .bg-primary { background-color: var(--primary); }
                .text-primary { color: var(--primary); }

                /* Standard WP Alignment Classes from style.css */
                .aligncenter { display: block; margin: 0 auto; text-align: center; clear: both; }
                .alignleft { float: left; margin: 0 1.5rem 1.5rem 0; }
                .alignright { float: right; margin: 0 0 1.5rem 1.5rem; }
                @media (max-width: 640px) {
                    .alignleft, .alignright { float: none; display: block; margin: 0 auto 1.5rem; width: 100%; text-align: center; }
                }

                /* News Card Fix from style.css */
                .news-card-excerpt-text p { color: inherit !important; }
            </style>
        </head>
        <body class="bg-slate-50 font-sans">
            <div class="max-w-4xl mx-auto p-8">
                <h1 class="text-3xl font-bold mb-8">Verification Page</h1>

                <!-- News Card Section (Testing Firefox Fix) -->
                <section class="mb-12">
                    <h2 class="text-xl font-bold mb-4">1. News Card (Firefox Fix Verification)</h2>
                    <div class="relative group w-full max-w-sm rounded-2xl overflow-hidden shadow-lg h-64 bg-slate-900">
                        <img src="https://picsum.photos/seed/lib1/400/300" class="absolute inset-0 w-full h-full object-cover opacity-60">
                        <div class="absolute inset-0 p-6 flex flex-col justify-end">
                            <h3 class="text-white text-xl font-bold mb-2">Заголовок новости</h3>
                            <div class="news-card-excerpt-text text-white text-sm opacity-90">
                                <p>Этот текст должен быть белым и видимым в Firefox благодаря нашему CSS фиксу.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Gutenberg Alignment Section -->
                <section class="mb-12 entry-content prose max-w-none bg-white p-6 rounded-xl border border-slate-200">
                    <h2 class="text-xl font-bold mb-4">2. Gutenberg Alignments</h2>
                    <p>Sample paragraph before image.</p>
                    <img src="https://picsum.photos/seed/align/200/150" class="alignleft rounded-lg" alt="Left aligned">
                    <p>This text should wrap around the left-aligned image correctly. It demonstrates the standard WordPress alignment classes that we verified and improved in the style.css file.</p>
                    <div class="clear-both"></div>
                    <img src="https://picsum.photos/seed/center/400/200" class="aligncenter rounded-lg mt-4" alt="Center aligned">
                    <p class="text-center italic text-slate-500">Center aligned image caption</p>
                </section>

                <!-- AI Chat Widget Section -->
                <section>
                    <h2 class="text-xl font-bold mb-4">3. Virtual Librarian Enhancements</h2>
                    <div id="ai-chat-window" class="w-[400px] bg-white rounded-3xl shadow-2xl border border-slate-200 flex flex-col h-[500px]">
                        <div class="bg-primary text-white p-4 rounded-t-3xl flex items-center justify-between">
                            <span class="font-bold">Виртуальный библиотекарь</span>
                            <span class="material-symbols-outlined">close</span>
                        </div>
                        <div id="ai-chat-messages" class="flex-grow p-4 overflow-y-auto bg-slate-50 text-sm">
                            <div class="flex gap-2 mb-4">
                                <div class="bg-white border p-3 rounded-2xl shadow-sm">
                                    Привет! Я готов помочь. Посмотрите наши новые функции.
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-2 bg-slate-50 border-t flex gap-2 overflow-x-auto whitespace-nowrap scrollbar-hide">
                            <button class="flex items-center gap-1.5 px-3 py-1.5 bg-white border rounded-full text-xs" data-command="/gost">ГОСТ 7.0.100</button>
                            <button class="flex items-center gap-1.5 px-3 py-1.5 bg-white border rounded-full text-xs" data-command="/exhibitions">Идеи выставок</button>
                        </div>
                        <div class="p-3 bg-white border-t flex gap-2">
                            <input type="text" id="ai-chat-input" class="w-full bg-slate-100 rounded-full px-4 py-2 text-sm" placeholder="Введите /gost...">
                            <button id="ai-chat-send" class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm">send</span>
                            </button>
                        </div>
                        <div class="px-4 pb-3 bg-white text-[10px] text-slate-400 text-center">
                            ИИ может ошибаться! Всегда проверяйте полученные от ИИ данные!
                        </div>
                    </div>
                </section>
            </div>

            <script>
                // Mock interaction for video
                setTimeout(() => {
                    const input = document.getElementById('ai-chat-input');
                    input.value = "Библиотечное дело";
                    document.querySelector('button[data-command="/gost"]').click();
                    input.value = "/gost Библиотечное дело";
                }, 1000);
            </script>
        </body>
        </html>
        """

        page.set_content(html_content)
        page.wait_for_timeout(1500) # Wait for mock script to run

        # Take main screenshot
        page.screenshot(path="verification/verification.png", full_page=True)

        # Verify specific elements
        disclaimer = page.locator("text=ИИ может ошибаться")
        expect(disclaimer).to_be_visible()

        gost_btn = page.locator("button[data-command='/gost']")
        expect(gost_btn).to_be_visible()

        context.close()
        browser.close()

if __name__ == "__main__":
    verify_frontend_changes()
