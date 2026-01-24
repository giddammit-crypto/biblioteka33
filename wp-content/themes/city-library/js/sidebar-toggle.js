document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('secondary');
    const content = document.getElementById('primary');
    const toggleBtn = document.getElementById('sidebar-toggle');
    const closeBtn = document.getElementById('close-sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    if (!sidebar || !toggleBtn) return;

    // Mobile/Overlay toggle
    function toggleMobileSidebar() {
        const isClosed = sidebar.classList.contains('-translate-x-full');
        if (isClosed) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    // Desktop toggle
    function toggleDesktopSidebar() {
        // Check if sidebar is currently visible
        const isHidden = sidebar.classList.contains('lg:hidden');

        if (isHidden) {
            // Show sidebar
            sidebar.classList.remove('lg:hidden');
            content.classList.remove('lg:w-full');
            content.classList.add('lg:w-[70%]');
        } else {
            // Hide sidebar
            sidebar.classList.add('lg:hidden');
            content.classList.remove('lg:w-[70%]');
            content.classList.add('lg:w-full');
        }
    }

    toggleBtn.addEventListener('click', function() {
        if (window.innerWidth >= 1024) { // lg breakpoint
            toggleDesktopSidebar();
        } else {
            toggleMobileSidebar();
        }
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', toggleMobileSidebar);
    }

    if (overlay) {
        overlay.addEventListener('click', toggleMobileSidebar);
    }

    // Handle resize events to reset state if needed
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            // Reset mobile state
            sidebar.classList.remove('-translate-x-full'); // On desktop, it should be visible by default (translate-x-0)
            // Wait, my HTML has -translate-x-full lg:translate-x-0.
            // If I remove -translate-x-full, it becomes visible on mobile too?
            // No, on mobile I toggle -translate-x-full.
            // On desktop, the class lg:translate-x-0 overrides it.

            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        } else {
             // Reset desktop state
             sidebar.classList.remove('lg:hidden');
             content.classList.remove('lg:w-full');
             content.classList.add('lg:w-[70%]');

             // Ensure it's hidden on mobile initially
             sidebar.classList.add('-translate-x-full');
        }
    });
});
