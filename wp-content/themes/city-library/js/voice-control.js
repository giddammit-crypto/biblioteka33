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

        // Attempt to find a high-quality (Google/Microsoft) Russian voice
        let voices = synth.getVoices();

        // Sometimes voices aren't loaded immediately
        if (voices.length === 0) {
            synth.onvoiceschanged = () => {
                voices = synth.getVoices();
                setBestRussianVoice(utterance, voices);
                synth.speak(utterance);
            };
            return;
        }

        setBestRussianVoice(utterance, voices);
        synth.speak(utterance);
    }

    function setBestRussianVoice(utterance, voices) {
        // Filter for Russian voices
        const ruVoices = voices.filter(voice => voice.lang.includes('ru') || voice.lang.includes('RU'));
        if (ruVoices.length > 0) {
            // Prefer "Yandex", "Google", "Microsoft", or Apple's "Milena" (premium natural voices)
            const premiumVoice = ruVoices.find(voice =>
                voice.name.includes('Yandex') ||
                voice.name.includes('Google') ||
                voice.name.includes('Microsoft') ||
                voice.name.includes('Milena') ||
                voice.name.includes('Yuri')
            );

            // If premium found, use it. Otherwise default to first available Russian voice.
            utterance.voice = premiumVoice ? premiumVoice : ruVoices[0];

            // Apply customizer settings
            utterance.pitch = parseFloat(cl_voice_control.voice_pitch) || 1.0;
            utterance.rate = parseFloat(cl_voice_control.voice_rate) || 1.05;
        }
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
                // Ensure URL contains a hash to scroll past hero
                let targetUrl = firstNewsLink.href;
                if (!targetUrl.includes('#')) {
                    targetUrl += '#primary';
                }
                window.location.href = targetUrl;
            } else {
                window.location.href = cl_voice_control.home_url + '/?news_archive=true#primary';
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
            // Append #primary to scroll past hero on homepage
            window.location.href = cl_voice_control.home_url + '/#primary';
            return;
        }

        if (cmd.includes('что ты умеешь') || cmd.includes('помощь') || cmd.includes('какие команды')) {
            speak('Открываю список доступных команд');
            const commandsModal = document.getElementById('voice-commands-modal');
            if (commandsModal) {
                commandsModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                requestAnimationFrame(() => {
                    commandsModal.classList.remove('opacity-0');
                    const content = commandsModal.querySelector('.voice-modal-content');
                    if (content) {
                        content.classList.remove('scale-90');
                        content.classList.add('scale-100');
                    }
                });
            }
            return;
        }

        // We removed the hardcoded 'контакты' or 'где вы находитесь' catch-all.
        // We only catch specific global commands here. Branch address queries go to AI.

        if (cmd.includes('открой контакты') || cmd.includes('раздел контакты')) {
            speak('Открываю раздел контактов');

            const allLinks = Array.from(document.querySelectorAll('a'));
            const contactLink = allLinks.find(el => el.textContent.toLowerCase().includes('контакт'));

            if (contactLink && contactLink.href) {
                 window.location.href = contactLink.href;
            } else if (document.getElementById('branches')) {
                 document.getElementById('branches').scrollIntoView({ behavior: 'smooth' });
            } else {
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

        if (cmd.includes('электронный каталог') || cmd.includes('каталог книг') || cmd.includes('каталог')) {
            speak('Открываю электронный каталог');
            // Wait a bit to let the voice synthesize before opening new tab
            setTimeout(() => {
                window.open('http://library.vladimir.ru/rguest_vlad_cgb.htm', '_blank');
            }, 1500);
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

        // Show thinking indicator for AI
        const a11yToggleBtn = document.getElementById('accessibility-button');
        const iconBtn = mobileVoiceBtn.querySelector('span');
        if (iconBtn) {
            iconBtn.textContent = 'more_horiz';
            iconBtn.classList.add('animate-spin');
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
                    const plainText = response.data.reply.replace(/<[^>]*>?/gm, '').trim();
                    speak(plainText);

                    // Open Yandex Maps if an exact address from Vladimir is returned
                    // Extract strings like "г. Владимир, пр-кт Ленина, д. 12"
                    const addressMatch = plainText.match(/г\.\s*Владимир,\s*([^.,]+),\s*д\.\s*(\d+[-а-яА-Я]*)/i);

                    if (addressMatch) {
                        const extractedAddress = addressMatch[0];
                        // Check if it's an inquiry about location to show map
                        if (query.toLowerCase().includes('где') || query.toLowerCase().includes('адрес') || query.toLowerCase().includes('находится')) {
                             // Wait a bit so the voice can start, then redirect to yandex maps with the query
                             setTimeout(() => {
                                 window.open(`https://yandex.ru/maps/?text=${encodeURIComponent(extractedAddress)}`, '_blank');
                             }, 1500);
                        } else if (document.getElementById('footer-yandex-map')) {
                             // Scroll to the embedded map in footer
                             document.getElementById('footer-yandex-map').scrollIntoView({ behavior: 'smooth' });
                        }
                    } else if (plainText.toLowerCase().includes('суздальский') || plainText.toLowerCase().includes('улица')) {
                        if (document.getElementById('branches')) {
                            document.getElementById('branches').scrollIntoView({ behavior: 'smooth' });
                        }
                    }
                } else {
                    const errorMsg = (response.data && response.data.reply) ? response.data.reply : 'Извините, я не смогла найти ответ на этот вопрос.';
                    speak(errorMsg);
                }
            },
            error: function() {
                speak('Произошла ошибка связи с сервером. Пожалуйста, проверьте подключение к интернету.');
            },
            complete: function() {
                if (iconBtn) {
                    iconBtn.textContent = 'mic';
                    iconBtn.classList.remove('animate-spin');
                }
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

    // Dragging Logic
    let isDragging = false;
    let dragStartX, dragStartY;
    let initialX, initialY;

    mobileVoiceBtn.addEventListener('touchstart', (e) => {
        isDragging = false;
        dragStartX = e.touches[0].clientX;
        dragStartY = e.touches[0].clientY;

        const rect = mobileVoiceBtn.getBoundingClientRect();
        // Calculate offset of touch point from the element's top-left corner
        initialX = dragStartX - rect.left;
        initialY = dragStartY - rect.top;

        // Disable CSS transitions during drag for smooth movement
        mobileVoiceBtn.style.transition = 'none';
    }, { passive: true });

    mobileVoiceBtn.addEventListener('touchmove', (e) => {
        const touchX = e.touches[0].clientX;
        const touchY = e.touches[0].clientY;

        // Calculate distance moved to determine if it's a drag or just a tap
        const deltaX = Math.abs(touchX - dragStartX);
        const deltaY = Math.abs(touchY - dragStartY);

        if (deltaX > 5 || deltaY > 5) {
            isDragging = true;
            e.preventDefault(); // Prevent scrolling while dragging

            // Calculate new position
            let newX = touchX - initialX;
            let newY = touchY - initialY;

            // Constrain to window bounds
            const maxX = window.innerWidth - mobileVoiceBtn.offsetWidth;
            const maxY = window.innerHeight - mobileVoiceBtn.offsetHeight;

            newX = Math.max(0, Math.min(newX, maxX));
            newY = Math.max(0, Math.min(newY, maxY));

            // Apply new position using inline styles (overrides Tailwind classes like bottom-24 right-4)
            mobileVoiceBtn.style.right = 'auto'; // Disable initial right alignment
            mobileVoiceBtn.style.bottom = 'auto'; // Disable initial bottom alignment
            mobileVoiceBtn.style.left = `${newX}px`;
            mobileVoiceBtn.style.top = `${newY}px`;
        }
    }, { passive: false });

    mobileVoiceBtn.addEventListener('touchend', (e) => {
        // Re-enable hover transitions
        mobileVoiceBtn.style.transition = '';
    });

    // Voice Commands Modal Close Logic
    const commandsModal = document.getElementById('voice-commands-modal');
    if (commandsModal) {
        const closeBtn = commandsModal.querySelector('.voice-modal-close');

        function closeVoiceModal() {
            commandsModal.classList.add('opacity-0');
            const content = commandsModal.querySelector('.voice-modal-content');
            if (content) {
                content.classList.remove('scale-100');
                content.classList.add('scale-90');
            }
            setTimeout(() => {
                commandsModal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 500);
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', closeVoiceModal);
        }

        commandsModal.addEventListener('click', (e) => {
            if (e.target === commandsModal) {
                closeVoiceModal();
            }
        });
    }

    // Single click to activate on mobile
    mobileVoiceBtn.addEventListener('click', (e) => {
        e.preventDefault();

        // If the user was dragging the button, don't trigger the voice assistant
        if (isDragging) {
            isDragging = false;
            return;
        }

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