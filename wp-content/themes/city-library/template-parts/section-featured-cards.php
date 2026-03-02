<?php
if (!get_theme_mod('show_featured_cards', false)) {
    return;
}

$section_title = get_theme_mod('featured_cards_title', 'Наши направления');
$design_style = get_theme_mod('featured_cards_design', 'design-1');
?>

<section class="featured-cards-section py-16 bg-transparent w-full <?php echo city_library_get_animation_class(); ?>">
    <div class="w-full lg:max-w-[80%] lg:mx-auto px-4 lg:px-8">
        <?php if ($section_title) : ?>
            <div class="flex flex-col items-center justify-center mb-12 gap-6 text-center">
                <div class="space-y-4 max-w-2xl mx-auto">
                    <div class="h-1 w-20 bg-primary mx-auto"></div>
                    <h2 class="text-[32px] md:text-[50px] font-display font-bold leading-tight"><?php echo esc_html($section_title); ?></h2>
                </div>
            </div>
        <?php endif; ?>

        <!-- Responsive Layout: Swiper for Mobile (< lg), Grid for Kiosk/Desktop (>= lg) -->
        <div class="swiper featured-cards-slider w-full">
            <div class="swiper-wrapper lg:!grid lg:grid-cols-4 lg:gap-6">
                <?php for ($i = 1; $i <= 4; $i++) :
                    $image = get_theme_mod("fc_image_$i", '');
                    $title = get_theme_mod("fc_title_$i", sprintf('Карточка %d', $i));
                    $desc = get_theme_mod("fc_desc_$i", 'Краткое описание карточки.');
                    $link = get_theme_mod("fc_link_$i", '#');
                    ?>

                    <div class="swiper-slide h-auto shrink-0 w-[80vw] sm:w-[320px] lg:w-auto snap-center">
                        <a href="<?php echo esc_url($link); ?>" class="block h-full group focus:outline-none">
                            <?php
                            // Render based on design choice
                            switch ($design_style) {
                                case 'design-2': // Text over image
                                    ?>
                                    <div class="relative h-[400px] w-full rounded-2xl overflow-hidden shadow-lg group-hover:shadow-2xl transition-all duration-300">
                                        <?php if ($image) : ?>
                                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                        <?php else : ?>
                                            <div class="absolute inset-0 bg-slate-200"></div>
                                        <?php endif; ?>
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                                        <div class="absolute inset-0 p-6 flex flex-col justify-end text-white">
                                            <h3 class="text-xl font-bold font-display mb-2 group-hover:text-primary transition-colors"><?php echo esc_html($title); ?></h3>
                                            <p class="text-sm text-slate-200 line-clamp-3"><?php echo esc_html($desc); ?></p>
                                        </div>
                                    </div>
                                    <?php
                                    break;

                                case 'design-3': // Minimalist without background
                                    ?>
                                    <div class="flex flex-col h-full bg-transparent group-hover:-translate-y-2 transition-transform duration-300">
                                        <?php if ($image) : ?>
                                            <div class="w-full aspect-video rounded-xl overflow-hidden mb-4">
                                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                            </div>
                                        <?php endif; ?>
                                        <h3 class="text-xl font-bold font-display mb-2 text-slate-900 group-hover:text-primary transition-colors"><?php echo esc_html($title); ?></h3>
                                        <p class="text-sm text-slate-600 line-clamp-3"><?php echo esc_html($desc); ?></p>
                                    </div>
                                    <?php
                                    break;

                                case 'design-4': // Shadow and border radius
                                    ?>
                                    <div class="flex flex-col h-full bg-white rounded-[2rem] overflow-hidden shadow-xl group-hover:shadow-2xl transition-all duration-300 group-hover:-translate-y-1">
                                        <?php if ($image) : ?>
                                            <div class="w-full aspect-video overflow-hidden shrink-0">
                                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                            </div>
                                        <?php endif; ?>
                                        <div class="p-6 flex flex-col flex-grow">
                                            <h3 class="text-xl font-bold font-display mb-2 text-slate-900 group-hover:text-primary transition-colors"><?php echo esc_html($title); ?></h3>
                                            <p class="text-sm text-slate-600 line-clamp-3"><?php echo esc_html($desc); ?></p>
                                        </div>
                                    </div>
                                    <?php
                                    break;

                                case 'design-5': // Gradient background
                                    ?>
                                    <div class="flex flex-col h-full bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl overflow-hidden shadow-md group-hover:shadow-lg border border-slate-200 transition-all duration-300 group-hover:-translate-y-1">
                                        <?php if ($image) : ?>
                                            <div class="w-full aspect-[4/3] overflow-hidden shrink-0 relative">
                                                <div class="absolute inset-0 bg-primary/10 mix-blend-multiply z-10 group-hover:opacity-0 transition-opacity duration-300"></div>
                                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                            </div>
                                        <?php endif; ?>
                                        <div class="p-6 flex flex-col flex-grow text-center">
                                            <h3 class="text-lg font-bold font-display mb-2 text-slate-900 group-hover:text-primary transition-colors uppercase tracking-wider"><?php echo esc_html($title); ?></h3>
                                            <p class="text-sm text-slate-600 line-clamp-3"><?php echo esc_html($desc); ?></p>
                                        </div>
                                    </div>
                                    <?php
                                    break;

                                case 'design-6': // Glassmorphism
                                    ?>
                                    <div class="relative flex flex-col h-full rounded-2xl overflow-hidden shadow-lg group-hover:shadow-xl transition-all duration-300">
                                        <?php if ($image) : ?>
                                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                        <?php else : ?>
                                            <div class="absolute inset-0 bg-slate-800"></div>
                                        <?php endif; ?>
                                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors duration-300 z-0"></div>
                                        <div class="relative z-10 flex flex-col justify-end h-[400px] p-4">
                                            <div class="bg-white/20 backdrop-blur-md border border-white/30 rounded-xl p-5 text-white">
                                                <h3 class="text-lg font-bold font-display mb-2 text-white shadow-sm"><?php echo esc_html($title); ?></h3>
                                                <p class="text-sm text-slate-100 line-clamp-2"><?php echo esc_html($desc); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    break;

                                case 'design-7': // Thin top line
                                    ?>
                                    <div class="flex flex-col h-full bg-white rounded-lg shadow-sm group-hover:shadow-md border border-slate-100 border-t-4 border-t-primary transition-all duration-300 group-hover:-translate-y-1 p-6">
                                        <?php if ($image) : ?>
                                            <div class="w-16 h-16 rounded-full overflow-hidden mb-4 border border-slate-200 shrink-0 shadow-inner">
                                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover">
                                            </div>
                                        <?php endif; ?>
                                        <h3 class="text-lg font-bold font-display mb-2 text-slate-900 group-hover:text-primary transition-colors"><?php echo esc_html($title); ?></h3>
                                        <p class="text-sm text-slate-600 line-clamp-4"><?php echo esc_html($desc); ?></p>
                                    </div>
                                    <?php
                                    break;

                                case 'design-8': // Solid fill, icon (using image as icon)
                                    ?>
                                    <div class="flex flex-col items-center text-center h-full bg-slate-800 rounded-3xl p-8 shadow-xl group-hover:bg-primary transition-colors duration-500">
                                        <?php if ($image) : ?>
                                            <div class="w-20 h-20 mb-6 shrink-0 flex items-center justify-center bg-white/10 rounded-full p-4">
                                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-contain filter brightness-0 invert">
                                            </div>
                                        <?php endif; ?>
                                        <h3 class="text-xl font-bold font-display mb-3 text-white"><?php echo esc_html($title); ?></h3>
                                        <p class="text-sm text-slate-300 line-clamp-4"><?php echo esc_html($desc); ?></p>
                                    </div>
                                    <?php
                                    break;

                                case 'design-9': // Large title, no photo
                                    ?>
                                    <div class="flex flex-col justify-between h-full bg-white rounded-2xl p-8 border border-slate-200 shadow-sm group-hover:shadow-xl group-hover:border-primary transition-all duration-300 group-hover:-translate-y-2">
                                        <div>
                                            <h3 class="text-3xl font-bold font-display mb-4 text-slate-900 group-hover:text-primary transition-colors"><?php echo esc_html($title); ?></h3>
                                            <p class="text-base text-slate-600 line-clamp-4"><?php echo esc_html($desc); ?></p>
                                        </div>
                                        <div class="mt-6 flex items-center text-primary font-bold text-sm uppercase tracking-wider">
                                            <?php _e('Подробнее', 'city-library'); ?>
                                            <span class="material-symbols-outlined ml-2 transform group-hover:translate-x-2 transition-transform">arrow_forward</span>
                                        </div>
                                    </div>
                                    <?php
                                    break;

                                case 'design-10': // Polaroid style
                                    ?>
                                    <div class="flex flex-col h-full bg-white p-4 shadow-md group-hover:shadow-2xl transition-all duration-300 transform group-hover:rotate-1">
                                        <?php if ($image) : ?>
                                            <div class="w-full aspect-[4/5] bg-slate-100 overflow-hidden shrink-0 mb-4 border border-slate-200">
                                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                            </div>
                                        <?php else : ?>
                                             <div class="w-full aspect-[4/5] bg-slate-200 shrink-0 mb-4 border border-slate-300"></div>
                                        <?php endif; ?>
                                        <div class="text-center px-2 pb-4 pt-2">
                                            <h3 class="text-lg font-bold font-handwriting mb-1 text-slate-800"><?php echo esc_html($title); ?></h3>
                                            <p class="text-xs text-slate-500 line-clamp-2"><?php echo esc_html($desc); ?></p>
                                        </div>
                                    </div>
                                    <?php
                                    break;

                                case 'design-1': // Default standard with border
                                default:
                                    ?>
                                    <div class="flex flex-col h-full bg-white rounded-2xl overflow-hidden shadow-md group-hover:shadow-xl border border-slate-200 transition-all duration-300 group-hover:-translate-y-1">
                                        <?php if ($image) : ?>
                                            <div class="w-full h-48 overflow-hidden shrink-0 border-b border-slate-100">
                                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                            </div>
                                        <?php endif; ?>
                                        <div class="p-6 flex flex-col flex-grow">
                                            <h3 class="text-xl font-bold font-display mb-3 text-slate-900 group-hover:text-primary transition-colors"><?php echo esc_html($title); ?></h3>
                                            <p class="text-sm text-slate-600 line-clamp-3 mb-4"><?php echo esc_html($desc); ?></p>
                                            <div class="mt-auto flex items-center text-primary font-bold text-sm">
                                                <?php _e('Узнать больше', 'city-library'); ?>
                                                <span class="material-symbols-outlined ml-1 text-lg transform transition-transform group-hover:translate-x-1">arrow_right_alt</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    break;
                            }
                            ?>
                        </a>
                    </div>
                <?php endfor; ?>
            </div>
            <!-- Pagination for mobile swiper -->
            <div class="swiper-pagination lg:hidden !bottom-0 !relative mt-8"></div>
        </div>
    </div>
</section>
