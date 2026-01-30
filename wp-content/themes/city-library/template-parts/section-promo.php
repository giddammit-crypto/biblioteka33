<?php
/**
 * Template part for displaying the Promo section.
 */

$show_promo = get_theme_mod('show_promo_section', true);

if (!$show_promo) {
    return;
}

$image = get_theme_mod('promo_image');
$title = get_theme_mod('promo_title', __('Специальное предложение', 'city-library'));
$text = get_theme_mod('promo_text', __('Описание вашего специального предложения или важной новости.', 'city-library'));
$btn_text = get_theme_mod('promo_btn_text', __('Подробнее', 'city-library'));
$link = get_theme_mod('promo_link', '#');
?>

<section class="mb-12 content-area bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden relative isolate bg-pattern-slate <?php echo city_library_get_animation_class(); ?>">
    <!-- Decorative Glow (optional, keeping it subtle) -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-primary/5 rounded-full blur-3xl pointer-events-none z-0"></div>

    <div class="flex flex-col md:flex-row relative z-10 gap-8">
        <!-- Image Column -->
        <?php if ($image) : ?>
            <div class="shrink-0 md:w-[400px] h-[300px] relative overflow-hidden group rounded-2xl">
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
            </div>
        <?php else : ?>
            <!-- Placeholder if no image is set but block is enabled -->
             <div class="shrink-0 md:w-[400px] h-[300px] bg-slate-200 dark:bg-slate-700 flex items-center justify-center relative overflow-hidden rounded-2xl">
                <span class="material-symbols-outlined text-6xl text-slate-400">image</span>
             </div>
        <?php endif; ?>

        <!-- Content Column -->
        <div class="flex-grow flex flex-col justify-center">
            <?php if ($title) : ?>
                <h2 class="text-3xl font-display font-bold mb-4 text-slate-900 dark:text-white leading-tight">
                    <?php echo esc_html($title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($text) : ?>
                <div class="prose prose-slate dark:prose-invert max-w-none text-slate-600 dark:text-slate-300 mb-6">
                    <?php echo wp_kses_post(wpautop($text)); ?>
                </div>
            <?php endif; ?>

            <?php if ($link && $btn_text) : ?>
                <div>
                    <a href="<?php echo esc_url($link); ?>" class="promo-btn inline-flex items-center px-6 py-3 rounded-full bg-primary text-white font-bold text-sm uppercase tracking-wider hover:bg-primary/90 transition-all shadow-md hover:shadow-lg group">
                        <?php echo esc_html($btn_text); ?>
                        <span class="material-symbols-outlined ml-2 group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
