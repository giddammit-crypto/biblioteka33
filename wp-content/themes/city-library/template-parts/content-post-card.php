<?php
$bg_color = get_theme_mod('news_card_grid_bg_color', '#FFFFFF');
$title_color = get_theme_mod('news_card_grid_title_color', '#1A3C34');
$text_color = get_theme_mod('news_card_grid_text_color', '#334155');
$link_color = get_theme_mod('news_card_grid_link_color', '#0b7930');
?>
<article class="group relative flex flex-col h-full bg-white dark:bg-slate-800 rounded-[2rem] overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-slate-100 dark:border-slate-700 isolate" style="background-color: <?php echo esc_attr($bg_color); ?>;">

    <!-- Image Container -->
    <div class="relative overflow-hidden w-full h-64 shrink-0">
        <a href="<?php the_permalink(); ?>" class="block w-full h-full" tabindex="-1" aria-hidden="true">
            <?php if (has_post_thumbnail()) : ?>
                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-[0.8s] group-hover:scale-110">
            <?php else : ?>
                <div class="absolute inset-0 bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600">image</span>
                </div>
            <?php endif; ?>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-80 transition-opacity duration-300"></div>
        </a>

        <!-- Floating Category Badge -->
        <?php
        $categories = get_the_category();
        if (!empty($categories)) : ?>
            <div class="absolute top-6 left-6 z-10">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/95 dark:bg-slate-900/90 backdrop-blur-md text-primary shadow-lg ring-1 ring-black/5">
                    <?php echo esc_html($categories[0]->name); ?>
                </span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Content -->
    <div class="flex flex-col flex-grow p-8 relative">
        <!-- Date -->
        <div class="flex items-center text-slate-400 dark:text-slate-500 text-[11px] font-bold tracking-widest uppercase mb-4">
            <span class="material-symbols-outlined text-base mr-2 text-primary/60">calendar_month</span>
            <?php echo get_the_date(); ?>
        </div>

        <!-- Title -->
        <h3 class="text-xl font-bold font-display leading-tight mb-3 line-clamp-2">
            <a href="<?php the_permalink(); ?>" class="transition-colors hover:text-primary focus:outline-none focus:underline" style="color: <?php echo esc_attr($title_color); ?>;">
                <?php the_title(); ?>
                <span class="absolute inset-0" aria-hidden="true"></span>
            </a>
        </h3>

        <!-- Excerpt -->
        <div class="text-sm leading-relaxed line-clamp-3 mb-4 flex-grow" style="color: <?php echo esc_attr($text_color); ?>;">
            <?php the_excerpt(); ?>
        </div>

        <!-- Footer / Link -->
        <div class="pt-4 mt-auto border-t border-slate-100 dark:border-slate-700 flex items-center justify-between">
            <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-xs font-bold uppercase tracking-wide group-hover:text-primary transition-colors relative z-10 hover:underline" style="color: <?php echo esc_attr($link_color); ?>;">
                <?php _e('Читать полностью', 'city-library'); ?>
            </a>
            <span class="material-symbols-outlined text-primary transform transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">arrow_forward</span>
        </div>
    </div>
</article>
