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
// $bg_color is unused now as we enforce standardized style
$inter_block_text = get_theme_mod('important_inter_block_text', '');
?>

<section class="py-16 bg-white dark:bg-slate-900">
    <!-- Width Correction: 80% to match other blocks -->
    <div class="w-full max-w-[80%] mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Main Alert Block - Standardized Style -->
        <?php if (!empty(trim(strip_tags($text)))) : ?>
        <div class="relative flex flex-col md:flex-row items-center justify-between gap-8 p-10 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border border-slate-100 dark:border-slate-800 overflow-hidden group transition-shadow duration-300"
             style="background-image: url('data:image/svg+xml,%3Csvg width=\'52\' height=\'26\' viewBox=\'0 0 52 26\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z\' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">

            <!-- Decorative Background Element (Subtle, not red) -->
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-primary/5 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row gap-6 items-start md:items-center flex-grow">
                <!-- Icon (Changed from Red to Primary/Standard) -->
                <div class="shrink-0">
                    <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-full flex items-center justify-center shadow-sm border border-slate-100 dark:border-slate-700">
                        <span class="material-symbols-outlined text-4xl text-primary animate-pulse">warning</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="space-y-3">
                    <h2 class="text-3xl font-bold font-display uppercase tracking-wider text-slate-800 dark:text-white"><?php echo esc_html($title); ?></h2>
                    <div class="prose prose-lg prose-slate dark:prose-invert max-w-none text-slate-600 dark:text-slate-300 leading-relaxed">
                        <?php echo wp_kses_post(wpautop($text)); ?>
                    </div>
                </div>
            </div>

            <?php if ($btn_link) : ?>
                <div class="relative z-10 shrink-0 mt-6 md:mt-0">
                    <a href="<?php echo esc_url($btn_link); ?>" class="important-btn inline-flex items-center justify-center px-10 py-4 bg-primary hover:bg-primary/90 text-white font-bold text-lg rounded-full transition-all shadow-md hover:shadow-lg hover:-translate-y-1">
                        <?php echo esc_html($btn_text); ?>
                        <span class="material-symbols-outlined ml-2">arrow_forward</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Spacer / Inter-block text -->
        <div class="py-12 flex items-center justify-center">
             <?php if ($inter_block_text) : ?>
                <div class="w-full bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-white text-center py-4 px-6 rounded-3xl border border-slate-100 dark:border-slate-800" style="background-image: url('data:image/svg+xml,%3Csvg width=\'52\' height=\'26\' viewBox=\'0 0 52 26\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z\' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                    <p class="text-xl font-bold uppercase tracking-widest"><?php echo esc_html($inter_block_text); ?></p>
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
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8 gap-6">
                <?php for ($i = 1; $i <= 8; $i++) :
                    $img = get_theme_mod("important_link_image_$i");
                    $url = get_theme_mod("important_link_url_$i", '#');
                    if (!$img) continue;
                ?>
                    <a href="<?php echo esc_url($url); ?>" class="block group relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 aspect-square">
                         <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr("Link $i"); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                         <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
