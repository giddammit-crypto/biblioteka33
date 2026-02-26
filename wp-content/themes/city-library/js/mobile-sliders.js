document.addEventListener('DOMContentLoaded', function() {
    let newsSwiper = null;
    let partnersSwiper = null;
    let importantLinksSwiper = null;

    const breakpoint = 1024;

    function initMobileSliders() {
        const isMobile = window.innerWidth < breakpoint;

        if (isMobile) {
            // News Slider
            if (!newsSwiper && document.querySelector('.news-slider')) {
                newsSwiper = new Swiper('.news-slider', {
                    slidesPerView: 'auto',
                    centeredSlides: true,
                    spaceBetween: 16,
                    pagination: {
                        el: '.news-slider .swiper-pagination',
                        clickable: true,
                    },
                    on: {
                        destroy: function() {
                            // Clean up styles manually
                            const wrapper = document.querySelector('.news-slider .swiper-wrapper');
                            if (wrapper) wrapper.removeAttribute('style');
                            const slides = document.querySelectorAll('.news-slider .swiper-slide');
                            slides.forEach(slide => slide.removeAttribute('style'));
                        }
                    }
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
                     on: {
                        destroy: function() {
                            const wrapper = document.querySelector('.partners-slider .swiper-wrapper');
                            if (wrapper) wrapper.removeAttribute('style');
                            const slides = document.querySelectorAll('.partners-slider .swiper-slide');
                            slides.forEach(slide => slide.removeAttribute('style'));
                        }
                    }
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
                    on: {
                        destroy: function() {
                            const wrapper = document.querySelector('.important-links-slider .swiper-wrapper');
                            if (wrapper) wrapper.removeAttribute('style');
                            const slides = document.querySelectorAll('.important-links-slider .swiper-slide');
                            slides.forEach(slide => slide.removeAttribute('style'));
                        }
                    }
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
