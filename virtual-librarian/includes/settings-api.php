<?php
/**
 * Settings API for Virtual Librarian Plugin
 */

if (!defined('ABSPATH')) exit;

class VL_Settings_API {

    public function init() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_settings_page() {
        add_options_page(
            'Virtual Librarian Settings',
            'Виртуальный библиотекарь',
            'manage_options',
            'virtual-librarian-settings',
            array($this, 'render_settings_page')
        );
    }

    public function register_settings() {
        $settings = array(
            'vl_openrouter_api_key', 'vl_ai_model', 'vl_ai_model_fallback', 'vl_ai_image_model',
            'vl_ai_test_mode', 'vl_enable_ai', 'vl_enable_voice', 'vl_voice_test_mode',
            'vl_ai_persona_prompt', 'vl_ai_persona_prompt_extra', 'vl_chat_theme',
            'vl_avatar_preset', 'vl_avatar_custom_url', 'vl_voice_pitch', 'vl_voice_rate'
        );

        foreach ($settings as $setting) {
            register_setting('vl_settings_group', $setting);
        }

        // Branch addresses
        $branches = array('cgb', 'cdb', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '13', '14', '15', '16');
        foreach ($branches as $key) {
            register_setting('vl_settings_group', "vl_branch_address_$key");
        }

        // Custom Commands
        for ($i = 1; $i <= 20; $i++) {
            register_setting('vl_settings_group', "vl_voice_cmd_phrases_$i");
            register_setting('vl_settings_group', "vl_voice_cmd_url_$i");
        }

        // Sections
        add_settings_section('vl_core_section', 'Основные настройки ИИ', null, 'virtual-librarian-settings');
        add_settings_section('vl_ui_section', 'Настройки интерфейса', null, 'virtual-librarian-settings');
        add_settings_section('vl_voice_section', 'Голосовой ассистент', null, 'virtual-librarian-settings');
        add_settings_section('vl_branches_section', 'Геолокация филиалов', null, 'virtual-librarian-settings');

        // Fields: Core
        add_settings_field('vl_enable_ai', 'Включить ИИ Чат', array($this, 'render_checkbox'), 'virtual-librarian-settings', 'vl_core_section', array('name' => 'vl_enable_ai'));
        add_settings_field('vl_openrouter_api_key', 'OpenRouter API Key', array($this, 'render_text_field'), 'virtual-librarian-settings', 'vl_core_section', array('name' => 'vl_openrouter_api_key'));
        add_settings_field('vl_ai_model', 'Основная модель', array($this, 'render_text_field'), 'virtual-librarian-settings', 'vl_core_section', array('name' => 'vl_ai_model', 'default' => 'google/gemini-2.0-flash-001'));
        add_settings_field('vl_ai_persona_prompt', 'Системный промпт', array($this, 'render_textarea'), 'virtual-librarian-settings', 'vl_core_section', array('name' => 'vl_ai_persona_prompt'));

        // Fields: UI
        add_settings_field('vl_chat_theme', 'Тема чата', array($this, 'render_select_field'), 'virtual-librarian-settings', 'vl_ui_section', array(
            'name' => 'vl_chat_theme',
            'options' => array('default' => 'Библиотека', 'vk' => 'VK Style', 'tg' => 'Telegram', 'wa' => 'WhatsApp', 'mac' => 'macOS')
        ));
        add_settings_field('vl_avatar_preset', 'Аватар', array($this, 'render_select_field'), 'virtual-librarian-settings', 'vl_ui_section', array(
            'name' => 'vl_avatar_preset',
            'options' => array('default' => 'Женщина-Библиотекарь', 'preset2' => 'Мужчина-Библиотекарь', 'preset3' => 'Робот', 'custom' => 'Свой URL')
        ));

        // Fields: Voice
        add_settings_field('vl_enable_voice', 'Включить Голос', array($this, 'render_checkbox'), 'virtual-librarian-settings', 'vl_voice_section', array('name' => 'vl_enable_voice'));
        add_settings_field('vl_voice_pitch', 'Тон (Pitch)', array($this, 'render_text_field'), 'virtual-librarian-settings', 'vl_voice_section', array('name' => 'vl_voice_pitch', 'default' => '1.0'));
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Настройки Виртуального библиотекаря</h1>
            <form action="options.php" method="POST">
                <?php settings_fields('vl_settings_group'); ?>
                <?php do_settings_sections('virtual-librarian-settings'); ?>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function render_text_field($args) {
        $val = get_option($args['name'], $args['default'] ?? '');
        echo '<input type="text" name="' . esc_attr($args['name']) . '" value="' . esc_attr($val) . '" class="regular-text">';
    }

    public function render_checkbox($args) {
        $val = get_option($args['name'], 'no');
        echo '<input type="checkbox" name="' . esc_attr($args['name']) . '" value="yes" ' . checked($val, 'yes', false) . '>';
    }

    public function render_textarea($args) {
        $val = get_option($args['name'], '');
        echo '<textarea name="' . esc_attr($args['name']) . '" rows="5" class="large-text">' . esc_textarea($val) . '</textarea>';
    }

    public function render_select_field($args) {
        $val = get_option($args['name'], 'default');
        echo '<select name="' . esc_attr($args['name']) . '">';
        foreach ($args['options'] as $key => $label) {
            echo '<option value="' . esc_attr($key) . '" ' . selected($val, $key, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
    }
}

new VL_Settings_API();
