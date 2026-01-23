<?php

if ( ! function_exists( 'city_library_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function city_library_setup() {
        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => __( 'Главное меню', 'city-library' ),
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'city_library_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );

        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );
    }
endif;
add_action( 'after_setup_theme', 'city_library_setup' );


/**
 * Enqueue scripts and styles.
 */
function city_library_scripts() {
    // Enqueue Google Fonts: Inter and Montserrat
    wp_enqueue_style( 'city-library-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300..700&family=Montserrat:wght@400;700&display=swap', array(), null );

    // Enqueue theme stylesheet.
    wp_enqueue_style( 'city-library-style', get_stylesheet_uri(), array(), '1.0' );

    // Enqueue Tailwind CSS script from CDN to be loaded in the header.
    wp_enqueue_script( 'tailwind-cdn', 'https://cdn.tailwindcss.com?plugins=forms,typography', array(), null, false );
}
add_action( 'wp_enqueue_scripts', 'city_library_scripts' );


/**
 * Customizer additions.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function city_library_customize_register( $wp_customize ) {
    // Add Hero Section
    $wp_customize->add_section( 'city_library_hero_section', array(
        'title'      => __( 'Секция Hero', 'city-library' ),
        'priority'   => 30,
        'description' => __( 'Настройки для главной секции на главной странице.', 'city-library' ),
    ) );

    // Hero Badge Text Setting
    $wp_customize->add_setting( 'hero_badge_text', array(
        'default'           => __( 'Добро пожаловать в мир знаний', 'city-library' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'hero_badge_text', array(
        'label'    => __( 'Текст значка', 'city-library' ),
        'section'  => 'city_library_hero_section',
        'type'     => 'text',
    ) );

    // Hero Title Setting
    $wp_customize->add_setting( 'hero_title', array(
        'default'           => __( 'Твой мир, <span class="text-primary italic text-glow">Твоя</span> <br>библиотека', 'city-library' ),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'hero_title', array(
        'label'    => __( 'Главный заголовок', 'city-library' ),
        'description' => __( 'Можно использовать HTML теги, например, &lt;span&gt; или &lt;br&gt;.', 'city-library' ),
        'section'  => 'city_library_hero_section',
        'type'     => 'textarea',
    ) );

    // Hero Description Setting
    $wp_customize->add_setting( 'hero_description', array(
        'default'           => __( 'Центральная городская библиотека — пространство для открытий, творчества и вдохновения. Мы объединяем традиции и современные технологии.', 'city-library' ),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'hero_description', array(
        'label'    => __( 'Описание', 'city-library' ),
        'section'  => 'city_library_hero_section',
        'type'     => 'textarea',
    ) );

    // Hero Background Image Setting
    $wp_customize->add_setting( 'hero_background_image', array(
        'default'           => 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000&auto=format&fit=crop',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_background_image', array(
        'label'    => __( 'Фоновое изображение', 'city-library' ),
        'section'  => 'city_library_hero_section',
        'settings' => 'hero_background_image',
    ) ) );
}
add_action( 'customize_register', 'city_library_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function city_library_customize_preview_js() {
    wp_enqueue_script( 'city-library-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'city_library_customize_preview_js' );
