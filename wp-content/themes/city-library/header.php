<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#0b7930",
                        secondary: "#1A3C34",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216"
                    },
                    fontFamily: {
                        display: "Inter",
                        sans: ["Montserrat", "sans-serif"]
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    }
                }
            }
        };
    </script>
    <style>
        /* This dynamic style is placed here because it relies on PHP to get the customizer setting. */
        .hero-gradient {
            background: linear-gradient(rgba(26, 60, 52, 0.7), rgba(26, 60, 52, 0.85)), url('<?php echo esc_url(get_theme_mod('hero_background_image', 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000&auto=format&fit=crop')); ?>');
            background-size: cover;
            background-position: center;
        }
        .text-glow {
            text-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
        }
    </style>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'font-sans antialiased bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 transition-colors duration-300' ); ?>>
<header class="site-header fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-secondary rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-white">menu_book</span>
                </div>
                <div class="hidden md:block">
                    <p class="text-xs font-bold uppercase tracking-widest text-secondary dark:text-primary"><?php echo esc_html__( 'Центральная городская', 'city-library' ); ?></p>
                    <p class="text-sm font-display font-bold"><?php bloginfo( 'name' ); ?></p>
                </div>
            </a>

            <nav class="main-navigation hidden lg:flex items-center space-x-8" aria-label="<?php esc_attr_e( 'Главное меню', 'city-library' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '<div class="flex space-x-8">%3$s</div>',
                    'fallback_cb'    => false,
                    // Note: A custom walker would be needed to apply the specific Tailwind classes to each `<a>` tag.
                    // This will be addressed in a future step if required.
                ) );
                ?>
            </nav>

            <div class="flex items-center space-x-4">
                <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                    <span class="material-symbols-outlined">search</span>
                </button>
                <button id="accessibility-toggle" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
                    <span class="material-symbols-outlined">visibility</span>
                </button>
                <div class="h-6 w-px bg-slate-200 dark:bg-slate-700 mx-2"></div>
                <button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors" onclick="document.documentElement.classList.toggle('dark')">
                    <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined hidden dark:block">light_mode</span>
                </button>
            </div>
        </div>
    </div>
</header>
<main>
