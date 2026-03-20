<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

$search = "    wp_localize_script('city-library-ai-chat', 'cl_ai_ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ai_chat_nonce')
    ));";

$replace = "    wp_localize_script('city-library-ai-chat', 'cl_ai_ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ai_chat_nonce'),
        'avatar_url' => get_theme_mod('ai_librarian_avatar', get_template_directory_uri() . '/assets/images/ai-avatar.png')
    ));";

if (strpos($content, "'avatar_url'") === false) {
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully patched localized variables in virtual-librarian.php\n";
    } else {
        echo "Search string not found in localized variables\n";
    }
} else {
    echo "Already patched\n";
}
