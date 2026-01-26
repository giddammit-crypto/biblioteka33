document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuTriggers = document.querySelectorAll('.mobile-menu-trigger');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeBtn = document.getElementById('mobile-menu-close');

    if (mobileMenu) {
        const openMenu = () => {
            mobileMenu.classList.remove('translate-x-full');
            document.body.style.overflow = 'hidden';
        };

        const closeMenu = () => {
            mobileMenu.classList.add('translate-x-full');
            document.body.style.overflow = '';
        };

        mobileMenuTriggers.forEach(btn => {
            btn.addEventListener('click', openMenu);
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', closeMenu);
        }

        // Close on outside click
        mobileMenu.addEventListener('click', function(e) {
            if (e.target === mobileMenu) {
                closeMenu();
            }
        });

        // Close on link click
        const links = mobileMenu.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', closeMenu);
        });
    }
});
