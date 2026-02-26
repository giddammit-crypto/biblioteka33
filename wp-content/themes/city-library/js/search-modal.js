document.addEventListener('DOMContentLoaded', () => {
    // Select all potential triggers (ID and Class)
    const searchToggles = document.querySelectorAll('#search-toggle, #search-toggle-mobile, .search-toggle-btn');
    const searchModal = document.getElementById('search-modal');
    const searchClose = document.getElementById('search-modal-close');
    const searchInput = searchModal ? searchModal.querySelector('input[type="search"]') : null;

    if (!searchModal) return;

    function openSearch() {
        searchModal.classList.remove('hidden');
        // Small delay for transition
        requestAnimationFrame(() => {
            searchModal.classList.remove('opacity-0');
            searchModal.querySelector('#search-modal-content').classList.remove('scale-95');
            searchModal.querySelector('#search-modal-content').classList.add('scale-100');
        });
        searchModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        if (searchInput) searchInput.focus();
    }

    function closeSearch() {
        searchModal.classList.add('opacity-0');
        searchModal.querySelector('#search-modal-content').classList.remove('scale-100');
        searchModal.querySelector('#search-modal-content').classList.add('scale-95');
        searchModal.setAttribute('aria-hidden', 'true');

        setTimeout(() => {
            searchModal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    // Attach listeners to all toggles
    searchToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            openSearch();
        });
    });

    if (searchClose) {
        searchClose.addEventListener('click', (e) => {
            e.preventDefault();
            closeSearch();
        });
    }

    // Close on Esc
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !searchModal.classList.contains('hidden')) {
            closeSearch();
        }
    });

    // Close on click outside (backdrop)
    searchModal.addEventListener('click', (e) => {
        if (e.target === searchModal || e.target.classList.contains('backdrop-blur-sm')) {
             closeSearch();
        }
    });
});
