<?php
/**
 * Template part for displaying the Promo section.
 */

$show_promo = get_theme_mod('show_promo_section', true);

if (!$show_promo) {
    return;
}

$image = get_theme_mod('promo_image');
$subtitle = get_theme_mod('promo_subtitle', 'THE MODERN LIBRARY EXPERIENCE');
$title = get_theme_mod('promo_title', 'Discover New Worlds');
$text = get_theme_mod('promo_text', 'Escape the ordinary with our meticulously curated collection of rare e-books, immersive audiobooks, and bespoke digital learning resources.');
$btn_text = get_theme_mod('promo_btn_text', 'Подробнее');
$link = get_theme_mod('promo_link', '#');

$btn2_text = get_theme_mod('promo_btn2_text', 'Watch Trailer');
$btn2_link = get_theme_mod('promo_btn2_link', '#');

$badge_text = get_theme_mod('promo_badge_text', 'Active Readers');
$badge_number = get_theme_mod('promo_badge_number', '12.4k+');
?>

<section class="mb-20 content-area w-full max-w-[95%] sm:max-w-[90%] xl:max-w-[85%] 2xl:max-w-[80%] mx-auto <?php echo city_library_get_animation_class(); ?>">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col lg:flex-row min-h-[500px]">

        <!-- Content Column (Left) -->
        <div class="w-full lg:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col justify-center order-2 lg:order-1 relative z-10">
             <?php if ($subtitle) : ?>
                <span class="block text-xs font-bold tracking-[0.2em] text-green-700 uppercase mb-4"><?php echo esc_html($subtitle); ?></span>
             <?php endif; ?>

             <?php if ($title) : ?>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-slate-900 mb-6 leading-tight">
                    <?php echo wp_kses_post($title); ?>
                </h2>
             <?php endif; ?>

             <?php if ($text) : ?>
                <div class="text-slate-600 text-lg leading-relaxed mb-10 prose max-w-none">
                    <?php echo wp_kses_post($text); ?>
                </div>
             <?php endif; ?>

             <div class="flex flex-col sm:flex-row gap-4">
                <?php if ($btn_text) : ?>
                    <a href="<?php echo esc_url($link); ?>" class="promo-btn px-8 py-4 rounded-xl font-bold text-white shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 text-center bg-green-700 hover:bg-green-800">
                        <?php echo esc_html($btn_text); ?>
                    </a>
                <?php endif; ?>

                <?php if ($btn2_text) : ?>
                    <a href="<?php echo esc_url($btn2_link); ?>" class="px-8 py-4 rounded-xl font-bold text-slate-700 border-2 border-slate-200 hover:bg-slate-50 transition-all flex items-center justify-center gap-2 hover:border-slate-300">
                        <span class="material-symbols-outlined">play_circle</span>
                        <?php echo esc_html($btn2_text); ?>
                    </a>
                <?php endif; ?>
             </div>
        </div>

        <!-- Image Column (Right) -->
        <div class="w-full lg:w-1/2 relative order-1 lg:order-2 h-64 lg:h-auto group overflow-hidden">
             <?php if ($image) : ?>
                <img src="<?php echo esc_url($image); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="<?php echo esc_attr($title); ?>">
             <?php else : ?>
                 <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-9xl text-slate-300">image</span>
                 </div>
             <?php endif; ?>

             <!-- Overlay Gradient -->
             <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent lg:bg-gradient-to-l lg:from-transparent lg:to-black/10"></div>

             <?php if ($badge_number) : ?>
                <div class="absolute bottom-6 right-6 bg-white/95 backdrop-blur-sm p-4 rounded-2xl shadow-lg flex items-center gap-4 animate-fade-in-up delay-200">
                    <div class="text-right">
                        <div class="text-2xl font-black text-slate-900 leading-none"><?php echo esc_html($badge_number); ?></div>
                        <div class="text-[10px] text-slate-500 font-bold uppercase tracking-wider"><?php echo esc_html($badge_text); ?></div>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700">
                         <span class="material-symbols-outlined">group</span>
                    </div>
                </div>
             <?php endif; ?>
        </div>
    </div>
</section>
