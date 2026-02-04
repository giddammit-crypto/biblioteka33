/**
 * Accessibility Tools
 *
 * Provides a simple cycler for accessibility modes:
 * 1. Normal
 * 2. Large Text
 * 3. High Contrast
 */
document.addEventListener('DOMContentLoaded', () => {
    const accessibilityButton = document.getElementById('accessibility-button');
    if (!accessibilityButton) return;

    // Inject CSS for accessibility modes
    const style = document.createElement('style');
    style.innerHTML = `
        /* Large Text Mode */
        body.a11y-large-text {
            font-size: 120% !important;
        }
        body.a11y-large-text h1 { font-size: 3.5rem !important; }
        body.a11y-large-text h2 { font-size: 2.5rem !important; }
        body.a11y-large-text p { font-size: 1.25rem !important; }

        /* High Contrast Mode */
        body.a11y-high-contrast {
            background-color: #000000 !important;
            color: #ffffff !important;
            filter: contrast(1.2);
        }
        body.a11y-high-contrast * {
            background-color: #000000 !important;
            color: #ffff00 !important;
            border-color: #ffffff !important;
        }
        body.a11y-high-contrast img,
        body.a11y-high-contrast video {
            filter: grayscale(100%) contrast(1.2);
        }
        /* Buttons in High Contrast */
        body.a11y-high-contrast button,
        body.a11y-high-contrast a.button {
            background-color: #ffff00 !important;
            color: #000000 !important;
            font-weight: bold;
        }
    `;
    document.head.appendChild(style);

    const modes = ['normal', 'large-text', 'high-contrast'];
    let currentModeIndex = 0;

    // Load saved preference
    const savedMode = localStorage.getItem('city_library_a11y_mode');
    if (savedMode && modes.includes(savedMode)) {
        currentModeIndex = modes.indexOf(savedMode);
        applyMode(savedMode);
    }

    accessibilityButton.addEventListener('click', () => {
        // Cycle to next mode
        currentModeIndex = (currentModeIndex + 1) % modes.length;
        const newMode = modes[currentModeIndex];

        applyMode(newMode);
        localStorage.setItem('city_library_a11y_mode', newMode);

        // Announce change for screen readers
        const messages = {
            'normal': 'Обычный режим',
            'large-text': 'Крупный текст',
            'high-contrast': 'Высокая контрастность'
        };
        alert(messages[newMode]); // Simple feedback
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
