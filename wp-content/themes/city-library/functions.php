<?php

// --- Enqueue Scripts and Styles ---
function city_library_scripts() {
    // Google Fonts
    wp_enqueue_style( 'google-fonts-preconnect', 'https://fonts.googleapis.com', array(), null );
    wp_enqueue_style( 'google-fonts-gstatic', 'https://fonts.gstatic.com', array(), null );
    wp_enqueue_style( 'google-fonts-lexend', 'https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;700;900&display=swap', array(), null );

    // Material Symbols
    wp_enqueue_style( 'material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap', array(), null );

    // Tailwind CSS from CDN
    wp_enqueue_script( 'tailwindcss', 'https://cdn.tailwindcss.com?plugins=forms,container-queries', array(), null, false );

    // Main Theme Stylesheet
    wp_enqueue_style( 'city-library-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'city_library_scripts' );


// --- Theme Setup ---
function city_library_setup() {
    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Custom Logo.
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
}
add_action( 'after_setup_theme', 'city_library_setup' );

// --- Tailwind Config ---
function add_tailwind_config() {
    echo '<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#135bec",
              "background-light": "#f6f6f8",
              "background-dark": "#101622",
              "navy-deep": "#0d121b", // Deep navy for text/dark backgrounds
              "gold-accent": "#E6B800", // Gold accent for details
            },
            fontFamily: {
              "display": ["Lexend", "sans-serif"]
            },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
            backgroundImage: {
              \'hero-pattern\': "linear-gradient(rgba(13, 18, 27, 0.7), rgba(13, 18, 27, 0.5)), url(\'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=2070&auto=format&fit=crop\')",
            }
          },
        },
      }
    </script>';
}
add_action('wp_head', 'add_tailwind_config', 1);

// --- Register Nav Menus ---
function register_my_menus() {
  register_nav_menus(
    array(
      'primary-menu' => __( 'Primary Menu' ),
     )
   );
 }
 add_action( 'init', 'register_my_menus' );

// --- Custom Nav Walker ---
class City_Library_Nav_Walker extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $output .= "<li>";
        $output .= '<a class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors" href="' . $item->url . '">';
        $output .= $item->title;
        $output .= '</a>';
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>";
    }
}

// --- Customizer Settings ---
function city_library_customize_register( $wp_customize ) {
    // --- Hero Section ---
    $wp_customize->add_section( 'hero_section', array(
        'title'      => __( 'Hero Section', 'city-library' ),
        'priority'   => 30,
    ) );

    // Hero Background Image
    $wp_customize->add_setting( 'hero_background_image', array(
        'default'   => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=2070&auto=format&fit=crop',
        'transport' => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_background_image', array(
        'label'      => __( 'Background Image', 'city-library' ),
        'section'    => 'hero_section',
        'settings'   => 'hero_background_image',
    ) ) );

    // Hero Title
    $wp_customize->add_setting( 'hero_title', array(
        'default'   => __( 'Discover Knowledge <br class="hidden sm:block"/> without Limits', 'city-library' ),
        'transport' => 'refresh',
    ) );

    $wp_customize->add_control( 'hero_title', array(
        'label'      => __( 'Title', 'city-library' ),
        'section'    => 'hero_section',
        'settings'   => 'hero_title',
        'type'       => 'textarea',
    ) );

    // Hero Subtitle
    $wp_customize->add_setting( 'hero_subtitle', array(
        'default'   => __( 'Explore our vast collection of books, digital archives, and community events in a space designed for modern learning.', 'city-library' ),
        'transport' => 'refresh',
    ) );

    $wp_customize->add_control( 'hero_subtitle', array(
        'label'      => __( 'Subtitle', 'city-library' ),
        'section'    => 'hero_section',
        'settings'   => 'hero_subtitle',
        'type'       => 'textarea',
    ) );
}
add_action( 'customize_register', 'city_library_customize_register' );

// --- Text Domain ---
function city_library_load_textdomain() {
    load_theme_textdomain( 'city-library', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'city_library_load_textdomain' );
