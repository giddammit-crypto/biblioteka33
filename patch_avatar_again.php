<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

// Find the image model customizer to add avatar after it
$search = "    \$wp_customize->add_setting('ai_librarian_image_model_custom', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));\n    \$wp_customize->add_control('ai_librarian_image_model_custom', array(\n        'label' => __('Пользовательская модель изображений', 'city-library'),\n        'description' => __('Если выше выбрано \"Указать вручную\", впишите модель OpenRouter здесь.', 'city-library'),\n        'section' => 'voice_assistant_section',\n        'type' => 'text',\n    ));";

$replace = "    \$wp_customize->add_setting('ai_librarian_image_model_custom', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
    \$wp_customize->add_control('ai_librarian_image_model_custom', array(
        'label' => __('Пользовательская модель изображений', 'city-library'),
        'description' => __('Если выше выбрано \"Указать вручную\", впишите модель OpenRouter здесь.', 'city-library'),
        'section' => 'voice_assistant_section',
        'type' => 'text',
    ));

    // AI Avatar URL
    \$wp_customize->add_setting('ai_librarian_avatar', array(
        'default'           => get_template_directory_uri() . '/assets/images/ai-avatar.png',
        'sanitize_callback' => 'esc_url_raw',
    ));
    \$wp_customize->add_control(new WP_Customize_Image_Control(\$wp_customize, 'ai_librarian_avatar', array(
        'label'    => __('Аватар Виртуального Библиотекаря', 'city-library'),
        'section'  => 'virtual_librarian_section',
        'settings' => 'ai_librarian_avatar',
    )));";

if (strpos($content, "'ai_librarian_avatar'") === false) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully patched avatar settings in virtual-librarian.php\n";
    } else {
        echo "Search string not found in virtual-librarian.php\n";
    }
} else {
    echo "Already patched\n";
}
