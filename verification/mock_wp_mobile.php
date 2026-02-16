<?php
// Mock WP functions for Mobile Test
function language_attributes() { echo 'lang="ru-RU"'; }
function bloginfo($show='') { echo 'City Library'; }
function wp_head() {
    // Add local fallback styles for critical verification
    echo '<style>
        .fixed { position: fixed; }
        .bottom-0 { bottom: 0; }
        .left-0 { left: 0; }
        .w-full { width: 100%; }
        .bg-white\/95 { background-color: rgba(255, 255, 255, 0.95); }
        .z-50 { z-index: 50; }
        .flex { display: flex; }
        .grid { display: grid; }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .h-16 { height: 4rem; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .flex-col { flex-direction: column; }
        @media (min-width: 768px) {
            .md\:hidden { display: none; }
        }
    </style>';
}
function body_class($class='') { echo 'class="' . $class . '"'; }
function wp_body_open() { }
function esc_html__($text, $domain='default') { return $text; }
function __($text, $domain='default') { return $text; }
function esc_attr_e($text, $domain='default') { echo $text; }
function esc_html_e($text, $domain='default') { echo $text; }
function esc_html($text) { return htmlspecialchars($text); }
function esc_attr($text) { return htmlspecialchars($text); }
function get_theme_mod($name, $default=false) { return $default; }
function has_custom_logo() { return false; }
function the_custom_logo() { }
function wp_nav_menu($args) { echo '<ul class="flex space-x-4"><li><a href="#">Home</a></li><li><a href="#">About</a></li></ul>'; }
function _e($text, $domain='default') { echo $text; }
function esc_url($url) { return $url; }
function esc_url_raw($url) { return $url; }
function home_url($path='') { return '/' . $path; }
function get_template_directory_uri() { return '.'; }
function wp_kses_post($text) { return $text; }
function city_library_get_animation_class() { return ''; }

// Mock Walker
class City_Library_Walker_Nav_Menu {
    function walk($elements, $max_depth) { return ''; }
}
