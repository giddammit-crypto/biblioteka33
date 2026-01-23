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

    // Enqueue Accessibility script
    wp_enqueue_script( 'city-library-accessibility', get_template_directory_uri() . '/js/accessibility.js', array(), '1.0', true );

    // Enqueue View Toggle script
    wp_enqueue_script( 'city-library-view-toggle', get_template_directory_uri() . '/js/view-toggle.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'city_library_scripts' );


/**
 * Customizer additions.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function city_library_customize_register( $wp_customize ) {
    // Add Header Section
    $wp_customize->add_section( 'city_library_header_section', array(
        'title'      => __( 'Настройки хедера', 'city-library' ),
        'priority'   => 25,
        'description' => __( 'Настройки для хедера сайта.', 'city-library' ),
    ) );

    // Header Background Color
    $wp_customize->add_setting( 'header_background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_background_color', array(
        'label'    => __( 'Цвет фона хедера', 'city-library' ),
        'section'  => 'city_library_header_section',
    ) ) );

    // Header Text Color
    $wp_customize->add_setting( 'header_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_text_color', array(
        'label'    => __( 'Цвет текста хедера', 'city-library' ),
        'section'  => 'city_library_header_section',
    ) ) );

    // Header Link Color
    $wp_customize->add_setting( 'header_link_color', array(
        'default'           => '#0b7930',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_link_color', array(
        'label'    => __( 'Цвет ссылок в хедере', 'city-library' ),
        'section'  => 'city_library_header_section',
    ) ) );

    // Accessibility Section
    $wp_customize->add_section( 'city_library_accessibility_section', array(
        'title'      => __( 'Версия для слабовидящих', 'city-library' ),
        'priority'   => 35,
        'description' => __( 'Настройки для версии сайта для слабовидящих.', 'city-library' ),
    ) );

    // Accessibility Background Color
    $wp_customize->add_setting( 'accessibility_background_color', array(
        'default'           => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accessibility_background_color', array(
        'label'    => __( 'Цвет фона для слабовидящих', 'city-library' ),
        'section'  => 'city_library_accessibility_section',
    ) ) );

    // Accessibility Text Color
    $wp_customize->add_setting( 'accessibility_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accessibility_text_color', array(
        'label'    => __( 'Цвет текста для слабовидящих', 'city-library' ),
        'section'  => 'city_library_accessibility_section',
    ) ) );

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

    // --- Primary Button Settings ---

    // Show Primary Button
    $wp_customize->add_setting( 'hero_primary_button_show', array( 'default' => true, 'sanitize_callback' => 'wp_validate_boolean' ) );
    $wp_customize->add_control( 'hero_primary_button_show', array( 'label' => __( 'Показывать главную кнопку', 'city-library' ), 'section' => 'city_library_hero_section', 'type' => 'checkbox' ) );

    // Primary Button Text
    $wp_customize->add_setting( 'hero_primary_button_text', array( 'default' => __( 'АФИША МЕРОПРИЯТИЙ', 'city-library' ), 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'hero_primary_button_text', array( 'label' => __( 'Текст главной кнопки', 'city-library' ), 'section' => 'city_library_hero_section', 'type' => 'text' ) );

    // Primary Button URL
    $wp_customize->add_setting( 'hero_primary_button_url', array( 'default' => '#events', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'hero_primary_button_url', array( 'label' => __( 'Ссылка главной кнопки', 'city-library' ), 'section' => 'city_library_hero_section', 'type' => 'url' ) );

    // Primary Button Background Color
    $wp_customize->add_setting( 'hero_primary_button_bg_color', array( 'default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hero_primary_button_bg_color', array( 'label' => __( 'Цвет фона главной кнопки', 'city-library' ), 'section' => 'city_library_hero_section' ) ) );

    // Primary Button Text Color
    $wp_customize->add_setting( 'hero_primary_button_text_color', array( 'default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hero_primary_button_text_color', array( 'label' => __( 'Цвет текста главной кнопки', 'city-library' ), 'section' => 'city_library_hero_section' ) ) );

    // --- Secondary Button Settings ---

    // Show Secondary Button
    $wp_customize->add_setting( 'hero_secondary_button_show', array( 'default' => true, 'sanitize_callback' => 'wp_validate_boolean' ) );
    $wp_customize->add_control( 'hero_secondary_button_show', array( 'label' => __( 'Показывать вторую кнопку', 'city-library' ), 'section' => 'city_library_hero_section', 'type' => 'checkbox' ) );

    // Secondary Button Text
    $wp_customize->add_setting( 'hero_secondary_button_text', array( 'default' => __( 'УЗНАТЬ БОЛЬШЕ', 'city-library' ), 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'hero_secondary_button_text', array( 'label' => __( 'Текст второй кнопки', 'city-library' ), 'section' => 'city_library_hero_section', 'type' => 'text' ) );

    // Secondary Button URL
    $wp_customize->add_setting( 'hero_secondary_button_url', array( 'default' => '#about', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'hero_secondary_button_url', array( 'label' => __( 'Ссылка второй кнопки', 'city-library' ), 'section' => 'city_library_hero_section', 'type' => 'url' ) );

    // Secondary Button Background Color
    $wp_customize->add_setting( 'hero_secondary_button_bg_color', array( 'default' => 'rgba(255, 255, 255, 0.1)', 'sanitize_callback' => 'sanitize_text_field' ) ); // Using sanitize_text_field for rgba
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hero_secondary_button_bg_color', array( 'label' => __( 'Цвет фона второй кнопки', 'city-library' ), 'section' => 'city_library_hero_section' ) ) );

    // Secondary Button Text Color
    $wp_customize->add_setting( 'hero_secondary_button_text_color', array( 'default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hero_secondary_button_text_color', array( 'label' => __( 'Цвет текста второй кнопки', 'city-library' ), 'section' => 'city_library_hero_section' ) ) );

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

    // F O O T E R   S E C T I O N
    // =========================================================================
    $wp_customize->add_section( 'city_library_footer_section', array(
        'title'    => __( 'Настройки подвала', 'city-library' ),
        'priority' => 140,
    ) );

    // Address
    $wp_customize->add_setting( 'footer_address', array(
        'default'           => __( 'ул. Центральная, д. 42<br>г. Владимир, 600000', 'city-library' ),
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'footer_address', array(
        'label'   => __( 'Адрес', 'city-library' ),
        'section' => 'city_library_footer_section',
        'type'    => 'textarea',
    ) );

    // Phone
    $wp_customize->add_setting( 'footer_phone', array(
        'default'           => '+7 (4922) 32-00-00',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_phone', array(
        'label'   => __( 'Телефон', 'city-library' ),
        'section' => 'city_library_footer_section',
        'type'    => 'text',
    ) );

    // Work Hours Mon-Fri
    $wp_customize->add_setting( 'footer_work_hours_weekdays', array(
        'default'           => '10:00 – 20:00',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_work_hours_weekdays', array(
        'label'   => __( 'Режим работы (Пн-Пт)', 'city-library' ),
        'section' => 'city_library_footer_section',
        'type'    => 'text',
    ) );

    // Work Hours Sat
    $wp_customize->add_setting( 'footer_work_hours_saturday', array(
        'default'           => '10:00 – 18:00',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_work_hours_saturday', array(
        'label'   => __( 'Режим работы (Сб)', 'city-library' ),
        'section' => 'city_library_footer_section',
        'type'    => 'text',
    ) );

    // Work Hours Sun
    $wp_customize->add_setting( 'footer_work_hours_sunday', array(
        'default'           => __( 'Выходной', 'city-library' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_work_hours_sunday', array(
        'label'   => __( 'Режим работы (Вс)', 'city-library' ),
        'section' => 'city_library_footer_section',
        'type'    => 'text',
    ) );

    // Copyright Text
    $wp_customize->add_setting( 'footer_copyright_text', array(
        'default'           => sprintf( '© %s %s. %s', date('Y'), get_bloginfo('name'), __( 'Все права защищены.', 'city-library' ) ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_copyright_text', array(
        'label'   => __( 'Текст копирайта', 'city-library' ),
        'section' => 'city_library_footer_section',
        'type'    => 'text',
    ) );

    // Privacy Policy URL
    $wp_customize->add_setting( 'footer_privacy_policy_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'footer_privacy_policy_url', array(
        'label'   => __( 'URL страницы Политики конфиденциальности', 'city-library' ),
        'section' => 'city_library_footer_section',
        'type'    => 'url',
    ) );

    // Sitemap URL
    $wp_customize->add_setting( 'footer_sitemap_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'footer_sitemap_url', array(
        'label'   => __( 'URL карты сайта', 'city-library' ),
        'section' => 'city_library_footer_section',
        'type'    => 'url',
    ) );

    // Subscription Form Placeholder
    $wp_customize->add_setting( 'footer_subscription_placeholder', array(
        'default'           => __( 'Email', 'city-library' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'footer_subscription_placeholder', array(
        'label'   => __( 'Текст-заполнитель для формы подписки', 'city-library' ),
        'section' => 'city_library_footer_section',
        'type'    => 'text',
    ) );

    // P A R T N E R S   S E C T I O N
    // =========================================================================
    $wp_customize->add_section( 'city_library_partners_section', array(
        'title'    => __( 'Наши партнёры', 'city-library' ),
        'priority' => 150,
    ) );

    // Show Partners Section
    $wp_customize->add_setting( 'partners_section_show', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'partners_section_show', array(
        'label'   => __( 'Показывать секцию "Наши партнёры"', 'city-library' ),
        'section' => 'city_library_partners_section',
        'type'    => 'checkbox',
    ) );

    // Loop to create settings for 8 partners
    for ( $i = 1; $i <= 8; $i++ ) {
        // Partner Logo
        $wp_customize->add_setting( "partner_logo_$i", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "partner_logo_$i", array(
            'label'    => sprintf( __( 'Логотип партнёра %d', 'city-library' ), $i ),
            'section'  => 'city_library_partners_section',
            'settings' => "partner_logo_$i",
        ) ) );

        // Partner Link
        $wp_customize->add_setting( "partner_link_$i", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( "partner_link_$i", array(
            'label'   => sprintf( __( 'Ссылка партнёра %d', 'city-library' ), $i ),
            'section' => 'city_library_partners_section',
            'type'    => 'url',
        ) );
    }
}
add_action( 'customize_register', 'city_library_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function city_library_customize_preview_js() {
    wp_enqueue_script( 'city-library-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'city_library_customize_preview_js' );

/**
 * Generate dynamic CSS for customizer options.
 */
function city_library_dynamic_styles() {
    ?>
    <style type="text/css">
        :root {
            --header-bg-color: <?php echo sanitize_hex_color( get_theme_mod( 'header_background_color', '#ffffff' ) ); ?>;
            --header-text-color: <?php echo sanitize_hex_color( get_theme_mod( 'header_text_color', '#333333' ) ); ?>;
            --header-link-color: <?php echo sanitize_hex_color( get_theme_mod( 'header_link_color', '#0b7930' ) ); ?>;
        }

        .site-header {
            background-color: rgba(255, 255, 255, 0.8); /* Fallback */
            background-color: var(--header-bg-color) !important;
        }

        .site-header .main-navigation a,
        .site-header .text-sm.font-display.font-bold {
            color: var(--header-text-color) !important;
        }

        .site-header .main-navigation a:hover {
            color: var(--header-link-color) !important;
        }

        /* Accessibility Mode Styles */
        .accessibility-mode {
            --accessibility-bg-color: <?php echo sanitize_hex_color( get_theme_mod( 'accessibility_background_color', '#000000' ) ); ?>;
            --accessibility-text-color: <?php echo sanitize_hex_color( get_theme_mod( 'accessibility_text_color', '#ffffff' ) ); ?>;
        }

        .accessibility-mode body,
        .accessibility-mode .site-header {
            background-color: var(--accessibility-bg-color) !important;
            color: var(--accessibility-text-color) !important;
            font-size: 1.25rem; /* Increased font size */
        }

        .accessibility-mode a,
        .accessibility-mode h1,
        .accessibility-mode h2,
        .accessibility-mode h3,
        .accessibility-mode button,
        .accessibility-mode p,
        .accessibility-mode span,
        .accessibility-mode div {
             color: var(--accessibility-text-color) !important;
        }

        /* Hero Button Colors */
        #hero-primary-button {
            background-color: <?php echo sanitize_hex_color( get_theme_mod( 'hero_primary_button_bg_color', '#0b7930' ) ); ?> !important;
            color: <?php echo sanitize_hex_color( get_theme_mod( 'hero_primary_button_text_color', '#ffffff' ) ); ?> !important;
        }
        #hero-secondary-button {
            background-color: <?php echo sanitize_text_field( get_theme_mod( 'hero_secondary_button_bg_color', 'rgba(255, 255, 255, 0.1)' ) ); ?> !important;
            color: <?php echo sanitize_hex_color( get_theme_mod( 'hero_secondary_button_text_color', '#ffffff' ) ); ?> !important;
        }

    </style>
    <?php
}
add_action( 'wp_head', 'city_library_dynamic_styles' );

/**
 * Adds custom CSS for the view switcher.
 */
function city_library_view_switcher_styles() {
    ?>
    <style type="text/css">
        /* Initial state is grid, which is handled by Tailwind classes */
        #posts-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }

        /* List View styles */
        #posts-container.list-view {
            display: block; /* Override grid display */
        }

        #posts-container.list-view > div {
           display: flex;
           flex-direction: row;
           align-items: center;
           margin-bottom: 2rem; /* Add space between list items */
           background-color: #fff; /* Ensure background color */
           border-radius: 0.75rem; /* rounded-xl */
           overflow: hidden;
        }

        #posts-container.list-view .aspect-\[16\/10\] {
            flex-shrink: 0;
            width: 300px; /* Fixed width for the image container */
            height: 180px; /* Fixed height */
        }

        #posts-container.list-view .p-8 {
            padding: 1.5rem; /* Adjust padding for list view */
        }

        .dark #posts-container.list-view > div {
            background-color: #1e293b; /* Corresponds to dark:bg-slate-800 */
        }

        /* Button Active State */
        #grid-view-button.active, #list-view-button.active {
            background-color: #fff;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        }

        .dark #grid-view-button.active, .dark #list-view-button.active {
             background-color: #334155; /* Corresponds to dark:bg-slate-700 */
        }
    </style>
    <?php
}
add_action( 'wp_head', 'city_library_view_switcher_styles' );

/**
 * Custom Walker class for styling the primary navigation menu.
 */
class City_Library_Nav_Walker extends Walker_Nav_Menu {
    /**
     * Starts the element output.
     *
     * @param string   $output            Used to append additional content (passed by reference).
     * @param WP_Post  $item              Menu item data object.
     * @param int      $depth             Depth of menu item. Used for padding.
     * @param stdClass $args              An object of wp_nav_menu() arguments.
     * @param int      $id                Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = 'text-sm font-semibold hover:text-primary transition-colors';
        $output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $classes ) . '">';
        $output .= esc_html( $item->title );
        $output .= '</a>';
    }

    /**
     * Ends the element output, if needed.
     * We don't need to do anything here, but the method is required.
     */
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        // We close the `<a>` tag in start_el, so nothing is needed here.
    }

     /**
     * Starts the list before the elements are added.
     * We override this to prevent WordPress from adding a `<ul>` wrapper.
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        // Do nothing.
    }

    /**
     * Ends the list of after the elements are added.
     * We override this to prevent WordPress from adding a `</ul>` wrapper.
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        // Do nothing.
    }
}
