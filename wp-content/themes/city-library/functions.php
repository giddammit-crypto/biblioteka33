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
    wp_enqueue_style('city-library-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@400;700&display=swap', array(), null);

    // Material Symbols
    wp_enqueue_style('material-symbols', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0', array(), null);

    // Tailwind CSS
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com?plugins=forms,typography', array(), null, false);

    // Custom JS files
    wp_enqueue_script('city-library-dark-mode', get_template_directory_uri() . '/js/dark-mode.js', array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-sidebar-toggle', get_template_directory_uri() . '/js/sidebar-toggle.js', array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-view-toggle', get_template_directory_uri() . '/js/view-toggle.js', array('jquery'), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-back-to-top', get_template_directory_uri() . '/js/back-to-top.js', array(), wp_get_theme()->get('Version'), true);
    wp_enqueue_script('city-library-accessibility', get_template_directory_uri() . '/js/accessibility.js', array(), wp_get_theme()->get('Version'), true);

    wp_localize_script('city-library-view-toggle', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'city_library_scripts');

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
}
add_action('customize_register', 'city_library_customize_register');


/**
 * Custom Walker for Nav Menu to apply Tailwind classes.
 */
class City_Library_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = 'text-sm font-semibold hover:text-primary transition-colors';
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
                        display: "Inter",
                        sans: ["Montserrat", "sans-serif"]
                    },
                }
            }
        }
    </script>
    <?php
}
add_action('wp_head', 'city_library_tailwind_config', 1);
