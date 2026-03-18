document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('ai-chat-toggle');
    const closeBtn = document.getElementById('close-ai-chat');
    const chatWindow = document.getElementById('ai-chat-window');
    const inputField = document.getElementById('ai-chat-input');
    const sendBtn = document.getElementById('ai-chat-send');
    const messagesContainer = document.getElementById('ai-chat-messages');
    const fullscreenBtn = document.getElementById('fullscreen-ai-chat');

    if (!toggleBtn || !chatWindow) return;


    // Initialize marked.js custom renderer safely for images
    if (typeof marked !== 'undefined') {
        const renderer = new marked.Renderer();
        // Fallback for different marked.js versions (v8+ uses token, older uses arguments)
        renderer.image = function(href_or_token, title, text) {
            let href = typeof href_or_token === 'object' ? href_or_token.href : href_or_token;
            let imgText = typeof href_or_token === 'object' ? href_or_token.text : text;

            return `
                <div class="generated-image-container relative my-3">
                    <img src="${href}" alt="${imgText || 'Сгенерированное изображение'}" class="w-full h-auto rounded-lg shadow-md border border-slate-200">
                    <a href="${href}" target="_blank" download="image.jpg" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm hover:bg-primary/90 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">download</span>
                        Скачать в полном размере
                    </a>
                </div>
            `;
        };
        marked.use({ renderer });
    }

    // Chat History Management (30 days)
    const STORAGE_KEY = 'city_library_ai_chat_history';
    const EXPIRY_DAYS = 30;
    let chatHistory = [];

    function loadHistory() {
        try {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (saved) {
                const parsed = JSON.parse(saved);
                const now = new Date().getTime();
                if (now - parsed.timestamp > EXPIRY_DAYS * 24 * 60 * 60 * 1000) {
                    localStorage.removeItem(STORAGE_KEY);
                    return;
                }

                chatHistory = parsed.messages || [];
                if (chatHistory.length > 0) {
                    if (messagesContainer.querySelector('.prose')) {
                        messagesContainer.innerHTML = '';
                    }
                    chatHistory.forEach(msg => {
                        addMessageToUI(msg.role, msg.content, null, false);
                    });
                }
            }
        } catch (e) {
            console.error('Failed to load chat history', e);
        }
    }

    function saveHistory() {
        try {
            const historyToSave = chatHistory.slice(-50);
            const data = {
                timestamp: new Date().getTime(),
                messages: historyToSave
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
        } catch (e) {
            console.error('Failed to save chat history', e);
        }
    }

    loadHistory();

    // Toggle Window
    function toggleChat() {
        if (chatWindow.classList.contains('hidden')) {
            chatWindow.classList.remove('hidden');
            chatWindow.classList.add('flex');
            // Remove notification dot if exists
            const dot = toggleBtn.querySelector('.animate-pulse');
            if(dot) dot.remove();
            // Focus input
            setTimeout(() => inputField.focus(), 100);
        } else {
            chatWindow.classList.add('hidden');
            chatWindow.classList.remove('flex');
            // Reset fullscreen state if closed
            if (chatWindow.classList.contains('fixed')) {
                toggleFullscreen();
            }
        }
    }

    function toggleFullscreen() {
        chatWindow.classList.toggle('fixed');
        chatWindow.classList.toggle('inset-0');
        chatWindow.classList.toggle('z-[1000]');
        chatWindow.classList.toggle('h-[100dvh]');
        chatWindow.classList.toggle('rounded-none');

        // Remove default fixed width/height when fullscreen
        chatWindow.classList.toggle('sm:w-96');
        chatWindow.classList.toggle('h-[60vh]');
        chatWindow.classList.toggle('max-h-[500px]');
        chatWindow.classList.toggle('sm:max-h-none');
        chatWindow.classList.toggle('sm:h-[500px]');
        chatWindow.classList.toggle('mb-4');
        chatWindow.classList.toggle('rounded-2xl');

        if (fullscreenBtn) {
            const icon = fullscreenBtn.querySelector('span');
            if (chatWindow.classList.contains('fixed')) {
                icon.textContent = 'fullscreen_exit';
            } else {
                icon.textContent = 'fullscreen';
            }
        }
    }

    toggleBtn.addEventListener('click', toggleChat);
    closeBtn.addEventListener('click', toggleChat);
    if (fullscreenBtn) fullscreenBtn.addEventListener('click', toggleFullscreen);

    // Send Message
    function sendMessage() {
        const message = inputField.value.trim();
        if (!message) return;

        // 1. Add User Message to UI
        addMessageToUI('user', message);
        inputField.value = '';

        // 2. Show typing or drawing indicator
        const typingId = 'typing-' + Date.now();

        let isDrawCommand = false;
        const msgLower = message.toLowerCase();
        if (msgLower.startsWith('/aimg') || msgLower.match(/^(нарисуй|сгенерируй|создай картинку|нарисуй мне|сделай картинку)\s+/)) {
            isDrawCommand = true;
        }

        if (isDrawCommand) {
            addMessageToUI('bot', '<div class="flex items-center gap-2 text-slate-500 font-medium"><span class="material-symbols-outlined animate-spin text-primary">palette</span> Создаю изображение...</div>', typingId, false);
        } else {
            addMessageToUI('bot', '<span class="flex gap-1 items-center"><span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce"></span><span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></span><span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span></span>', typingId, false);
        }

        const contextHistory = chatHistory.slice(-6).map(m => ({
            role: m.role === 'bot' ? 'assistant' : 'user',
            content: m.content
        }));

        // 3. Send AJAX Request
        jQuery.ajax({
            url: cl_ai_ajax.url,
            type: 'POST',
            data: {
                action: 'city_library_ai_chat',
                nonce: cl_ai_ajax.nonce,
                message: message,
                history: JSON.stringify(contextHistory)
            },
            success: function(response) {
                // Remove typing indicator
                const typingEl = document.getElementById(typingId);
                if (typingEl) typingEl.remove();

                if (response.success) {
                    addMessageToUI('bot', response.data.reply);
                } else {
                    addMessageToUI('bot', '<span class="text-red-500">' + response.data.reply + '</span>');
                }
            },
            error: function() {
                const typingEl = document.getElementById(typingId);
                if (typingEl) typingEl.remove();
                addMessageToUI('bot', '<span class="text-red-500">Произошла ошибка сети.</span>');
            }
        });
    }

    // Add message helper
    function addMessageToUI(sender, text, id = null, save = true) {
        if (save && !text.includes('animate-bounce') && !text.includes('Создаю изображение')) {
            chatHistory.push({ role: sender, content: text });
            saveHistory();
        }
        const wrapper = document.createElement('div');
        wrapper.className = sender === 'user' ? 'flex justify-end' : 'flex gap-2';
        if (id) wrapper.id = id;

        let content = '';

        // Implement /clear command
        if (sender === 'user' && text.trim().toLowerCase() === '/clear') {
            chatHistory = [];
            localStorage.removeItem(STORAGE_KEY);
            if (messagesContainer.querySelector('.prose')) {
                messagesContainer.innerHTML = '';
            }
            if (!save) return;
            // Add a confirmation message that doesn't save to history
            addMessageToUI('bot', 'История чата успешно очищена.', null, false);
            return;
        }

        let parsedText = text;
        if (sender === 'bot' && !text.includes('animate-bounce') && !text.includes('Создаю изображение') && typeof marked !== 'undefined') {
            parsedText = marked.parse(text);
        }

        if (sender === 'user') {
            content = `
                <div class="bg-primary text-white p-3 rounded-2xl rounded-tr-sm shadow-sm max-w-[85%] whitespace-pre-wrap">
                    ${escapeHtml(text)}
                </div>
            `;
        } else {
            let actionButtons = '';
            // Only add download buttons to substantial bot replies (not loaders or short confirmations)
            if (save && text.length > 50 && !text.includes('animate-bounce') && !text.includes('Создаю изображение')) {
                // Generate a base64 encoded text string for the data URI
                const encodedText = encodeURIComponent(text);
                actionButtons = `
                    <div class="flex gap-2 mt-3 pt-3 border-t border-slate-100/50 justify-end">
                        <button class="text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-copy-btn" data-text="${escapeHtml(text)}">
                            <span class="material-symbols-outlined text-[14px]">content_copy</span> Копировать
                        </button>
                        <a href="data:text/plain;charset=utf-8,${encodedText}" download="Ответ_Виртуального_Библиотекаря.txt" class="text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium">
                            <span class="material-symbols-outlined text-[14px]">download</span> Скачать (TXT)
                        </a>
                    </div>
                `;
            }

            content = `
                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center shrink-0 mt-1 shadow-sm border border-primary/20">
                    <span class="material-symbols-outlined text-[16px] text-primary">auto_awesome</span>
                </div>
                <div class="bg-white border border-slate-200 p-4 rounded-[1.25rem] rounded-tl-sm shadow-sm hover:shadow-md transition-shadow text-slate-800 max-w-[85%] text-[14px] leading-relaxed break-words prose prose-sm prose-slate max-w-none">
                    ${parsedText}
                    ${actionButtons}
                </div>
            `;
        }

        wrapper.innerHTML = content;
        messagesContainer.appendChild(wrapper);

        // Bind Copy Button if present
        const copyBtn = wrapper.querySelector('.ai-copy-btn');
        if (copyBtn) {
            copyBtn.addEventListener('click', function() {
                const rawText = this.getAttribute('data-text');
                navigator.clipboard.writeText(rawText).then(() => {
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<span class="material-symbols-outlined text-[14px]">check</span> Скопировано';
                    this.classList.add('text-green-600');
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.classList.remove('text-green-600');
                    }, 2000);
                });
            });
        }

        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Escape user input to prevent XSS (Hoisted for reuse)
    function escapeHtml(unsafe) {
        return unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }

    // Listeners
    sendBtn.addEventListener('click', sendMessage);
    inputField.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
});