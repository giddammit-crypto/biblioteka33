<?php
require_once 'verification/mock_wp_mobile.php';
// Mock get_template_part since we can't fully load WP
function get_template_part($slug, $name = null) {
    if ($slug === 'template-parts/mobile-bottom-nav') {
        include 'wp-content/themes/city-library/template-parts/mobile-bottom-nav.php';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body class="bg-gray-100 h-screen">
    <div class="p-4">
        <h1 class="text-2xl">Mobile Content Area</h1>
        <p>Scroll down...</p>
        <div class="h-[200vh]">Spacer</div>
    </div>

    <?php get_template_part('template-parts/mobile-bottom-nav'); ?>
</body>
</html>
