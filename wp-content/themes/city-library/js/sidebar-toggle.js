document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('sidebar-toggle-btn');
    const layoutContainer = document.getElementById('main-layout-container');

    if (toggleBtn && layoutContainer) {
        toggleBtn.addEventListener('click', function() {
            layoutContainer.classList.toggle('sidebar-collapsed');

            // Update icon
            const icon = toggleBtn.querySelector('.material-symbols-outlined');
            if (icon) {
                if (layoutContainer.classList.contains('sidebar-collapsed')) {
                    icon.textContent = 'menu';
                } else {
                    icon.textContent = 'menu_open';
                }
            }
        });
    }
});
