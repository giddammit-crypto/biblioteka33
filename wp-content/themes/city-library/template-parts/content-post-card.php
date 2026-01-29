<?php
$bg_color = get_theme_mod('news_card_grid_bg_color', '#FFFFFF');
$title_color = get_theme_mod('news_card_grid_title_color', '#1e293b'); // Slate 800
$text_color = get_theme_mod('news_card_grid_text_color', '#475569'); // Slate 600
$link_color = get_theme_mod('news_card_grid_link_color', '#15803d'); // Green 700
?>
<article class="group relative flex flex-col h-full bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-slate-100" style="background-color: <?php echo esc_attr($bg_color); ?>;">

    <!-- Image Container -->
    <div class="relative overflow-hidden w-full aspect-[4/3] shrink-0">
        <a href="<?php the_permalink(); ?>" class="block w-full h-full" tabindex="-1" aria-hidden="true">
            <?php if (has_post_thumbnail()) : ?>
                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <?php else : ?>
                <div class="w-full h-full bg-slate-50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-4xl text-slate-300">image</span>
                </div>
            <?php endif; ?>
        </a>

        <!-- Category Badge -->
        <?php
        $categories = get_the_category();
        if (!empty($categories)) : ?>
            <div class="absolute top-4 left-4 z-10">
                <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-white/90 text-slate-800 shadow-sm backdrop-blur-sm">
                    <?php echo esc_html($categories[0]->name); ?>
                </span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Content -->
    <div class="flex flex-col flex-grow p-6">
        <!-- Meta -->
        <div class="flex items-center text-xs text-slate-400 mb-3 space-x-2">
            <span class="material-symbols-outlined text-base">calendar_today</span>
            <span><?php echo get_the_date(); ?></span>
        </div>

        <!-- Title -->
        <h3 class="text-xl font-bold leading-snug mb-3 line-clamp-2 group-hover:text-green-700 transition-colors">
            <a href="<?php the_permalink(); ?>" class="focus:outline-none" style="color: <?php echo esc_attr($title_color); ?>;">
                <?php the_title(); ?>
                <span class="absolute inset-0" aria-hidden="true"></span>
            </a>
        </h3>

        <!-- Excerpt -->
        <div class="text-sm leading-relaxed line-clamp-3 mb-6 flex-grow text-slate-600" style="color: <?php echo esc_attr($text_color); ?>;">
            <?php the_excerpt(); ?>
        </div>

        <!-- Footer / Link -->
        <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-100">
            <span class="text-xs font-bold uppercase tracking-wider transition-colors group-hover:underline decoration-2 underline-offset-4" style="color: <?php echo esc_attr($link_color); ?>;">
                <?php _e('Читать далее', 'city-library'); ?>
            </span>
            <span class="material-symbols-outlined text-xl text-slate-300 group-hover:text-green-700 group-hover:translate-x-1 transition-all">arrow_forward</span>
        </div>
    </div>
</article>
