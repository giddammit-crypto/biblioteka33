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
        'ratio' => '21/9', // e.g. 16/9, 4/3, 1/1
        'effect' => 'fade', // fade, slide, cube, coverflow, flip
        'object_fit' => 'contain', // cover, contain
        'autoplay' => 'true', // true, false
        'style' => 'default', // default, shadow-card, brutalism, minimal
    ), $atts, 'city_library_slider');

    $attachments = [];
    $slider_id = 'slider-' . wp_generate_uuid4();

    // Validate aspect ratio to ensure it's safe for inline styles if needed
    $ratio = sanitize_text_field($atts['ratio']);
    $is_auto = ($ratio === 'auto');

    $effect = sanitize_text_field($atts['effect']);
    $object_fit = in_array($atts['object_fit'], ['cover', 'contain']) ? $atts['object_fit'] : 'contain';
    $autoplay = filter_var($atts['autoplay'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
    $style = in_array($atts['style'], ['default', 'shadow-card', 'brutalism', 'minimal']) ? $atts['style'] : 'default';

    // Base CSS rules
    $slider_style_css = $is_auto ? '' : 'aspect-ratio: ' . esc_attr($ratio) . ';';
    $img_classes = $is_auto ? 'w-full h-auto object-contain' : 'w-full h-full object-' . esc_attr($object_fit);

    // Apply visual styles
    $container_classes = 'swiper inline-post-slider overflow-hidden';

    if ($style === 'shadow-card') {
        $container_classes .= ' rounded-2xl shadow-2xl border border-slate-100 bg-white';
        $img_classes .= ' rounded-2xl';
    } elseif ($style === 'brutalism') {
        $container_classes .= ' border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] bg-white';
    } elseif ($style === 'minimal') {
        $container_classes .= ' bg-transparent';
    } else {
        // default
        $container_classes .= ' rounded-xl shadow border border-slate-200 bg-slate-50';
    }

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
    <div class="my-8 relative group/slider" id="<?php echo esc_attr($slider_id); ?>">
        <div class="<?php echo esc_attr($container_classes); ?>" style="<?php echo esc_attr($slider_style_css); ?>">
            <div class="swiper-wrapper">
                <?php foreach ($attachments as $attachment) :
                    $img_full = wp_get_attachment_image_src($attachment->ID, 'full');
                    $img_large = wp_get_attachment_image_src($attachment->ID, 'large');
                    $alt_text = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true) ?: $attachment->post_title;
                ?>
                    <div class="swiper-slide flex items-center justify-center <?php echo $is_auto ? 'h-auto' : ''; ?> <?php echo ($style === 'minimal') ? 'bg-transparent' : 'bg-slate-50'; ?>">
                        <a href="<?php echo esc_url($img_full[0]); ?>" class="glightbox block w-full <?php echo $is_auto ? 'h-auto flex items-center' : 'h-full'; ?> cursor-zoom-in relative">
                            <img src="<?php echo esc_url($img_large[0]); ?>" alt="<?php echo esc_attr($alt_text); ?>" class="<?php echo $img_classes; ?>">
                            <div class="absolute inset-0 bg-black/0 hover:bg-black/10 transition-colors duration-300 flex items-center justify-center opacity-0 hover:opacity-100 pointer-events-none">
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
                    const sliderWrapper = document.getElementById('<?php echo esc_js($slider_id); ?>');
                    if (!sliderWrapper) return;

                    const sliderElement = sliderWrapper.querySelector('.swiper');
                    if (sliderElement && !sliderElement.classList.contains('swiper-initialized')) {

                        const autoplayConfig = <?php echo $autoplay; ?> ? {
                            delay: 5000,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true
                        } : false;

                        new Swiper(sliderElement, {
                            loop: true,
                            speed: 600,
                            autoHeight: <?php echo $is_auto ? 'true' : 'false'; ?>,
                            autoplay: autoplayConfig,
                            pagination: {
                                el: sliderWrapper.querySelector('.swiper-pagination'),
                                clickable: true,
                            },
                            navigation: {
                                nextEl: sliderWrapper.querySelector('.swiper-button-next'),
                                prevEl: sliderWrapper.querySelector('.swiper-button-prev'),
                            },
                            effect: '<?php echo esc_js($effect); ?>',
                            fadeEffect: {
                                crossFade: true
                            }
                        });
                    }
                }
            });
        </script>

        <style>
            /* Specific style overrides for inline post slider pagination */
            #<?php echo esc_attr($slider_id); ?> .swiper-pagination-bullet { background: #fff; opacity: 0.5; }
            #<?php echo esc_attr($slider_id); ?> .swiper-pagination-bullet-active { background: var(--btn-bg, #0b7930); opacity: 1; }
        </style>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('city_library_slider', 'city_library_post_slider_shortcode');

/**
 * Register Gutenberg Block for the Slider
 */
function city_library_register_slider_block() {
    // Check if Gutenberg is active
    if (!function_exists('register_block_type')) {
        return;
    }

    // Register script
    wp_register_script(
        'city-library-slider-block',
        get_template_directory_uri() . '/js/block-slider.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-block-editor'),
        filemtime(get_template_directory() . '/js/block-slider.js')
    );

    // Register block
    register_block_type('city-library/slider', array(
        'editor_script' => 'city-library-slider-block',
        // The frontend rendering is handled by the shortcode generated in save()
    ));
}
add_action('init', 'city_library_register_slider_block');