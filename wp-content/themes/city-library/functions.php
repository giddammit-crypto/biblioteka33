<?php
/**
 * Theme setup.
 */
// Include Branches Map Shortcode
require_once get_template_directory() . '/inc/branches-map.php';

// Include Hero Custom Meta Box
require_once get_template_directory() . '/inc/hero-meta-box.php';

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

    // Add support for editor styles.
    add_theme_support('editor-styles');

    // Enqueue editor styles.
    add_editor_style('css/editor-style.css');
}
add_action('after_setup_theme', 'city_library_setup');

/**
 * Allow extra mime types for upload.
 */
function city_library_add_mime_types($mimes) {
    $mimes['webm'] = 'video/webm';
    $mimes['mp4'] = 'video/mp4';
    return $mimes;
}
add_filter('upload_mimes', 'city_library_add_mime_types');


/**
 * Enqueue scripts and styles.
 */
function city_library_scripts() {
    // Main stylesheet.
    // Use filemtime for version to force cache clear on update
    wp_enqueue_style('city-library-style', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . '/style.css'));

    // Scrollbar Fix
    wp_enqueue_style('city-library-scrollbar-fix', get_template_directory_uri() . '/css/scrollbar-fix.css', array(), wp_get_theme()->get('Version'));

    // Google Fonts (Including Magic Mode fonts)
    wp_enqueue_style('city-library-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Merriweather:wght@300;400;700&family=Cinzel:wght@400;700;900&family=MedievalSharp&family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400&family=Great+Vibes&family=Comforter&family=Marck+Script&display=swap', array(), null);

    // Material Symbols
    wp_enqueue_style('material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0', array(), null);

    // Magic Mode CSS (Removed)
    // wp_enqueue_style('city-library-magic-mode-css', get_template_directory_uri() . '/css/magic-mode.css', array(), wp_get_theme()->get('Version'));

    // Tailwind CSS
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com?plugins=forms,typography', array(), null, false);

    // Swiper CSS & JS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);

    // GLightbox CSS & JS
    wp_enqueue_style('glightbox-css', 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css', array(), '3.3.0');
    wp_enqueue_script('glightbox-js', 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js', array(), '3.3.0', true);
    wp_enqueue_script('city-library-lightbox-init', get_template_directory_uri() . '/js/lightbox-init.js', array('glightbox-js'), wp_get_theme()->get('Version'), true);

    // Custom JS files
    wp_enqueue_script('city-library-view-toggle', get_template_directory_uri() . '/js/view-toggle.js', array('jquery'), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-sidebar', get_template_directory_uri() . '/js/sidebar.js', array(), wp_get_theme()->get('Version'), true);
    // wp_enqueue_script('city-library-back-to-top', get_template_directory_uri() . '/js/back-to-top.js', array(), wp_get_theme()->get('Version'), true); // Removed as per request
    wp_enqueue_script('city-library-accessibility', get_template_directory_uri() . '/js/accessibility.js', array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-modal-popup', get_template_directory_uri() . '/js/modal-popup.js', array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-mobile-menu', get_template_directory_uri() . '/js/mobile-menu.js', array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-mobile-sliders', get_template_directory_uri() . '/js/mobile-sliders.js', array('swiper-js'), wp_get_theme()->get('Version'), true);
    // Magic Mode removed/replaced by Renewal
    // wp_enqueue_script('city-library-magic-mode', get_template_directory_uri() . '/js/magic-mode.js', array(), wp_get_theme()->get('Version'), true);

    // Book Renewal & Cookies
    wp_enqueue_script('city-library-book-renewal', get_template_directory_uri() . '/js/book-renewal.js', array('jquery'), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-cookie-consent', get_template_directory_uri() . '/js/cookie-consent.js', array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-search-modal', get_template_directory_uri() . '/js/search-modal.js', array(), wp_get_theme()->get('Version'), true);

    // Yandex Map
    if (get_theme_mod('footer_show_map', false)) {
        $apikey = get_theme_mod('footer_map_apikey', '');
        $api_url = 'https://api-maps.yandex.ru/2.1/?lang=ru_RU';
        if ($apikey) {
            $api_url .= '&apikey=' . esc_attr($apikey);
        }
        wp_enqueue_script('yandex-maps-api', $api_url, array(), null, true);
        wp_enqueue_script('city-library-yandex-map', get_template_directory_uri() . '/js/yandex-map-init.js', array('yandex-maps-api'), wp_get_theme()->get('Version'), true);

        wp_localize_script('city-library-yandex-map', 'yandex_map_params', array(
            'lat' => get_theme_mod('footer_map_lat', '56.162458'),
            'lon' => get_theme_mod('footer_map_lon', '40.470598'),
            'zoom' => get_theme_mod('footer_map_zoom', 15),
        ));
    }

    // Scroll Animations
    wp_enqueue_script('city-library-scroll-animations', get_template_directory_uri() . '/js/scroll-animations.js', array(), wp_get_theme()->get('Version'), true);

    if (is_single()) {
        wp_enqueue_script('city-library-reading-progress', get_template_directory_uri() . '/js/reading-progress.js', array(), wp_get_theme()->get('Version'), true);
    }

    wp_localize_script('city-library-view-toggle', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));

    // Prepare Renewal Button Settings for JS
    $renewal_settings = array(
        'btn_text' => get_theme_mod('renewal_btn_text', 'Продлить книгу'),
        'btn_bg' => get_theme_mod('renewal_btn_bg_color', '#0b7930'),
        'btn_text_color' => get_theme_mod('renewal_btn_text_color', '#ffffff'),
        'btn_radius' => get_theme_mod('renewal_btn_radius', 'circle'),
        'btn_visibility' => get_theme_mod('renewal_btn_visibility', 'mobile-only'),
        'btn_position' => get_theme_mod('renewal_btn_position', 'bottom-right'),
    );

    wp_localize_script('city-library-book-renewal', 'renewal_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('book_renewal_nonce'),
        'branches' => city_library_get_branches_list(), // Helper to pass branch list if needed JS side, though we just need IDs
        'settings' => $renewal_settings
    ));

    // Sticky Header
    wp_enqueue_script('city-library-sticky-header', get_template_directory_uri() . '/js/sticky-header.js', array(), wp_get_theme()->get('Version'), true);

    $sticky_css = file_get_contents(get_template_directory() . '/css/sticky-header.css');
    if ($sticky_css) {
        wp_add_inline_style('city-library-style', $sticky_css);
    }
}
add_action('wp_enqueue_scripts', 'city_library_scripts');

/**
 * Helper: Get Branches List
 */
function city_library_get_branches_list() {
    $branches = array(
        'cgb' => 'Центральная городская библиотека (ЦГБ)',
        'cdb' => 'Центральная детская библиотека (ЦДБ)',
    );
    for ($i = 1; $i <= 16; $i++) {
        $branches[$i] = "Филиал №$i";
    }
    return $branches;
}

/**
 * AJAX Handler for Book Renewal
 */
function city_library_send_book_renewal() {
    check_ajax_referer('book_renewal_nonce', 'nonce');

    $fio = sanitize_text_field($_POST['fio']);
    $card_number = sanitize_text_field($_POST['card_number']);
    $branch_id = sanitize_text_field($_POST['branch']);
    $email = sanitize_email($_POST['email']);
    $books = sanitize_textarea_field($_POST['books']);

    if (empty($fio) || empty($card_number) || empty($branch_id) || empty($email) || empty($books)) {
        wp_send_json_error(['message' => 'Пожалуйста, заполните все поля.']);
    }

    // Get branch email
    $branch_email = get_theme_mod("branch_email_$branch_id");

    // Fallback to admin email if not set
    if (!$branch_email) {
        $branch_email = get_option('admin_email');
    }

    $subject = 'Заявка на продление книг: ' . $fio;

    $message = "
    <html>
    <head>
        <title>Заявка на продление книг</title>
    </head>
    <body style='font-family: sans-serif; color: #333;'>
        <h2 style='color: #0b7930;'>Новая заявка на продление</h2>
        <p><strong>ФИО:</strong> $fio</p>
        <p><strong>№ Читательского билета:</strong> $card_number</p>
        <p><strong>Email читателя:</strong> $email</p>
        <p><strong>Выбранный филиал:</strong> $branch_id</p>
        <hr>
        <h3>Список книг:</h3>
        <p style='white-space: pre-wrap; background: #f6f8f6; padding: 15px; border-radius: 5px;'>$books</p>
    </body>
    </html>
    ";

    $headers = array('Content-Type: text/html; charset=UTF-8');
    $headers[] = 'From: Продление книг онлайн <wordpress@' . $_SERVER['SERVER_NAME'] . '>';
    $headers[] = 'Reply-To: ' . $fio . ' <' . $email . '>';

    $sent = wp_mail($branch_email, $subject, $message, $headers);

    if ($sent) {
        wp_send_json_success(['message' => 'Ваша заявка успешно отправлена!']);
    } else {
        wp_send_json_error(['message' => 'Ошибка отправки письма. Попробуйте позже.']);
    }
}
add_action('wp_ajax_city_library_send_book_renewal', 'city_library_send_book_renewal');
add_action('wp_ajax_nopriv_city_library_send_book_renewal', 'city_library_send_book_renewal');

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
 * Modify main query for homepage and archives.
 */
function city_library_homepage_query($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (isset($_GET['news_archive'])) {
            $query->set('posts_per_page', 8);
        } elseif ($query->is_home()) {
            $query->set('posts_per_page', 8); // Changed from 10 to 8 as requested
        } elseif ($query->is_archive() || $query->is_post_type_archive('post')) {
            $query->set('posts_per_page', 16);
        }
    }
}
add_action('pre_get_posts', 'city_library_homepage_query');

/**
 * Force load archive template for news archive view.
 */
function city_library_news_archive_template($template) {
    if (isset($_GET['news_archive'])) {
        $archive_template = locate_template('archive.php');
        if ($archive_template) {
            return $archive_template;
        }
    }
    return $template;
}
add_filter('template_include', 'city_library_news_archive_template');

/**
 * Register widget areas.
 */
function city_library_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Main Sidebar', 'city-library' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'city-library' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s mb-8 p-6 bg-white rounded-2xl shadow-sm border border-slate-100">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title text-lg font-bold font-display mb-4 text-primary border-b border-slate-100 pb-2">',
        'after_title'   => '</h2>',
    ) );

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

    // Custom Widget Area for Shortcode
    register_sidebar( array(
        'name'          => esc_html__( 'Content Widgets (Shortcode)', 'city-library' ),
        'id'            => 'content-widgets',
        'description'   => esc_html__( 'Widgets added here can be displayed inside any page or post using the shortcode [city_library_widgets]', 'city-library' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-8 p-6 bg-slate-50 rounded-2xl border border-slate-200">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title text-xl font-bold font-display mb-4 text-slate-800">',
        'after_title'   => '</h3>',
    ) );
}
add_action('widgets_init', 'city_library_widgets_init');

/**
 * Shortcode to output the 'Content Widgets' sidebar anywhere in content.
 */
function city_library_widgets_shortcode() {
    ob_start();
    if ( is_active_sidebar( 'content-widgets' ) ) {
        echo '<div class="city-library-content-widgets-wrapper my-8">';
        dynamic_sidebar( 'content-widgets' );
        echo '</div>';
    }
    return ob_get_clean();
}
add_shortcode( 'city_library_widgets', 'city_library_widgets_shortcode' );


/**
 * Customizer additions.
 */
function city_library_customize_register($wp_customize) {
    // Global Colors (AAA WYSIWYG)
    $wp_customize->add_section('global_colors_section', array(
        'title'    => __('Глобальные цвета (Theme)', 'city-library'),
        'priority' => 10,
    ));

    $wp_customize->add_setting('primary_color', array('default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label' => __('Основной цвет (Primary)', 'city-library'), 'section' => 'global_colors_section',
    )));

    $wp_customize->add_setting('secondary_color', array('default' => '#1A3C34', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label' => __('Вторичный цвет (Secondary)', 'city-library'), 'section' => 'global_colors_section',
    )));

    $wp_customize->add_setting('bg_body_color', array('default' => '#f6f8f6', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bg_body_color', array(
        'label' => __('Цвет фона страницы', 'city-library'), 'section' => 'global_colors_section',
    )));

    // Global Link Colors
    $wp_customize->add_setting('global_link_color', array('default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'global_link_color', array(
        'label' => __('Глобальный цвет ссылок', 'city-library'), 'section' => 'global_colors_section',
    )));

    $wp_customize->add_setting('global_link_hover_color', array('default' => '#096328', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'global_link_hover_color', array(
        'label' => __('Глобальный цвет ссылок (при наведении)', 'city-library'), 'section' => 'global_colors_section',
    )));

    // Global Button Settings
    $wp_customize->add_section('global_buttons_section', array(
        'title'    => __('Глобальные настройки кнопок', 'city-library'),
        'priority' => 18,
    ));

    $wp_customize->add_setting('global_btn_bg_color', array('default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'global_btn_bg_color', array(
        'label' => __('Основной цвет фона', 'city-library'), 'section' => 'global_buttons_section',
    )));

    $wp_customize->add_setting('global_btn_text_color', array('default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'global_btn_text_color', array(
        'label' => __('Основной цвет текста', 'city-library'), 'section' => 'global_buttons_section',
    )));

    $wp_customize->add_setting('global_btn_hover_bg_color', array('default' => '#096328', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'global_btn_hover_bg_color', array(
        'label' => __('Цвет фона при наведении', 'city-library'), 'section' => 'global_buttons_section',
    )));

    $wp_customize->add_setting('global_btn_hover_text_color', array('default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'global_btn_hover_text_color', array(
        'label' => __('Цвет текста при наведении', 'city-library'), 'section' => 'global_buttons_section',
    )));

    // Slider Buttons Settings (Navigation)
    $wp_customize->add_section('slider_buttons_section', array(
        'title'    => __('Кнопки слайдера (Навигация)', 'city-library'),
        'priority' => 18,
    ));

    $wp_customize->add_setting('slider_btn_bg_color', array('default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slider_btn_bg_color', array(
        'label' => __('Цвет фона кнопки', 'city-library'), 'section' => 'slider_buttons_section',
    )));

    $wp_customize->add_setting('slider_btn_icon_color', array('default' => '#334155', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slider_btn_icon_color', array(
        'label' => __('Цвет иконки/стрелки', 'city-library'), 'section' => 'slider_buttons_section',
    )));

    $wp_customize->add_setting('slider_btn_hover_bg_color', array('default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slider_btn_hover_bg_color', array(
        'label' => __('Цвет фона при наведении', 'city-library'), 'section' => 'slider_buttons_section',
    )));

    $wp_customize->add_setting('slider_btn_hover_icon_color', array('default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'slider_btn_hover_icon_color', array(
        'label' => __('Цвет иконки при наведении', 'city-library'), 'section' => 'slider_buttons_section',
    )));

    $wp_customize->add_setting('slider_btn_radius', array('default' => '9999px', 'sanitize_callback' => 'sanitize_text_field')); // Default circle
    $wp_customize->add_control('slider_btn_radius', array(
        'label' => __('Скругление углов', 'city-library'),
        'section' => 'slider_buttons_section',
        'type' => 'select',
        'choices' => array(
            '0' => 'Квадратные (0)',
            '0.5rem' => 'Скругленные (Small)',
            '1rem' => 'Скругленные (Medium)',
            '9999px' => 'Круглые (Circle)',
        ),
    ));


    // "Read More" / "Details" Buttons Settings
    $wp_customize->add_section('read_more_buttons_section', array(
        'title'    => __('Кнопки "Подробнее" / "Читать далее"', 'city-library'),
        'priority' => 18,
    ));

    $wp_customize->add_setting('read_more_btn_bg_color', array('default' => 'transparent', 'sanitize_callback' => 'sanitize_text_field')); // Can be transparent
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'read_more_btn_bg_color', array(
        'label' => __('Цвет фона кнопки', 'city-library'), 'section' => 'read_more_buttons_section',
    )));

    $wp_customize->add_setting('read_more_btn_text_color', array('default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'read_more_btn_text_color', array(
        'label' => __('Цвет текста', 'city-library'), 'section' => 'read_more_buttons_section',
    )));

    $wp_customize->add_setting('read_more_btn_hover_bg_color', array('default' => 'transparent', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'read_more_btn_hover_bg_color', array(
        'label' => __('Цвет фона при наведении', 'city-library'), 'section' => 'read_more_buttons_section',
    )));

    $wp_customize->add_setting('read_more_btn_hover_text_color', array('default' => '#096328', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'read_more_btn_hover_text_color', array(
        'label' => __('Цвет текста при наведении', 'city-library'), 'section' => 'read_more_buttons_section',
    )));

    $wp_customize->add_setting('read_more_show_underline', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('read_more_show_underline', array(
        'label' => __('Подчеркивание ссылки', 'city-library'),
        'section' => 'read_more_buttons_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('read_more_btn_radius', array('default' => '9999px', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('read_more_btn_radius', array(
        'label' => __('Скругление углов', 'city-library'),
        'section' => 'read_more_buttons_section',
        'type' => 'select',
        'choices' => array(
            '0' => 'Квадратные (0)',
            '0.5rem' => 'Скругленные (Small)',
            '1rem' => 'Скругленные (Medium)',
            '9999px' => 'Круглые (Circle)',
        ),
    ));


    // Layout Settings
    $wp_customize->add_section('layout_section', array(
        'title'    => __('Настройки макета (Layout)', 'city-library'),
        'priority' => 19,
    ));

    // Default sidebar to false as requested
    $wp_customize->add_setting('show_sidebar', array('default' => false, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('show_sidebar', array(
        'label' => __('Показать сайдбар', 'city-library'),
        'section' => 'layout_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('global_border_radius', array('default' => '2rem', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('global_border_radius', array(
        'label' => __('Скругление углов (Global Border Radius)', 'city-library'),
        'section' => 'layout_section',
        'type' => 'select',
        'choices' => array(
            '0' => '0 (Sharp)',
            '0.5rem' => 'Small (0.5rem)',
            '1rem' => 'Medium (1rem)',
            '2rem' => 'Large (2rem - Default)',
        ),
    ));

    $wp_customize->add_setting('global_container_width', array('default' => '80%', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('global_container_width', array(
        'label' => __('Ширина контента (Desktop)', 'city-library'),
        'section' => 'layout_section',
        'type' => 'select',
        'choices' => array(
            '100%' => 'Full Width (100%)',
            '90%' => 'Wide (90%)',
            '80%' => 'Standard (80%)',
            '1280px' => 'Fixed (1280px)',
        ),
    ));

    // Branch Emails Section
    $wp_customize->add_section('branches_email_section', array(
        'title' => __('Email адреса филиалов', 'city-library'),
        'priority' => 140,
        'description' => __('Введите Email для каждого филиала для получения заявок на продление книг.', 'city-library'),
    ));

    $branches = city_library_get_branches_list();
    foreach ($branches as $id => $name) {
        $wp_customize->add_setting("branch_email_$id", array('sanitize_callback' => 'sanitize_email'));
        $wp_customize->add_control("branch_email_$id", array(
            'label' => $name,
            'section' => 'branches_email_section',
            'type' => 'email',
        ));
    }

    // Book Renewal Button Settings
    $wp_customize->add_section('renewal_button_section', array(
        'title' => __('Кнопка продления книг', 'city-library'),
        'priority' => 145,
        'description' => __('Настройки внешнего вида и поведения кнопки продления книг.', 'city-library'),
    ));

    $wp_customize->add_setting('renewal_btn_text', array('default' => 'Продлить книгу', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('renewal_btn_text', array(
        'label' => __('Текст кнопки', 'city-library'),
        'section' => 'renewal_button_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('renewal_btn_bg_color', array('default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'renewal_btn_bg_color', array(
        'label' => __('Цвет фона', 'city-library'),
        'section' => 'renewal_button_section',
    )));

    $wp_customize->add_setting('renewal_btn_text_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'renewal_btn_text_color', array(
        'label' => __('Цвет текста/иконки', 'city-library'),
        'section' => 'renewal_button_section',
    )));

    $wp_customize->add_setting('renewal_btn_radius', array('default' => 'circle', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('renewal_btn_radius', array(
        'label' => __('Скругление углов', 'city-library'),
        'section' => 'renewal_button_section',
        'type' => 'select',
        'choices' => array(
            'square' => 'Square (0)',
            'small' => 'Small (Rounded-md)',
            'medium' => 'Medium (Rounded-xl)',
            'circle' => 'Circle (Full)',
        ),
    ));

    $wp_customize->add_setting('renewal_btn_visibility', array('default' => 'mobile-only', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('renewal_btn_visibility', array(
        'label' => __('Видимость кнопки', 'city-library'),
        'section' => 'renewal_button_section',
        'type' => 'select',
        'choices' => array(
            'mobile-only' => 'Только на мобильных',
            'desktop-only' => 'Только на ПК',
            'all' => 'На всех устройствах',
            'hidden' => 'Скрыть полностью',
        ),
    ));

    $wp_customize->add_setting('renewal_btn_position', array('default' => 'bottom-right', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('renewal_btn_position', array(
        'label' => __('Позиция на экране', 'city-library'),
        'section' => 'renewal_button_section',
        'type' => 'select',
        'choices' => array(
            'bottom-right' => 'Справа внизу',
            'bottom-left' => 'Слева внизу',
        ),
    ));

    // Mobile Bottom Menu Section
    $wp_customize->add_section('mobile_menu_section', array(
        'title'    => __('Нижнее мобильное меню', 'city-library'),
        'priority' => 21,
    ));

    $wp_customize->add_setting('mobile_menu_bg_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mobile_menu_bg_color', array(
        'label' => __('Цвет фона', 'city-library'), 'section' => 'mobile_menu_section',
    )));

    $wp_customize->add_setting('mobile_menu_icon_color', array('default' => '#64748b', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mobile_menu_icon_color', array(
        'label' => __('Цвет иконок', 'city-library'), 'section' => 'mobile_menu_section',
    )));

    $wp_customize->add_setting('mobile_menu_active_color', array('default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mobile_menu_active_color', array(
        'label' => __('Цвет активного элемента', 'city-library'), 'section' => 'mobile_menu_section',
    )));

    $wp_customize->add_setting('mobile_menu_font_color', array('default' => '#64748b', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mobile_menu_font_color', array(
        'label' => __('Цвет шрифта (текст)', 'city-library'), 'section' => 'mobile_menu_section',
    )));

    $wp_customize->add_setting('mobile_menu_font_family', array('default' => 'Inter', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('mobile_menu_font_family', array(
        'label' => __('Шрифт меню', 'city-library'),
        'section' => 'mobile_menu_section',
        'type' => 'select',
        'choices' => array(
            'Inter' => 'Inter',
            'Montserrat' => 'Montserrat',
            'Playfair Display' => 'Playfair Display',
            'Merriweather' => 'Merriweather',
        ),
    ));

    $wp_customize->add_setting('mobile_menu_icon_set', array('default' => 'outlined', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('mobile_menu_icon_set', array(
        'label' => __('Набор иконок', 'city-library'),
        'section' => 'mobile_menu_section',
        'type' => 'select',
        'choices' => array(
            'outlined' => 'Material Outlined (Контурные)',
            'rounded' => 'Material Rounded (Скругленные)',
            'sharp' => 'Material Sharp (Острые)',
        ),
    ));

    $wp_customize->add_setting('mobile_menu_style', array('default' => 'default', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('mobile_menu_style', array(
        'label' => __('Стиль меню', 'city-library'),
        'section' => 'mobile_menu_section',
        'type' => 'select',
        'choices' => array(
            'default' => 'Default (Fixed Bottom)',
            'ios-blur' => 'iOS Blur (Translucent)',
            'material-pill' => 'Material Pill (Floating)',
            'neon-glow' => 'Neon Glow (Dark Mode)',
            'minimal-border' => 'Minimal Border (Top Line)',
            'floating-island' => 'Floating Island (Rounded)',
            'glassmorphism' => 'Glassmorphism (Frosted Glass)',
            'gradient-bar' => 'Gradient Bar (Color Flow)',
            'tab-bar' => 'Tab Bar (Android Style)',
            'floating-dock' => 'Floating Dock (macOS Style)',
            'minimal-icons' => 'Minimal Icons (No Text)',
            'text-only' => 'Text Only (No Icons)',
            'cyberpunk' => 'Cyberpunk (Futuristic)',
            'neumorphism' => 'Neumorphism (Soft UI)',
            'retro-pixel' => 'Retro Pixel (8-bit Vibe)',
            'sidebar-drawer' => 'Bottom Drawer (Slide Up)',
        ),
    ));

    $wp_customize->add_setting('mobile_menu_btn_style', array('default' => 'classic', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('mobile_menu_btn_style', array(
        'label' => __('Стиль кнопок меню', 'city-library'),
        'section' => 'mobile_menu_section',
        'type' => 'select',
        'choices' => array(
            'classic' => 'Classic (Icon + Text)',
            'minimal' => 'Minimal (Icon Only)',
            'bold' => 'Bold (Thick Icons)',
            'soft' => 'Soft (Pastel Colors)',
            'bubble' => 'Bubble (Circle BG)',
            'square' => 'Square (Rounded-md BG)',
            'underline' => 'Underline (Active State)',
            'glow' => 'Glow (Text Shadow)',
            'floating' => 'Floating (Lift on Hover)',
            'glass-btn' => 'Glass Button (Blur)',
        ),
    ));

    // Header Section
    $wp_customize->add_section('header_section', array(
        'title'    => __('Настройки шапки (Header)', 'city-library'),
        'priority' => 20,
    ));

    // Header Style
    $wp_customize->add_setting('header_style', array('default' => 'default', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('header_style', array(
        'label' => __('Стиль шапки (Header Style)', 'city-library'),
        'section' => 'header_section',
        'type' => 'select',
        'choices' => array(
            'default' => 'Default (Left Logo, Right Menu)',
            'centered' => 'Centered (Logo Top, Menu Bottom)',
            'minimal' => 'Minimal (Logo Left, Menu Hidden/Hamburger)',
            'full-width' => 'Full Width (No Container)',
            'transparent-overlay' => 'Transparent Overlay (Absolute)',
            'floating' => 'Floating (Rounded, Detached)',
            'dark-mode' => 'Dark Mode (Inverted Colors)',
        ),
    ));

    // Menu Style
    $wp_customize->add_setting('menu_style', array('default' => 'default', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('menu_style', array(
        'label' => __('Стиль меню (Menu Style)', 'city-library'),
        'section' => 'header_section',
        'type' => 'select',
        'choices' => array(
            'default' => 'Default (Simple Hover)',
            'underline' => 'Underline Animation',
            'pill' => 'Pill Background',
            'bracket' => 'Brackets [ Link ]',
            'bold' => 'Bold on Hover',
        ),
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

    $wp_customize->add_setting('hero_overlay_color', array('default' => '#1a3c34', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hero_overlay_color', array(
        'label' => __('Цвет наложения (Overlay Color)', 'city-library'),
        'section' => 'hero_section',
    )));

    $wp_customize->add_setting('hero_bg_opacity', array('default' => '0.5', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('hero_bg_opacity', array(
        'label' => __('Прозрачность наложения (Overlay Opacity)', 'city-library'),
        'section' => 'hero_section',
        'type' => 'range',
        'input_attrs' => array('min' => 0, 'max' => 1, 'step' => 0.1),
    ));

    $wp_customize->add_setting('hero_align', array('default' => 'center', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('hero_align', array(
        'label' => __('Выравнивание текста (Alignment)', 'city-library'),
        'section' => 'hero_section',
        'type' => 'select',
        'choices' => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'),
    ));

    $wp_customize->add_setting('hero_title_size', array('default' => 'text-5xl md:text-7xl lg:text-8xl', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('hero_title_size', array(
        'label' => __('Размер заголовка (Title Size)', 'city-library'),
        'section' => 'hero_section',
        'type' => 'select',
        'choices' => array(
            'text-4xl md:text-6xl lg:text-7xl' => 'Small',
            'text-5xl md:text-7xl lg:text-8xl' => 'Medium (Default)',
            'text-6xl md:text-8xl lg:text-9xl' => 'Large',
        ),
    ));

    // Footer Section
    $wp_customize->add_section('footer_section', array('title' => __('Footer', 'city-library'), 'priority' => 120));

    $wp_customize->add_setting('footer_style', array('default' => 'default', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('footer_style', array(
        'label' => __('Стиль футера (Footer Style)', 'city-library'),
        'section' => 'footer_section',
        'type' => 'select',
        'choices' => array(
            'default' => 'Default (Dark Simple)',
            'light-clean' => 'Light Clean (White BG)',
            'centered' => 'Centered Layout',
            'multi-column' => 'Multi-Column (Grid)',
            'minimal' => 'Minimal (Copyright Only)',
        ),
    ));

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

    // New Footer Customizations
    $wp_customize->add_setting('footer_description', array('default' => '', 'sanitize_callback' => 'sanitize_textarea_field'));
    $wp_customize->add_control('footer_description', array('label' => __('Описание в футере', 'city-library'), 'section' => 'footer_section', 'type' => 'textarea'));

    $wp_customize->add_setting('footer_phone', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('footer_phone', array('label' => __('Телефон', 'city-library'), 'section' => 'footer_section', 'type' => 'text'));

    $wp_customize->add_setting('footer_email', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('footer_email', array('label' => __('Email', 'city-library'), 'section' => 'footer_section', 'type' => 'text'));

    $wp_customize->add_setting('footer_address', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('footer_address', array('label' => __('Адрес', 'city-library'), 'section' => 'footer_section', 'type' => 'text'));

    // Social Links
    $wp_customize->add_setting('footer_social_vk', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('footer_social_vk', array('label' => __('VKontakte URL', 'city-library'), 'section' => 'footer_section', 'type' => 'url'));

    $wp_customize->add_setting('footer_social_telegram', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('footer_social_telegram', array('label' => __('Telegram URL', 'city-library'), 'section' => 'footer_section', 'type' => 'url'));

    $wp_customize->add_setting('footer_social_ok', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('footer_social_ok', array('label' => __('Odnoklassniki URL', 'city-library'), 'section' => 'footer_section', 'type' => 'url'));

    $wp_customize->add_setting('footer_social_youtube', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('footer_social_youtube', array('label' => __('YouTube URL', 'city-library'), 'section' => 'footer_section', 'type' => 'url'));

    // Footer Map Section
    $wp_customize->add_section('footer_map_section', array(
        'title' => __('Яндекс Карта', 'city-library'),
        'priority' => 125,
        'description' => __('Настройки карты в футере.', 'city-library'),
    ));

    $wp_customize->add_setting('footer_show_map', array('default' => false, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('footer_show_map', array(
        'label' => __('Показать карту', 'city-library'),
        'section' => 'footer_map_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('footer_map_apikey', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('footer_map_apikey', array(
        'label' => __('API Key (Optional for basic use)', 'city-library'),
        'section' => 'footer_map_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('footer_map_lat', array('default' => '56.162458', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('footer_map_lat', array(
        'label' => __('Широта (Latitude)', 'city-library'),
        'section' => 'footer_map_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('footer_map_lon', array('default' => '40.470598', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('footer_map_lon', array(
        'label' => __('Долгота (Longitude)', 'city-library'),
        'section' => 'footer_map_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('footer_map_zoom', array('default' => 15, 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('footer_map_zoom', array(
        'label' => __('Масштаб (Zoom)', 'city-library'),
        'section' => 'footer_map_section',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 19, 'step' => 1),
    ));

    $wp_customize->add_setting('footer_map_height', array('default' => '300px', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('footer_map_height', array(
        'label' => __('Высота карты (например, 300px)', 'city-library'),
        'section' => 'footer_map_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('footer_map_width_desktop', array('default' => '250px', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('footer_map_width_desktop', array(
        'label' => __('Ширина карты на ПК (Desktop Width)', 'city-library'),
        'section' => 'footer_map_section',
        'type' => 'text',
        'description' => 'Например: 250px, 300px, 100%'
    ));

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

    $wp_customize->add_setting('partners_bg_color', array('default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'partners_bg_color', array(
        'label' => __('Цвет фона блока', 'city-library'), 'section' => 'partners_section',
    )));

    // Partner Logo Size Settings
    $wp_customize->add_setting('partners_logo_size', array('default' => 'medium', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('partners_logo_size', array(
        'label' => __('Размер логотипов партнеров', 'city-library'),
        'section' => 'partners_section',
        'type' => 'select',
        'choices' => array(
            'xs' => 'XS (Very Small - h-8)',
            'sm' => 'S (Small - h-12)',
            'medium' => 'M (Medium - h-16) [Default]',
            'lg' => 'L (Large - h-20)',
            'xl' => 'XL (Extra Large - h-24)',
            '2xl' => '2XL (Huge - h-32)',
            '3xl' => '3XL (Gigantic - h-40)',
            'original' => 'Original (Auto)',
        ),
    ));

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

        $wp_customize->add_setting("afisha_ribbon_$i", array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("afisha_ribbon_$i", array('label' => sprintf(__('Ribbon Text %d (e.g. NEW)', 'city-library'), $i), 'section' => 'afisha_section', 'type' => 'text'));

        $wp_customize->add_setting("afisha_badge_$i", array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("afisha_badge_$i", array('label' => sprintf(__('Badge Text %d (e.g. Featured)', 'city-library'), $i), 'section' => 'afisha_section', 'type' => 'text'));

        $wp_customize->add_setting("afisha_date_$i", array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("afisha_date_$i", array('label' => sprintf(__('Event Date %d (e.g. 12 OCT)', 'city-library'), $i), 'section' => 'afisha_section', 'type' => 'text'));
    }

    $wp_customize->add_setting('afisha_bg_style', array('default' => 'default', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('afisha_bg_style', array(
        'label' => __('Background Style', 'city-library'),
        'section' => 'afisha_section',
        'type' => 'select',
        'choices' => array(
            'default' => 'Default (SVG Pattern)',
            'gradient' => 'Modern Gradient',
        ),
    ));

    $wp_customize->add_setting('afisha_card_style', array('default' => 'default', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('afisha_card_style', array(
        'label' => __('Стиль карточек слайдера (Card Style)', 'city-library'),
        'section' => 'afisha_section',
        'type' => 'select',
        'choices' => array(
            'default' => 'Default (Rounded, Shadow)',
            'card' => 'Classic Card (White Border)',
            'clean' => 'Clean (No Shadow, Minimal)',
            'overlay' => 'Full Overlay (Text on Image)',
            'glass' => 'Glassmorphism (Blur)',
            'gradient' => 'Gradient Overlay (Dark)',
            'brutalism' => 'Brutalism (Hard Borders)',
            'minimal-text' => 'Minimal Text Focus',
            'cyberpunk' => 'Cyberpunk (Neon Accents)',
            'rounded-image' => 'Circular Image (Portrait style)',
        ),
    ));

    $wp_customize->add_setting('afisha_font_family', array('default' => 'Inter', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('afisha_font_family', array(
        'label' => __('Шрифт заголовка афиши', 'city-library'),
        'section' => 'afisha_section',
        'type' => 'select',
        'choices' => array(
            'Inter' => 'Inter',
            'Montserrat' => 'Montserrat',
            'Playfair Display' => 'Playfair Display',
            'Merriweather' => 'Merriweather',
            'Cinzel' => 'Cinzel',
            'MedievalSharp' => 'MedievalSharp',
            'Crimson Text' => 'Crimson Text',
            'Great Vibes' => 'Great Vibes',
            'Comforter' => 'Comforter',
            'Marck Script' => 'Marck Script',
        ),
    ));

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

    // Important Button Colors
    $wp_customize->add_setting('important_btn_bg_color', array('default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'important_btn_bg_color', array(
        'label' => __('Цвет фона кнопки', 'city-library'), 'section' => 'important_section',
    )));
    $wp_customize->add_setting('important_btn_text_color', array('default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'important_btn_text_color', array(
        'label' => __('Цвет текста кнопки', 'city-library'), 'section' => 'important_section',
    )));

    $wp_customize->add_setting('important_bg_color', array('default' => '#fef2f2', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'important_bg_color', array(
        'label' => __('Цвет фона блока', 'city-library'), 'section' => 'important_section',
    )));

    $wp_customize->add_setting('important_inter_block_text', array('default' => '', 'sanitize_callback' => 'sanitize_textarea_field'));
    $wp_customize->add_control('important_inter_block_text', array('label' => __('Текст между блоками', 'city-library'), 'section' => 'important_section', 'type' => 'textarea'));

    $wp_customize->add_setting('important_link_radius', array('default' => 'medium', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('important_link_radius', array(
        'label' => __('Скругление изображений ссылок', 'city-library'),
        'section' => 'important_section',
        'type' => 'select',
        'choices' => array(
            'none' => 'Square (None)',
            'small' => 'Small',
            'medium' => 'Medium (Default)',
            'full' => 'Circle (Full)',
        ),
    ));

    $wp_customize->add_setting('important_link_style', array('default' => 'default', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('important_link_style', array(
        'label' => __('Стиль изображений ссылок', 'city-library'),
        'section' => 'important_section',
        'type' => 'select',
        'choices' => array(
            'default' => 'Default (Simple)',
            'shadow' => 'Drop Shadow',
            'border' => 'Bordered',
            'grayscale' => 'Grayscale Hover',
        ),
    ));

    $wp_customize->add_setting('important_links_image_orientation', array('default' => 'square', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('important_links_image_orientation', array(
        'label' => __('Ориентация изображений', 'city-library'),
        'description' => __('Выберите пропорции для 8 изображений ссылок ниже.', 'city-library'),
        'section' => 'important_section',
        'type' => 'select',
        'choices' => array(
            'square' => 'Квадратные (1:1)',
            'horizontal' => 'Горизонтальные (16:9)',
        ),
    ));

    // Important Section Links (8 items)
    for ($i = 1; $i <= 8; $i++) {
        $wp_customize->add_setting("important_link_image_$i", array('sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "important_link_image_$i", array(
            'label' => sprintf(__('Link Image %d', 'city-library'), $i),
            'section' => 'important_section',
        )));

        $wp_customize->add_setting("important_link_url_$i", array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("important_link_url_$i", array(
            'label' => sprintf(__('Link URL %d', 'city-library'), $i),
            'section' => 'important_section',
            'type' => 'url'
        ));
    }

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

    $wp_customize->add_setting('modal_video', array('sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'modal_video', array(
        'label' => __('Видео файл (заменяет изображение)', 'city-library'),
        'section' => 'modal_section',
        'mime_type' => 'video',
    )));

    $wp_customize->add_setting('modal_title', array('default' => 'Специальное предложение!', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('modal_title', array('label' => __('Заголовок', 'city-library'), 'section' => 'modal_section', 'type' => 'text'));

    $wp_customize->add_setting('modal_text', array('default' => 'Подпишитесь на нашу рассылку новостей.', 'sanitize_callback' => 'city_library_sanitize_html'));
    $wp_customize->add_control('modal_text', array('label' => __('Текст (HTML/Video)', 'city-library'), 'section' => 'modal_section', 'type' => 'textarea'));

    $wp_customize->add_setting('modal_delay', array('default' => 3000, 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('modal_delay', array('label' => __('Задержка (мс)', 'city-library'), 'section' => 'modal_section', 'type' => 'number'));

    // Featured Cards Section
    $wp_customize->add_section('featured_cards_section', array(
        'title' => __('Выделенные карточки (Featured Cards)', 'city-library'),
        'priority' => 103,
    ));

    $wp_customize->add_setting('show_featured_cards', array('default' => false, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('show_featured_cards', array(
        'label' => __('Показать блок', 'city-library'),
        'section' => 'featured_cards_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('featured_cards_title', array('default' => 'Наши направления', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('featured_cards_title', array('label' => __('Заголовок блока', 'city-library'), 'section' => 'featured_cards_section', 'type' => 'text'));

    $wp_customize->add_setting('featured_cards_design', array('default' => 'design-1', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('featured_cards_design', array(
        'label' => __('Дизайн карточек', 'city-library'),
        'section' => 'featured_cards_section',
        'type' => 'select',
        'choices' => array(
            'design-1' => 'Дизайн 1 (Стандартный с рамкой)',
            'design-2' => 'Дизайн 2 (Текст поверх изображения)',
            'design-3' => 'Дизайн 3 (Минималистичный без фона)',
            'design-4' => 'Дизайн 4 (С тенью и скруглением)',
            'design-5' => 'Дизайн 5 (Градиентный фон)',
            'design-6' => 'Дизайн 6 (Glassmorphism)',
            'design-7' => 'Дизайн 7 (Тонкая линия сверху)',
            'design-8' => 'Дизайн 8 (Сплошная заливка, иконки)',
            'design-9' => 'Дизайн 9 (Крупный заголовок, без фото)',
            'design-10' => 'Дизайн 10 (Стиль Polaroid)',
            'design-11' => 'Дизайн 11 (Только фото, адаптивное)',
            'design-12' => 'Дизайн 12 (Двухцветный Duotone)',
            'design-13' => 'Дизайн 13 (Неоморфизм / Выпуклый)',
            'design-14' => 'Дизайн 14 (Брутализм / Журнальный)',
            'design-15' => 'Дизайн 15 (Круглые блоки)',
            'design-16' => 'Дизайн 16 (Черно-белый контраст)',
            'design-17' => 'Дизайн 17 (Абстрактные формы)',
            'design-18' => 'Дизайн 18 (Элегантная типографика)',
            'design-19' => 'Дизайн 19 (Киберпанк / Неон)',
            'design-20' => 'Дизайн 20 (Смещенные блоки)'
        ),
    ));

    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting("fc_image_$i", array('sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "fc_image_$i", array(
            'label' => sprintf(__('Картинка карточки %d', 'city-library'), $i),
            'section' => 'featured_cards_section',
        )));

        $wp_customize->add_setting("fc_title_$i", array('default' => sprintf('Карточка %d', $i), 'sanitize_callback' => 'sanitize_text_field'));
        $wp_customize->add_control("fc_title_$i", array('label' => sprintf(__('Заголовок карточки %d', 'city-library'), $i), 'section' => 'featured_cards_section', 'type' => 'text'));

        $wp_customize->add_setting("fc_desc_$i", array('default' => 'Краткое описание карточки.', 'sanitize_callback' => 'sanitize_textarea_field'));
        $wp_customize->add_control("fc_desc_$i", array('label' => sprintf(__('Описание карточки %d', 'city-library'), $i), 'section' => 'featured_cards_section', 'type' => 'textarea'));

        $wp_customize->add_setting("fc_link_$i", array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
        $wp_customize->add_control("fc_link_$i", array('label' => sprintf(__('Ссылка карточки %d', 'city-library'), $i), 'section' => 'featured_cards_section', 'type' => 'url'));
    }

    // Promo Section
    $wp_customize->add_section('promo_section', array(
        'title' => __('Промо Блок (Promo)', 'city-library'),
        'priority' => 104,
    ));

    $wp_customize->add_setting('show_promo_section', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('show_promo_section', array(
        'label' => __('Показать Промо Блок', 'city-library'),
        'section' => 'promo_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('promo_image', array('sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'promo_image', array(
        'label' => __('Изображение (400x300)', 'city-library'),
        'section' => 'promo_section',
    )));

    $wp_customize->add_setting('promo_title', array('default' => 'Добро пожаловать', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('promo_title', array('label' => __('Заголовок', 'city-library'), 'section' => 'promo_section', 'type' => 'text'));

    $wp_customize->add_setting('promo_text', array('default' => 'Узнайте больше о наших услугах и мероприятиях.', 'sanitize_callback' => 'city_library_sanitize_html'));
    $wp_customize->add_control('promo_text', array('label' => __('Текст', 'city-library'), 'section' => 'promo_section', 'type' => 'textarea'));

    // Promo Section Link Settings
    $wp_customize->add_setting('promo_btn_text', array('default' => 'Подробнее', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('promo_btn_text', array('label' => __('Текст кнопки', 'city-library'), 'section' => 'promo_section', 'type' => 'text'));

    $wp_customize->add_setting('promo_link', array('default' => '#', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('promo_link', array('label' => __('Ссылка', 'city-library'), 'section' => 'promo_section', 'type' => 'url'));

    // Promo Button Colors
    $wp_customize->add_setting('promo_btn_bg_color', array('default' => '#0b7930', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'promo_btn_bg_color', array(
        'label' => __('Цвет фона кнопки', 'city-library'), 'section' => 'promo_section',
    )));
    $wp_customize->add_setting('promo_btn_text_color', array('default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'promo_btn_text_color', array(
        'label' => __('Цвет текста кнопки', 'city-library'), 'section' => 'promo_section',
    )));

    $wp_customize->add_setting('promo_btn_hover_bg_color', array('default' => '#096328', 'sanitize_callback' => 'sanitize_hex_color'));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'promo_btn_hover_bg_color', array(
        'label' => __('Цвет фона кнопки (Hover)', 'city-library'), 'section' => 'promo_section',
    )));

    // Animation Settings
    $wp_customize->add_section('animation_section', array(
        'title' => __('Настройки анимаций', 'city-library'),
        'priority' => 150,
    ));

    $wp_customize->add_setting('enable_animations', array('default' => true, 'sanitize_callback' => 'wp_validate_boolean'));
    $wp_customize->add_control('enable_animations', array(
        'label' => __('Включить анимации при прокрутке', 'city-library'),
        'section' => 'animation_section',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('animation_type', array('default' => 'fade-up', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('animation_type', array(
        'label' => __('Тип анимации', 'city-library'),
        'section' => 'animation_section',
        'type' => 'select',
        'choices' => array(
            'fade-up' => 'Fade Up (Default)',
            'fade-down' => 'Fade Down',
            'fade-left' => 'Fade Left',
            'fade-right' => 'Fade Right',
            'zoom-in' => 'Zoom In',
            'zoom-out' => 'Zoom Out',
            'flip-up' => 'Flip Up',
            'slide-up' => 'Slide Up (Bounce)',
            'blur-in' => 'Blur In',
            'rotate-in' => 'Rotate In',
        ),
    ));
}
add_action('customize_register', 'city_library_customize_register');

/**
 * Helper to get animation classes.
 */
function city_library_get_animation_class() {
    if (get_theme_mod('enable_animations', true)) {
        $type = get_theme_mod('animation_type', 'fade-up');
        return 'animate-on-scroll aos-' . esc_attr($type);
    }
    return '';
}


/**
 * Disable comments.
 */
function city_library_disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'city_library_disable_comments_post_types_support');

function city_library_disable_comments_status() {
    return false;
}
add_filter('comments_open', 'city_library_disable_comments_status', 20, 2);
add_filter('pings_open', 'city_library_disable_comments_status', 20, 2);

function city_library_disable_comments_hide_existing_comments($comments) {
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'city_library_disable_comments_hide_existing_comments', 10, 2);

function city_library_disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'city_library_disable_comments_admin_menu');

function city_library_disable_comments_admin_bar() {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'city_library_disable_comments_admin_bar');


/**
 * Custom Walker for Nav Menu to apply Tailwind classes.
 */
class City_Library_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        // Base classes for the link
        $link_classes = 'text-sm font-semibold hover:text-primary transition-all whitespace-nowrap hover:underline decoration-2 underline-offset-4 flex items-center justify-between w-full';

        // Add parent wrapper li
        // Changed 'group' to 'group/menuitem' to isolate hover state
        $li_classes = 'group/menuitem relative py-2 lg:py-0';
        if ($args->has_children) {
            $li_classes .= ' has-children';
        }
        $output .= '<li class="' . esc_attr($li_classes) . '">';

        // Check if item has children to add toggle button logic
        if ($args->has_children) {
            $output .= '<div class="flex items-center justify-between w-full">';
            $output .= '<a href="' . esc_url($item->url) . '" class="' . esc_attr($link_classes) . '">' . esc_html($item->title) . '</a>';
            // Mobile Toggle Button (Visible on mobile, hidden on desktop hover)
            $output .= '<button class="submenu-toggle p-2 lg:hidden focus:outline-none" aria-expanded="false" aria-label="Toggle submenu"><span class="material-symbols-outlined text-lg transition-transform duration-300">expand_more</span></button>';
            // Desktop Arrow (Visual only, handled by group-hover/menuitem)
            $output .= '<span class="material-symbols-outlined text-lg hidden lg:block ml-1 group-hover/menuitem:rotate-180 transition-transform duration-300">expand_more</span>';
            $output .= '</div>';
        } else {
            $output .= '<a href="' . esc_url($item->url) . '" class="' . esc_attr($link_classes) . '">' . esc_html($item->title) . '</a>';
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>";
    }

    function start_lvl(&$output, $depth = 0, $args = null) {
        // Submenu UL classes
        // Desktop: absolute, top-full, opacity-0/invisible by default, fade in on group-hover/menuitem
        // Mobile: hidden by default, block when toggled (via JS), relative/indented
        $ul_classes = 'submenu hidden lg:block lg:absolute lg:top-full lg:left-0 lg:min-w-[200px] lg:bg-white lg:shadow-xl lg:rounded-xl lg:border lg:border-slate-100 lg:p-2 z-50 transition-all duration-300 ease-in-out origin-top bg-transparent lg:bg-white mt-2 lg:mt-4 space-y-1';

        // Desktop Transitions
        $ul_classes .= ' lg:opacity-0 lg:invisible lg:translate-y-2';
        $ul_classes .= ' lg:group-hover/menuitem:opacity-100 lg:group-hover/menuitem:visible lg:group-hover/menuitem:translate-y-0';

        $output .= '<ul class="' . esc_attr($ul_classes) . '">';
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= "</ul>";
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
 * Custom HTML sanitization to allow iframes.
 */
function city_library_sanitize_html($html) {
    global $allowedposttags;
    $allowed_html = $allowedposttags;
    $allowed_html['iframe'] = array(
        'src'             => true,
        'width'           => true,
        'height'          => true,
        'frameborder'     => true,
        'allow'           => true,
        'allowfullscreen' => true,
        'style'           => true,
    );
    $allowed_html['button'] = array(
        'class' => true,
        'onclick' => true,
    );
    $allowed_html['a']['class'] = true;
    $allowed_html['a']['target'] = true;

    // Allow Media
    $allowed_html['img'] = array(
        'src' => true,
        'alt' => true,
        'class' => true,
        'width' => true,
        'height' => true,
    );
    $allowed_html['video'] = array(
        'src' => true,
        'class' => true,
        'width' => true,
        'height' => true,
        'controls' => true,
        'autoplay' => true,
        'muted' => true,
        'loop' => true,
        'playsinline' => true,
    );
    $allowed_html['source'] = array(
        'src' => true,
        'type' => true,
    );
    $allowed_html['iframe'] = array(
        'src' => true,
        'width' => true,
        'height' => true,
        'frameborder' => true,
        'allow' => true,
        'allowfullscreen' => true,
        'style' => true,
        'class' => true,
    );

    return wp_kses($html, $allowed_html);
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
    $btn_bg = get_theme_mod('global_btn_bg_color', '#0b7930');
    $btn_text = get_theme_mod('global_btn_text_color', '#FFFFFF');
    $btn_hover_bg = get_theme_mod('global_btn_hover_bg_color', '#096328');
    $btn_hover_text = get_theme_mod('global_btn_hover_text_color', '#FFFFFF');

    // Slider Buttons
    $slider_btn_bg = get_theme_mod('slider_btn_bg_color', '#FFFFFF');
    $slider_btn_icon = get_theme_mod('slider_btn_icon_color', '#334155');
    $slider_btn_hover_bg = get_theme_mod('slider_btn_hover_bg_color', '#0b7930');
    $slider_btn_hover_icon = get_theme_mod('slider_btn_hover_icon_color', '#FFFFFF');
    $slider_btn_radius = get_theme_mod('slider_btn_radius', '9999px');

    // Read More Buttons
    $read_more_bg = get_theme_mod('read_more_btn_bg_color', 'transparent');
    $read_more_text = get_theme_mod('read_more_btn_text_color', '#0b7930');
    $read_more_hover_bg = get_theme_mod('read_more_btn_hover_bg_color', 'transparent');
    $read_more_hover_text = get_theme_mod('read_more_btn_hover_text_color', '#096328');
    $read_more_underline = get_theme_mod('read_more_show_underline', true) ? 'underline' : 'none';
    $read_more_radius = get_theme_mod('read_more_btn_radius', '9999px');

    $primary_color = get_theme_mod('primary_color', '#0b7930');
    $secondary_color = get_theme_mod('secondary_color', '#1A3C34');
    $bg_body = get_theme_mod('bg_body_color', '#f6f8f6');
    $link_color = get_theme_mod('global_link_color', '#0b7930');
    $link_hover_color = get_theme_mod('global_link_hover_color', '#096328');
    $radius = get_theme_mod('global_border_radius', '2rem');
    $width = get_theme_mod('global_container_width', '80%');

    // Mobile Menu
    $mob_menu_bg = get_theme_mod('mobile_menu_bg_color', '#ffffff');
    $mob_menu_icon = get_theme_mod('mobile_menu_icon_color', '#64748b');
    $mob_menu_active = get_theme_mod('mobile_menu_active_color', '#0b7930');
    $mob_menu_font_color = get_theme_mod('mobile_menu_font_color', '#64748b');
    $mob_menu_font = get_theme_mod('mobile_menu_font_family', 'Inter');
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --secondary-color: <?php echo esc_attr($secondary_color); ?>;
            --bg-body: <?php echo esc_attr($bg_body); ?>;

            --global-link-color: <?php echo esc_attr($link_color); ?>;
            --global-link-hover-color: <?php echo esc_attr($link_hover_color); ?>;

            --mob-menu-bg: <?php echo esc_attr($mob_menu_bg); ?>;
            --mob-menu-icon: <?php echo esc_attr($mob_menu_icon); ?>;
            --mob-menu-active: <?php echo esc_attr($mob_menu_active); ?>;
            --mob-menu-font-color: <?php echo esc_attr($mob_menu_font_color); ?>;
            --mob-menu-font: "<?php echo esc_js($mob_menu_font); ?>", sans-serif;

            --btn-bg: <?php echo esc_attr($btn_bg); ?>;
            --btn-text: <?php echo esc_attr($btn_text); ?>;
            --btn-hover-bg: <?php echo esc_attr($btn_hover_bg); ?>;
            --btn-hover-text: <?php echo esc_attr($btn_hover_text); ?>;

            --slider-btn-bg: <?php echo esc_attr($slider_btn_bg); ?>;
            --slider-btn-icon: <?php echo esc_attr($slider_btn_icon); ?>;
            --slider-btn-hover-bg: <?php echo esc_attr($slider_btn_hover_bg); ?>;
            --slider-btn-hover-icon: <?php echo esc_attr($slider_btn_hover_icon); ?>;
            --slider-btn-radius: <?php echo esc_attr($slider_btn_radius); ?>;

            --read-more-bg: <?php echo esc_attr($read_more_bg); ?>;
            --read-more-text: <?php echo esc_attr($read_more_text); ?>;
            --read-more-hover-bg: <?php echo esc_attr($read_more_hover_bg); ?>;
            --read-more-hover-text: <?php echo esc_attr($read_more_hover_text); ?>;
            --read-more-underline: <?php echo esc_attr($read_more_underline); ?>;
            --read-more-radius: <?php echo esc_attr($read_more_radius); ?>;

            --global-radius: <?php echo esc_attr($radius); ?>;
        }

        /* Global Color Override for Tailwind Config (via CSS Var) */
        .text-primary { color: var(--primary-color) !important; }
        .bg-primary { background-color: var(--primary-color) !important; }
        .border-primary { border-color: var(--primary-color) !important; }
        .hover\:bg-primary:hover { background-color: var(--primary-color) !important; }
        .focus\:ring-primary:focus { --tw-ring-color: var(--primary-color) !important; }

        body {
            background-color: var(--bg-body) !important;
        }

        /* Global Links */
        /* Applying to general content areas to avoid breaking specific navs */
        .content-area a:not(.btn):not(.button):not(.read-more-btn):not(.slider-nav-btn):not(.wp-block-button__link):not(.important-btn):not(.promo-btn),
        .entry-content a:not(.btn):not(.button):not(.read-more-btn):not(.slider-nav-btn):not(.wp-block-button__link):not(.important-btn):not(.promo-btn),
        .text-link {
            color: var(--global-link-color);
            transition: color 0.3s ease;
        }
        .content-area a:not(.btn):not(.button):not(.read-more-btn):not(.slider-nav-btn):not(.wp-block-button__link):not(.important-btn):not(.promo-btn):hover,
        .entry-content a:not(.btn):not(.button):not(.read-more-btn):not(.slider-nav-btn):not(.wp-block-button__link):not(.important-btn):not(.promo-btn):hover,
        .text-link:hover {
            color: var(--global-link-hover-color);
        }

        /* Global Radius Apply */
        .rounded-\[2rem\], .rounded-\[2\.5rem\], .rounded-2xl {
            border-radius: var(--global-radius) !important;
        }

        /* Container Width Apply */
        @media (min-width: 1024px) {
            .lg\:max-w-\[80\%\] {
                max-width: <?php echo esc_attr($width); ?> !important;
            }
        }

        /* Global Buttons */
        button, .button, input[type="button"], input[type="reset"], input[type="submit"], .wp-block-button__link {
            background-color: var(--btn-bg) !important;
            color: var(--btn-text) !important;
        }
        button:hover, .button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .wp-block-button__link:hover {
            background-color: var(--btn-hover-bg) !important;
            color: var(--btn-hover-text) !important;
        }

        /* Slider Navigation Buttons */
        .slider-nav-btn {
            background-color: var(--slider-btn-bg) !important;
            color: var(--slider-btn-icon) !important;
            border-radius: var(--slider-btn-radius) !important;
        }
        .slider-nav-btn:hover {
            background-color: var(--slider-btn-hover-bg) !important;
            color: var(--slider-btn-hover-icon) !important;
        }
        .slider-nav-btn span {
            color: inherit !important;
        }

        /* Read More / Details Buttons */
        .read-more-btn {
            background-color: var(--read-more-bg) !important;
            color: var(--read-more-text) !important;
            text-decoration: var(--read-more-underline) !important;
            border-radius: var(--read-more-radius) !important;
            padding: 0.5rem 1rem !important; /* py-2 px-4 */
        }
        .read-more-btn:hover {
            background-color: var(--read-more-hover-bg) !important;
            color: var(--read-more-hover-text) !important;
        }
        .read-more-btn span { /* For arrows */
             color: inherit !important;
        }

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
            background-color: <?php echo esc_attr(get_theme_mod('hero_primary_btn_bg_color', $btn_bg)); ?> !important;
            color: <?php echo esc_attr(get_theme_mod('hero_primary_btn_text_color', $btn_text)); ?> !important;
        }
        #hero-primary-btn:hover {
            background-color: <?php echo esc_attr(get_theme_mod('hero_primary_btn_hover_bg_color', $btn_hover_bg)); ?> !important;
        }

        /* Hero Secondary Button */
        #hero-secondary-btn {
            background-color: <?php echo esc_attr(get_theme_mod('hero_secondary_btn_bg_color', 'rgba(255, 255, 255, 0.1)')); ?> !important;
            color: <?php echo esc_attr(get_theme_mod('hero_secondary_btn_text_color', '#FFFFFF')); ?> !important;
        }
        #hero-secondary-btn:hover {
            background-color: <?php echo esc_attr(get_theme_mod('hero_secondary_btn_hover_bg_color', 'rgba(255, 255, 255, 0.2)')); ?> !important;
        }

        /* Promo Button */
        .promo-btn {
            background-color: <?php echo esc_attr(get_theme_mod('promo_btn_bg_color', $btn_bg)); ?> !important;
            color: <?php echo esc_attr(get_theme_mod('promo_btn_text_color', $btn_text)); ?> !important;
        }
        .promo-btn:hover {
            background-color: <?php echo esc_attr(get_theme_mod('promo_btn_hover_bg_color', $btn_hover_bg)); ?> !important;
        }

        /* Important Button */
        .important-btn {
            background-color: <?php echo esc_attr(get_theme_mod('important_btn_bg_color', $btn_bg)); ?> !important;
            color: <?php echo esc_attr(get_theme_mod('important_btn_text_color', $btn_text)); ?> !important;
        }
        .important-btn:hover {
            background-color: <?php echo esc_attr($btn_hover_bg); ?> !important; /* Fallback/Global Hover */
            opacity: 0.9;
        }

        /* Afisha Font */
        .afisha-custom-title {
            font-family: "<?php echo esc_js(get_theme_mod('afisha_font_family', 'Inter')); ?>", sans-serif !important;
        }

        /* Pagination Styling */
        .navigation.pagination {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
        }
        .nav-links {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        .page-numbers {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.5rem;
            border-radius: 0.5rem;
            background-color: #fff;
            color: var(--primary-color);
            font-weight: 600;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
            text-decoration: none;
        }
        .page-numbers:hover {
            background-color: var(--primary-color);
            color: #fff;
            border-color: var(--primary-color);
        }
        .page-numbers.current {
            background-color: var(--primary-color);
            color: #fff;
            border-color: var(--primary-color);
        }
        .page-numbers.dots {
            border: none;
            background: transparent;
            color: #64748b;
        }
    </style>
    <?php
}
add_action('wp_head', 'city_library_dynamic_styles');

/**
 * Add disableRemotePlayback to video tags to prevent local network scanning prompts.
 */
function city_library_disable_remote_playback() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var videos = document.querySelectorAll('video');
            videos.forEach(function(video) {
                video.setAttribute('disableRemotePlayback', '');
                video.setAttribute('controlsList', 'nodownload noremoteplayback');
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'city_library_disable_remote_playback');

/**
 * Output Schema.org JSON-LD structured data.
 */
function city_library_schema_json_ld() {
    $schema = [];

    if (is_front_page()) {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Library',
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'url' => home_url(),
            'logo' => get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => get_theme_mod('footer_address', ''),
                'addressLocality' => 'City', // Ideally dynamic
                'addressCountry' => 'RU'
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => get_theme_mod('footer_phone', ''),
                'contactType' => 'customer service'
            ]
        ];
    } elseif (is_single()) {
        global $post;
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => get_the_title(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => [
                '@type' => 'Person',
                'name' => get_the_author()
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : ''
                ]
            ],
            'description' => get_the_excerpt()
        ];
        if (has_post_thumbnail()) {
            $schema['image'] = [
                get_the_post_thumbnail_url($post->ID, 'full')
            ];
        }
    }

    if (!empty($schema)) {
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';
    }
}
add_action('wp_head', 'city_library_schema_json_ld');
