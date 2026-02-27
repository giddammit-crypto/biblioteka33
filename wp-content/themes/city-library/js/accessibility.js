/**
 * Accessibility Tools (AAA Quality)
 *
 * Provides a robust cycler for accessibility modes with persistent state.
 * Modes: Normal -> Large Text -> High Contrast (Black/White/Yellow)
 */
document.addEventListener('DOMContentLoaded', () => {
    const accessibilityButton = document.getElementById('accessibility-button');
    if (!accessibilityButton) return;

    // Inject CSS for accessibility modes
    const style = document.createElement('style');
    style.id = 'city-library-a11y-styles';
    style.innerHTML = `
        /* --- Large Text Mode --- */
        body.a11y-large-text {
            font-size: 130% !important;
            line-height: 1.6 !important;
        }
        body.a11y-large-text h1, body.a11y-large-text .text-5xl, body.a11y-large-text .text-7xl, body.a11y-large-text .text-8xl { font-size: 4rem !important; line-height: 1.2 !important; }
        body.a11y-large-text h2, body.a11y-large-text .text-4xl, body.a11y-large-text .text-5xl { font-size: 3rem !important; }
        body.a11y-large-text h3, body.a11y-large-text .text-2xl, body.a11y-large-text .text-3xl { font-size: 2rem !important; }
        body.a11y-large-text p, body.a11y-large-text li, body.a11y-large-text a, body.a11y-large-text span { font-size: 1.2rem !important; }

        /* --- High Contrast Mode (AAA - Black/White/Yellow) --- */
        body.a11y-high-contrast {
            background-color: #000000 !important;
            color: #ffffff !important;
            filter: grayscale(100%) contrast(120%); /* Force grayscale base */
        }

        /* Override ALL backgrounds and colors for strict contrast */
        body.a11y-high-contrast *:not(img):not(video):not(.material-symbols-outlined) {
            background-color: #000000 !important;
            background-image: none !important;
            color: #ffffff !important;
            border-color: #ffffff !important;
            box-shadow: none !important;
            text-shadow: none !important;
        }

        /* Links - Yellow for high visibility against black */
        body.a11y-high-contrast a,
        body.a11y-high-contrast a * {
            color: #ffff00 !important;
            text-decoration: underline !important;
        }
        body.a11y-high-contrast a:hover,
        body.a11y-high-contrast a:focus {
            background-color: #ffff00 !important;
            color: #000000 !important;
            outline: 2px solid #ffffff !important;
        }

        /* Buttons & Inputs */
        body.a11y-high-contrast button,
        body.a11y-high-contrast input,
        body.a11y-high-contrast select,
        body.a11y-high-contrast textarea,
        body.a11y-high-contrast .wp-block-button__link,
        body.a11y-high-contrast .btn,
        body.a11y-high-contrast [role="button"] {
            background-color: #000000 !important;
            color: #ffff00 !important;
            border: 2px solid #ffff00 !important;
            font-weight: bold !important;
        }
        body.a11y-high-contrast button:hover,
        body.a11y-high-contrast [role="button"]:hover {
            background-color: #ffff00 !important;
            color: #000000 !important;
        }

        /* Images - Optional: Add high contrast filter or border */
        body.a11y-high-contrast img {
            border: 1px solid #ffffff !important;
            filter: grayscale(100%) contrast(120%) !important;
        }

        /* Hide decorative elements */
        body.a11y-high-contrast .decorative-element,
        body.a11y-high-contrast .bg-pattern-slate,
        body.a11y-high-contrast .hero-gradient {
            background: none !important;
        }
    `;

    // Ensure styles are added only once
    if (!document.getElementById('city-library-a11y-styles')) {
        document.head.appendChild(style);
    }

    const modes = ['normal', 'large-text', 'high-contrast'];
    let currentModeIndex = 0;

    // Load saved preference
    const savedMode = localStorage.getItem('city_library_a11y_mode');
    if (savedMode && modes.includes(savedMode)) {
        currentModeIndex = modes.indexOf(savedMode);
        applyMode(savedMode);
    }

    accessibilityButton.addEventListener('click', (e) => {
        e.preventDefault();
        // Cycle to next mode
        currentModeIndex = (currentModeIndex + 1) % modes.length;
        const newMode = modes[currentModeIndex];

        applyMode(newMode);
        localStorage.setItem('city_library_a11y_mode', newMode);

        // Announce change for screen readers via alert or live region (using alert for simplicity as requested)
        const messages = {
            'normal': 'Обычный режим сайта включен.',
            'large-text': 'Режим крупного текста включен.',
            'high-contrast': 'Режим высокой контрастности включен.'
        };
        // Use a small timeout to let the UI update first
        setTimeout(() => alert(messages[newMode]), 50);
    });

    function applyMode(mode) {
        document.body.classList.remove('a11y-large-text', 'a11y-high-contrast');

        if (mode === 'large-text') {
            document.body.classList.add('a11y-large-text');
        } else if (mode === 'high-contrast') {
            document.body.classList.add('a11y-high-contrast');
        }
    }
});
