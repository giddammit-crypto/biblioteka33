<?php
/**
 * Shortcode to insert an image slider within post content.
 * Usage: [city_library_slider] (shows all attached images except thumbnail)
 * Or: [city_library_slider ids="12,34,56"] (shows specific image IDs)
 */

function city_library_post_slider_shortcode($atts) {
    // Parse attributes
    $atts = shortcode_atts(array(
        'ids' => '', // Comma separated list of attachment IDs
    ), $atts, 'city_library_slider');

    $attachments = [];

    if (!empty($atts['ids'])) {
        // Fetch specific IDs
        $id_array = array_map('intval', explode(',', $atts['ids']));
        $attachments = get_posts(array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post__in'       => $id_array,
            'orderby'        => 'post__in',
            'posts_per_page' => -1,
        ));
    } else {
        // Fallback: Fetch all images attached to the current post (excluding featured image)
        global $post;
        if (!$post) return '';

        $attachments = get_posts(array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'post_parent'    => $post->ID,
            'posts_per_page' => -1,
            'exclude'        => get_post_thumbnail_id($post->ID),
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ));
    }

    // If no images found, return nothing
    if (empty($attachments)) {
        return '';
    }

    // Generate HTML
    ob_start();
    ?>
    <div class="my-8 relative group/slider">
        <div class="swiper inline-post-slider rounded-2xl overflow-hidden shadow-lg border border-slate-100 bg-slate-50 aspect-video md:aspect-[21/9]">
            <div class="swiper-wrapper">
                <?php foreach ($attachments as $attachment) :
                    $img_full = wp_get_attachment_image_src($attachment->ID, 'full');
                    $img_large = wp_get_attachment_image_src($attachment->ID, 'large');
                    $alt_text = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true) ?: $attachment->post_title;
                ?>
                    <div class="swiper-slide">
                        <a href="<?php echo esc_url($img_full[0]); ?>" class="glightbox block w-full h-full cursor-zoom-in relative">
                            <img src="<?php echo esc_url($img_large[0]); ?>" alt="<?php echo esc_attr($alt_text); ?>" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/0 hover:bg-black/10 transition-colors duration-300 flex items-center justify-center opacity-0 hover:opacity-100">
                                <span class="material-symbols-outlined text-white bg-black/50 p-3 rounded-full drop-shadow-md">zoom_in</span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Navigation buttons -->
            <div class="swiper-button-prev !text-white !w-10 !h-10 !bg-black/40 hover:!bg-primary !rounded-full opacity-0 group-hover/slider:opacity-100 transition-all duration-300 backdrop-blur-sm shadow-md after:!text-sm ml-2"></div>
            <div class="swiper-button-next !text-white !w-10 !h-10 !bg-black/40 hover:!bg-primary !rounded-full opacity-0 group-hover/slider:opacity-100 transition-all duration-300 backdrop-blur-sm shadow-md after:!text-sm mr-2"></div>

            <!-- Pagination -->
            <div class="swiper-pagination !bottom-2"></div>
        </div>

        <!-- Inline script to initialize this specific slider -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swiper !== 'undefined') {
                    // Find all inline sliders and initialize them independently
                    const sliders = document.querySelectorAll('.inline-post-slider:not(.swiper-initialized)');
                    sliders.forEach(sliderElement => {
                        new Swiper(sliderElement, {
                            loop: true,
                            speed: 600,
                            autoplay: {
                                delay: 5000,
                                disableOnInteraction: false,
                                pauseOnMouseEnter: true
                            },
                            pagination: {
                                el: sliderElement.querySelector('.swiper-pagination'),
                                clickable: true,
                            },
                            navigation: {
                                nextEl: sliderElement.parentElement.querySelector('.swiper-button-next'),
                                prevEl: sliderElement.parentElement.querySelector('.swiper-button-prev'),
                            },
                            effect: 'fade',
                            fadeEffect: {
                                crossFade: true
                            }
                        });
                    });
                }
            });
        </script>

        <style>
            /* Specific style overrides for inline post slider pagination */
            .inline-post-slider .swiper-pagination-bullet { background: #fff; opacity: 0.5; }
            .inline-post-slider .swiper-pagination-bullet-active { background: var(--btn-bg, #0b7930); opacity: 1; }
        </style>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('city_library_slider', 'city_library_post_slider_shortcode');