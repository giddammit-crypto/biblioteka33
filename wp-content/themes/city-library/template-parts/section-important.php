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

<section class="py-16" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- Main Alert Block -->
        <?php if (!empty(trim(strip_tags($text)))) : ?>
        <div class="relative flex flex-col md:flex-row items-center justify-between gap-8 p-10 bg-white rounded-2xl shadow-xl border-l-8 border-red-500 overflow-hidden group hover:shadow-2xl transition-shadow duration-300">
            <!-- Decorative Background Element -->
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-red-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row gap-6 items-start md:items-center flex-grow">
                <!-- Icon -->
                <div class="shrink-0">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center shadow-inner">
                        <span class="material-symbols-outlined text-4xl text-red-600 animate-pulse">warning</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="space-y-3">
                    <h2 class="text-3xl font-bold font-display uppercase tracking-wider text-slate-800"><?php echo esc_html($title); ?></h2>
                    <div class="prose prose-lg prose-slate max-w-none text-slate-600 leading-relaxed">
                        <?php echo wp_kses_post(wpautop($text)); ?>
                    </div>
                </div>
            </div>

            <?php if ($btn_link) : ?>
                <div class="relative z-10 shrink-0 mt-6 md:mt-0">
                    <a href="<?php echo esc_url($btn_link); ?>" class="inline-flex items-center justify-center px-10 py-4 bg-red-600 hover:bg-red-700 text-white font-bold text-lg rounded-full transition-all shadow-lg shadow-red-200 hover:shadow-red-300 hover:-translate-y-1">
                        <?php echo esc_html($btn_text); ?>
                        <span class="material-symbols-outlined ml-2">arrow_forward</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

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
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8 gap-6">
                <?php for ($i = 1; $i <= 8; $i++) :
                    $img = get_theme_mod("important_link_image_$i");
                    $url = get_theme_mod("important_link_url_$i", '#');
                    if (!$img) continue;
                ?>
                    <a href="<?php echo esc_url($url); ?>" class="block group relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 bg-white aspect-square flex items-center justify-center p-4 border border-slate-100">
                         <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr("Link $i"); ?>" class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-150">
                         <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
