/**
 * Voice Control for City Library
 * Activated by double clicking the accessibility toggle button.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Check if voice control is enabled via localized script variables
    if (typeof cl_voice_control === 'undefined' || !cl_voice_control.enabled) {
        return;
    }

    const a11yToggleBtn = document.getElementById('accessibility-button');
    if (!a11yToggleBtn) {
        console.warn('Voice Control: Accessibility button not found.');
        return;
    }

    let recognition = null;
    let isListening = false;
    const synth = window.speechSynthesis;

    // Web Speech API Initialization
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    if (SpeechRecognition) {
        recognition = new SpeechRecognition();
        recognition.continuous = false; // Stop after one command
        recognition.lang = 'ru-RU'; // Russian
        recognition.interimResults = false;
    } else {
        console.warn('Speech Recognition API not supported in this browser.');
        return;
    }

    // UI Indicator
    const indicator = document.createElement('div');
    indicator.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-600 text-white px-6 py-3 rounded-full shadow-2xl z-[9999] font-bold text-sm flex items-center gap-3 transition-all duration-300 opacity-0 translate-y-[-20px] pointer-events-none';
    indicator.innerHTML = '<span class="material-symbols-outlined animate-pulse">mic</span> Слушаю команду...';
    document.body.appendChild(indicator);

    function showIndicator() {
        indicator.style.opacity = '1';
        indicator.style.transform = 'translate(-50%, 0)';
    }

    function hideIndicator() {
        indicator.style.opacity = '0';
        indicator.style.transform = 'translate(-50%, -20px)';
    }

    function speak(text) {
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
            if (document.getElementById('branches')) {
                document.getElementById('branches').scrollIntoView({ behavior: 'smooth' });
            } else {
                window.location.href = cl_voice_control.home_url + '/#branches';
            }
            return;
        }

        if (cmd.includes('версия для слабовидящих') || cmd.includes('обычная версия')) {
             speak('Переключаю режим отображения');
             a11yToggleBtn.click();
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

    // Double click to activate
    a11yToggleBtn.addEventListener('dblclick', (e) => {
        e.preventDefault(); // Prevent standard toggle on double click

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