document.addEventListener('DOMContentLoaded', function() {
    let newsSwiper = null;
    let partnersSwiper = null;
    let importantLinksSwiper = null;

    function initMobileSliders() {
        if (window.innerWidth < 1024) {
            // News Slider
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

            // Partners Slider
            if (!partnersSwiper && document.querySelector('.partners-slider')) {
                partnersSwiper = new Swiper('.partners-slider', {
                    slidesPerView: 1, // Full width slide
                    spaceBetween: 20,
                    pagination: {
                        el: '.partners-slider .swiper-pagination',
                        clickable: true,
                    },
                });
            }

            // Important Links Slider
            if (!importantLinksSwiper && document.querySelector('.important-links-slider')) {
                importantLinksSwiper = new Swiper('.important-links-slider', {
                    slidesPerView: 2.2,
                    spaceBetween: 16,
                    breakpoints: {
                        640: {
                            slidesPerView: 3.2,
                        },
                        768: {
                            slidesPerView: 4.2,
                        }
                    },
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
