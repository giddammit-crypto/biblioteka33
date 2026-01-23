document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('secondary');
    const content = document.getElementById('primary');
    const icon = toggleButton ? toggleButton.querySelector('.material-symbols-outlined') : null;

    if (!toggleButton || !sidebar || !content) return;

    const storageKey = 'city_library_sidebar_state';

    function updateIcon(isHidden) {
        if (!icon) return;
        // Assuming the button might have an icon.
        // If hidden, we show 'chevron_right' (to expand), if visible 'chevron_left' (to collapse)
        // or just a menu icon. Let's keep it simple or check what I put in HTML later.
        // User didn't specify icon, so I'll leave icon logic generic or skip unless I defined it.
        // I'll stick to class toggles.
    }

    function applyState(isHidden) {
        if (isHidden) {
            sidebar.classList.add('hidden');
            content.classList.remove('lg:w-[70%]');
            content.classList.add('w-full');
            if (icon) icon.innerText = 'dock_to_right'; // Icon indicating "Show sidebar" or similar
        } else {
            sidebar.classList.remove('hidden');
            content.classList.add('lg:w-[70%]');
            content.classList.remove('w-full');
             if (icon) icon.innerText = 'dock_to_left'; // Icon indicating "Hide sidebar"
        }
    }

    // Load state
    const savedState = localStorage.getItem(storageKey);
    // Default is visible
    if (savedState === 'hidden') {
        applyState(true);
    } else {
        applyState(false);
    }

    toggleButton.addEventListener('click', () => {
        const isHidden = !sidebar.classList.contains('hidden');
        applyState(isHidden);
        localStorage.setItem(storageKey, isHidden ? 'hidden' : 'visible');
    });
});
