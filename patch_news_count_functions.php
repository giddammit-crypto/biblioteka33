<?php
$file = 'wp-content/themes/city-library/functions.php';
$content = file_get_contents($file);

// Find the start of the Layout section to insert News section before it
$search = "    // Layout Settings\n    \$wp_customize->add_section('layout_section', array(";

$replace = "    // News Settings
    \$wp_customize->add_section('news_section', array(
        'title'      => __('Новости', 'city-library'),
        'priority'   => 25,
    ));
    \$wp_customize->add_setting('news_count', array('default' => 8, 'sanitize_callback' => 'absint'));
    \$wp_customize->add_control('news_count', array(
        'label' => __('Количество карточек новостей', 'city-library'),
        'description' => __('Количество новостей на главной странице.', 'city-library'),
        'section' => 'news_section',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 48, 'step' => 1)
    ));

    // Layout Settings\n    \$wp_customize->add_section('layout_section', array(";

if (strpos($content, "'news_section'") === false) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully patched functions.php\n";
    } else {
        echo "Search string not found in functions.php\n";
    }
} else {
    echo "Already patched\n";
}
