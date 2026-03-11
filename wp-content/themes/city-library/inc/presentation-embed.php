<?php
/**
 * Shortcode to embed adaptive PPT/PPTX presentations using Microsoft Office Web Viewer.
 * Usage: [city_library_presentation url="https://example.com/path/to/file.pptx"]
 */

function city_library_presentation_shortcode($atts) {
    $atts = shortcode_atts(array(
        'url' => '',
        'height' => '500px',
    ), $atts, 'city_library_presentation');

    $url = esc_url($atts['url']);

    if (empty($url)) {
        return '<p class="text-red-500 font-bold p-4 border border-red-200 rounded bg-red-50">' . __('Ошибка: Не указан URL презентации в шорткоде.', 'city-library') . '</p>';
    }

    // Verify it's likely a PPT file (basic check)
    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
    if (!in_array(strtolower($ext), ['ppt', 'pptx'])) {
        // We still allow it, but add a wrapper class in case it's a docx/xls
        $is_ppt = false;
    } else {
        $is_ppt = true;
    }

    // The official Microsoft Office embed URL
    $embed_url = 'https://view.officeapps.live.com/op/embed.aspx?src=' . urlencode($url) . '&wdAr=1.7777';

    ob_start();
    ?>
    <div class="my-8 w-full city-library-presentation">
        <div class="relative bg-slate-100 rounded-xl overflow-hidden shadow-lg border border-slate-200 group" style="padding-bottom: 56.25%;">

            <!-- Loading State Placeholder -->
            <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 z-0">
                <span class="material-symbols-outlined text-4xl animate-spin mb-2">sync</span>
                <span class="text-sm font-medium uppercase tracking-widest"><?php _e('Загрузка презентации...', 'city-library'); ?></span>
            </div>

            <iframe
                src="<?php echo esc_url($embed_url); ?>"
                width="100%"
                height="100%"
                frameborder="0"
                title="<?php esc_attr_e('Презентация', 'city-library'); ?>"
                class="absolute inset-0 z-10 w-full h-full"
                allowfullscreen="true"
                webkitallowfullscreen="true"
                mozallowfullscreen="true">
            </iframe>

            <!-- Fullscreen helper overlay (visible on hover) -->
            <div class="absolute top-4 right-4 z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                <div class="bg-black/70 backdrop-blur-md text-white text-xs px-3 py-1.5 rounded-full flex items-center gap-2 shadow-xl border border-white/10">
                    <span class="material-symbols-outlined text-sm">fullscreen</span>
                    <?php _e('Используйте кнопку в плеере для полного экрана', 'city-library'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('city_library_presentation', 'city_library_presentation_shortcode');