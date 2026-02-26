document.addEventListener('DOMContentLoaded', function() {
    // Only target single post content or designated galleries
    const contentImages = document.querySelectorAll('.entry-content img, .post-content img, .wp-block-image img');

    if (contentImages.length > 0) {
        contentImages.forEach(img => {
            // Skip if already linked or no source
            if (img.parentElement.tagName === 'A' || !img.src) return;

            const link = document.createElement('a');
            link.href = img.src;
            link.classList.add('glightbox');
            link.dataset.gallery = 'post-gallery'; // Group images in one gallery

            // Wrap image
            img.parentNode.insertBefore(link, img);
            link.appendChild(img);
        });

        // Initialize GLightbox for any .glightbox elements (including those we just wrapped and existing ones)
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            zoomable: true
        });
    } else {
        // Init anyway for other potential galleries
        const lightbox = GLightbox({
            selector: '.glightbox'
        });
    }
});
