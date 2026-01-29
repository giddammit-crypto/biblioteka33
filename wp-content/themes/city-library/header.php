<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('font-sans antialiased bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 transition-colors duration-300'); ?>>
<header id="masthead" class="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-white/20 dark:border-slate-800 shadow-glass transition-all duration-300">
    <div class="w-full max-w-[95%] sm:max-w-[90%] xl:max-w-[85%] 2xl:max-w-[80%] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-24">
            <div class="flex items-center space-x-4 h-full py-2">
                <!-- Mobile Hamburger Button -->
                <button id="mobile-menu-btn" class="lg:hidden p-2 -ml-2 text-slate-600 dark:text-slate-300 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-3xl">menu</span>
                </button>

                <?php if (has_custom_logo()) : ?>
                    <div class="custom-logo-wrapper h-full w-auto flex items-center [&_a]:h-full [&_a]:w-auto [&_img]:h-full [&_img]:w-auto [&_img]:object-contain">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <div class="w-10 h-10 bg-secondary rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-white">menu_book</span>
                    </div>
                <?php endif; ?>
                <div class="hidden md:block">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400 mb-0.5"><?php echo esc_html(get_theme_mod('header_subtitle', __('Центральная городская', 'city-library'))); ?></p>
                    <p class="text-xl font-display font-bold leading-none text-slate-800 dark:text-white"><?php echo esc_html(get_theme_mod('header_title', __('Библиотека', 'city-library'))); ?></p>
                </div>
            </div>

            <nav class="hidden lg:flex items-center space-x-10">
                 <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'walker'         => new City_Library_Walker_Nav_Menu(),
                    ));
                ?>
            </nav>

            <!-- Eye Icon (Moved to far right) -->
            <div class="flex items-center space-x-2 ml-auto">
                <button id="accessibility-button" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors text-slate-600 dark:text-slate-300">
                    <span class="material-symbols-outlined">visibility</span>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Global Breadcrumbs -->
<?php
if (!is_front_page()) {
    get_template_part('template-parts/breadcrumbs');
}
?>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu" class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-md transform translate-x-full transition-transform duration-500 cubic-bezier(0.4, 0, 0.2, 1) lg:hidden">
    <div class="absolute right-0 top-0 h-full w-[85%] max-w-sm bg-white/95 dark:bg-slate-900/95 backdrop-blur-2xl shadow-2xl p-8 flex flex-col border-l border-white/20">
        <div class="flex justify-between items-center mb-10">
            <span class="text-2xl font-bold font-display text-slate-800 dark:text-white tracking-wide"><?php _e('Меню', 'city-library'); ?></span>
            <button id="mobile-menu-close" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <nav class="flex-grow space-y-4 flex flex-col">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s',
                // Use a simpler walker or default to ensure vertical stacking
                'walker'         => new City_Library_Walker_Nav_Menu(),
            ));
            ?>
        </nav>
        <!-- Mobile Footer/Contact -->
        <div class="mt-auto border-t border-slate-200 dark:border-slate-800 pt-6">
             <p class="text-xs text-slate-500 text-center"><?php echo esc_html(get_theme_mod('footer_copyright')); ?></p>
        </div>
    </div>
</div>

<main>
<?php if (get_theme_mod('show_hero_section', true)) : ?>
<?php
    $hero_color = get_theme_mod('hero_overlay_color', '#1a3c34');
    list($r, $g, $b) = sscanf($hero_color, "#%02x%02x%02x");
    // Radial gradient spotlight effect + linear overlay for text legibility
    $hero_gradient = "radial-gradient(circle at 50% 50%, rgba($r, $g, $b, 0.4) 0%, rgba($r, $g, $b, 0.85) 100%), linear-gradient(to bottom, rgba(0,0,0,0.3), rgba($r, $g, $b, 0.9))";
?>
<section class="relative min-h-[90vh] flex items-center justify-center hero-gradient pt-24 pb-12" style="background-image: <?php echo $hero_gradient; ?>, url('<?php echo esc_url(get_theme_mod('hero_background_image', get_template_directory_uri() . '/images/hero-bg.jpg')); ?>'); background-size: cover; background-position: center fixed;">
    <div class="max-w-5xl mx-auto text-center px-4 space-y-10 relative z-10">
        <?php if (get_theme_mod('hero_show_badge', true)) : ?>
        <div class="inline-flex items-center bg-white/5 backdrop-blur-md px-5 py-2.5 rounded-full border border-white/10 animate-fade-in-up shadow-glass hover:bg-white/10 transition-colors">
            <span class="w-2 h-2 bg-secondary rounded-full mr-3 animate-pulse"></span>
            <span class="text-[10px] font-bold text-white uppercase tracking-[0.2em]"><?php echo esc_html(get_theme_mod('hero_badge_text', 'Добро пожаловать в мир знаний')); ?></span>
        </div>
        <?php endif; ?>

        <h1 class="text-5xl md:text-7xl lg:text-9xl font-display font-bold text-white leading-tight animate-fade-in-up delay-100 drop-shadow-2xl">
            <?php echo wp_kses_post(get_theme_mod('hero_title', 'Твой мир, <span class="text-secondary italic">Твоя</span> <br/>библиотека')); ?>
        </h1>

        <p class="text-lg md:text-2xl text-slate-100 max-w-3xl mx-auto font-light leading-relaxed animate-fade-in-up delay-200 drop-shadow-md">
            <?php echo esc_html(get_theme_mod('hero_subtitle', 'Центральная городская библиотека — пространство для открытий, творчества и вдохновения. Мы объединяем традиции и современные технологии.')); ?>
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-5 pt-8 <?php echo city_library_get_animation_class(); ?>">
            <a id="hero-primary-btn" class="w-full sm:w-auto px-10 py-5 bg-primary hover:bg-secondary text-white font-bold rounded-full transition-all duration-300 flex items-center justify-center space-x-3 shadow-lg hover:shadow-glow hover:-translate-y-1" href="<?php echo esc_url(get_theme_mod('hero_primary_button_link', '#events')); ?>">
                <span class="material-symbols-outlined text-xl">event</span>
                <span class="tracking-widest text-sm"><?php echo esc_html(get_theme_mod('hero_primary_button_text', 'АФИША МЕРОПРИЯТИЙ')); ?></span>
            </a>
            <a id="hero-secondary-btn" class="w-full sm:w-auto px-10 py-5 bg-white/5 hover:bg-white/10 backdrop-blur-md text-white font-bold rounded-full border border-white/20 transition-all duration-300 flex items-center justify-center hover:-translate-y-1 hover:border-white/40" href="<?php echo esc_url(get_theme_mod('hero_secondary_button_link', '#about')); ?>">
                <span class="tracking-widest text-sm"><?php echo esc_html(get_theme_mod('hero_secondary_button_text', 'УЗНАТЬ БОЛЬШЕ')); ?></span>
            </a>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
        <span class="material-symbols-outlined text-white text-3xl">expand_more</span>
    </div>
</section>
<?php endif; ?>
