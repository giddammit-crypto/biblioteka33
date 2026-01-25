document.addEventListener('DOMContentLoaded', function() {
    const magicParams = window.magic_mode_params || {};

    // Create Toggle Button (Wand Icon) - BOTTOM RIGHT
    const toggleBtn = document.createElement('button');
    toggleBtn.id = 'magic-mode-toggle';
    toggleBtn.innerHTML = '<span class="material-symbols-outlined">auto_fix_high</span>';
    toggleBtn.title = "Волшебный режим";
    toggleBtn.className = "fixed bottom-6 right-6 z-50 p-4 rounded-full bg-purple-700 text-white shadow-lg hover:bg-purple-600 transition-all duration-300 hover:scale-110 group";

    // Tooltip
    const tooltip = document.createElement('span');
    tooltip.className = "absolute right-full mr-2 top-1/2 -translate-y-1/2 px-2 py-1 bg-black/80 text-white text-xs rounded opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity pointer-events-none";
    tooltip.textContent = "Войти в мир магии";
    toggleBtn.appendChild(tooltip);

    document.body.appendChild(toggleBtn);

    // Book Overlay Elements
    const overlay = document.createElement('div');
    overlay.id = 'magic-book-overlay';
    overlay.className = 'fixed inset-0 z-[60] pointer-events-none perspective-1000 hidden';

    // Darkening Overlay (New Requirement)
    const darkOverlay = document.createElement('div');
    darkOverlay.id = 'magic-dark-overlay';
    document.body.appendChild(darkOverlay);

    // Sparkles Container (New Requirement)
    const sparklesContainer = document.createElement('div');
    sparklesContainer.id = 'magic-sparkles-container';
    document.body.appendChild(sparklesContainer);

    // Left and Right Covers
    // Slower animation (duration-[3000ms])
    const leftCover = document.createElement('div');
    leftCover.className = 'absolute inset-y-0 left-0 w-1/2 bg-cover bg-right shadow-2xl origin-left transition-transform duration-[3000ms] ease-in-out transform-style-3d';
    leftCover.style.backgroundImage = `url('${magicParams.book_cover}')`;
    leftCover.style.backfaceVisibility = 'hidden';

    const rightCover = document.createElement('div');
    rightCover.className = 'absolute inset-y-0 right-0 w-1/2 bg-cover bg-left shadow-2xl origin-right transition-transform duration-[3000ms] ease-in-out transform-style-3d';
    rightCover.style.backgroundImage = `url('${magicParams.book_cover}')`;
    rightCover.style.backfaceVisibility = 'hidden';

    // Inner pages (for effect)
    const leftPage = document.createElement('div');
    leftPage.className = 'absolute inset-y-0 left-0 w-1/2 bg-[#fdfbf7] origin-left transition-transform duration-[3000ms] ease-in-out delay-100';

    const rightPage = document.createElement('div');
    rightPage.className = 'absolute inset-y-0 right-0 w-1/2 bg-[#fdfbf7] origin-right transition-transform duration-[3000ms] ease-in-out delay-100';

    overlay.appendChild(leftPage);
    overlay.appendChild(rightPage);
    overlay.appendChild(leftCover);
    overlay.appendChild(rightCover);
    document.body.appendChild(overlay);

    // State Management
    let isMagicMode = localStorage.getItem('city_library_magic_mode') === 'true';

    // Apply initial state
    if (isMagicMode) {
        enableMagicMode(false); // No animation on load
    }

    toggleBtn.addEventListener('click', function() {
        isMagicMode = !isMagicMode;
        localStorage.setItem('city_library_magic_mode', isMagicMode);

        if (isMagicMode) {
            animateBookOpening();
        } else {
            disableMagicMode();
        }
    });

    function createSparkle() {
        const sparkle = document.createElement('div');
        sparkle.className = 'sparkle';
        sparkle.style.left = Math.random() * 100 + '%';
        sparkle.style.top = Math.random() * 100 + '%';
        // Randomize size slightly
        const scale = 0.5 + Math.random();
        sparkle.style.transform = `scale(${scale})`;
        sparklesContainer.appendChild(sparkle);

        // Remove after animation
        setTimeout(() => {
            sparkle.remove();
        }, 1000);
    }

    function animateBookOpening() {
        // 1. Show Overlay (Book Closed) & Dark Overlay
        overlay.classList.remove('hidden');
        overlay.style.pointerEvents = 'auto';

        darkOverlay.style.opacity = '1'; // Start dark

        // Reset transforms
        leftCover.style.transform = 'rotateY(0deg)';
        rightCover.style.transform = 'rotateY(0deg)';

        // Force reflow
        void overlay.offsetWidth;

        // 2. Start Animation sequence
        setTimeout(() => {
            // Apply Magic Styles behind the scenes
            enableMagicMode(true);

            // 3. Open the book to reveal (Slowly)
            leftCover.style.transform = 'rotateY(-110deg)';
            rightCover.style.transform = 'rotateY(110deg)';

            // 4. Fade out Dark Overlay slowly as book opens
            darkOverlay.style.opacity = '0';

            // 5. Generate Sparkles
            let sparkleInterval = setInterval(createSparkle, 50);

            // Stop sparkles after a bit
            setTimeout(() => {
                clearInterval(sparkleInterval);
            }, 2500);

            // Fade out overlay after animation
            setTimeout(() => {
                overlay.classList.add('opacity-0', 'transition-opacity', 'duration-1000');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                    overlay.classList.remove('opacity-0', 'transition-opacity', 'duration-1000');
                    overlay.style.pointerEvents = 'none';
                    // Reset
                    leftCover.style.transform = 'rotateY(0deg)';
                    rightCover.style.transform = 'rotateY(0deg)';
                }, 1000);
            }, 3000); // Wait for book to fully open (3s)
        }, 500);
    }

    function enableMagicMode(animate) {
        document.body.classList.add('magic-mode');

        // Background texture is now handled by CSS on #masthead and body classes,
        // but we might want a global background for the body too if not just the header.
        // User asked for "Background of header (menu) should be texture".
        // Let's assume body gets the parchment color via CSS.

        toggleBtn.querySelector('span').textContent = 'auto_fix_off';
        tooltip.textContent = "Вернуться в реальность";
    }

    function disableMagicMode() {
        document.body.classList.remove('magic-mode');

        toggleBtn.querySelector('span').textContent = 'auto_fix_high';
        tooltip.textContent = "Войти в мир магии";
    }
});
