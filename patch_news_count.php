<?php
$file = 'wp-content/themes/city-library/functions.php';
$content = file_get_contents($file);

$search1 = <<<'PHP'
    $wp_customize->add_section('colors', array(
        'title'      => __('Цвета и Фон', 'city-library'),
        'priority'   => 40,
    ));
PHP;

$replace1 = <<<'PHP'
    $wp_customize->add_section('news_section', array(
        'title'      => __('Новости', 'city-library'),
        'priority'   => 35,
    ));

    $wp_customize->add_setting('news_count', array('default' => 8, 'sanitize_callback' => 'absint'));
    $wp_customize->add_control('news_count', array(
        'label' => __('Количество карточек новостей', 'city-library'),
        'description' => __('Количество новостей на главной странице.', 'city-library'),
        'section' => 'news_section',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 48, 'step' => 1)
    ));

    $wp_customize->add_section('colors', array(
        'title'      => __('Цвета и Фон', 'city-library'),
        'priority'   => 40,
    ));
PHP;

$content = str_replace($search1, $replace1, $content);
file_put_contents($file, $content);
