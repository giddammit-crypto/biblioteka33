document.addEventListener('DOMContentLoaded', function() {
    // --- Mobile Menu Logic ---
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const globalCloseBtn = document.getElementById('mobile-menu-close');

    if (mobileMenu) {
        // Function to open menu
        function openMobileMenu() {
            mobileMenu.classList.remove('translate-x-full', 'pointer-events-none');
            document.body.style.overflow = 'hidden';
        }

        // Function to close menu
        function closeMobileMenu() {
            mobileMenu.classList.add('translate-x-full', 'pointer-events-none');
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
        // Find ANY button inside the menu that has a "close" icon or text "Close"
        const internalCloseBtns = mobileMenu.querySelectorAll('button, .menu-item-close a'); // Flexible selector
        internalCloseBtns.forEach(btn => {
            // Check if it's the global button (handled) or new one
            if (btn !== globalCloseBtn) {
                // EXCLUDE submenu toggles from this logic!
                if (btn.classList.contains('submenu-toggle')) {
                    return;
                }

                // If it has "close" icon or text, add listener
                // Also double check it's not a toggle by checking for expand_more icon just in case
                const hasExpandIcon = btn.querySelector('.material-symbols-outlined') && btn.querySelector('.material-symbols-outlined').textContent === 'expand_more';

                if (!hasExpandIcon && (btn.querySelector('.material-symbols-outlined') || btn.textContent.toLowerCase().includes('close') || btn.textContent.toLowerCase().includes('закрыть'))) {
                    btn.addEventListener('click', closeMobileMenu);
                }
            }
        });

        // Ensure the ID based internal search also works if the global one didn't match
        const internalIdBtn = mobileMenu.querySelector('#mobile-menu-close');
        if (internalIdBtn && internalIdBtn !== globalCloseBtn) {
             internalIdBtn.addEventListener('click', closeMobileMenu);
        }

        // Close on Outside Click (Removed to prevent accidental closes while scrolling)
        /*
        mobileMenu.addEventListener('click', function(e) {
            if (e.target === mobileMenu) {
                closeMobileMenu();
            }
        });
        */

        // Close on Link Click
        const links = mobileMenu.querySelectorAll('a');
        links.forEach(link => {
            // Optimization: Do NOT close menu if the link is a parent item (has submenus)
            // unless it's a real link (not just a toggle anchor)
            const parentLi = link.closest('li');
            const href = link.getAttribute('href');

            // Check if it's a "real" link (not # or empty)
            const isRealLink = href && href !== '#' && !href.startsWith('javascript');

            if (parentLi && parentLi.classList.contains('has-children')) {
                // If it has children, only close if it's a real navigable link
                // If it is just a toggle (often '#'), don't close
                if (!isRealLink) {
                    return;
                }
                // If it IS a real link, we let it navigate and close
            }

            link.addEventListener('click', closeMobileMenu);
        });

        // --- Submenu Toggle Logic (Mobile Only) ---
        // Find all toggle buttons within the mobile menu
        const toggles = mobileMenu.querySelectorAll('.submenu-toggle');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation(); // Prevent closing the menu

                // Find the parent list item
                const parentLi = this.closest('li');
                if (!parentLi) return;

                // Find the submenu UL
                const submenu = parentLi.querySelector('ul.submenu');
                if (!submenu) return;

                // Toggle visibility
                submenu.classList.toggle('hidden');

                // Rotate the icon
                const icon = this.querySelector('.material-symbols-outlined');
                if (icon) {
                    icon.classList.toggle('rotate-180');
                }

                // Update aria-expanded
                const isExpanded = !submenu.classList.contains('hidden');
                this.setAttribute('aria-expanded', isExpanded);
            });
        });
    }

    // --- Smart Scroll Visibility (Bottom Nav & Renewal Button) ---
    const bottomNav = document.querySelector('nav.safe-area-bottom');
    const renewalBtn = document.getElementById('book-renewal-btn');

    if (bottomNav) {
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
                    renewalBtn.classList.add('translate-x-full', 'opacity-0', 'pointer-events-none');
                }
            } else {
                // Show Nav
                bottomNav.classList.remove('translate-y-full', 'opacity-0', 'pointer-events-none');

                // Show Renewal Button
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
