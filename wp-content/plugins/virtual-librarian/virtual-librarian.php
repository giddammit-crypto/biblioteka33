<?php
/**
 * Plugin Name: Virtual Librarian
 * Plugin URI: https://github.com/giddammit-crypto/biblioteka33
 * Description: AI-powered Chatbot and Voice Assistant for City Library, extracted from the main theme.
 * Version: 1.0.0
 * Author: Jules
 * Text Domain: virtual-librarian
 * Domain Path: /languages
 * Requires PHP: 8.0
 * Requires at least: 6.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('VIRTUAL_LIBRARIAN_VERSION', '1.0.0');
define('VIRTUAL_LIBRARIAN_PATH', plugin_dir_path(__FILE__));
define('VIRTUAL_LIBRARIAN_URL', plugin_dir_url(__FILE__));

require_once VIRTUAL_LIBRARIAN_PATH . 'includes/class-virtual-librarian.php';
require_once VIRTUAL_LIBRARIAN_PATH . 'includes/ajax-handler.php';
require_once VIRTUAL_LIBRARIAN_PATH . 'includes/settings.php';

function virtual_librarian_init() {
    $plugin = new Virtual_Librarian();
    $plugin->run();
}
add_action('plugins_loaded', 'virtual_librarian_init');

// Activation Migration Logic
function virtual_librarian_activate() {
    if (get_option('vl_migrated_from_theme')) return;

    $mods = get_option('theme_mods_city-library');
    if (!$mods) return;

    $map = [
        'enable_ai_librarian' => 'vl_enable_ai_librarian',
        'openrouter_api_key' => 'vl_openrouter_api_key',
        'ai_librarian_model' => 'vl_ai_librarian_model',
        'enable_voice_control' => 'vl_enable_voice_control',
        'voice_pitch' => 'vl_voice_pitch',
        'voice_rate' => 'vl_voice_rate',
        'ai_persona_prompt' => 'vl_ai_persona_prompt'
    ];

    foreach ($map as $theme_key => $plugin_key) {
        if (isset($mods[$theme_key])) {
            $val = $mods[$theme_key];
            if (is_bool($val)) $val = $val ? 'yes' : 'no';
            update_option($plugin_key, $val);
        }
    }

    update_option('vl_migrated_from_theme', true);
}
register_activation_hook(__FILE__, 'virtual_librarian_activate');
