<?php
/**
 * Settings API for Virtual Librarian Plugin
 */

if (!defined('ABSPATH')) exit;

class VL_Settings_API {

    public function init() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    public function enqueue_admin_assets($hook) {
        if ($hook !== 'toplevel_page_virtual-librarian-settings') return;
        wp_enqueue_style('vl-admin-settings', VL_PLUGIN_URL . 'assets/css/admin-settings.css', array(), VL_VERSION);
    }

    public function add_settings_page() {
        add_menu_page(
            'Virtual Librarian Settings',
            'ИИ Библиотекарь',
            'manage_options',
            'virtual-librarian-settings',
            array($this, 'render_settings_page'),
            'dashicons-book-alt',
            25
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

        // Sections mapped to tabs
        add_settings_section('vl_core_section', 'Основные настройки ИИ', null, 'virtual-librarian-settings-core');
        add_settings_section('vl_ui_section', 'Настройки интерфейса', null, 'virtual-librarian-settings-ui');
        add_settings_section('vl_voice_section', 'Голосовой ассистент', null, 'virtual-librarian-settings-voice');
        add_settings_section('vl_branches_section', 'Геолокация филиалов', null, 'virtual-librarian-settings-branches');

        // Fields: Core
        add_settings_field('vl_enable_ai', 'Включить ИИ Чат', array($this, 'render_checkbox'), 'virtual-librarian-settings-core', 'vl_core_section', array('name' => 'vl_enable_ai'));
        add_settings_field('vl_openrouter_api_key', 'OpenRouter API Key', array($this, 'render_text_field'), 'virtual-librarian-settings-core', 'vl_core_section', array('name' => 'vl_openrouter_api_key'));
        add_settings_field('vl_ai_model', 'Основная модель', array($this, 'render_text_field'), 'virtual-librarian-settings-core', 'vl_core_section', array('name' => 'vl_ai_model', 'default' => 'google/gemini-2.0-flash-001'));
        add_settings_field('vl_ai_persona_prompt', 'Системный промпт', array($this, 'render_textarea'), 'virtual-librarian-settings-core', 'vl_core_section', array('name' => 'vl_ai_persona_prompt'));

        // Fields: UI
        add_settings_field('vl_chat_theme', 'Тема чата', array($this, 'render_select_field'), 'virtual-librarian-settings-ui', 'vl_ui_section', array(
            'name' => 'vl_chat_theme',
            'options' => array('default' => 'Библиотека', 'vk' => 'VK Style', 'tg' => 'Telegram', 'wa' => 'WhatsApp', 'mac' => 'macOS')
        ));
        add_settings_field('vl_avatar_preset', 'Аватар', array($this, 'render_select_field'), 'virtual-librarian-settings-ui', 'vl_ui_section', array(
            'name' => 'vl_avatar_preset',
            'options' => array('default' => 'Женщина-Библиотекарь', 'preset2' => 'Мужчина-Библиотекарь', 'preset3' => 'Робот', 'custom' => 'Свой URL')
        ));

        // Fields: Voice
        add_settings_field('vl_enable_voice', 'Включить Голос', array($this, 'render_checkbox'), 'virtual-librarian-settings-voice', 'vl_voice_section', array('name' => 'vl_enable_voice'));
        add_settings_field('vl_voice_pitch', 'Тон (Pitch)', array($this, 'render_text_field'), 'virtual-librarian-settings-voice', 'vl_voice_section', array('name' => 'vl_voice_pitch', 'default' => '1.0'));

        // Fields: Branches
        $branches = array(
            'cgb' => 'ЦГБ (пр. Строителей, 16а)',
            'cdb' => 'ЦДБ (ул. Б. Московская, 31)',
        );
        for ($i = 1; $i <= 16; $i++) {
            if ($i == 12) continue; // Branch 12 is usually skipped in this library's numbering
            $branches[$i] = "Филиал №$i";
        }

        foreach ($branches as $key => $name) {
            add_settings_field(
                "vl_branch_address_$key",
                $name,
                array($this, 'render_text_field'),
                'virtual-librarian-settings-branches',
                'vl_branches_section',
                array('name' => "vl_branch_address_$key")
            );
        }
    }

    public function render_settings_page() {
        ?>
        <div class="wrap vl-settings-wrap">

            <div class="vl-admin-card vl-header-card">
                <div class="vl-flex-between">
                    <div class="vl-flex-center gap-20">
                        <div class="vl-icon-box">
                            <img src="<?php echo VL_PLUGIN_URL . 'assets/images/logo.png'; ?>" alt="Logo" style="width: 64px; height: 64px; object-fit: contain;">
                        </div>
                        <div>
                            <h1>Виртуальный библиотекарь</h1>
                            <div class="vl-flex-center gap-10 mt-5">
                                <span class="vl-status-badge">v<?php echo VL_VERSION; ?></span>
                                <span class="vl-status-badge" style="background: #f0f9ff; color: #0369a1;">Stable</span>
                            </div>
                        </div>
                    </div>
                    <div class="vl-header-actions">
                        <a href="<?php echo home_url(); ?>" target="_blank" class="vl-btn-secondary">🏠 Перейти на сайт</a>
                    </div>
                </div>
            </div>

            <div class="vl-layout-grid">
                <!-- Sidebar Nav -->
                <div class="vl-sidebar-nav">
                    <div class="vl-nav-inner">
                        <button class="vl-nav-item active" onclick="switchTab(event, 'core')">
                            <span class="dashicons dashicons-admin-generic"></span> Основные
                        </button>
                        <button class="vl-nav-item" onclick="switchTab(event, 'ui')">
                            <span class="dashicons dashicons-admin-appearance"></span> Интерфейс
                        </button>
                        <button class="vl-nav-item" onclick="switchTab(event, 'voice')">
                            <span class="dashicons dashicons-microphone"></span> Голос
                        </button>
                        <button class="vl-nav-item" onclick="switchTab(event, 'branches')">
                            <span class="dashicons dashicons-location"></span> Филиалы
                        </button>
                        <div class="vl-nav-divider"></div>
                        <button class="vl-nav-item" onclick="switchTab(event, 'system')">
                            <span class="dashicons dashicons-performance"></span> Система
                        </button>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="vl-main-content">
                    <form action="options.php" method="POST">
                        <?php settings_fields('vl_settings_group'); ?>

                        <div id="tab-core" class="vl-tab-pane active">
                            <div class="vl-section-header">
                                <h2>Параметры ИИ</h2>
                                <p>Настройте соединение с OpenRouter и системные промпты.</p>
                            </div>
                            <?php do_settings_sections('virtual-librarian-settings-core'); ?>
                        </div>

                        <div id="tab-ui" class="vl-tab-pane">
                            <div class="vl-section-header">
                                <h2>Визуальное оформление</h2>
                                <p>Персонализируйте внешний вид чата и аватара.</p>
                            </div>
                            <?php do_settings_sections('virtual-librarian-settings-ui'); ?>
                        </div>

                        <div id="tab-voice" class="vl-tab-pane">
                            <div class="vl-section-header">
                                <h2>Голосовое управление</h2>
                                <p>Настройка синтеза и распознавания речи.</p>
                            </div>
                            <?php do_settings_sections('virtual-librarian-settings-voice'); ?>
                        </div>

                        <div id="tab-branches" class="vl-tab-pane">
                            <div class="vl-section-header">
                                <h2>Филиалы и Геолокация</h2>
                                <p>Адреса для автоматического построения маршрутов.</p>
                            </div>
                            <?php do_settings_sections('virtual-librarian-settings-branches'); ?>
                        </div>

                        <div id="tab-system" class="vl-tab-pane">
                            <div class="vl-section-header">
                                <h2>Системные данные</h2>
                                <p>Отладка и состояние синхронизации.</p>
                            </div>
                            <div class="vl-stats-grid">
                                <div class="vl-stat-card">
                                    <span class="vl-stat-label">Последняя синхронизация</span>
                                    <span class="vl-stat-value"><?php echo get_option('vl_ai_knowledge_last_sync', 'Никогда'); ?></span>
                                </div>
                                <div class="vl-stat-card">
                                    <span class="vl-stat-label">Записей в базе знаний</span>
                                    <span class="vl-stat-value"><?php echo count((array)get_option('vl_ai_knowledge', [])); ?></span>
                                </div>
                            </div>
                            <div style="margin-top: 30px;">
                                <button type="button" id="vl-sync-now" class="vl-btn-secondary" style="cursor: pointer; border: 1px solid #e2e8f0;">📍 Запустить синхронизацию Базы Знаний</button>
                                <p class="description" style="margin-top: 10px;">Принудительно сканирует сайт biblioteka33.ru для обновления данных о филиалах.</p>
                            </div>

                            <script>
                                jQuery(document).ready(function($) {
                                    $('#vl-sync-now').on('click', function() {
                                        const btn = $(this);
                                        btn.text('⌛ Синхронизация...').prop('disabled', true);
                                        $.post(ajaxurl, { action: 'vl_sync_kb', _wpnonce: '<?php echo wp_create_nonce("vl_sync_nonce"); ?>' }, function(response) {
                                            if (response.success) {
                                                alert('Синхронизация успешно завершена!');
                                                location.reload();
                                            } else {
                                                alert('Ошибка синхронизации: ' + response.data);
                                                btn.text('📍 Запустить синхронизацию').prop('disabled', false);
                                            }
                                        });
                                    });
                                });
                            </script>
                        </div>

                        <div class="vl-form-footer">
                            <?php submit_button('Сохранить изменения', 'primary large'); ?>
                        </div>
                    </form>
                </div>
            </div>


            <script>
                function switchTab(evt, tabName) {
                    const panes = document.querySelectorAll('.vl-tab-pane');
                    const items = document.querySelectorAll('.vl-nav-item');
                    panes.forEach(p => p.classList.remove('active'));
                    items.forEach(i => i.classList.remove('active'));
                    document.getElementById('tab-' + tabName).classList.add('active');
                    evt.currentTarget.classList.add('active');
                }
            </script>
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

// Instantiation is now handled in virtual-librarian.php
