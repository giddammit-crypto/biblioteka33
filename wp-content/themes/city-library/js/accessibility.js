/**
 * Accessibility Tools (AAA Quality - GOST Standard)
 *
 * Provides a robust toggle for accessibility modes with persistent state.
 * Modes: Normal <-> GOST High Contrast (Black/White/Yellow, Large Text, No Images)
 */
document.addEventListener('DOMContentLoaded', () => {
    const accessibilityButton = document.getElementById('accessibility-button');
    if (!accessibilityButton) return;

    // Inject CSS for GOST AAA accessibility mode
    const style = document.createElement('style');
    style.id = 'city-library-a11y-styles';
    style.innerHTML = `
        /* --- GOST High Contrast Mode (AAA - Black/White/Yellow, Arial, Fully Adaptive) --- */
        body.a11y-high-contrast {
            background-color: #000000 !important;
            color: #ffffff !important;
            font-family: Arial, Helvetica, sans-serif !important; /* GOST recommends simple sans-serif */
            font-size: clamp(1rem, 2vw + 0.5rem, 1.5rem) !important; /* Adaptive base font size */
            line-height: 1.5 !important;
            letter-spacing: 0.05em !important;
        }

        /* Force text sizes to scale adaptively */
        body.a11y-high-contrast h1, body.a11y-high-contrast .text-5xl, body.a11y-high-contrast .text-6xl, body.a11y-high-contrast .text-7xl, body.a11y-high-contrast .text-8xl { font-size: clamp(2rem, 5vw + 1rem, 3rem) !important; line-height: 1.2 !important; font-family: Arial, Helvetica, sans-serif !important; font-weight: bold !important; }
        body.a11y-high-contrast h2, body.a11y-high-contrast .text-4xl, body.a11y-high-contrast .text-3xl { font-size: clamp(1.5rem, 4vw + 0.5rem, 2.5rem) !important; font-family: Arial, Helvetica, sans-serif !important; font-weight: bold !important; }
        body.a11y-high-contrast h3, body.a11y-high-contrast .text-2xl { font-size: clamp(1.25rem, 3vw + 0.5rem, 2rem) !important; font-family: Arial, Helvetica, sans-serif !important; font-weight: bold !important; }
        body.a11y-high-contrast p, body.a11y-high-contrast li, body.a11y-high-contrast span, body.a11y-high-contrast div { font-family: Arial, Helvetica, sans-serif !important; word-wrap: break-word !important; overflow-wrap: break-word !important; }

        /* Disable all transitions and animations */
        body.a11y-high-contrast *, body.a11y-high-contrast *:before, body.a11y-high-contrast *:after {
            transition: none !important;
            animation: none !important;
            transform: none !important;
        }

        /* Override ALL backgrounds and colors for strict contrast */
        body.a11y-high-contrast *:not(img):not(video):not(.material-symbols-outlined) {
            background-color: #000000 !important;
            background-image: none !important;
            color: #ffffff !important;
            border-color: #ffffff !important;
            box-shadow: none !important;
            text-shadow: none !important;
            border-radius: 0 !important; /* Square corners are often preferred for strict structure */
        }

        /* Links - Yellow for high visibility against black */
        body.a11y-high-contrast a,
        body.a11y-high-contrast a * {
            color: #ffff00 !important;
            text-decoration: underline !important;
            text-decoration-thickness: 2px !important;
        }
        body.a11y-high-contrast a:hover,
        body.a11y-high-contrast a:focus {
            background-color: #ffff00 !important;
            color: #000000 !important;
            outline: 4px solid #ffffff !important;
            outline-offset: 4px !important;
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
            border: 3px solid #ffff00 !important;
            font-weight: bold !important;
            padding: 10px 15px !important;
            font-size: 1.2rem !important;
        }
        body.a11y-high-contrast button:hover,
        body.a11y-high-contrast button:focus,
        body.a11y-high-contrast [role="button"]:hover,
        body.a11y-high-contrast [role="button"]:focus {
            background-color: #ffff00 !important;
            color: #000000 !important;
            outline: 4px solid #ffffff !important;
        }

        /* Images - Hide decorative, strictly border informative ones */
        body.a11y-high-contrast img {
            border: 2px solid #ffffff !important;
            filter: grayscale(100%) contrast(150%) !important;
            max-width: 100% !important;
        }

        /* Hide purely decorative background elements, blur effects, gradients */
        body.a11y-high-contrast .absolute.bg-primary\\/5,
        body.a11y-high-contrast .blur-3xl,
        body.a11y-high-contrast .bg-pattern-slate,
        body.a11y-high-contrast [class*="bg-gradient"],
        body.a11y-high-contrast .pointer-events-none {
            display: none !important;
        }

        /* Enforce visible structure for layout elements */
        body.a11y-high-contrast article,
        body.a11y-high-contrast section,
        body.a11y-high-contrast .widget {
            border: 2px solid #ffffff !important;
            margin-bottom: 2rem !important;
            padding: 1rem !important;
            max-width: 100vw !important;
            box-sizing: border-box !important;
            overflow-x: hidden !important;
        }
    `;

    // Ensure styles are added only once
    if (!document.getElementById('city-library-a11y-styles')) {
        document.head.appendChild(style);
    }

    const modes = ['normal', 'high-contrast'];
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

        // Announce change for screen readers via alert
        const messages = {
            'normal': 'Обычный режим сайта включен.',
            'high-contrast': 'Версия для слабовидящих включена.'
        };
        // Use a small timeout to let the UI update first
        setTimeout(() => alert(messages[newMode]), 50);
    });

    function applyMode(mode) {
        document.body.classList.remove('a11y-high-contrast');

        if (mode === 'high-contrast') {
            document.body.classList.add('a11y-high-contrast');
        }
    }
});
