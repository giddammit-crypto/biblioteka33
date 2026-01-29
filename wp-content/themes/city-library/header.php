<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('font-sans antialiased bg-white text-slate-900 transition-colors duration-300'); ?>>
<header id="masthead" class="sticky top-0 w-full z-[100] bg-white border-b border-slate-100 shadow-sm transition-all duration-300">
    <div class="w-full max-w-[95%] sm:max-w-[90%] xl:max-w-[85%] 2xl:max-w-[80%] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20 md:h-24">
            <div class="flex items-center space-x-6 h-full py-2">
                <!-- Mobile Hamburger Button -->
                <button id="mobile-menu-btn" class="lg:hidden p-2 -ml-2 text-slate-600 hover:text-green-700 transition-colors">
                    <span class="material-symbols-outlined text-3xl">menu</span>
                </button>

                <?php if (has_custom_logo()) : ?>
                    <div class="custom-logo-wrapper h-full w-auto flex items-center [&_a]:h-full [&_a]:w-auto [&_img]:h-full [&_img]:w-auto [&_img]:object-contain">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <a href="<?php echo home_url(); ?>" class="w-12 h-12 bg-green-700 rounded-xl flex items-center justify-center hover:bg-green-800 transition-colors shadow-md">
                        <span class="material-symbols-outlined text-white text-2xl">menu_book</span>
                    </a>
                <?php endif; ?>
                <div class="hidden md:block">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 mb-0.5"><?php echo esc_html(get_theme_mod('header_subtitle', __('Центральная городская', 'city-library'))); ?></p>
                    <p class="text-xl font-display font-bold leading-none text-slate-900"><?php echo esc_html(get_theme_mod('header_title', __('Библиотека', 'city-library'))); ?></p>
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

            <!-- Eye Icon (Moved to far right) -->
            <div class="flex items-center space-x-2 ml-auto">
                <button id="accessibility-button" class="p-2.5 hover:bg-slate-100 rounded-full transition-colors text-slate-600 hover:text-green-700" aria-label="<?php esc_attr_e('Версия для слабовидящих', 'city-library'); ?>">
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
<div id="mobile-menu" class="fixed inset-0 z-[110] bg-black/50 backdrop-blur-sm transform translate-x-full transition-transform duration-500 cubic-bezier(0.4, 0, 0.2, 1) lg:hidden">
    <div class="absolute right-0 top-0 h-full w-[85%] max-w-sm bg-white shadow-2xl p-8 flex flex-col border-l border-slate-100">
        <div class="flex justify-between items-center mb-10">
            <span class="text-2xl font-bold font-display text-slate-900 tracking-wide"><?php _e('Меню', 'city-library'); ?></span>
            <button id="mobile-menu-close" class="p-2 hover:bg-slate-100 rounded-full transition-colors text-slate-600 hover:text-red-500">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <nav class="flex-grow space-y-4 flex flex-col">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'walker'         => new City_Library_Walker_Nav_Menu(),
            ));
            ?>
        </nav>
        <!-- Mobile Footer/Contact -->
        <div class="mt-auto border-t border-slate-100 pt-6">
             <p class="text-xs text-slate-500 text-center"><?php echo esc_html(get_theme_mod('footer_copyright')); ?></p>
        </div>
    </div>
</div>

<main>
<?php if (get_theme_mod('show_hero_section', true)) : ?>
<?php
    $hero_color = get_theme_mod('hero_overlay_color', '#1a3c34');
    list($r, $g, $b) = sscanf($hero_color, "#%02x%02x%02x");
    // Cleaner gradient
    $hero_gradient = "linear-gradient(to right bottom, rgba($r, $g, $b, 0.85), rgba($r, $g, $b, 0.7)), linear-gradient(to bottom, transparent, rgba(0,0,0,0.5))";
?>
<section class="relative min-h-[85vh] flex items-center justify-center pt-20 pb-12" style="background-image: <?php echo $hero_gradient; ?>, url('<?php echo esc_url(get_theme_mod('hero_background_image', get_template_directory_uri() . '/images/hero-bg.jpg')); ?>'); background-size: cover; background-position: center;">
    <div class="max-w-5xl mx-auto text-center px-4 space-y-8 relative z-10">
        <?php if (get_theme_mod('hero_show_badge', true)) : ?>
        <div class="inline-flex items-center bg-white/10 backdrop-blur-sm px-5 py-2 rounded-full border border-white/20 animate-fade-in-up">
            <span class="w-2 h-2 bg-green-400 rounded-full mr-3 animate-pulse"></span>
            <span class="text-[11px] font-bold text-white uppercase tracking-[0.2em]"><?php echo esc_html(get_theme_mod('hero_badge_text', 'Добро пожаловать в мир знаний')); ?></span>
        </div>
        <?php endif; ?>

        <h1 class="text-5xl md:text-7xl font-display font-bold text-white leading-tight animate-fade-in-up delay-100 drop-shadow-lg">
            <?php echo wp_kses_post(get_theme_mod('hero_title', 'Твой мир, <span class="text-secondary italic">Твоя</span> <br/>библиотека')); ?>
        </h1>

        <p class="text-lg md:text-xl text-slate-100 max-w-3xl mx-auto font-light leading-relaxed animate-fade-in-up delay-200">
            <?php echo esc_html(get_theme_mod('hero_subtitle', 'Центральная городская библиотека — пространство для открытий, творчества и вдохновения. Мы объединяем традиции и современные технологии.')); ?>
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-8 <?php echo city_library_get_animation_class(); ?>">
            <a id="hero-primary-btn" class="w-full sm:w-auto px-8 py-4 bg-green-700 hover:bg-green-600 text-white font-bold rounded-full transition-all duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl hover:-translate-y-0.5" href="<?php echo esc_url(get_theme_mod('hero_primary_button_link', '#events')); ?>">
                <span class="material-symbols-outlined text-xl">event</span>
                <span class="tracking-widest text-xs uppercase"><?php echo esc_html(get_theme_mod('hero_primary_button_text', 'АФИША МЕРОПРИЯТИЙ')); ?></span>
            </a>
            <a id="hero-secondary-btn" class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-bold rounded-full border border-white/30 transition-all duration-300 flex items-center justify-center hover:-translate-y-0.5" href="<?php echo esc_url(get_theme_mod('hero_secondary_button_link', '#about')); ?>">
                <span class="tracking-widest text-xs uppercase"><?php echo esc_html(get_theme_mod('hero_secondary_button_text', 'УЗНАТЬ БОЛЬШЕ')); ?></span>
            </a>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce opacity-70">
        <span class="material-symbols-outlined text-white text-3xl">expand_more</span>
    </div>
</section>
<?php endif; ?>