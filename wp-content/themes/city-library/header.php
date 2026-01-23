<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('font-sans antialiased bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 transition-colors duration-300'); ?>>
<header id="masthead" class="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-secondary rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-white">menu_book</span>
                </div>
                <div class="hidden md:block">
                    <p class="text-xs font-bold uppercase tracking-widest text-secondary dark:text-primary"><?php echo esc_html(get_theme_mod('header_subtitle', __('Центральная городская', 'city-library'))); ?></p>
                    <p class="text-sm font-display font-bold"><?php echo esc_html(get_theme_mod('header_title', __('Библиотека', 'city-library'))); ?></p>
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
                <button id="accessibility-button" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                    <span class="material-symbols-outlined">visibility</span>
                </button>
            </div>
        </div>
    </div>
</header>
<main>
<?php if (get_theme_mod('show_hero_section', true)) : ?>
<section class="relative h-screen flex items-center justify-center hero-gradient pt-20" style="background-image: linear-gradient(rgba(26, 60, 52, 0.7), rgba(26, 60, 52, 0.85)), url('<?php echo esc_url(get_theme_mod('hero_background_image', get_template_directory_uri() . '/images/hero-bg.jpg')); ?>'); background-size: cover; background-position: center;">
    <div class="max-w-4xl mx-auto text-center px-4 space-y-8">
        <?php if (get_theme_mod('hero_show_badge', true)) : ?>
        <div class="inline-flex items-center bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20">
            <span class="w-2 h-2 bg-primary rounded-full mr-3 animate-pulse"></span>
            <span class="text-xs font-bold text-white uppercase tracking-widest"><?php echo esc_html(get_theme_mod('hero_badge_text', 'Добро пожаловать в мир знаний')); ?></span>
        </div>
        <?php endif; ?>

        <h1 class="text-5xl md:text-7xl lg:text-8xl font-display font-bold text-white leading-tight">
            <?php echo wp_kses_post(get_theme_mod('hero_title', 'Твой мир, <span class="text-primary italic text-glow">Твоя</span> <br/>библиотека')); ?>
        </h1>

        <p class="text-lg md:text-xl text-slate-200 max-w-2xl mx-auto font-light leading-relaxed">
            <?php echo esc_html(get_theme_mod('hero_subtitle', 'Центральная городская библиотека — пространство для открытий, творчества и вдохновения. Мы объединяем традиции и современные технологии.')); ?>
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a id="hero-primary-btn" class="w-full sm:w-auto px-8 py-4 bg-primary hover:bg-yellow-600 text-slate-900 font-bold rounded-full transition-all flex items-center justify-center space-x-2 shadow-lg shadow-primary/20" href="<?php echo esc_url(get_theme_mod('hero_primary_button_link', '#events')); ?>">
                <span class="material-symbols-outlined text-xl">event</span>
                <span><?php echo esc_html(get_theme_mod('hero_primary_button_text', 'АФИША МЕРОПРИЯТИЙ')); ?></span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
            <a id="hero-secondary-btn" class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-full border border-white/30 transition-all flex items-center justify-center" href="<?php echo esc_url(get_theme_mod('hero_secondary_button_link', '#about')); ?>">
                <span><?php echo esc_html(get_theme_mod('hero_secondary_button_text', 'УЗНАТЬ БОЛЬШЕ')); ?></span>
            </a>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
        <span class="material-symbols-outlined text-white text-3xl">expand_more</span>
    </div>
</section>
<?php endif; ?>
