<?php
/**
 * Core Plugin Class
 */

if (!defined('ABSPATH')) exit;

class Virtual_Librarian {

    public function init() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('wp_footer', array($this, 'render_widget'));
        add_shortcode('vl_chatbot', array($this, 'chatbot_shortcode'));

        add_action('vl_daily_cron', array($this, 'sync_knowledge_base'));
        if (!wp_next_scheduled('vl_daily_cron')) {
            wp_schedule_event(time(), 'daily', 'vl_daily_cron');
        }
    }

    public function enqueue_assets() {
        if (get_option('vl_enable_ai', 'yes') !== 'yes') return;

        $test_mode = get_option('vl_ai_test_mode', 'no') === 'yes';
        if ($test_mode && !is_user_logged_in() && !$this->has_valid_test_cookie()) return;

        wp_enqueue_script('marked-js', 'https://cdn.jsdelivr.net/npm/marked/marked.min.js', array(), null, true);
        wp_enqueue_script('pdf-js', 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js', array(), null, true);
        wp_enqueue_style('vl-chatbot-style', VL_PLUGIN_URL . 'assets/css/virtual-librarian.min.css', array(), VL_VERSION);
        wp_enqueue_script('vl-chatbot-js', VL_PLUGIN_URL . 'assets/js/virtual-librarian.min.js', array('jquery', 'marked-js', 'pdf-js'), VL_VERSION, true);

        wp_localize_script('vl-chatbot-js', 'vl_chat_data', array(
            'ajax_url'   => admin_url('admin-ajax.php'),
            'nonce'      => wp_create_nonce('vl_chat_nonce'),
            'avatar_url' => self::get_avatar_url(),
            'user_name'  => is_user_logged_in() ? wp_get_current_user()->display_name : 'Гость',
            'is_logged_in' => is_user_logged_in()
        ));

        if (get_option('vl_enable_voice', 'no') === 'yes') {
            wp_enqueue_script('vl-voice-js', VL_PLUGIN_URL . 'assets/js/voice-assistant.min.js', array('jquery'), VL_VERSION, true);
            wp_localize_script('vl-voice-js', 'vl_voice_data', array(
                'ajax_url'   => admin_url('admin-ajax.php'),
                'nonce'      => wp_create_nonce('vl_voice_nonce'),
                'ai_nonce'   => wp_create_nonce('vl_chat_nonce'),
                'home_url'   => home_url(),
                'test_mode'  => get_option('vl_voice_test_mode', 'no') === 'yes',
                'is_logged_in' => is_user_logged_in(),
                'voice_pitch' => get_option('vl_voice_pitch', '1.0'),
                'voice_rate'  => get_option('vl_voice_rate', '1.05'),
                'branch_addresses' => $this->get_branch_addresses(),
                'custom_commands'  => $this->get_custom_voice_commands()
            ));
        }
    }

    public function render_widget() {
        if (get_option('vl_enable_ai', 'yes') !== 'yes') return;
        $test_mode = get_option('vl_ai_test_mode', 'no') === 'yes';
        if ($test_mode && !is_user_logged_in() && !$this->has_valid_test_cookie()) return;

        include VL_PLUGIN_DIR . 'templates/chatbot-ui.php';
        if (get_option('vl_enable_voice', 'no') === 'yes') {
            include VL_PLUGIN_DIR . 'templates/voice-modals.php';
        }
    }

    public function chatbot_shortcode($atts) {
        ob_start();
        $this->render_widget();
        return ob_get_clean();
    }

    public static function get_avatar_url() {
        $preset = get_option('vl_avatar_preset', 'default');
        $custom = get_option('vl_avatar_custom_url', '');
        if ($preset === 'custom' && !empty($custom)) return esc_url($custom);
        switch ($preset) {
            case 'preset2': return 'https://api.dicebear.com/7.x/avataaars/svg?seed=Jasper&backgroundColor=0b7930';
            case 'preset3': return 'https://api.dicebear.com/7.x/bottts/svg?seed=LibraryBot&backgroundColor=0b7930';
            default: return 'https://api.dicebear.com/7.x/avataaars/svg?seed=Avery&backgroundColor=0b7930';
        }
    }

    private function has_valid_test_cookie() {
        return isset($_COOKIE['cl_voice_test_active']) && (int)$_COOKIE['cl_voice_test_active'] > (time() * 1000);
    }

    private function get_branch_addresses() {
        $branches = array('cgb', 'cdb', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '13', '14', '15', '16');
        $addresses = array();
        foreach ($branches as $key) $addresses[$key] = get_option("vl_branch_address_$key", '');
        return $addresses;
    }

    private function get_custom_voice_commands() {
        $commands = array();
        for ($i = 1; $i <= 20; $i++) {
            $phrases = get_option("vl_voice_cmd_phrases_$i", '');
            $url = get_option("vl_voice_cmd_url_$i", '');
            if (!empty($phrases) && !empty($url)) $commands[] = array('phrases' => array_map('trim', explode(',', $phrases)), 'url' => esc_url_raw($url));
        }
        return $commands;
    }

    public function sync_knowledge_base() {
        $url = 'https://biblioteka33.ru/?p=19379';
        $response = wp_remote_get($url, array('timeout' => 30));

        if (is_wp_error($response)) return;

        $html = wp_remote_retrieve_body($response);
        if (empty($html)) return;

        // Extract structured data using regex
        $knowledge = array();
        $addresses = array();

        // Unified pattern for branches: either <h3> or <strong> followed by address/phone info
        preg_match_all('/<(h3|strong)[^>]*>(.*?)<\/(h3|strong)>(.*?)<hr/s', $html, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $name = trim(strip_tags($match[2]));
            $content = $match[4];

            $branch_info = array('name' => $name);

            // Detailed patterns to capture address, phone, schedule
            if (preg_match('/Адрес:\s*(.*?)(?:<br|<\/p|&nbsp;)/i', $content, $addr)) {
                $branch_info['address'] = trim(strip_tags($addr[1]));
                $addresses[] = $branch_info['address'];
            }
            if (preg_match('/Телефон:\s*(.*?)(?:<br|<\/p)/i', $content, $phone)) {
                $branch_info['phone'] = trim(strip_tags($phone[1]));
            }
            if (preg_match('/Режим работы:\s*(.*?)(?:<br|<\/p)/i', $content, $hours)) {
                $branch_info['hours'] = trim(strip_tags($hours[1]));
            }
            if (preg_match('/href="(https:\/\/vk\.com\/.*?)"/i', $content, $vk)) {
                $branch_info['vk'] = $vk[1];
            }

            $knowledge[] = $branch_info;
        }

        update_option('vl_ai_knowledge', $knowledge);
        update_option('vl_ai_extracted_addresses', $addresses);
        update_option('vl_ai_knowledge_last_sync', current_time('mysql'));
    }
}
