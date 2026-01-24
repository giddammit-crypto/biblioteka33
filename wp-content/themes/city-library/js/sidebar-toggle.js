document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebarWrapper = document.getElementById('left-sidebar-wrapper');
    const primaryContent = document.getElementById('primary');

    if (sidebarToggle && sidebarWrapper) {

        // Load state from localStorage
        const isHidden = localStorage.getItem('sidebarHidden') === 'true';
        if (isHidden) {
            setSidebarState(true);
        }

        sidebarToggle.addEventListener('click', function() {
            const currentlyHidden = sidebarWrapper.classList.contains('hidden-sidebar');
            setSidebarState(!currentlyHidden);
        });

        function setSidebarState(hidden) {
            if (hidden) {
                // Hide Sidebar
                sidebarWrapper.classList.add('hidden-sidebar');
                // Adjust width classes
                sidebarWrapper.classList.remove('lg:w-[30%]');
                sidebarWrapper.classList.add('lg:w-0', 'overflow-hidden', 'opacity-0', 'pointer-events-none');
                sidebarWrapper.style.width = '0';
                sidebarWrapper.style.padding = '0';

                // Expand Content
                primaryContent.classList.remove('lg:w-[70%]');
                primaryContent.classList.add('lg:w-full');

                // Update Icon
                sidebarToggle.querySelector('.material-symbols-outlined').textContent = 'menu_open';
                sidebarToggle.setAttribute('aria-expanded', 'false');

                localStorage.setItem('sidebarHidden', 'true');
            } else {
                // Show Sidebar
                sidebarWrapper.classList.remove('hidden-sidebar');
                // Adjust width classes
                sidebarWrapper.classList.remove('lg:w-0', 'overflow-hidden', 'opacity-0', 'pointer-events-none');
                sidebarWrapper.classList.add('lg:w-[30%]');
                sidebarWrapper.style.width = ''; // Reset inline style
                sidebarWrapper.style.padding = '';

                // Shrink Content
                primaryContent.classList.remove('lg:w-full');
                primaryContent.classList.add('lg:w-[70%]');

                // Update Icon
                sidebarToggle.querySelector('.material-symbols-outlined').textContent = 'close';
                sidebarToggle.setAttribute('aria-expanded', 'true');

                localStorage.setItem('sidebarHidden', 'false');
            }
        }
    }
});
