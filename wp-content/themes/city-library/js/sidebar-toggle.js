document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('main-sidebar');
    const content = document.getElementById('primary');

    // Exit if elements don't exist
    if (!toggleBtn || !sidebar || !content) return;

    toggleBtn.addEventListener('click', function() {
        const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
        const icon = toggleBtn.querySelector('.material-symbols-outlined');

        if (isExpanded) {
            // HIDE SIDEBAR
            // 1. Animate width to 0 and opacity
            sidebar.classList.remove('lg:w-[30%]', 'w-full', 'mb-8'); // mb-8 might be needed if mobile has spacing
            sidebar.classList.add('w-0', 'h-0', 'lg:h-auto', 'lg:w-0', 'opacity-0', 'overflow-hidden', 'p-0', 'm-0');

            // 2. Expand content area
            content.classList.remove('lg:w-[70%]');
            content.classList.add('w-full');

            // 3. Update Button State
            toggleBtn.setAttribute('aria-expanded', 'false');
            toggleBtn.classList.add('bg-slate-400');
            toggleBtn.classList.remove('bg-primary');
            if(icon) icon.innerText = 'first_page'; // Icon changes to indicate "expand" (or similar)

        } else {
            // SHOW SIDEBAR
            // 1. Restore layout
            sidebar.classList.remove('w-0', 'h-0', 'lg:h-auto', 'lg:w-0', 'opacity-0', 'overflow-hidden', 'p-0', 'm-0');
            sidebar.classList.add('lg:w-[30%]', 'w-full');

            // 2. Shrink content area
            content.classList.remove('w-full');
            content.classList.add('lg:w-[70%]');

            // 3. Update Button State
            toggleBtn.setAttribute('aria-expanded', 'true');
            toggleBtn.classList.remove('bg-slate-400');
            toggleBtn.classList.add('bg-primary');
            if(icon) icon.innerText = 'view_sidebar';
        }
    });
});
