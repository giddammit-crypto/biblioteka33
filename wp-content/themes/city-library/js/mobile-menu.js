document.addEventListener('DOMContentLoaded', function() {
    // --- Mobile Menu Logic ---
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const globalCloseBtn = document.getElementById('mobile-menu-close');

    if (mobileMenu) {
        // Function to open menu
        function openMobileMenu() {
            mobileMenu.classList.remove('translate-x-full');
            document.body.style.overflow = 'hidden';
        }

        // Function to close menu
        function closeMobileMenu() {
            mobileMenu.classList.add('translate-x-full');
            document.body.style.overflow = '';
        }

        // Expose globally just in case
        window.openMobileMenu = openMobileMenu;

        // Open Listener
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                openMobileMenu();
            });
        }

        // Close Listener (Global Button)
        if (globalCloseBtn) {
            globalCloseBtn.addEventListener('click', closeMobileMenu);
        }

        // Close Listener (Internal Button - Backup)
        // Sometimes the global ID lookup might fail if the element is inside a shadow DOM or template (unlikely here, but good safety)
        const internalCloseBtn = mobileMenu.querySelector('.material-symbols-outlined').closest('button'); // Fallback strategy
        if (internalCloseBtn && internalCloseBtn !== globalCloseBtn) {
            internalCloseBtn.addEventListener('click', closeMobileMenu);
        }

        // Ensure the ID based internal search also works if the global one didn't match
        const internalIdBtn = mobileMenu.querySelector('#mobile-menu-close');
        if (internalIdBtn && internalIdBtn !== globalCloseBtn) {
             internalIdBtn.addEventListener('click', closeMobileMenu);
        }

        // Close on Outside Click
        mobileMenu.addEventListener('click', function(e) {
            if (e.target === mobileMenu) {
                closeMobileMenu();
            }
        });

        // Close on Link Click
        const links = mobileMenu.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });
    }

    // --- Smart Scroll Visibility (Bottom Nav & Renewal Button) ---
    const bottomNav = document.querySelector('nav.safe-area-bottom');
    const renewalBtn = document.getElementById('book-renewal-btn');

    if (bottomNav) {
        let lastScrollTop = 0;

        function checkNavVisibility() {
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            const windowHeight = window.innerHeight;
            const docHeight = document.documentElement.scrollHeight;
            const scrollBottom = currentScroll + windowHeight;

            // Logic: Hide ONLY if at the very bottom (Footer)
            // We use a threshold of approx 50-100px from the bottom
            const isAtBottom = scrollBottom >= docHeight - 50;

            if (isAtBottom) {
                // Hide Nav
                bottomNav.classList.add('translate-y-full', 'opacity-0', 'pointer-events-none');

                // Hide Renewal Button
                if (renewalBtn) {
                    // Mobile renewal button logic usually hides it via same classes or separate logic
                    // If renewal button is floating at bottom, hide it too
                    renewalBtn.classList.add('translate-x-full', 'opacity-0', 'pointer-events-none');
                }
            } else {
                // Show Nav
                bottomNav.classList.remove('translate-y-full', 'opacity-0', 'pointer-events-none');

                // Show Renewal Button (but check top/hero logic for it if separate?)
                // User instruction said: "If site scrolled to footer -> hide, else -> show".
                // This implies it should be visible everywhere else.
                if (renewalBtn) {
                    renewalBtn.classList.remove('translate-x-full', 'opacity-0', 'pointer-events-none');
                }
            }
        }

        // Init
        checkNavVisibility();
        window.addEventListener('scroll', checkNavVisibility, { passive: true });
    }
});
