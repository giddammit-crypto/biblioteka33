document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('ai-chat-toggle');
    const closeBtn = document.getElementById('close-ai-chat');
    const chatWindow = document.getElementById('ai-chat-window');
    const inputField = document.getElementById('ai-chat-input');
    const sendBtn = document.getElementById('ai-chat-send');
    const messagesContainer = document.getElementById('ai-chat-messages');
    const fullscreenBtn = document.getElementById('fullscreen-ai-chat');

    if (!toggleBtn || !chatWindow) return;


    // Clean and encode Cyrillic URLs specifically for Pollinations.ai issues
    function safeImageUrl(href) {
        if (!href) return '';
        // If the URL already contains a seed, don't append another one.
        // Also check if it contains Cyrillic. If it does, encodeURI it.
        let safeHref = href;
        if (/[а-яА-ЯёЁ]/.test(safeHref)) {
            safeHref = encodeURI(safeHref);
        }

        // Append random seed if it's pollinations and doesn't have one to prevent caching
        if (safeHref.includes('pollinations.ai') && !safeHref.includes('seed=')) {
            const separator = safeHref.includes('?') ? '&' : '?';
            safeHref += `${separator}seed=${Math.floor(Math.random() * 1000000)}`;
        }
        return safeHref;
    }

    // Initialize marked.js custom renderer safely for images and code blocks
    if (typeof marked !== 'undefined') {
        const renderer = new marked.Renderer();
        // Fallback for different marked.js versions (v8+ uses token, older uses arguments)
        renderer.image = function(href_or_token, title, text) {
            let href = typeof href_or_token === 'object' ? href_or_token.href : href_or_token;
            let imgText = typeof href_or_token === 'object' ? href_or_token.text : text;

            const processedHref = safeImageUrl(href);
            const cleanHref = processedHref.replace(/\s/g, '%20');

            return `
                <div class="library-image-wrapper mt-3 mb-3 relative group overflow-hidden rounded-xl border border-slate-200/60 shadow-sm">
                    <a href="${cleanHref}" class="glightbox" data-type="image">
                        <img src="${cleanHref}" alt="${imgText || 'Сгенерированное изображение'}" style="max-width:100%; height:auto; display:block;" class="transition-transform duration-500 group-hover:scale-105 bg-slate-50 min-h-[100px] w-full max-h-[350px] object-cover" onerror="this.outerHTML='<div class=\'p-4 text-center text-slate-500 bg-slate-100 rounded-lg border border-dashed border-slate-300 w-full\'>⚠️ Ошибка загрузки.</div>'">
                    </a>
                    <div class="image-controls absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 backdrop-blur-[2px] pointer-events-none">
                        <a href="${cleanHref}" target="_blank" download="Library_Poster.png" class="btn-download flex items-center gap-1.5 px-4 py-2 bg-white/90 text-slate-800 font-bold text-sm rounded-lg hover:bg-white hover:-translate-y-0.5 hover:shadow-lg transition-all shadow-sm pointer-events-auto">
                            <span class="material-symbols-outlined text-[18px]">download</span> Скачать плакат
                        </a>
                    </div>
                </div>
            `;
        };

        // Custom code block renderer with copy button
        renderer.code = function(code_or_token, lang, escaped) {
            let code = typeof code_or_token === 'object' ? code_or_token.text : code_or_token;
            let language = typeof code_or_token === 'object' ? code_or_token.lang : lang;

            return `
                <div class="code-block-wrapper relative group my-4">
                    <div class="absolute right-2 top-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="copy-code-btn p-1.5 bg-slate-800/80 hover:bg-slate-700 text-white/80 hover:text-white rounded-md flex items-center gap-1 text-[10px] uppercase font-bold tracking-wider transition-all border border-white/10" data-code="${escapeHtml(code)}">
                            <span class="material-symbols-outlined text-[14px]">content_copy</span> Копировать
                        </button>
                    </div>
                    <pre><code class="language-${language || 'text'}">${code}</code></pre>
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
        chatWindow.classList.toggle('!h-[100dvh]');
        chatWindow.classList.toggle('!w-[100vw]');
        chatWindow.classList.toggle('!max-w-none');
        chatWindow.classList.toggle('!rounded-none');

        // Disable default dimensional classes
        chatWindow.classList.toggle('sm:w-[400px]');
        chatWindow.classList.toggle('h-[65vh]');
        chatWindow.classList.toggle('max-h-[550px]');
        chatWindow.classList.toggle('sm:max-h-none');
        chatWindow.classList.toggle('sm:h-[550px]');
        chatWindow.classList.toggle('mb-4');
        chatWindow.classList.toggle('rounded-3xl');

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

    // Quick Actions
    const quickActionBtns = document.querySelectorAll('.ai-quick-action-btn');
    if (quickActionBtns) {
        quickActionBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const command = this.getAttribute('data-command');
                if (command) {
                    inputField.value = command;
                    sendMessage();
                }
            });
        });
    }

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
            addMessageToUI('bot', `
                <div class="flex items-center gap-3 text-slate-500 font-medium p-2">
                    <div class="relative w-8 h-8 flex items-center justify-center">
                        <span class="material-symbols-outlined animate-spin text-primary text-2xl">palette</span>
                        <span class="absolute inset-0 border-2 border-primary/20 border-t-primary rounded-full animate-spin"></span>
                    </div>
                    <span>Создаю визуальный образ...</span>
                </div>
            `, typingId, false);
        } else {
            addMessageToUI('bot', `
                <div class="typing-indicator flex gap-1.5 p-2 items-center">
                    <span class="w-2 h-2 bg-primary/40 rounded-full animate-bounce"></span>
                    <span class="w-2 h-2 bg-primary/60 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                    <span class="w-2 h-2 bg-primary/80 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                </div>
            `, typingId, false);
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
                history: JSON.stringify(contextHistory),
                user_name: cl_ai_ajax.user_name,
                is_logged_in: cl_ai_ajax.is_logged_in
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
        let isForeignAgent = false;

        if (sender === 'bot' && !text.includes('animate-bounce') && !text.includes('Создаю изображение')) {
            // Check for foreign agent marker or keywords
            if (text.includes('⚠️') || /\b(иноагент|иностранный агент)\b/i.test(text)) {
                isForeignAgent = true;
            }

            if (typeof marked !== 'undefined') {
                parsedText = marked.parse(text);
            }
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
                    <div class="flex gap-2 mt-3 pt-3 border-t border-slate-100/50 justify-end flex-wrap">
                        <button class="text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-copy-btn" data-text="${escapeHtml(text)}">
                            <span class="material-symbols-outlined text-[14px]">content_copy</span> Копировать
                        </button>
                        <a href="data:text/plain;charset=utf-8,${encodedText}" download="Ответ_Виртуального_Библиотекаря.txt" class="text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium">
                            <span class="material-symbols-outlined text-[14px]">download</span> Скачать (TXT)
                        </a>
                        <button class="text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-pdf-btn" data-text="${escapeHtml(text)}">
                            <span class="material-symbols-outlined text-[14px]">picture_as_pdf</span> PDF
                        </button>
                        <button class="text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-docx-btn" data-text="${escapeHtml(text)}">
                            <span class="material-symbols-outlined text-[14px]">description</span> DOCX
                        </button>
                        <button class="text-xs text-slate-400 hover:text-primary transition-colors flex items-center gap-1 font-medium ai-email-btn" data-text="${escapeHtml(text)}">
                            <span class="material-symbols-outlined text-[14px]">mail</span> На почту
                        </button>
                        ${text.toLowerCase().includes('источники') && text.length > 500 ? `
                        <button class="text-xs text-slate-500 hover:text-primary transition-colors flex items-center gap-1 font-bold ai-save-draft-btn bg-slate-100 hover:bg-slate-200 px-2.5 py-1.5 rounded-lg border border-slate-200 ml-auto" data-text="${escapeHtml(text)}">
                            <span class="material-symbols-outlined text-[16px]">note_add</span> Сохранить черновик в WP
                        </button>
                        ` : ''}
                    </div>
                `;
            }

            content = `
                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center shrink-0 mt-1 shadow-sm border border-slate-300 overflow-hidden relative">
                    <img src="${cl_ai_ajax.avatar_url}" alt="AI Avatar" class="w-full h-full object-cover">
                </div>
                <div class="bg-white border border-slate-200 p-4 rounded-[1.25rem] rounded-tl-sm shadow-sm hover:shadow-md transition-shadow text-slate-800 max-w-[85%] text-[14px] leading-relaxed break-words prose prose-sm prose-slate max-w-none relative">
                    ${isForeignAgent ? `
                        <div class="inoagent-badge absolute -top-3 right-4 px-2 py-0.5 bg-amber-100 border border-amber-200 rounded text-[10px] font-bold text-amber-700 uppercase tracking-tighter flex items-center gap-1 z-10 shadow-sm animate-badge-pulse">
                            <span class="material-symbols-outlined text-[12px]">warning</span> Иноагент
                        </div>
                    ` : ''}
                    ${parsedText}
                    ${actionButtons}
                </div>
            `;
        }

        wrapper.innerHTML = content;
        messagesContainer.appendChild(wrapper);

        // Handle book covers for bot messages
        if (sender === 'bot' && save && !text.includes('animate-bounce') && !text.includes('Создаю изображение')) {
            const proseContainer = wrapper.querySelector('.prose');
            if (proseContainer) processBookMentions(text, proseContainer);
        }

        // Re-initialize GLightbox for new content
        if (typeof GLightbox !== 'undefined') {
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                autoplayVideos: true
            });
        }

        // Bind Code Copy Buttons
        const codeCopyBtns = wrapper.querySelectorAll('.copy-code-btn');
        codeCopyBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const code = this.getAttribute('data-code');
                navigator.clipboard.writeText(code).then(() => {
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<span class="material-symbols-outlined text-[14px]">check</span> Готово';
                    this.classList.add('bg-green-600/90');
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.classList.remove('bg-green-600/90');
                    }, 2000);
                });
            });
        });

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

        // Bind PDF Download (using browser print to PDF)
        const pdfBtn = wrapper.querySelector('.ai-pdf-btn');
        if (pdfBtn) {
            pdfBtn.addEventListener('click', function() {
                const rawText = this.getAttribute('data-text');
                const printWindow = window.open('', '_blank', 'width=800,height=600');
                let htmlContent = rawText;
                if (typeof marked !== 'undefined') {
                    htmlContent = marked.parse(rawText);
                }
                printWindow.document.write(`
                    <html><head><title>Печать / Сохранить как PDF</title>
                    <style>
                        body { font-family: sans-serif; padding: 40px; line-height: 1.6; color: #333; }
                        img { max-width: 100%; height: auto; }
                    </style>
                    </head><body>
                    ${htmlContent}
                    <script>window.onload = function() { window.print(); window.close(); }</script>
                    </body></html>
                `);
                printWindow.document.close();
            });
        }

        // Bind DOCX Download
        const docxBtn = wrapper.querySelector('.ai-docx-btn');
        if (docxBtn) {
            docxBtn.addEventListener('click', function() {
                const rawText = this.getAttribute('data-text');
                const originalHTML = this.innerHTML;
                this.innerHTML = '<span class="material-symbols-outlined text-[14px] animate-spin">sync</span> ...';
                this.disabled = true;

                jQuery.ajax({
                    url: cl_ai_ajax.url,
                    type: 'POST',
                    data: {
                        action: 'city_library_ai_docx',
                        nonce: cl_ai_ajax.nonce,
                        content: rawText
                    },
                    success: (response) => {
                        if (response.success) {
                            const byteCharacters = atob(response.data.html);
                            const byteNumbers = new Array(byteCharacters.length);
                            for (let i = 0; i < byteCharacters.length; i++) {
                                byteNumbers[i] = byteCharacters.charCodeAt(i);
                            }
                            const byteArray = new Uint8Array(byteNumbers);
                            const blob = new Blob([byteArray], { type: 'application/msword;charset=utf-8' });
                            const link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = 'Ответ_Библиотекаря.doc';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        } else {
                            alert("Ошибка генерации DOCX: " + response.data);
                        }
                    },
                    error: () => {
                        alert("Произошла ошибка при генерации документа.");
                    },
                    complete: () => {
                        this.innerHTML = originalHTML;
                        this.disabled = false;
                    }
                });
            });
        }

        // Bind Email Button
        const emailBtn = wrapper.querySelector('.ai-email-btn');
        if (emailBtn) {
            emailBtn.addEventListener('click', function() {
                const rawText = this.getAttribute('data-text');
                const userEmail = prompt("Введите ваш email адрес для отправки ответа:");
                if (userEmail && userEmail.trim() !== '') {
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<span class="material-symbols-outlined text-[14px] animate-spin">sync</span> ...';
                    this.disabled = true;

                    jQuery.ajax({
                        url: cl_ai_ajax.url,
                        type: 'POST',
                        data: {
                            action: 'city_library_ai_email',
                            nonce: cl_ai_ajax.nonce,
                            email: userEmail,
                            content: rawText
                        },
                        success: (response) => {
                            if (response.success) {
                                this.innerHTML = '<span class="material-symbols-outlined text-[14px]">check</span> Отправлено';
                                this.classList.add('text-green-600');
                                setTimeout(() => {
                                    this.innerHTML = originalHTML;
                                    this.classList.remove('text-green-600');
                                }, 3000);
                            } else {
                                alert("Ошибка: " + response.data);
                                this.innerHTML = originalHTML;
                            }
                        },
                        error: () => {
                            alert("Произошла ошибка при отправке.");
                            this.innerHTML = originalHTML;
                        },
                        complete: () => {
                            this.disabled = false;
                        }
                    });
                }
            });
        }

        // Bind Draft Button if present
        const draftBtns = wrapper.querySelectorAll('.ai-draft-btn');
        if (draftBtns.length > 0) {
            draftBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const authorName = this.getAttribute('data-author');
                    if (authorName) {
                        inputField.value = '/author ' + authorName;
                        sendMessage();
                    }
                });
            });
        }

        // Bind Save to WP Draft button
        const saveDraftBtn = wrapper.querySelector('.ai-save-draft-btn');
        if (saveDraftBtn) {
            saveDraftBtn.addEventListener('click', function() {
                const rawText = this.getAttribute('data-text');
                const postTitle = 'Черновик: ' + (rawText.split('\n')[0].replace(/#/g, '').trim() || 'Статья');

                const originalHTML = this.innerHTML;
                this.innerHTML = '<span class="material-symbols-outlined text-[14px] animate-spin">sync</span> Сохраняем...';
                this.disabled = true;

                jQuery.ajax({
                    url: cl_ai_ajax.url,
                    type: 'POST',
                    data: {
                        action: 'city_library_ai_draft',
                        nonce: cl_ai_ajax.nonce,
                        title: postTitle,
                        content: rawText
                    },
                    success: (response) => {
                        if (response.success) {
                            this.innerHTML = `<a href="${response.data.edit_link}" target="_blank" class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">open_in_new</span> Редактировать</a>`;
                            this.classList.add('text-green-600', 'hover:text-green-700');
                            this.classList.remove('text-slate-500', 'hover:text-primary', 'bg-slate-100');
                        } else {
                            alert("Ошибка: " + response.data);
                            this.innerHTML = originalHTML;
                        }
                    },
                    error: () => {
                        alert("Произошла ошибка при создании черновика.");
                        this.innerHTML = originalHTML;
                    },
                    complete: () => {
                        this.disabled = false;
                    }
                });
            });
        }

        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // --- Book Covers Logic ---
    async function fetchBookCover(query) {
        try {
            const response = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(query)}&maxResults=1`);
            const data = await response.json();
            if (data.items && data.items[0] && data.items[0].volumeInfo.imageLinks) {
                return data.items[0].volumeInfo.imageLinks.thumbnail.replace('http:', 'https:');
            }
        } catch (e) {
            console.error('Book cover fetch error:', e);
        }
        return null;
    }

    async function processBookMentions(text, container) {
        // Regex for "Author - Title" or quoted titles
        const bookRegex = /(?:«([^»]+)»\s+([А-ЯЁ][а-яё]+(?:\s+[А-ЯЁ][а-яё]+)?))|([А-ЯЁ][а-яё]+\s+[А-ЯЁ][а-яё]+)\s+(?:-|—)\s+«([^»]+)»/g;
        let matches;
        const foundBooks = [];

        while ((matches = bookRegex.exec(text)) !== null) {
            const title = matches[1] || matches[4];
            const author = matches[2] || matches[3];
            if (title && author) foundBooks.push(`${author} ${title}`);
        }

        if (foundBooks.length > 0) {
            const shelf = document.createElement('div');
            shelf.className = 'book-shelf-wrapper flex gap-3 overflow-x-auto py-4 px-2 scrollbar-hide mt-2 border-t border-slate-100';
            container.appendChild(shelf);

            for (const bookQuery of foundBooks) {
                const coverUrl = await fetchBookCover(bookQuery);
                if (coverUrl) {
                    const bookEl = document.createElement('div');
                    bookEl.className = 'book-card flex-shrink-0 w-24 group cursor-pointer';
                    bookEl.innerHTML = `
                        <div class="relative aspect-[2/3] rounded-md overflow-hidden shadow-sm group-hover:shadow-md transition-all group-hover:-translate-y-1">
                            <img src="${coverUrl}" alt="${bookQuery}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="material-symbols-outlined text-white">menu_book</span>
                            </div>
                        </div>
                        <p class="text-[10px] mt-1.5 text-slate-500 font-medium line-clamp-2 leading-tight">${bookQuery}</p>
                    `;
                    bookEl.onclick = () => {
                        inputField.value = `Расскажи подробнее о книге ${bookQuery}`;
                        sendMessage();
                    };
                    shelf.appendChild(bookEl);
                }
            }
        }
    }

    // --- Scroll to Bottom Button ---
    const scrollBtn = document.createElement('button');
    scrollBtn.id = 'ai-chat-scroll-bottom';
    scrollBtn.className = 'absolute bottom-20 right-6 w-10 h-10 bg-white border border-slate-200 rounded-full shadow-lg flex items-center justify-center text-primary transition-all scale-0 z-50 hover:bg-slate-50 active:scale-95';
    scrollBtn.innerHTML = '<span class="material-symbols-outlined">arrow_downward</span>';
    chatWindow.appendChild(scrollBtn);

    messagesContainer.addEventListener('scroll', () => {
        const threshold = 150;
        const isNearBottom = messagesContainer.scrollHeight - messagesContainer.scrollTop - messagesContainer.clientHeight < threshold;
        if (!isNearBottom) {
            scrollBtn.classList.remove('scale-0');
        } else {
            scrollBtn.classList.add('scale-0');
        }
    });

    scrollBtn.onclick = () => {
        messagesContainer.scrollTo({ top: messagesContainer.scrollHeight, behavior: 'smooth' });
    };

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

    // File Attachment Logic
    const attachmentBtn = document.getElementById('ai-chat-attachment');
    const fileInput = document.getElementById('ai-chat-file-input');
    if (attachmentBtn && fileInput) {
        attachmentBtn.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 20 * 1024 * 1024) {
                    alert('Файл слишком большой. Максимум 20МБ.');
                    this.value = '';
                    return;
                }
                inputField.value = `[Файл прикреплен: ${file.name}] Проанализируй этот файл.`;
                addMessageToUI('bot', `<span class="text-slate-500 text-xs italic"><span class="material-symbols-outlined text-[14px] align-middle mr-1">attach_file</span> Вы прикрепили файл: ${file.name}. В данный момент полная интеграция парсинга в разработке, файл имитирован.</span>`, null, false);
                this.value = '';
            }
        });
    }
});