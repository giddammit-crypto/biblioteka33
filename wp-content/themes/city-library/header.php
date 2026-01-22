<!DOCTYPE html>

<html class="light" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-background-light dark:bg-background-dark text-navy-deep dark:text-white font-display antialiased' ); ?>>
<!-- Top Navigation -->
<header class="sticky top-0 z-50 w-full border-b border-gray-200 dark:border-gray-800 bg-white/90 dark:bg-background-dark/95 backdrop-blur-md">
<div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
<div class="flex items-center gap-2">
<div class="flex h-8 w-8 items-center justify-center rounded bg-primary text-white">
<span class="material-symbols-outlined text-xl">local_library</span>
</div>
<h1 class="text-xl font-bold tracking-tight text-navy-deep dark:text-white"><?php bloginfo('name'); ?></h1>
</div>
<?php
wp_nav_menu( array(
    'theme_location' => 'primary-menu',
    'container'      => 'nav',
    'container_class'=> 'hidden md:flex items-center gap-8',
    'menu_class'     => 'flex items-center gap-8',
    'fallback_cb'    => false,
    'walker'         => new City_Library_Nav_Walker(),
) );
?>
<div class="flex items-center gap-3">
<button class="hidden sm:flex h-9 items-center justify-center rounded-lg px-4 text-sm font-bold text-navy-deep dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
    <?php _e( 'Login', 'city-library' ); ?>
</button>
<button class="flex h-9 items-center justify-center rounded-lg bg-primary px-4 text-sm font-bold text-white shadow-sm hover:bg-blue-700 transition-colors">
    <?php _e( 'Join', 'city-library' ); ?>
</button>
</div>
</div>
</header>
<!-- Hero Section -->
<div class="relative w-full bg-navy-deep">
<div class="absolute inset-0 bg-cover bg-center" style="background-image: linear-gradient(rgba(13, 18, 27, 0.7), rgba(13, 18, 27, 0.5)), url('<?php echo esc_url( get_theme_mod( 'hero_background_image', get_template_directory_uri() . '/images/hero-background.jpg' ) ); ?>');"></div>
<div class="relative mx-auto flex min-h-[500px] max-w-7xl flex-col items-center justify-center px-4 py-20 text-center sm:px-6 lg:px-8 lg:py-32">
<div class="mb-6 inline-flex items-center rounded-full border border-white/20 bg-white/10 px-3 py-1 text-sm font-medium text-white backdrop-blur-sm">
<span class="mr-2 h-2 w-2 rounded-full bg-gold-accent"></span>
                <?php _e( 'Now Open: The Innovation Wing', 'city-library' ); ?>
            </div>
<h1 class="mb-4 max-w-3xl text-4xl font-black leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                <?php echo wp_kses_post( get_theme_mod( 'hero_title', __( 'Discover Knowledge <br class="hidden sm:block"/> without Limits', 'city-library' ) ) ); ?>
            </h1>
<p class="mb-10 max-w-2xl text-lg text-gray-200 sm:text-xl">
                <?php echo wp_kses_post( get_theme_mod( 'hero_subtitle', __( 'Explore our vast collection of books, digital archives, and community events in a space designed for modern learning.', 'city-library' ) ) ); ?>
            </p>
<!-- Search Bar -->
<div class="w-full max-w-2xl">
<div class="group relative flex h-14 w-full items-center rounded-xl bg-white shadow-2xl transition-transform focus-within:scale-[1.01] sm:h-16">
<div class="flex h-full w-14 items-center justify-center text-gray-400">
<span class="material-symbols-outlined text-2xl">search</span>
</div>
<input class="h-full flex-1 border-0 bg-transparent p-0 text-base text-navy-deep placeholder:text-gray-400 focus:ring-0 sm:text-lg" placeholder="<?php _e( 'Search books, articles, or archives...', 'city-library' ); ?>" type="text"/>
<div class="flex h-full items-center pr-2">
<div class="hidden sm:flex items-center border-l border-gray-200 px-4">
<select class="border-0 bg-transparent py-0 pl-0 pr-8 text-sm font-medium text-gray-600 focus:ring-0 cursor-pointer">
<option><?php _e( 'All Types', 'city-library' ); ?></option>
<option><?php _e( 'Books', 'city-library' ); ?></option>
<option><?php _e( 'Articles', 'city-library' ); ?></option>
<option><?php _e( 'Archives', 'city-library' ); ?></option>
</select>
</div>
<button class="flex h-10 min-w-[100px] items-center justify-center rounded-lg bg-primary px-6 text-sm font-bold text-white transition-colors hover:bg-blue-700 sm:h-12 sm:text-base">
    <?php _e( 'Search', 'city-library' ); ?>
</button>
</div>
</div>
</div>
<!-- Quick Stats/Info (Optional visual flair) -->
<div class="mt-12 flex flex-wrap justify-center gap-8 text-white/80">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-gold-accent">auto_stories</span>
        <span class="text-sm font-medium"><?php _e( '1M+ Books', 'city-library' ); ?></span>
    </div>
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-gold-accent">devices</span>
        <span class="text-sm font-medium"><?php _e( 'Digital Access', 'city-library' ); ?></span>
    </div>
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-gold-accent">group</span>
        <span class="text-sm font-medium"><?php _e( 'Community Hub', 'city-library' ); ?></span>
    </div>
</div>
</div>
</div>
