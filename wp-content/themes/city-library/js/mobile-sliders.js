document.addEventListener('DOMContentLoaded', function() {
    let newsSwiper = null;
    let partnersSwiper = null;
    let importantLinksSwiper = null;

    function initMobileSliders() {
        if (window.innerWidth < 1024) {
            // News Slider (1 slide per view)
            if (!newsSwiper && document.querySelector('.news-slider')) {
                newsSwiper = new Swiper('.news-slider', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    pagination: {
                        el: '.news-slider .swiper-pagination',
                        clickable: true,
                    },
                });
            }

            // Partners Slider (2 slides per view)
            if (!partnersSwiper && document.querySelector('.partners-slider')) {
                partnersSwiper = new Swiper('.partners-slider', {
                    slidesPerView: 2,
                    spaceBetween: 20,
                    pagination: {
                        el: '.partners-slider .swiper-pagination',
                        clickable: true,
                    },
                });
            }

            // Important Links Slider (2 slides per view)
            if (!importantLinksSwiper && document.querySelector('.important-links-slider')) {
                importantLinksSwiper = new Swiper('.important-links-slider', {
                    slidesPerView: 2,
                    spaceBetween: 20,
                    pagination: {
                        el: '.important-links-slider .swiper-pagination',
                        clickable: true,
                    },
                });
            }
        } else {
            // Destroy if exists
            if (newsSwiper) {
                newsSwiper.destroy(true, true);
                newsSwiper = null;
            }
            if (partnersSwiper) {
                partnersSwiper.destroy(true, true);
                partnersSwiper = null;
            }
            if (importantLinksSwiper) {
                importantLinksSwiper.destroy(true, true);
                importantLinksSwiper = null;
            }
        }
    }

    // Initialize on load
    initMobileSliders();

    // Re-initialize/Destroy on resize
    window.addEventListener('resize', function() {
        initMobileSliders();
    });
});
