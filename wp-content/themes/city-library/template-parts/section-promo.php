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
$btn_text = get_theme_mod('promo_btn_text', 'Start Your Reading Journey');
$link = get_theme_mod('promo_link', '#');

$btn2_text = get_theme_mod('promo_btn2_text', 'Watch Trailer');
$btn2_link = get_theme_mod('promo_btn2_link', '#');

$badge_text = get_theme_mod('promo_badge_text', 'Active Readers');
$badge_number = get_theme_mod('promo_badge_number', '12.4k+');
?>

<section class="mb-24 content-area w-full max-w-[95%] sm:max-w-[90%] xl:max-w-[85%] 2xl:max-w-[80%] mx-auto relative <?php echo city_library_get_animation_class(); ?>">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
        <!-- Content -->
        <div class="order-2 lg:order-1 text-center lg:text-left">
             <?php if ($subtitle) : ?>
                <span class="block text-xs font-bold tracking-[0.2em] text-slate-500 uppercase mb-6"><?php echo esc_html($subtitle); ?></span>
             <?php endif; ?>

             <?php if ($title) : ?>
                <h2 class="text-4xl sm:text-5xl lg:text-7xl font-display font-bold text-slate-800 dark:text-white mb-8 leading-[1.1]">
                    <?php
                    // Allow simple styling in title if user adds span tags, but mostly rely on font
                    echo wp_kses_post($title);
                    ?>
                </h2>
             <?php endif; ?>

             <?php if ($text) : ?>
                <div class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed mb-10 max-w-xl mx-auto lg:mx-0 font-medium">
                    <?php echo wp_kses_post($text); ?>
                </div>
             <?php endif; ?>

             <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <?php if ($btn_text) : ?>
                    <a href="<?php echo esc_url($link); ?>" class="promo-btn px-8 py-4 rounded-xl font-bold text-white shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 text-center">
                        <?php echo esc_html($btn_text); ?>
                    </a>
                <?php endif; ?>

                <?php if ($btn2_text) : ?>
                    <a href="<?php echo esc_url($btn2_link); ?>" class="px-8 py-4 rounded-xl font-bold text-slate-700 dark:text-slate-200 bg-transparent border-2 border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">play_circle</span>
                        <?php echo esc_html($btn2_text); ?>
                    </a>
                <?php endif; ?>
             </div>
        </div>

        <!-- Image -->
        <div class="order-1 lg:order-2 relative flex justify-center lg:justify-end">
             <?php if ($image) : ?>
                <div class="relative w-[300px] h-[300px] md:w-[500px] md:h-[500px]">
                    <!-- Main Image -->
                    <img src="<?php echo esc_url($image); ?>" class="w-full h-full object-cover rounded-full border-[12px] border-white dark:border-slate-800 shadow-2xl relative z-10" alt="<?php echo esc_attr($title); ?>">

                    <!-- Badge -->
                    <?php if ($badge_number) : ?>
                    <div class="absolute bottom-4 md:bottom-10 -left-4 md:-left-10 z-20 bg-white/90 dark:bg-slate-800/90 backdrop-blur-md p-4 pr-8 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] flex items-center gap-4 animate-bounce-slow border border-white/20">
                        <div class="flex -space-x-3 shrink-0">
                            <div class="w-10 h-10 rounded-full bg-green-200 border-2 border-white dark:border-slate-700"></div>
                            <div class="w-10 h-10 rounded-full bg-purple-200 border-2 border-white dark:border-slate-700"></div>
                            <div class="w-10 h-10 rounded-full bg-slate-200 border-2 border-white dark:border-slate-700 flex items-center justify-center text-[10px] font-bold text-slate-500">...</div>
                        </div>
                        <div>
                            <div class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider mb-0.5"><?php echo esc_html($badge_text); ?></div>
                            <div class="text-xl font-black text-slate-800 dark:text-white leading-none"><?php echo esc_html($badge_number); ?></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Decorative Elements -->
                    <div class="absolute top-10 right-0 w-20 h-20 bg-yellow-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                    <div class="absolute -bottom-8 left-20 w-20 h-20 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                </div>
            <?php else : ?>
                 <!-- Fallback Placeholder -->
                 <div class="w-[300px] h-[300px] md:w-[500px] md:h-[500px] bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center border-[12px] border-white dark:border-slate-700 shadow-xl">
                    <span class="material-symbols-outlined text-9xl text-slate-300">auto_stories</span>
                 </div>
            <?php endif; ?>
        </div>
    </div>
</section>
