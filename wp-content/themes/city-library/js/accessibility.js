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
            /* Do not disable transforms globally, as they break Swiper sliders and absolute positioning on mobile */
        }

        /* Override backgrounds and colors carefully to maintain layout integrity */
        body.a11y-high-contrast {
            background-color: #000000 !important;
            color: #ffffff !important;
        }

        /* Remove background graphics, shadows, and rounded corners globally without destroying div display properties */
        body.a11y-high-contrast *,
        body.a11y-high-contrast *::before,
        body.a11y-high-contrast *::after {
            background-image: none !important;
            box-shadow: none !important;
            text-shadow: none !important;
            border-radius: 0 !important;
        }

        /* Force high contrast text colors explicitly on standard containers */
        body.a11y-high-contrast h1, body.a11y-high-contrast h2, body.a11y-high-contrast h3, body.a11y-high-contrast h4, body.a11y-high-contrast h5, body.a11y-high-contrast h6,
        body.a11y-high-contrast p, body.a11y-high-contrast span:not(.material-symbols-outlined), body.a11y-high-contrast li, body.a11y-high-contrast td, body.a11y-high-contrast th, body.a11y-high-contrast label, body.a11y-high-contrast div {
            color: #ffffff !important;
        }

        /* Ensure containers that might have inherited light backgrounds from Tailwind are forced black */
        body.a11y-high-contrast main,
        body.a11y-high-contrast header,
        body.a11y-high-contrast footer,
        body.a11y-high-contrast section,
        body.a11y-high-contrast article,
        body.a11y-high-contrast nav,
        body.a11y-high-contrast .bg-white,
        body.a11y-high-contrast .bg-slate-50,
        body.a11y-high-contrast .bg-slate-100,
        body.a11y-high-contrast .bg-slate-800,
        body.a11y-high-contrast .bg-slate-900,
        body.a11y-high-contrast .backdrop-blur-md,
        body.a11y-high-contrast .backdrop-blur-xl {
            background-color: #000000 !important;
            border-color: #ffffff !important;
        }

        /* Fix adaptivity for Swiper sliders and absolute positioned cards in mobile view */
        body.a11y-high-contrast .swiper-wrapper {
            display: flex !important;
            flex-direction: column !important;
            gap: 2rem !important;
        }

        body.a11y-high-contrast .swiper-slide {
            width: 100% !important;
            height: auto !important;
        }

        body.a11y-high-contrast article.group {
            display: flex !important;
            flex-direction: column !important;
            height: auto !important;
            aspect-ratio: auto !important;
            width: 100% !important;
            border: 2px solid #ffffff !important;
            position: relative !important;
        }

        body.a11y-high-contrast article.group > div.absolute.inset-0 {
            position: relative !important;
            height: auto !important;
            min-height: 200px !important;
            width: 100% !important;
            border-bottom: 2px solid #ffffff !important;
        }

        body.a11y-high-contrast article.group > div.relative.z-10 {
            position: relative !important;
            padding: 1.5rem !important;
            pointer-events: auto !important;
            background-color: #000000 !important;
        }

        /* Ensure links that span whole cards are clickable but don't block text */
        body.a11y-high-contrast article.group a.absolute.inset-0.lg\\:hidden {
            display: none !important;
        }

        /* Specifically preserve icons but force them white or yellow */
        body.a11y-high-contrast .material-symbols-outlined {
            color: #ffffff !important;
            background-color: transparent !important;
            font-family: 'Material Symbols Outlined' !important; /* Ensure font isn't overridden */
        }
        body.a11y-high-contrast button .material-symbols-outlined,
        body.a11y-high-contrast a .material-symbols-outlined {
            color: inherit !important; /* Inherit yellow from parent link/button */
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

        /* Images - Strictly border informative ones, ensure they adapt properly */
        body.a11y-high-contrast img {
            border: 2px solid #ffffff !important;
            filter: grayscale(100%) contrast(150%) !important;
            max-width: 100% !important;
            height: auto !important; /* Allow natural aspect ratio scaling */
            object-fit: contain !important; /* Prevent cropping/zooming distortion */
        }

        /* Hide purely decorative background elements, blur effects, gradients */
        body.a11y-high-contrast .absolute.bg-primary\\/5,
        body.a11y-high-contrast .blur-3xl,
        body.a11y-high-contrast [class*="bg-gradient"]:not(.swiper-button-prev):not(.swiper-button-next) {
            display: none !important;
        }

        /* Enforce visible structure and borders safely */
        body.a11y-high-contrast article,
        body.a11y-high-contrast .widget,
        body.a11y-high-contrast .swiper-slide > div,
        body.a11y-high-contrast #masthead,
        body.a11y-high-contrast footer {
            border: 2px solid #ffffff !important;
            box-sizing: border-box !important;
        }

        /* Ensure header doesn't overlap weirdly when border is applied */
        body.a11y-high-contrast #masthead {
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            border-bottom: 4px solid #ffffff !important;
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
