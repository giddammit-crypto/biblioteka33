<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

$search1 = "<?php echo esc_url(get_theme_mod('ai_librarian_avatar', get_template_directory_uri() . '/assets/images/ai-avatar.png')); ?>";
$replace1 = "<?php echo esc_url(get_city_library_ai_avatar_url()); ?>";

$content = str_replace($search1, $replace1, $content);

$search2 = "'avatar_url' => get_theme_mod('ai_librarian_avatar', get_template_directory_uri() . '/assets/images/ai-avatar.png')";
$replace2 = "'avatar_url' => get_city_library_ai_avatar_url()";

$content = str_replace($search2, $replace2, $content);

file_put_contents($file, $content);
