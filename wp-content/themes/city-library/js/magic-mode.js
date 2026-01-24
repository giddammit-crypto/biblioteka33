document.addEventListener('DOMContentLoaded', function() {
    const magicToggle = document.getElementById('magic-toggle');
    const magicOverlay = document.getElementById('magic-overlay');
    const body = document.body;

    // Check localStorage
    if (localStorage.getItem('magicMode') === 'enabled') {
        body.classList.add('magic-mode');
        // Only update icon if button exists
        if (magicToggle) {
            updateIcon(true);
        }
    }

    if (magicToggle) {
        magicToggle.addEventListener('click', function() {
            toggleMagicMode();
        });
    }

    function toggleMagicMode() {
        const isEnabled = body.classList.contains('magic-mode');

        // Trigger Animation
        animateTransition(!isEnabled);

        // Toggle State after delay for animation to cover screen
        setTimeout(() => {
            body.classList.toggle('magic-mode');
            const newState = body.classList.contains('magic-mode');
            localStorage.setItem('magicMode', newState ? 'enabled' : 'disabled');
            if (magicToggle) {
                updateIcon(newState);
            }
        }, 600); // Sync with CSS animation duration
    }

    function animateTransition(enabling) {
        if (!magicOverlay) return;

        const shockwave = magicOverlay.querySelector('.shockwave');
        if (!shockwave) return;

        // Reset
        magicOverlay.classList.remove('opacity-0', 'pointer-events-none');
        shockwave.classList.remove('animate-shockwave-expand');
        void shockwave.offsetWidth; // Trigger reflow

        // Play Animation
        shockwave.classList.add('animate-shockwave-expand');

        // Cleanup
        setTimeout(() => {
            magicOverlay.classList.add('opacity-0', 'pointer-events-none');
            shockwave.classList.remove('animate-shockwave-expand');
        }, 1500);
    }

    function updateIcon(isMagic) {
        if (!magicToggle) return;
        const icon = magicToggle.querySelector('.material-symbols-outlined');
        if (icon) {
            icon.textContent = isMagic ? 'auto_fix_off' : 'auto_fix';
        }
    }
});
