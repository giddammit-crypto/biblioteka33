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
        showToast(messages[newMode]);
    });

    function showToast(message) {
        let toast = document.getElementById('a11y-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'a11y-toast';
            toast.setAttribute('role', 'status');
            toast.setAttribute('aria-live', 'polite');

            // Base styles with reliable inline fallbacks for positioning/appearance
            toast.className = 'fixed top-24 right-4 z-[9999] bg-slate-900 text-white px-6 py-3 rounded-full shadow-lg transition-all duration-300 opacity-0 translate-y-2 pointer-events-none font-medium text-sm flex items-center gap-3';

            // Strict inline styles to ensure functionality without external CSS
            toast.style.position = 'fixed';
            toast.style.top = '6rem'; // ~24
            toast.style.right = '1rem'; // ~4
            toast.style.zIndex = '9999';
            toast.style.backgroundColor = '#0f172a';
            toast.style.color = '#ffffff';
            toast.style.display = 'flex';
            toast.style.alignItems = 'center';
            toast.style.gap = '0.75rem';
            toast.style.padding = '0.75rem 1.5rem';
            toast.style.borderRadius = '9999px';
            toast.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
            toast.style.transition = 'all 0.3s ease-in-out';
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(0.5rem)'; // Initial state for animation

            // Accessible Icon (SVG)
            const iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>`;

            toast.innerHTML = `${iconSvg}<span id="a11y-toast-msg"></span>`;
            document.body.appendChild(toast);
        }

        const msgSpan = toast.querySelector('#a11y-toast-msg');
        if (msgSpan) msgSpan.textContent = message;

        // Show
        requestAnimationFrame(() => {
            toast.classList.remove('opacity-0');
            toast.classList.remove('translate-y-2');
            // Inline style override for animation
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        });

        // Hide after 3s
        if (window.a11yToastTimeout) clearTimeout(window.a11yToastTimeout);
        window.a11yToastTimeout = setTimeout(() => {
            toast.classList.add('opacity-0');
            // Inline style override
            toast.style.opacity = '0';
        }, 3000);
    }

    function applyMode(mode) {
        document.body.classList.remove('a11y-large-text', 'a11y-high-contrast');

        if (mode === 'large-text') {
            document.body.classList.add('a11y-large-text');
        } else if (mode === 'high-contrast') {
            document.body.classList.add('a11y-high-contrast');
        }
    }
});
