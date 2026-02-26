document.addEventListener('DOMContentLoaded', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    const closeBtn = document.getElementById('mobile-menu-close');

    if (mobileMenu) {
        // Expose open function globally or via event for bottom nav
        window.openMobileMenu = function() {
            mobileMenu.classList.remove('translate-x-full');
            document.body.style.overflow = 'hidden';
        };

        const closeMenu = () => {
            mobileMenu.classList.add('translate-x-full');
            document.body.style.overflow = '';
        };

        if (closeBtn) {
            closeBtn.addEventListener('click', closeMenu);
        }

        // Close on outside click
        mobileMenu.addEventListener('click', function(e) {
            if (e.target === mobileMenu) {
                closeMenu();
            }
        });

        // Close button might be inside a template part that is loaded differently or just not found initially
        // Use delegate if needed, but standard ID should work if present in DOM.
        // Let's add a safe check for the close button inside the menu container if the global one fails.
        const internalCloseBtn = mobileMenu.querySelector('#mobile-menu-close');
        if (internalCloseBtn && internalCloseBtn !== closeBtn) {
            internalCloseBtn.addEventListener('click', closeMenu);
        }

        // Close on link click
        const links = mobileMenu.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', closeMenu);
        });
    }

    // Smart Scroll Visibility for Bottom Nav
    const bottomNav = document.querySelector('nav.safe-area-bottom');
    if (bottomNav) {
        const heroSection = document.querySelector('section.hero-gradient') || document.querySelector('header#masthead');
        const heroHeight = heroSection ? heroSection.offsetHeight : 300;
        let lastScrollTop = 0;

        function checkNavVisibility() {
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            const windowHeight = window.innerHeight;
            const docHeight = document.documentElement.scrollHeight;
            const scrollBottom = currentScroll + windowHeight;

            // 1. Hide at Top (Hero Zone)
            if (currentScroll < heroHeight) {
                bottomNav.classList.add('translate-y-full', 'opacity-0', 'pointer-events-none');
            }
            // 2. Hide at Bottom (Footer Zone - approx 100px threshold)
            else if (scrollBottom >= docHeight - 50) {
                bottomNav.classList.add('translate-y-full', 'opacity-0', 'pointer-events-none');
            }
            // 3. Show in between
            else {
                bottomNav.classList.remove('translate-y-full', 'opacity-0', 'pointer-events-none');
            }

            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        }

        // Init
        checkNavVisibility();
        window.addEventListener('scroll', checkNavVisibility, { passive: true });
    }
});
