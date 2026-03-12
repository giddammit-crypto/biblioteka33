/**
 * Voice Control for City Library
 * Activated by double clicking the accessibility toggle button.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Check if voice control is enabled via localized script variables
    if (typeof cl_voice_control === 'undefined' || !cl_voice_control.enabled) {
        return;
    }

    const mobileVoiceBtn = document.getElementById('mobile-voice-assistant-btn');
    if (!mobileVoiceBtn) {
        return; // Early return if button is not present (e.g., user not logged in)
    }

    let recognition = null;
    let isListening = false;
    const synth = window.speechSynthesis;
    const isMobile = window.innerWidth < 1024;

    // Web Speech API Initialization
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (SpeechRecognition) {
        recognition = new SpeechRecognition();
        recognition.continuous = false; // Stop after one command
        recognition.lang = 'ru-RU'; // Russian
        recognition.interimResults = false;
    } else {
        console.warn('Speech Recognition API not supported in this browser.');
        // Optionally, hide the button if API is not supported
        mobileVoiceBtn.style.display = 'none';
        return;
    }

    // UI Indicator (Stylish Mobile Overlay)
    const indicator = document.createElement('div');
    indicator.className = 'fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-black/80 backdrop-blur-xl text-white px-10 py-8 rounded-3xl shadow-2xl z-[9999] font-bold text-xl flex flex-col items-center gap-4 transition-all duration-300 opacity-0 scale-90 pointer-events-none text-center border border-white/10';
    indicator.innerHTML = `
        <div class="relative w-16 h-16 flex items-center justify-center bg-primary rounded-full mb-2">
            <span class="material-symbols-outlined text-4xl animate-pulse">mic</span>
            <div class="absolute inset-0 rounded-full border-[3px] border-primary animate-ping opacity-75"></div>
        </div>
        <span class="tracking-wide text-glow">Слушаю Вас!</span>
    `;
    document.body.appendChild(indicator);

    function showIndicator() {
        indicator.style.opacity = '1';
        indicator.style.transform = 'translate(-50%, -50%) scale(1)';
        // Change the button state to show it's active
        mobileVoiceBtn.classList.add('bg-primary', 'text-white');
        mobileVoiceBtn.classList.remove('bg-white', 'text-primary');
    }

    function hideIndicator() {
        indicator.style.opacity = '0';
        indicator.style.transform = 'translate(-50%, -50%) scale(0.9)';
        // Revert button state
        mobileVoiceBtn.classList.remove('bg-primary', 'text-white');
        mobileVoiceBtn.classList.add('bg-white', 'text-primary');
    }

    function speak(text) {
        // As per request: "Вместо этого (Слушаю) для мобильной версии надо сделать всплывающее уведомление"
        // We will skip voice synthesis for the "Слушаю" phrase, but still use it for other responses.
        if (text === 'Слушаю' && isMobile) {
            return;
        }
        if (synth.speaking) synth.cancel();
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'ru-RU';
        utterance.rate = 1.0;
        synth.speak(utterance);
    }

    // Command Processing
    function processCommand(command) {
        const cmd = command.toLowerCase().trim();
        console.log('Voice Command Received:', cmd);

        // Predefined Commands Map
        if (cmd.includes('открой последние новости') || cmd.includes('открой последнюю новость')) {
            speak('Открываю последнюю новость');
            // Redirect to the first news item (assuming it's on the homepage or news archive)
            const firstNewsLink = document.querySelector('.news-slider a, .content-area a');
            if (firstNewsLink && firstNewsLink.href) {
                window.location.href = firstNewsLink.href;
            } else {
                window.location.href = cl_voice_control.home_url + '/?news_archive=true';
            }
            return;
        }

        if (cmd.includes('афиша новостей') || cmd.includes('афиша') || cmd.includes('мероприятия')) {
            speak('Перехожу к афише мероприятий');
            if (document.getElementById('afisha')) {
                document.getElementById('afisha').scrollIntoView({ behavior: 'smooth' });
            } else {
                window.location.href = cl_voice_control.home_url + '/#afisha';
            }
            return;
        }

        if (cmd.includes('на главную') || cmd.includes('главная страница')) {
            speak('Открываю главную страницу');
            window.location.href = cl_voice_control.home_url;
            return;
        }

        if (cmd.includes('контакты') || cmd.includes('адрес') || cmd.includes('где вы находитесь')) {
            speak('Открываю раздел контактов');

            // Logic to open "О нас" submenu and navigate to Contacts
            // In WordPress standard menu, if 'Контакты' is under 'О нас', it usually has its own URL.
            // We search for a link with text containing 'контакт'
            const allLinks = Array.from(document.querySelectorAll('a'));
            const contactLink = allLinks.find(el => el.textContent.toLowerCase().includes('контакт'));

            if (contactLink && contactLink.href) {
                 window.location.href = contactLink.href;
            } else if (document.getElementById('branches')) {
                 document.getElementById('branches').scrollIntoView({ behavior: 'smooth' });
            } else {
                 // Fallback to homepage anchor
                 window.location.href = cl_voice_control.home_url + '/#branches';
            }
            return;
        }

        if (cmd.includes('продление книг') || cmd.includes('продлить книгу')) {
            speak('Открываю форму продления книг');
            const renewBtn = document.getElementById('book-renewal-btn');
            if (renewBtn) {
                // Ensure it's not hidden due to visibility logic
                renewBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-x-full');
                renewBtn.click();
            } else {
                speak('Функция продления книг сейчас недоступна.');
            }
            return;
        }

        if (cmd.includes('версия для слабовидящих') || cmd.includes('обычная версия')) {
             speak('Переключаю режим отображения');
             const a11yToggleBtn = document.getElementById('accessibility-button');
             if (a11yToggleBtn) a11yToggleBtn.click();
             return;
        }

        // Fallback: Send to Virtual Librarian AI
        speak('Секундочку, уточняю информацию...');
        askVirtualLibrarian(command);
    }

    function askVirtualLibrarian(query) {
        if (!cl_voice_control.ai_nonce) {
            speak('Извините, виртуальный помощник сейчас недоступен.');
            return;
        }

        jQuery.ajax({
            url: cl_voice_control.ajax_url,
            type: 'POST',
            data: {
                action: 'city_library_ai_chat',
                nonce: cl_voice_control.ai_nonce,
                message: query
            },
            success: function(response) {
                if (response.success) {
                    // Strip HTML tags from AI response before speaking
                    const plainText = response.data.reply.replace(/<[^>]*>?/gm, '');
                    speak(plainText);
                } else {
                    speak('Я не смог найти ответ на этот вопрос.');
                }
            },
            error: function() {
                speak('Произошла ошибка связи с сервером.');
            }
        });
    }

    // Recognition Events
    recognition.onstart = function() {
        isListening = true;
        showIndicator();
        if (synth.speaking) synth.cancel(); // Stop talking when starting to listen
        speak('Слушаю');
    };

    recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        processCommand(transcript);
    };

    recognition.onerror = function(event) {
        console.error('Speech recognition error', event.error);
        isListening = false;
        hideIndicator();
        speak('Ошибка распознавания голоса. Повторите попытку.');
    };

    recognition.onend = function() {
        isListening = false;
        hideIndicator();
    };

    // Single click to activate on mobile
    mobileVoiceBtn.addEventListener('click', (e) => {
        e.preventDefault();

        if (isListening) {
            recognition.stop();
        } else {
            try {
                recognition.start();
            } catch(err) {
                console.error('Failed to start recognition:', err);
            }
        }
    });

    // Also add a keyboard shortcut (Ctrl+Shift+V or Alt+V) as a fallback for accessibility
    document.addEventListener('keydown', (e) => {
        if (e.altKey && e.code === 'KeyV') {
            if (isListening) {
                recognition.stop();
            } else {
                recognition.start();
            }
        }
    });
});