<?php
/**
 * Plugin Name: Virtual Librarian
 * Plugin URI: https://github.com/giddammit-crypto/biblioteka33
 * Description: AI Chatbot and Voice Assistant for WordPress libraries.
 * Version: 1.0.0
 * Author: City Library Team
 * Text Domain: virtual-librarian
 * Domain Path: /languages
 * Requires PHP: 8.1
 * Requires at least: 6.4
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('VL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('VL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('VL_VERSION', '1.0.0');

// Autoload (or direct require) core files
require_once VL_PLUGIN_DIR . 'includes/class-virtual-librarian.php';
require_once VL_PLUGIN_DIR . 'includes/ajax-handler.php';
require_once VL_PLUGIN_DIR . 'includes/settings-api.php';
require_once VL_PLUGIN_DIR . 'includes/voice-engine.php';

/**
 * Initialize the plugin
 */
function vl_init_plugin() {
    $plugin = new Virtual_Librarian();
    $plugin->init();
}
add_action('plugins_loaded', 'vl_init_plugin');
