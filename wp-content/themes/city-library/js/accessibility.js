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

        // Announce change via toast instead of alert
        const messages = {
            'normal': 'Обычный режим',
            'large-text': 'Крупный текст',
            'high-contrast': 'Высокая контрастность'
        };
        showToast(messages[newMode]);
    });

    function applyMode(mode) {
        document.body.classList.remove('a11y-large-text', 'a11y-high-contrast');

        if (mode === 'large-text') {
            document.body.classList.add('a11y-large-text');
        } else if (mode === 'high-contrast') {
            document.body.classList.add('a11y-high-contrast');
        }
    }

    /**
     * Displays a non-intrusive accessible toast notification
     * @param {string} message
     */
    function showToast(message) {
        // Remove existing toast if any
        const existingToast = document.getElementById('a11y-toast');
        if (existingToast) {
            existingToast.remove();
        }

        const toast = document.createElement('div');
        toast.id = 'a11y-toast';
        toast.setAttribute('role', 'status');
        toast.setAttribute('aria-live', 'polite');
        // Added border for high contrast mode visibility
        toast.className = 'fixed bottom-6 right-6 z-[100] px-6 py-3 rounded-xl bg-slate-800 text-white font-bold shadow-2xl transition-all duration-300 transform translate-y-4 opacity-0 flex items-center gap-3 border border-slate-700';

        // Add icon based on message
        let iconName = 'info';
        if (message.includes('Обычный')) iconName = 'restart_alt'; // restart_alt or similar
        if (message.includes('Крупный')) iconName = 'format_size';
        if (message.includes('Высокая')) iconName = 'contrast';

        // Using material symbols if available, otherwise just text
        toast.innerHTML = `
            <span class="material-symbols-outlined text-xl text-green-400" aria-hidden="true">${iconName}</span>
            <span>${message}</span>
        `;

        document.body.appendChild(toast);

        // Trigger animation
        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
        });

        // Auto remove
        setTimeout(() => {
            if (toast && document.body.contains(toast)) {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-4', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }
        }, 3000);
    }
});
