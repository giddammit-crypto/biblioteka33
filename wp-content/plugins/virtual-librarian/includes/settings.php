<?php
/**
 * Admin Settings Page for Virtual Librarian
 */

if (!defined('ABSPATH')) exit;

class Virtual_Librarian_Settings {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_settings_page() {
        add_options_page('Virtual Librarian', 'Virtual Librarian', 'manage_options', 'virtual-librarian', array($this, 'render_settings_page'));
    }

    public function register_settings() {
        $settings = [
            'vl_enable_ai_librarian', 'vl_ai_librarian_test_mode', 'vl_openrouter_api_key', 'vl_ai_librarian_model',
            'vl_ai_librarian_model_fallback', 'vl_ai_chat_theme', 'vl_ai_librarian_avatar_preset', 'vl_ai_librarian_avatar',
            'vl_ai_librarian_kb_ids', 'vl_ai_persona_prompt', 'vl_ai_persona_prompt_extra', 'vl_enable_voice_control',
            'vl_voice_control_test_mode', 'vl_voice_pitch', 'vl_voice_rate', 'vl_feedback_email'
        ];
        foreach ($settings as $s) register_setting('vl_group', $s);

        for ($i = 1; $i <= 20; $i++) {
            register_setting('vl_group', "vl_voice_cmd_phrases_$i");
            register_setting('vl_group', "vl_voice_cmd_url_$i");
        }
        $branch_keys = array('cgb', 'cdb', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '13', '14', '15', '16');
        foreach ($branch_keys as $key) register_setting('vl_group', "vl_branch_address_$key");
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Virtual Librarian Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('vl_group'); ?>
                <h2 class="title">General Settings</h2>
                <table class="form-table">
                    <tr><th>Enable AI Librarian</th><td><input type="checkbox" name="vl_enable_ai_librarian" value="yes" <?php checked(get_option('vl_enable_ai_librarian'), 'yes'); ?> /></td></tr>
                    <tr><th>OpenRouter API Key</th><td><input type="text" name="vl_openrouter_api_key" value="<?php echo esc_attr(get_option('vl_openrouter_api_key')); ?>" class="regular-text" /></td></tr>
                </table>
                <h2 class="title">AI Models</h2>
                <table class="form-table">
                    <tr><th>Primary Model</th><td><input type="text" name="vl_ai_librarian_model" value="<?php echo esc_attr(get_option('vl_ai_librarian_model', 'google/gemini-2.5-flash-lite')); ?>" class="regular-text" /></td></tr>
                    <tr><th>Fallback Model</th><td><input type="text" name="vl_ai_librarian_model_fallback" value="<?php echo esc_attr(get_option('vl_ai_librarian_model_fallback', 'google/gemini-3.1-flash-lite-preview')); ?>" class="regular-text" /></td></tr>
                </table>
                <h2 class="title">Voice Assistant</h2>
                <table class="form-table">
                    <tr><th>Enable Voice Control</th><td><input type="checkbox" name="vl_enable_voice_control" value="yes" <?php checked(get_option('vl_enable_voice_control'), 'yes'); ?> /></td></tr>
                    <tr><th>Voice Pitch</th><td><input type="text" name="vl_voice_pitch" value="<?php echo esc_attr(get_option('vl_voice_pitch', '1.0')); ?>" class="small-text" /></td></tr>
                    <tr><th>Voice Rate</th><td><input type="text" name="vl_voice_rate" value="<?php echo esc_attr(get_option('vl_voice_rate', '1.05')); ?>" class="small-text" /></td></tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
new Virtual_Librarian_Settings();
