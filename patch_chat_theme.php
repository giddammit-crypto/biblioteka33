<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

$search = "    // AI Avatar URL\n    \$wp_customize->add_setting('ai_librarian_avatar', array(\n        'default'           => get_template_directory_uri() . '/assets/images/ai-avatar.png',\n        'sanitize_callback' => 'esc_url_raw',\n    ));";

$replace = "    // Chat Theme Selection
    \$wp_customize->add_setting('ai_chat_theme', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    \$wp_customize->add_control('ai_chat_theme', array(
        'label'    => __('Стиль чата', 'city-library'),
        'section'  => 'virtual_librarian_section',
        'type'     => 'select',
        'choices'  => array(
            'default' => 'Библиотека (по умолчанию)',
            'vk'      => 'ВКонтакте (VK Style)',
            'tg'      => 'Telegram (Светлый)',
            'wa'      => 'WhatsApp (Классика)',
            'mac'     => 'macOS (iMessage)'
        ),
    ));

    // AI Avatar URL
    \$wp_customize->add_setting('ai_librarian_avatar', array(
        'default'           => get_template_directory_uri() . '/assets/images/ai-avatar.png',
        'sanitize_callback' => 'esc_url_raw',
    ));";

if (strpos($content, "'ai_chat_theme'") === false) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully added Chat Theme customizer.\n";
    } else {
        echo "Search string not found.\n";
    }
} else {
    echo "Already patched.\n";
}
