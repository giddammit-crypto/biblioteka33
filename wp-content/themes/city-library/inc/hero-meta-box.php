<?php
/**
 * Custom Meta Boxes for Post/Page specific Hero Section customization.
 */

// Register the Meta Box
function city_library_add_hero_meta_box() {
    $screens = ['post', 'page'];
    foreach ($screens as $screen) {
        add_meta_box(
            'city_library_hero_box_id',
            __('Настройки Hero секции (Главного экрана)', 'city-library'),
            'city_library_hero_meta_box_html',
            $screen,
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'city_library_add_hero_meta_box');

// Render the Meta Box HTML
function city_library_hero_meta_box_html($post) {
    wp_nonce_field('city_library_save_hero_meta_box_data', 'city_library_hero_meta_box_nonce');

    $enable = get_post_meta($post->ID, '_hero_custom_enable', true);
    $title = get_post_meta($post->ID, '_hero_custom_title', true);
    $subtitle = get_post_meta($post->ID, '_hero_custom_subtitle', true);
    $image = get_post_meta($post->ID, '_hero_custom_image', true);
    $btn1_text = get_post_meta($post->ID, '_hero_custom_btn1_text', true);
    $btn1_link = get_post_meta($post->ID, '_hero_custom_btn1_link', true);

    // Fine-tuning settings
    $overlay_color = get_post_meta($post->ID, '_hero_custom_overlay_color', true);
    $overlay_opacity = get_post_meta($post->ID, '_hero_custom_overlay_opacity', true);
    $align = get_post_meta($post->ID, '_hero_custom_align', true);
    $height = get_post_meta($post->ID, '_hero_custom_height', true);

    ?>
    <style>
        .cl-hero-admin-row { margin-bottom: 15px; }
        .cl-hero-admin-row label { display: block; font-weight: bold; margin-bottom: 5px; }
        .cl-hero-admin-row input[type="text"], .cl-hero-admin-row textarea { width: 100%; max-width: 600px; }
        .cl-hero-admin-desc { font-size: 12px; color: #666; font-style: italic; display: block; margin-top: 4px; }
    </style>

    <div class="cl-hero-admin-row">
        <label>
            <input type="checkbox" name="hero_custom_enable" value="yes" <?php checked($enable, 'yes'); ?> />
            <?php _e('Включить уникальный Hero экран для этой записи', 'city-library'); ?>
        </label>
        <span class="cl-hero-admin-desc"><?php _e('Если включено, нижеуказанные настройки заменят настройки по умолчанию.', 'city-library'); ?></span>
    </div>

    <hr style="margin-bottom: 15px;" />

    <div class="cl-hero-admin-row">
        <label for="hero_custom_title"><?php _e('Заголовок (Title)', 'city-library'); ?></label>
        <input type="text" id="hero_custom_title" name="hero_custom_title" value="<?php echo esc_attr($title); ?>" />
        <span class="cl-hero-admin-desc"><?php _e('Можно использовать теги &lt;br&gt; или &lt;span class="text-primary italic"&gt; для акцента.', 'city-library'); ?></span>
    </div>

    <div class="cl-hero-admin-row">
        <label for="hero_custom_subtitle"><?php _e('Подзаголовок (Subtitle)', 'city-library'); ?></label>
        <textarea id="hero_custom_subtitle" name="hero_custom_subtitle" rows="3"><?php echo esc_textarea($subtitle); ?></textarea>
    </div>

    <div class="cl-hero-admin-row">
        <label for="hero_custom_image"><?php _e('URL Фонового изображения', 'city-library'); ?></label>
        <input type="text" id="hero_custom_image" name="hero_custom_image" value="<?php echo esc_attr($image); ?>" />
        <span class="cl-hero-admin-desc"><?php _e('Вставьте полный URL изображения (или используйте изображение по умолчанию если пусто).', 'city-library'); ?></span>
    </div>

    <div class="cl-hero-admin-row" style="display: flex; gap: 20px; flex-wrap: wrap;">
        <div>
            <label for="hero_custom_overlay_color"><?php _e('Цвет затемнения (Hex)', 'city-library'); ?></label>
            <input type="text" id="hero_custom_overlay_color" name="hero_custom_overlay_color" value="<?php echo esc_attr($overlay_color); ?>" placeholder="#1a3c34" style="width: 150px;" />
        </div>
        <div>
            <label for="hero_custom_overlay_opacity"><?php _e('Непрозрачность (0.0 - 1.0)', 'city-library'); ?></label>
            <input type="number" step="0.1" min="0" max="1" id="hero_custom_overlay_opacity" name="hero_custom_overlay_opacity" value="<?php echo esc_attr($overlay_opacity); ?>" placeholder="0.5" style="width: 150px;" />
        </div>
    </div>

    <div class="cl-hero-admin-row" style="display: flex; gap: 20px; flex-wrap: wrap;">
        <div>
            <label for="hero_custom_align"><?php _e('Выравнивание текста', 'city-library'); ?></label>
            <select id="hero_custom_align" name="hero_custom_align" style="width: 150px;">
                <option value="" <?php selected($align, ''); ?>>По умолчанию</option>
                <option value="left" <?php selected($align, 'left'); ?>>По левому краю</option>
                <option value="center" <?php selected($align, 'center'); ?>>По центру</option>
                <option value="right" <?php selected($align, 'right'); ?>>По правому краю</option>
            </select>
        </div>
        <div>
            <label for="hero_custom_height"><?php _e('Высота блока', 'city-library'); ?></label>
            <select id="hero_custom_height" name="hero_custom_height" style="width: 200px;">
                <option value="" <?php selected($height, ''); ?>>По умолчанию (Во весь экран)</option>
                <option value="min-h-[60vh]" <?php selected($height, 'min-h-[60vh]'); ?>>Средняя (60% экрана)</option>
                <option value="py-32" <?php selected($height, 'py-32'); ?>>Компактная (Только по контенту)</option>
            </select>
        </div>
    </div>

    <hr style="margin-bottom: 15px;" />

    <div class="cl-hero-admin-row">
        <label for="hero_custom_btn1_text"><?php _e('Текст главной кнопки', 'city-library'); ?></label>
        <input type="text" id="hero_custom_btn1_text" name="hero_custom_btn1_text" value="<?php echo esc_attr($btn1_text); ?>" placeholder="Например: Читать далее" />
    </div>

    <div class="cl-hero-admin-row">
        <label for="hero_custom_btn1_link"><?php _e('Ссылка главной кнопки', 'city-library'); ?></label>
        <input type="text" id="hero_custom_btn1_link" name="hero_custom_btn1_link" value="<?php echo esc_attr($btn1_link); ?>" placeholder="#content" />
    </div>
    <?php
}

// Save the Meta Box data
function city_library_save_hero_meta_box_data($post_id) {
    if (!isset($_POST['city_library_hero_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['city_library_hero_meta_box_nonce'], 'city_library_save_hero_meta_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    $fields = [
        'hero_custom_enable',
        'hero_custom_title',
        'hero_custom_subtitle',
        'hero_custom_image',
        'hero_custom_btn1_text',
        'hero_custom_btn1_link',
        'hero_custom_overlay_color',
        'hero_custom_overlay_opacity',
        'hero_custom_align',
        'hero_custom_height'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = ($field === 'hero_custom_title') ? wp_kses_post($_POST[$field]) : sanitize_text_field($_POST[$field]);
            update_post_meta($post_id, '_' . $field, $value);
        } else {
            delete_post_meta($post_id, '_' . $field);
        }
    }
}
add_action('save_post', 'city_library_save_hero_meta_box_data');
