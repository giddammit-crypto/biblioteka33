document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('city-library-modal');
    if (!modal) return;

    const closeBtn = modal.querySelector('.modal-close');
    const modalContent = modal.querySelector('.modal-content');
    const delay = parseInt(modal.dataset.delay) || 3000;

    // Check sessionStorage to see if already shown in this session
    if (sessionStorage.getItem('city_library_modal_shown')) {
        return;
    }

    function showModal() {
        modal.classList.remove('hidden');
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        sessionStorage.setItem('city_library_modal_shown', 'true');
    }

    // Show after delay
    setTimeout(showModal, delay);

    // Close events
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    // Close on click outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
