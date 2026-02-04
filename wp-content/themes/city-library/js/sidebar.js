document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('sidebar-toggle-btn');
    const sidebar = document.getElementById('sidebar-column');
    const primary = document.getElementById('primary');

    if (!toggleBtn || !sidebar || !primary) return;

    toggleBtn.addEventListener('click', function() {
        // Toggle Sidebar visibility
        const isExpanded = sidebar.classList.contains('lg:w-[30%]');

        if (isExpanded) {
            // Hide Sidebar
            sidebar.classList.remove('lg:w-[30%]');
            sidebar.classList.add('lg:w-0', 'lg:overflow-hidden', 'lg:opacity-0', 'lg:p-0');

            // Expand Content
            primary.classList.remove('lg:w-[70%]');
            primary.classList.add('lg:w-full');

            // Update State & Icon
            toggleBtn.setAttribute('aria-expanded', 'false');
            const icon = toggleBtn.querySelector('.material-symbols-outlined');
            if (icon) icon.textContent = 'menu';
        } else {
            // Show Sidebar
            sidebar.classList.add('lg:w-[30%]');
            sidebar.classList.remove('lg:w-0', 'lg:overflow-hidden', 'lg:opacity-0', 'lg:p-0');

            // Shrink Content
            primary.classList.add('lg:w-[70%]');
            primary.classList.remove('lg:w-full');

            // Update State & Icon
            toggleBtn.setAttribute('aria-expanded', 'true');
            const icon = toggleBtn.querySelector('.material-symbols-outlined');
            if (icon) icon.textContent = 'menu_open';
        }
    });
});
