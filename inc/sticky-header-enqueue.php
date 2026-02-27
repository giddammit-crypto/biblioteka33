<?php
// Enqueue sticky header script
wp_enqueue_script('city-library-sticky-header', get_template_directory_uri() . '/js/sticky-header.js', array(), wp_get_theme()->get('Version'), true);

// Enqueue sticky header styles (can also be in style.css, but separate file requested in plan/implied by structure)
// Actually, let's put it in style.css or inline. I created css/sticky-header.css, need to enqueue it or inline it.
// I'll inline it via wp_add_inline_style to avoid extra request if file is small.
$sticky_css = file_get_contents(get_template_directory() . '/css/sticky-header.css');
if ($sticky_css) {
    wp_add_inline_style('city-library-style', $sticky_css);
}
?>
