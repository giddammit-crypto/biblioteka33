<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class('font-sans antialiased bg-background-light text-slate-900 transition-colors duration-300'); ?>>
<?php wp_body_open(); ?>
<a class="sr-only focus:not-sr-only focus:absolute focus:z-[100] focus:p-4 focus:bg-white focus:text-primary transition-all" href="#primary"><?php esc_html_e( 'Перейти к основному содержимому', 'city-library' ); ?></a>

<?php
$header_style = get_theme_mod('header_style', 'default');
$menu_style = get_theme_mod('menu_style', 'default');

$header_classes = 'block fixed top-0 w-full z-50 bg-white/60 backdrop-blur-md border-b border-slate-200 hover:bg-white transition-colors duration-300 group';
$container_classes = 'w-full px-4 sm:px-6 lg:px-8';
$flex_classes = 'flex flex-wrap lg:flex-nowrap justify-between items-center h-auto min-h-[5rem] py-2 lg:py-0 gap-4';

// Header Style Logic
if ($header_style === 'centered') {
    $flex_classes = 'flex flex-col justify-center items-center h-auto py-4 space-y-4';
} elseif ($header_style === 'minimal') {
    // Logic handled in layout structure below (nav hidden)
} elseif ($header_style === 'full-width') {
    $container_classes = 'w-full px-0';
} elseif ($header_style === 'transparent-overlay') {
    $header_classes = 'block absolute top-0 w-full z-50 bg-transparent border-b border-white/10 hover:bg-white/90 transition-all duration-300 group hover:text-slate-900 text-white';
} elseif ($header_style === 'floating') {
    $header_classes = 'block fixed top-4 left-4 right-4 z-50 bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-slate-200 transition-all duration-300';
    $container_classes = 'w-full px-6';
} elseif ($header_style === 'dark-mode') {
    $header_classes = 'block fixed top-0 w-full z-50 bg-slate-900 border-b border-slate-800 text-white transition-colors duration-300';
}

// Menu Style Classes
$menu_item_classes = 'menu-style-' . $menu_style;
?>
<style>
/* Menu Styles */
.menu-style-underline a { position: relative; }
.menu-style-underline a::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px; background: currentColor; transition: width 0.3s; }
.menu-style-underline a:hover::after { width: 100%; }

.menu-style-pill a { padding: 0.5rem 1rem; border-radius: 9999px; transition: background 0.3s, color 0.3s; }
.menu-style-pill a:hover { background: var(--primary-color); color: white !important; }

.menu-style-bracket a::before { content: '['; opacity: 0; margin-right: 5px; transition: opacity 0.3s, transform 0.3s; transform: translateX(5px); }
.menu-style-bracket a::after { content: ']'; opacity: 0; margin-left: 5px; transition: opacity 0.3s, transform 0.3s; transform: translateX(-5px); }
.menu-style-bracket a:hover::before, .menu-style-bracket a:hover::after { opacity: 1; transform: translateX(0); }

.menu-style-bold a:hover { font-weight: 800; }
</style>

<header id="masthead" class="<?php echo esc_attr($header_classes); ?>">
    <div class="<?php echo esc_attr($container_classes); ?>">
        <div class="<?php echo esc_attr($flex_classes); ?>">
            <div class="flex items-center space-x-3 h-full shrink-0">
                <?php if (has_custom_logo()) : ?>
                    <div class="custom-logo-wrapper h-10 w-auto flex items-center [&_a]:h-full [&_a]:w-auto [&_img]:h-full [&_img]:w-auto [&_img]:object-contain">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <div class="w-10 h-10 bg-secondary rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-white">menu_book</span>
                    </div>
                <?php endif; ?>
                <!-- Text visible on all screens (adapted size) -->
                <div class="block">
                    <p class="text-[8px] sm:text-[10px] xl:text-xs font-bold uppercase tracking-widest text-secondary text-primary"><?php echo esc_html(get_theme_mod('header_subtitle', __('Центральная городская', 'city-library'))); ?></p>
                    <p class="text-[10px] sm:text-xs xl:text-sm font-display font-bold leading-tight"><?php echo esc_html(get_theme_mod('header_title', __('Библиотека', 'city-library'))); ?></p>
                </div>
            </div>

            <?php if ($header_style !== 'minimal') : ?>
            <nav class="hidden xl:flex items-center space-x-4 xl:space-x-8 text-sm xl:text-base <?php echo esc_attr($menu_item_classes); ?>">
                 <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'walker'         => new City_Library_Walker_Nav_Menu(),
                    ));
                ?>
            </nav>
            <?php endif; ?>

            <div class="flex items-center space-x-2">
                <!-- Search Button Removed as per request -->
                <!-- Mobile Menu Button Removed as per request -->
                <button id="accessibility-button" class="p-2 rounded-full transition-colors shadow-sm border border-slate-200" aria-label="<?php esc_attr_e('Настройки доступности', 'city-library'); ?>" style="background-color: #ffffff !important; color: #000000 !important;">
                    <span class="material-symbols-outlined">visibility</span>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu" class="fixed inset-0 h-[100dvh] z-[60] bg-black/50 backdrop-blur-sm transform translate-x-full transition-transform duration-300 xl:hidden pointer-events-none">
    <div class="absolute right-0 top-0 h-full w-4/5 max-w-sm bg-white shadow-2xl p-6 flex flex-col bg-pattern-slate pointer-events-auto overflow-y-auto">
        <div class="flex justify-between items-center mb-8 shrink-0">
            <span class="text-lg font-bold font-display text-secondary"><?php _e('Меню', 'city-library'); ?></span>
            <button id="mobile-menu-close" class="p-2 hover:bg-slate-100 rounded-full transition-colors" aria-label="<?php esc_attr_e('Закрыть меню', 'city-library'); ?>">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <nav class="flex-grow space-y-4 flex flex-col shrink-0">
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
        <div class="mt-auto border-t border-slate-200 pt-6 shrink-0 pb-6">
             <p class="text-xs text-slate-500 text-center"><?php echo esc_html(get_theme_mod('footer_copyright')); ?></p>
        </div>
    </div>
</div>

<main>
<?php if (get_theme_mod('show_hero_section', true)) : ?>
<?php
    $hero_color = get_theme_mod('hero_overlay_color', '#1a3c34');
    $hero_opacity = get_theme_mod('hero_bg_opacity', '0.5');
    list($r, $g, $b) = sscanf($hero_color, "#%02x%02x%02x");
    // Use opacity control for overlay strength
    $hero_gradient = "linear-gradient(rgba($r, $g, $b, $hero_opacity), rgba($r, $g, $b, $hero_opacity))";

    $hero_align = get_theme_mod('hero_align', 'center');
    $hero_text_align_class = 'text-' . $hero_align;
    $hero_flex_align_class = ($hero_align === 'left') ? 'items-start justify-start text-left' : (($hero_align === 'right') ? 'items-end justify-end text-right' : 'items-center justify-center text-center');
    $hero_mx_class = ($hero_align === 'left' || $hero_align === 'right') ? 'mx-0' : 'mx-auto';

    $hero_title_size = get_theme_mod('hero_title_size', 'text-5xl md:text-7xl lg:text-8xl');
    $hero_image_url = get_theme_mod('hero_background_image', get_template_directory_uri() . '/images/hero-bg.jpg');
?>
<section class="relative min-h-screen flex <?php echo esc_attr($hero_flex_align_class); ?> hero-gradient pt-24 lg:pt-20 overflow-hidden">
    <!-- Adaptive Image -->
    <img src="<?php echo esc_url($hero_image_url); ?>" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover -z-20">

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 -z-10" style="background: <?php echo $hero_gradient; ?>;"></div>

    <div class="relative z-10 max-w-4xl <?php echo esc_attr($hero_mx_class); ?> px-4 space-y-8 w-full">
        <?php if (get_theme_mod('hero_show_badge', true)) : ?>
        <div class="inline-flex items-center bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 animate-fade-in-up">
            <span class="w-2 h-2 bg-primary rounded-full mr-3 animate-pulse"></span>
            <span class="text-xs font-bold text-white uppercase tracking-widest"><?php echo esc_html(get_theme_mod('hero_badge_text', 'Добро пожаловать в мир знаний')); ?></span>
        </div>
        <?php endif; ?>

        <h1 class="<?php echo esc_attr($hero_title_size); ?> font-display font-bold text-white leading-tight animate-fade-in-up delay-100">
            <?php echo wp_kses_post(get_theme_mod('hero_title', 'Твой мир, <span class="text-primary italic text-glow">Твоя</span> <br/>библиотека')); ?>
        </h1>

        <p class="text-lg md:text-xl text-slate-200 max-w-2xl <?php echo esc_attr($hero_mx_class); ?> font-light leading-relaxed animate-fade-in-up delay-200">
            <?php echo esc_html(get_theme_mod('hero_subtitle', 'Центральная городская библиотека — пространство для открытий, творчества и вдохновения. Мы объединяем традиции и современные технологии.')); ?>
        </p>

        <div class="flex flex-col sm:flex-row <?php echo esc_attr($hero_flex_align_class); ?> gap-4 pt-4 <?php echo city_library_get_animation_class(); ?>">
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
