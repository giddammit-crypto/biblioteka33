<?php
/**
 * City Library Branches Map Shortcode
 *
 * Usage: [city_library_branches_map]
 */

function city_library_branches_map_shortcode($atts) {
    $atts = shortcode_atts(array(
        'height' => '500px',
        'zoom' => '12',
    ), $atts);

    // Hardcoded Branches Data (Basis for future DB integration)
    $branches = array(
        array('coords' => [56.162458, 40.470598], 'name' => 'Центральная городская библиотека', 'address' => 'Суздальский пр-т, 2', 'phone' => '21-68-27'),
        array('coords' => [56.129057, 40.406635], 'name' => 'Центральная детская библиотека', 'address' => 'ул. Большая Московская, 31', 'phone' => '32-47-97'),
        array('coords' => [56.126485, 40.396951], 'name' => 'Филиал № 1 (Детский)', 'address' => 'ул. Гагарина, 2', 'phone' => '32-47-97'), // Example placeholder coords
        array('coords' => [56.110756, 40.353347], 'name' => 'Филиал № 2 (Экологическая библиотека)', 'address' => 'пр-т Ленина, 65', 'phone' => '54-32-10'),
        array('coords' => [56.147985, 40.442953], 'name' => 'Филиал № 4 (Историко-краеведческая)', 'address' => 'ул. Комиссарова, 9', 'phone' => '21-68-27'),
        // ... Add more branches here or fetch from options
    );

    // Enqueue Yandex API if not already
    wp_enqueue_script('yandex-maps-api', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU', array(), null, true);

    // Register & Enqueue Map Script
    wp_register_script('city-library-branches-map', get_template_directory_uri() . '/js/branches-map.js', array('yandex-maps-api'), '1.0', true);
    wp_localize_script('city-library-branches-map', 'branches_map_data', array(
        'branches' => $branches,
        'center' => [56.145, 40.405], // Approximate center of Vladimir
        'zoom' => intval($atts['zoom'])
    ));
    wp_enqueue_script('city-library-branches-map');

    $output = '<div id="branches-yandex-map" style="width: 100%; height: ' . esc_attr($atts['height']) . '; background: #f0f0f0; border-radius: 1rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>';

    return $output;
}
add_shortcode('city_library_branches_map', 'city_library_branches_map_shortcode');
