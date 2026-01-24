document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('sidebar-toggle-btn');
    const sidebar = document.getElementById('sidebar-column');
    const primary = document.getElementById('primary');
    const icon = toggleBtn ? toggleBtn.querySelector('.material-symbols-outlined') : null;

    if (!toggleBtn || !sidebar || !primary) return;

    toggleBtn.addEventListener('click', function() {
        // Toggle Sidebar visibility
        sidebar.classList.toggle('hidden');
        sidebar.classList.toggle('lg:hidden'); // Ensure it hides on desktop too

        // Toggle Primary width
        if (sidebar.classList.contains('hidden') || sidebar.classList.contains('lg:hidden')) {
            primary.classList.remove('lg:w-[70%]');
            primary.classList.add('w-full');
            if(icon) icon.textContent = 'menu'; // Icon when closed (to open)
        } else {
            primary.classList.add('lg:w-[70%]');
            primary.classList.remove('w-full');
            if(icon) icon.textContent = 'menu_open'; // Icon when open (to close)
        }
    });
});
