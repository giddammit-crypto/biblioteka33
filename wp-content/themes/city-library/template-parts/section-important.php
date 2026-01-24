<?php
/**
 * Important Information Section
 */

if (!get_theme_mod('show_important_section', true)) {
    return;
}

$title = get_theme_mod('important_title', __('Важная информация', 'city-library'));
$text = get_theme_mod('important_text', __('Внимание! В связи с санитарным днем библиотека работает по измененному графику.', 'city-library'));
$btn_text = get_theme_mod('important_btn_text', __('Подробнее', 'city-library'));
$btn_link = get_theme_mod('important_btn_link', '#');
$bg_color = get_theme_mod('important_bg_color', '#fef2f2'); // Default light red/pink
?>

<section class="py-12" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Main Alert Block -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 p-8 border-l-4 border-red-500 bg-white shadow-sm rounded-r-xl">
            <div class="space-y-4 flex-grow">
                <div class="flex items-center space-x-3 text-red-600">
                    <span class="material-symbols-outlined text-3xl animate-pulse">warning</span>
                    <h2 class="text-2xl font-bold font-display uppercase tracking-wider"><?php echo esc_html($title); ?></h2>
                </div>
                <div class="prose prose-slate max-w-none text-slate-600">
                    <?php echo wp_kses_post(wpautop($text)); ?>
                </div>
            </div>

            <?php if ($btn_link) : ?>
                <div class="shrink-0">
                    <a href="<?php echo esc_url($btn_link); ?>" class="inline-flex items-center justify-center px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-full transition-all shadow-lg shadow-red-200">
                        <?php echo esc_html($btn_text); ?>
                        <span class="material-symbols-outlined ml-2">arrow_forward</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Links Grid (8 items) -->
        <?php
        $links_present = false;
        for ($i = 1; $i <= 8; $i++) {
            if (get_theme_mod("important_link_image_$i")) {
                $links_present = true;
                break;
            }
        }

        if ($links_present) : ?>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8 gap-4">
                <?php for ($i = 1; $i <= 8; $i++) :
                    $img = get_theme_mod("important_link_image_$i");
                    $url = get_theme_mod("important_link_url_$i", '#');
                    if (!$img) continue;
                ?>
                    <a href="<?php echo esc_url($url); ?>" class="block group relative rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all bg-white aspect-square flex items-center justify-center p-2">
                         <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr("Link $i"); ?>" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-110">
                         <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors"></div>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
