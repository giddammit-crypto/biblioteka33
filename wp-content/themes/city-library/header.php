<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('font-sans antialiased bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 transition-colors duration-300'); ?>>
<header id="masthead" class="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center space-x-3 h-full py-2">
                <!-- Mobile Hamburger Button -->
                <button id="mobile-menu-btn" class="lg:hidden p-2 -ml-2 text-slate-600 dark:text-slate-300 hover:text-primary transition-colors" aria-label="<?php esc_attr_e('Открыть меню', 'city-library'); ?>" aria-controls="mobile-menu" aria-expanded="false">
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
                    <p class="text-xs font-bold uppercase tracking-widest text-secondary dark:text-primary"><?php echo esc_html(get_theme_mod('header_subtitle', __('Центральная городская', 'city-library'))); ?></p>
                    <p class="text-xs font-display font-bold"><?php echo esc_html(get_theme_mod('header_title', __('Библиотека', 'city-library'))); ?></p>
                </div>
            </div>

            <nav class="hidden lg:flex items-center space-x-8">
                 <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'walker'         => new City_Library_Walker_Nav_Menu(),
                    ));
                ?>
            </nav>

            <div class="flex items-center space-x-2">
                <button id="accessibility-button" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors" aria-label="<?php esc_attr_e('Настройки доступности', 'city-library'); ?>">
                    <span class="material-symbols-outlined">visibility</span>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu" class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm transform translate-x-full transition-transform duration-300 lg:hidden">
    <div class="absolute right-0 top-0 h-full w-4/5 max-w-sm bg-white dark:bg-slate-900 shadow-2xl p-6 flex flex-col bg-pattern-slate">
        <div class="flex justify-between items-center mb-8">
            <span class="text-lg font-bold font-display text-secondary dark:text-white"><?php _e('Меню', 'city-library'); ?></span>
            <button id="mobile-menu-close" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors" aria-label="<?php esc_attr_e('Закрыть меню', 'city-library'); ?>">
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
    $hero_gradient = "linear-gradient(rgba($r, $g, $b, 0.7), rgba($r, $g, $b, 0.85))";
?>
<section class="relative h-screen flex items-center justify-center hero-gradient pt-20" style="background-image: <?php echo $hero_gradient; ?>, url('<?php echo esc_url(get_theme_mod('hero_background_image', get_template_directory_uri() . '/images/hero-bg.jpg')); ?>'); background-size: cover; background-position: center;">
    <div class="max-w-4xl mx-auto text-center px-4 space-y-8">
        <?php if (get_theme_mod('hero_show_badge', true)) : ?>
        <div class="inline-flex items-center bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 animate-fade-in-up">
            <span class="w-2 h-2 bg-primary rounded-full mr-3 animate-pulse"></span>
            <span class="text-xs font-bold text-white uppercase tracking-widest"><?php echo esc_html(get_theme_mod('hero_badge_text', 'Добро пожаловать в мир знаний')); ?></span>
        </div>
        <?php endif; ?>

        <h1 class="text-5xl md:text-7xl lg:text-8xl font-display font-bold text-white leading-tight animate-fade-in-up delay-100">
            <?php echo wp_kses_post(get_theme_mod('hero_title', 'Твой мир, <span class="text-primary italic text-glow">Твоя</span> <br/>библиотека')); ?>
        </h1>

        <p class="text-lg md:text-xl text-slate-200 max-w-2xl mx-auto font-light leading-relaxed animate-fade-in-up delay-200">
            <?php echo esc_html(get_theme_mod('hero_subtitle', 'Центральная городская библиотека — пространство для открытий, творчества и вдохновения. Мы объединяем традиции и современные технологии.')); ?>
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4 <?php echo city_library_get_animation_class(); ?>">
            <a id="hero-primary-btn" class="w-full sm:w-auto px-6 py-3 sm:px-8 sm:py-4 bg-primary hover:bg-yellow-600 text-slate-900 font-bold rounded-full transition-all flex items-center justify-center space-x-2 shadow-lg shadow-primary/20 text-center" href="<?php echo esc_url(get_theme_mod('hero_primary_button_link', '#events')); ?>">
                <span class="material-symbols-outlined text-xl shrink-0">event</span>
                <span class="whitespace-normal sm:whitespace-nowrap"><?php echo esc_html(get_theme_mod('hero_primary_button_text', 'АФИША МЕРОПРИЯТИЙ')); ?></span>
                <span class="material-symbols-outlined shrink-0">arrow_forward</span>
            </a>
            <a id="hero-secondary-btn" class="w-full sm:w-auto px-6 py-3 sm:px-8 sm:py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-full border border-white/30 transition-all flex items-center justify-center text-center" href="<?php echo esc_url(get_theme_mod('hero_secondary_button_link', '#about')); ?>">
                <span class="whitespace-normal sm:whitespace-nowrap"><?php echo esc_html(get_theme_mod('hero_secondary_button_text', 'УЗНАТЬ БОЛЬШЕ')); ?></span>
            </a>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
        <span class="material-symbols-outlined text-white text-3xl">expand_more</span>
    </div>
</section>
<?php endif; ?>
