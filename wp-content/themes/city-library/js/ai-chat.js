document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('ai-chat-toggle');
    const closeBtn = document.getElementById('close-ai-chat');
    const chatWindow = document.getElementById('ai-chat-window');
    const inputField = document.getElementById('ai-chat-input');
    const sendBtn = document.getElementById('ai-chat-send');
    const messagesContainer = document.getElementById('ai-chat-messages');
    const fullscreenBtn = document.getElementById('fullscreen-ai-chat');

    if (!toggleBtn || !chatWindow) return;

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
        chatWindow.classList.toggle('w-full');
        chatWindow.classList.toggle('h-[100dvh]');
        chatWindow.classList.toggle('rounded-none');

        // Remove default fixed width/height when fullscreen
        chatWindow.classList.toggle('w-80');
        chatWindow.classList.toggle('sm:w-96');
        chatWindow.classList.toggle('h-[500px]');
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

        // 2. Show typing indicator
        const typingId = 'typing-' + Date.now();
        addMessageToUI('bot', '<span class="flex gap-1 items-center"><span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce"></span><span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></span><span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span></span>', typingId);

        // 3. Send AJAX Request
        jQuery.ajax({
            url: cl_ai_ajax.url,
            type: 'POST',
            data: {
                action: 'city_library_ai_chat',
                nonce: cl_ai_ajax.nonce,
                message: message
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
    function addMessageToUI(sender, text, id = null) {
        const wrapper = document.createElement('div');
        wrapper.className = sender === 'user' ? 'flex justify-end' : 'flex gap-2';
        if (id) wrapper.id = id;

        let content = '';

        if (sender === 'user') {
            content = `
                <div class="bg-primary text-white p-3 rounded-2xl rounded-tr-sm shadow-sm max-w-[85%]">
                    ${text}
                </div>
            `;
        } else {
            content = `
                <div class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center shrink-0 mt-1">
                    <span class="material-symbols-outlined text-[14px] text-primary">auto_awesome</span>
                </div>
                <div class="bg-white border border-slate-200 p-3 rounded-2xl rounded-tl-sm shadow-sm text-slate-700 max-w-[85%]">
                    ${text}
                </div>
            `;
        }

        wrapper.innerHTML = content;
        messagesContainer.appendChild(wrapper);

        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Listeners
    sendBtn.addEventListener('click', sendMessage);
    inputField.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
});