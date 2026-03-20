<?php
$file = 'wp-content/themes/city-library/inc/virtual-librarian.php';
$content = file_get_contents($file);

$search1 = '<img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Nala&backgroundColor=0b7930&accessories=prescription02" alt="Avatar" class="w-full h-full object-cover">';
$search2 = '<img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Nala&backgroundColor=e2e8f0&accessories=prescription02" alt="AI Avatar" class="w-full h-full object-cover">';

$replace = '<img src="<?php echo esc_url(get_theme_mod(\'ai_librarian_avatar\', get_template_directory_uri() . \'/assets/images/ai-avatar.png\')); ?>" alt="Avatar" class="w-full h-full object-cover">';

$content = str_replace($search1, $replace, $content);
$content = str_replace($search2, $replace, $content);
file_put_contents($file, $content);
