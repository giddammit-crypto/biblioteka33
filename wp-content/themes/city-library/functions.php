<?php
/**
 * Theme setup.
 */
function city_library_setup() {
    // Make theme available for translation.
    load_theme_textdomain('city-library', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Enable support for Custom Logo.
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Register navigation menus.
    register_nav_menus(
        array(
            'primary' => esc_html__('Primary Menu', 'city-library'),
        )
    );

    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');
}
add_action('after_setup_theme', 'city_library_setup');


/**
 * Enqueue scripts and styles.
 */
function city_library_scripts() {
    // Main stylesheet.
    wp_enqueue_style('city-library-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

    // Google Fonts
    wp_enqueue_style('city-library-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Merriweather:wght@300;400;700&display=swap', array(), null);

    // Material Symbols
    wp_enqueue_style('material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0', array(), null);

    // Tailwind CSS
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com?plugins=forms,typography', array(), null, false);

    // Swiper CSS & JS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);

    // GLightbox CSS & JS
    wp_enqueue_style('glightbox-css', 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css', array(), '3.3.0');
    wp_enqueue_script('glightbox-js', 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js', array(), '3.3.0', true);

    // Custom JS files
    wp_enqueue_script('city-library-dark-mode', get_template_directory_uri() . '/js/dark-mode.js', array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-view-toggle', get_template_directory_uri() . '/js/view-toggle.js', array('jquery'), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-back-to-top', get_template_directory_uri() . '/js/back-to-top.js', array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-accessibility', get_template_directory_uri() . '/js/accessibility.js', array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-modal-popup', get_template_directory_uri() . '/js/modal-popup.js', array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-sidebar-toggle', get_template_directory_uri() . '/js/sidebar-toggle.js', array(), wp_get_theme()->get('Version'), true);

    wp_localize_script('city-library-view-toggle', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'city_library_scripts');

/**
 * Disable comments globally.
 */
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('wp_before_admin_bar_render', function () {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
});

/**
 * Modify main query for homepage to show 8 posts.
 */
function city_library_homepage_query($query) {
    if ($query->is_home() && $query->is_main_query()) {
        $query->set('posts_per_page', 10);
    }
}
add_action('pre_get_posts', 'city_library_homepage_query');

/**
 * Register widget areas.
 */
function city_library_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__('Main Sidebar', 'city-library'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'city-library'),
            'before_widget' => '<section id="%1$s" class="widget %2$s bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title text-xl font-bold font-display mb-4">',
            'after_title'   => '</h2>',
        )
    );

    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(esc_html__('Footer %d', 'city-library'), $i),
            'id'            => 'footer-' . $i,
            'description'   => esc_html__('Add widgets here to appear in your footer.', 'city-library'),
            'before_widget' => '<div id="%1$s" class="widget %2$s space-y-4">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="font-bold mb-6 text-primary uppercase text-xs tracking-widest">',
            'after_title'   => '</h4>',
        ));
    }
}
add_action('widgets_init', 'city_library_widgets_init');


/**
 * Customizer additions.
 */
function city_library_customize_register($wp_customize) {
    // Header Section
    $wp_customize->add_section('header_section', array(
        'title'    => __('Настройки шапки (Header)', 'city-library'),
        'priority' => 20,
    ));

    $wp_customize->add_setting('header_bg_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_bg_color', array(
        'label' => __('Цвет фона шапки', 'city-library'), 'section' => 'header_section',
    )));

    $wp_customize->add_setting('header_text_color', array('default' => '#1A3C34', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_text_color', array(
        'label' => __('Цвет текста шапки', 'city-library'), 'section' => 'header_section',
    )));

     $wp_customize->add_setting('header_font_family', array('default' => 'Inter', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('header_font_family', array(
        'label' => __('Шрифт шапки', 'city-library'),
        'section' => 'header_section',
        'type' => 'select',
        'choices' => array(
            'Inter' => 'Inter',
            'Montserrat' => 'Montserrat',
            'Playfair Display' => 'Playfair Display',
            'Merriweather' => 'Merriweather',
        ),
    ));

    // Header Content Settings (Title/Subtitle)
    $wp_customize->add_setting('header_subtitle', array('default' => 'Центральная городская', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('header_subtitle', array('label' => __('Подзаголовок (верхняя строка)', 'city-library'), 'section' => 'header_section', 'type' => 'text'));

    $wp_customize->add_setting('header_title', array('default' => 'Библиотека', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('header_title', array('label' => __('Название сайта (нижняя строка)', 'city-library'), 'section' => 'header_section', 'type' => 'text'));

    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Hero Section', 'city-library'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('show_hero_section', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('show_hero_section', array(
        'label' => __('Show Hero Section', 'city-library'),
        'section' => 'hero_section',
        'type' => 'checkbox',
    ));

    // ... other settings
    $wp_customize->add_setting('hero_badge_text', array('default' => 'Добро пожаловать в мир знаний', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('hero_badge_text', array('label' => __('Badge Text', 'city-library'), 'section' => 'hero_section', 'type' => 'text'));

    $wp_customize->add_setting('hero_title', array('default' => 'Твой мир, <span class="text-primary italic text-glow">Твоя</span> <br/>библиотека', 'sanitize_callback' => 'wp_kses_post'));
    $wp_customize->add_control('hero_title', array('label' => __('Title', 'city-library'), 'section' => 'hero_section', 'type' => 'textarea'));

    $wp_customize->add_setting('hero_subtitle', array('default' => 'Центральная городская библиотека — пространство для открытий...', 'sanitize_callback' => 'sanitize_textarea_field'));
    $wp_customize->add_control('hero_subtitle', array('label' => __('Subtitle', 'city-library'), 'section' => 'hero_section', 'type' => 'textarea'));

    $wp_customize->add_setting('hero_primary_button_text', array('default' => 'АФИША МЕРОПРИЯТИЙ', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('hero_primary_button_text', array('label' => __('Primary Button Text', 'city-library'), 'section' => 'hero_section', 'type' => 'text'));

    $wp_customize->add_setting('hero_primary_button_link', array('default' => '#events', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('hero_primary_button_link', array('label' => __('Primary Button Link', 'city-library'), 'section' => 'hero_section', 'type' => 'url'));

    $wp_customize->add_setting('hero_secondary_button_text', array('default' => 'УЗНАТЬ БОЛЬШЕ', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('hero_secondary_button_text', array('label' => __('Secondary Button Text', 'city-library'), 'section' => 'hero_section', 'type' => 'text'));

    $wp_customize->add_setting('hero_secondary_button_link', array('default' => '#about', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('hero_secondary_button_link', array('label' => __('Secondary Button Link', 'city-library'), 'section' => 'hero_section', 'type' => 'url'));

    $wp_customize->add_setting('hero_background_image', array('default' => get_template_directory_uri() . '/images/hero-bg.jpg', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label' => __('Background Image', 'city-library'),
        'section' => 'hero_section',
    )));

    // Footer Section
    $wp_customize->add_section('footer_section', array('title' => __('Footer', 'city-library'), 'priority' => 120));

    $wp_customize->add_setting('footer_copyright', array('default' => '© 2024 Центральная городская библиотека. Все права защищены.', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('footer_copyright', array('label' => __('Copyright Text', 'city-library'), 'section' => 'footer_section', 'type' => 'text'));

    $wp_customize->add_setting('footer_privacy_link', array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('footer_privacy_link', array('label' => __('Privacy Policy Link', 'city-library'), 'section' => 'footer_section', 'type' => 'url'));

    $wp_customize->add_setting('footer_sitemap_link', array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('footer_sitemap_link', array('label' => __('Sitemap Link', 'city-library'), 'section' => 'footer_section', 'type' => 'url'));

    $wp_customize->add_setting('footer_bg_color', array('default' => '#1A3C34', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_bg_color', array(
        'label' => __('Footer Background Color', 'city-library'), 'section' => 'footer_section',
    )));
    $wp_customize->add_setting('footer_text_color', array('default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_text_color', array(
        'label' => __('Footer Text Color', 'city-library'), 'section' => 'footer_section',
    )));

    // Hero Button Colors
    $wp_customize->add_setting('hero_primary_btn_bg_color', array('default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hero_primary_btn_bg_color', array(
        'label' => __('Primary Button BG', 'city-library'), 'section' => 'hero_section',
    )));
    $wp_customize->add_setting('hero_primary_btn_text_color', array('default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hero_primary_btn_text_color', array(
        'label' => __('Primary Button Text', 'city-library'), 'section' => 'hero_section',
    )));
    $wp_customize->add_setting('hero_primary_btn_hover_bg_color', array('default' => '#d4af37', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hero_primary_btn_hover_bg_color', array(
        'label' => __('Primary Button Hover BG', 'city-library'), 'section' => 'hero_section',
    )));

    $wp_customize->add_setting('hero_secondary_btn_bg_color', array('default' => 'rgba(255, 255, 255, 0.1)', 'sanitize_callback' => 'sanitize_text_field')); // RGBA support
    $wp_customize->add_control('hero_secondary_btn_bg_color', array(
        'label' => __('Secondary Button BG', 'city-library'), 'section' => 'hero_section', 'type' => 'text',
    ));
     $wp_customize->add_setting('hero_secondary_btn_text_color', array('default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hero_secondary_btn_text_color', array(
        'label' => __('Secondary Button Text', 'city-library'), 'section' => 'hero_section',
    )));
    $wp_customize->add_setting('hero_secondary_btn_hover_bg_color', array('default' => 'rgba(255, 255, 255, 0.2)', 'sanitize_callback' => 'sanitize_text_field')); // RGBA support
    $wp_customize->add_control('hero_secondary_btn_hover_bg_color', array(
        'label' => __('Secondary Button Hover BG', 'city-library'), 'section' => 'hero_section', 'type' => 'text',
    ));


    // Partners Section
    $wp_customize->add_section('partners_section', array(
        'title'    => __('Our Partners', 'city-library'),
        'priority' => 110,
    ));

    $wp_customize->add_setting('show_partners_section', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('show_partners_section', array(
        'label' => __('Show Partners Section', 'city-library'),
        'section' => 'partners_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('partners_title', array('default' => 'Наши партнеры', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('partners_title', array('label' => __('Title', 'city-library'), 'section' => 'partners_section', 'type' => 'text'));

    $wp_customize->add_setting('partners_subtitle', array('default' => 'Мы гордимся сотрудничеством с ведущими организациями', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('partners_subtitle', array('label' => __('Subtitle', 'city-library'), 'section' => 'partners_section', 'type' => 'text'));

    for ($i = 1; $i <= 8; $i++) {
        $wp_customize->add_setting("partner_logo_$i", array('sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "partner_logo_$i", array(
            'label' => sprintf(__('Partner Logo %d', 'city-library'), $i),
            'section' => 'partners_section',
        )));
        $wp_customize->add_setting("partner_link_$i", array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("partner_link_$i", array('label' => sprintf(__('Partner Link %d', 'city-library'), $i), 'section' => 'partners_section', 'type' => 'url'));
    }

    // News Card Section
    $wp_customize->add_section('news_card_section', array(
        'title' => __('News Card Styles', 'city-library'),
        'priority' => 100,
    ));

    $wp_customize->add_setting('news_card_grid_bg_color', array('default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'news_card_grid_bg_color', array(
        'label' => __('Grid: Card Background', 'city-library'), 'section' => 'news_card_section',
    )));
    $wp_customize->add_setting('news_card_grid_title_color', array('default' => '#1A3C34', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'news_card_grid_title_color', array(
        'label' => __('Grid: Title Color', 'city-library'), 'section' => 'news_card_section',
    )));
    $wp_customize->add_setting('news_card_grid_text_color', array('default' => '#334155', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'news_card_grid_text_color', array(
        'label' => __('Grid: Text Color', 'city-library'), 'section' => 'news_card_section',
    )));
    $wp_customize->add_setting('news_card_grid_link_color', array('default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'news_card_grid_link_color', array(
        'label' => __('Grid: Link Color', 'city-library'), 'section' => 'news_card_section',
    )));

    $wp_customize->add_setting('news_card_list_bg_color', array('default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'news_card_list_bg_color', array(
        'label' => __('List: Card Background', 'city-library'), 'section' => 'news_card_section',
    )));
    $wp_customize->add_setting('news_card_list_title_color', array('default' => '#1A3C34', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'news_card_list_title_color', array(
        'label' => __('List: Title Color', 'city-library'), 'section' => 'news_card_section',
    )));
    $wp_customize->add_setting('news_card_list_text_color', array('default' => '#334155', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'news_card_list_text_color', array(
        'label' => __('List: Text Color', 'city-library'), 'section' => 'news_card_section',
    )));
    $wp_customize->add_setting('news_card_list_link_color', array('default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'news_card_list_link_color', array(
        'label' => __('List: Link Color', 'city-library'), 'section' => 'news_card_section',
    )));

    // Typography Settings
    $wp_customize->add_section('typography_section', array(
        'title' => __('Typography', 'city-library'),
        'priority' => 20,
    ));
    $wp_customize->add_setting('heading_font', array('default' => 'Inter', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('heading_font', array(
        'label' => __('Heading Font', 'city-library'),
        'section' => 'typography_section',
        'type' => 'select',
        'choices' => array(
            'Inter' => 'Inter (Modern)',
            'Playfair Display' => 'Playfair Display (Journal)',
            'Montserrat' => 'Montserrat (Geometric)',
            'Merriweather' => 'Merriweather (Serif)',
        ),
    ));
    $wp_customize->add_setting('body_font', array('default' => 'Montserrat', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('body_font', array(
        'label' => __('Body Font', 'city-library'),
        'section' => 'typography_section',
        'type' => 'select',
        'choices' => array(
            'Montserrat' => 'Montserrat (Geometric)',
            'Inter' => 'Inter (Modern)',
            'Playfair Display' => 'Playfair Display (Journal)',
            'Merriweather' => 'Merriweather (Serif)',
        ),
    ));

    // Afisha (Events) Section
    $wp_customize->add_section('afisha_section', array(
        'title' => __('Afisha (Events)', 'city-library'),
        'priority' => 105,
    ));
    $wp_customize->add_setting('show_afisha_section', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('show_afisha_section', array(
        'label' => __('Show Afisha Section', 'city-library'),
        'section' => 'afisha_section',
        'type' => 'checkbox',
    ));
    $wp_customize->add_setting('afisha_title', array('default' => 'Афиша Мероприятий', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('afisha_title', array('label' => __('Section Title', 'city-library'), 'section' => 'afisha_section', 'type' => 'text'));

    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting("afisha_image_$i", array('sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "afisha_image_$i", array(
            'label' => sprintf(__('Event Image %d', 'city-library'), $i),
            'section' => 'afisha_section',
        )));
        $wp_customize->add_setting("afisha_title_$i", array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("afisha_title_$i", array('label' => sprintf(__('Event Title %d', 'city-library'), $i), 'section' => 'afisha_section', 'type' => 'text'));

        $wp_customize->add_setting("afisha_link_$i", array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("afisha_link_$i", array('label' => sprintf(__('Event Link %d', 'city-library'), $i), 'section' => 'afisha_section', 'type' => 'url'));
    }

    // Important Section
    $wp_customize->add_section('important_section', array(
        'title' => __('Важная информация (Блок)', 'city-library'),
        'priority' => 106,
    ));

    $wp_customize->add_setting('show_important_section', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('show_important_section', array(
        'label' => __('Показать блок "Важная информация"', 'city-library'),
        'section' => 'important_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('important_title', array('default' => 'Важная информация', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('important_title', array('label' => __('Заголовок', 'city-library'), 'section' => 'important_section', 'type' => 'text'));

    $wp_customize->add_setting('important_text', array('default' => 'Внимание! В связи с санитарным днем библиотека работает по измененному графику.', 'sanitize_callback' => 'wp_kses_post'));
    $wp_customize->add_control('important_text', array('label' => __('Текст', 'city-library'), 'section' => 'important_section', 'type' => 'textarea'));

    $wp_customize->add_setting('important_btn_text', array('default' => 'Подробнее', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('important_btn_text', array('label' => __('Текст кнопки', 'city-library'), 'section' => 'important_section', 'type' => 'text'));

    $wp_customize->add_setting('important_btn_link', array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('important_btn_link', array('label' => __('Ссылка кнопки', 'city-library'), 'section' => 'important_section', 'type' => 'url'));

    $wp_customize->add_setting('important_bg_color', array('default' => '#fef2f2', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'important_bg_color', array(
        'label' => __('Цвет фона', 'city-library'), 'section' => 'important_section',
    )));

    // Modal Popup Section
    $wp_customize->add_section('modal_section', array(
        'title' => __('Модальные окна', 'city-library'),
        'priority' => 120,
    ));

    $wp_customize->add_setting('show_modal', array('default' => false, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('show_modal', array(
        'label' => __('Включить всплывающее окно', 'city-library'),
        'section' => 'modal_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('modal_image', array('sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'modal_image', array(
        'label' => __('Изображение', 'city-library'),
        'section' => 'modal_section',
    )));

    $wp_customize->add_setting('modal_title', array('default' => 'Специальное предложение!', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('modal_title', array('label' => __('Заголовок', 'city-library'), 'section' => 'modal_section', 'type' => 'text'));

    $wp_customize->add_setting('modal_text', array('default' => 'Подпишитесь на нашу рассылку новостей.', 'sanitize_callback' => 'wp_kses_post'));
    $wp_customize->add_control('modal_text', array('label' => __('Текст', 'city-library'), 'section' => 'modal_section', 'type' => 'textarea'));

    $wp_customize->add_setting('modal_delay', array('default' => 3000, 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('modal_delay', array('label' => __('Задержка (мс)', 'city-library'), 'section' => 'modal_section', 'type' => 'number'));
}
add_action('customize_register', 'city_library_customize_register');


/**
 * Custom Walker for Nav Menu to apply Tailwind classes.
 */
class City_Library_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = 'text-sm font-semibold hover:text-primary transition-colors whitespace-nowrap';
        $output .= '<a href="' . esc_url($item->url) . '" class="' . esc_attr($classes) . '">' . esc_html($item->title) . '</a>';
    }
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "";
    }
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= "";
    }
    function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= "";
    }
    function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output) {
        $id_field = $this->db_fields['id'];
        if (is_object($args[0])) {
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);
        }
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}


/**
 * AJAX handler for post view toggle.
 */
function load_posts_by_view() {
    $view = sanitize_text_field($_POST['view']);
    $template_part = ($view === 'list') ? 'template-parts/content-post-card-list' : 'template-parts/content-post-card';

    $query = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 10,
    ));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part($template_part);
        }
    } else {
        echo '<p>' . esc_html__('No posts found.', 'city-library') . '</p>';
    }

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_posts_by_view', 'load_posts_by_view');
add_action('wp_ajax_nopriv_load_posts_by_view', 'load_posts_by_view');

/**
* Add custom script to head to configure TailwindCSS
*/
function city_library_tailwind_config() {
    $heading_font = get_theme_mod('heading_font', 'Inter');
    $body_font = get_theme_mod('body_font', 'Montserrat');
    ?>
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
                        display: "<?php echo esc_js($heading_font); ?>",
                        sans: ["<?php echo esc_js($body_font); ?>", "sans-serif"]
                    },
                }
            }
        }
    </script>
    <?php
}
add_action('wp_head', 'city_library_tailwind_config', 1);

/**
 * Generate custom CSS from Customizer settings.
 */
function city_library_dynamic_styles() {
    ?>
    <style type="text/css">
        /* Header Settings */
        #masthead {
            background-color: <?php echo esc_attr(get_theme_mod('header_bg_color', '#ffffff')); ?> !important;
        }
        #masthead nav a, #masthead .material-symbols-outlined, #masthead p {
            color: <?php echo esc_attr(get_theme_mod('header_text_color', '#1A3C34')); ?> !important;
        }
        #masthead {
             font-family: "<?php echo esc_js(get_theme_mod('header_font_family', 'Inter')); ?>", sans-serif !important;
        }

        /* Hero Primary Button */
        #hero-primary-btn {
            background-color: <?php echo esc_attr(get_theme_mod('hero_primary_btn_bg_color', '#0b7930')); ?> !important;
            color: <?php echo esc_attr(get_theme_mod('hero_primary_btn_text_color', '#FFFFFF')); ?> !important;
        }
        #hero-primary-btn:hover {
            background-color: <?php echo esc_attr(get_theme_mod('hero_primary_btn_hover_bg_color', '#d4af37')); ?> !important;
        }

        /* Hero Secondary Button */
        #hero-secondary-btn {
            background-color: <?php echo esc_attr(get_theme_mod('hero_secondary_btn_bg_color', 'rgba(255, 255, 255, 0.1)')); ?> !important;
            color: <?php echo esc_attr(get_theme_mod('hero_secondary_btn_text_color', '#FFFFFF')); ?> !important;
        }
        #hero-secondary-btn:hover {
            background-color: <?php echo esc_attr(get_theme_mod('hero_secondary_btn_hover_bg_color', 'rgba(255, 255, 255, 0.2)')); ?> !important;
        }
    </style>
    <?php
}
add_action('wp_head', 'city_library_dynamic_styles');
