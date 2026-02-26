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

    $wp_customize->add_setting('footer_map_lat', array('default' => '56.129057', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('footer_map_lat', array(
        'label' => __('Широта (Latitude)', 'city-library'),
        'section' => 'footer_map_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('footer_map_lon', array('default' => '40.406635', 'sanitize_callback' => 'sanitize_text_field'));
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
