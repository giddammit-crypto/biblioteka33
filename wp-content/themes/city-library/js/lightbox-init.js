document.addEventListener('DOMContentLoaded', function() {
    /**
     * Robust Lightbox Initialization
     * Targets images in posts, pages, and news content.
     */
    const contentContainers = '.entry-content, .prose, .post-content, .page-content, .news-content, .featured-cards-section, .promo-section-content, .featured-cards-image-only, .promo-section-image-wrapper, .important-section-link, .library-branch-image-wrapper';
    const contentImages = document.querySelectorAll(`${contentContainers} img:not(.emoji)`);

    if (contentImages.length > 0) {
        contentImages.forEach(img => {
            const parent = img.parentElement;

            // Extract alignment classes to transfer them
            const alignmentClasses = Array.from(img.classList).filter(c =>
                c.startsWith('align') || c.startsWith('wp-image-')
            );

            // 1. Handle already linked images
            if (parent.tagName === 'A') {
                const href = parent.getAttribute('href');
                // If it links to an image but doesn't have the class, add it
                if (href && href.match(/\.(jpg|jpeg|png|webp|gif|svg)(\?.*)?$/i)) {
                    if (!parent.classList.contains('glightbox')) {
                        parent.classList.add('glightbox');
                    }
                    if (!parent.dataset.gallery) {
                        parent.dataset.gallery = 'post-gallery';
                    }
                    // Ensure parent has alignment classes for proper layout
                    alignmentClasses.forEach(c => parent.classList.add(c));
                }
                return;
            }

            // 2. Wrap unlinked images
            if (!img.src) return;

            const link = document.createElement('a');
            link.href = img.src;
            link.classList.add('glightbox');
            link.dataset.gallery = 'post-gallery';

            // Transfer alignment classes to link
            alignmentClasses.forEach(c => link.classList.add(c));

            img.parentNode.insertBefore(link, img);
            link.appendChild(img);
        });
    }

    // Global Initialization for all .glightbox elements
    // This handles images wrapped above, plus hardcoded ones in templates
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        zoomable: true,
        autoplayVideos: true,
        moreLength: 0 // Show full caption
    });
});
