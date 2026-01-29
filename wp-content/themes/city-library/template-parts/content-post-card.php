<?php
$bg_color = get_theme_mod('news_card_grid_bg_color', '#FFFFFF');
$title_color = get_theme_mod('news_card_grid_title_color', '#1A3C34');
$text_color = get_theme_mod('news_card_grid_text_color', '#334155');
$link_color = get_theme_mod('news_card_grid_link_color', '#0b7930');
?>
<article class="group relative flex flex-col h-full bg-white dark:bg-slate-800 rounded-[2.5rem] overflow-hidden shadow-lg hover:shadow-card-hover transition-all duration-500 hover:-translate-y-2 border border-slate-100 dark:border-slate-700 isolate" style="background-color: <?php echo esc_attr($bg_color); ?>;">

    <!-- Image Container -->
    <div class="relative overflow-hidden w-full h-72 shrink-0">
        <a href="<?php the_permalink(); ?>" class="block w-full h-full" tabindex="-1" aria-hidden="true">
            <?php if (has_post_thumbnail()) : ?>
                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-[0.8s] group-hover:scale-110 filter brightness-95 group-hover:brightness-105">
            <?php else : ?>
                <div class="absolute inset-0 bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-5xl text-slate-300 dark:text-slate-600">image</span>
                </div>
            <?php endif; ?>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-80 transition-opacity duration-300"></div>
        </a>

        <!-- Floating Category Badge -->
        <?php
        $categories = get_the_category();
        if (!empty($categories)) : ?>
            <div class="absolute top-5 left-5 z-10">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-[0.1em] bg-white/95 dark:bg-slate-900/90 backdrop-blur-md text-slate-800 dark:text-white shadow-lg ring-1 ring-white/20 transition-transform group-hover:scale-105">
                    <?php echo esc_html($categories[0]->name); ?>
                </span>
            </div>
        <?php endif; ?>

        <!-- Date Badge (Over Image) -->
        <div class="absolute bottom-5 left-5 z-10 flex items-center text-white/90 text-[10px] font-bold tracking-[0.15em] uppercase">
            <span class="material-symbols-outlined text-sm mr-2">calendar_month</span>
            <?php echo get_the_date(); ?>
        </div>
    </div>

    <!-- Content -->
    <div class="flex flex-col flex-grow p-8 relative bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm">
        <!-- Title -->
        <h3 class="text-2xl font-display font-bold leading-tight mb-4 line-clamp-2">
            <a href="<?php the_permalink(); ?>" class="transition-colors hover:text-secondary focus:outline-none decoration-clone" style="color: <?php echo esc_attr($title_color); ?>;">
                <?php the_title(); ?>
                <span class="absolute inset-0" aria-hidden="true"></span>
            </a>
        </h3>

        <!-- Excerpt -->
        <div class="text-sm leading-relaxed line-clamp-3 mb-6 flex-grow font-light" style="color: <?php echo esc_attr($text_color); ?>;">
            <?php the_excerpt(); ?>
        </div>

        <!-- Footer / Link -->
        <div class="pt-5 mt-auto border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between">
            <span class="inline-flex items-center text-[10px] font-bold uppercase tracking-[0.2em] group-hover:text-secondary transition-colors relative z-10" style="color: <?php echo esc_attr($link_color); ?>;">
                <?php _e('Читать далее', 'city-library'); ?>
            </span>
            <div class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-700 flex items-center justify-center group-hover:bg-secondary group-hover:text-white transition-all duration-300 shadow-sm group-hover:shadow-glow">
                <span class="material-symbols-outlined text-sm transform group-hover:translate-x-0.5 transition-transform" aria-hidden="true">arrow_forward</span>
            </div>
        </div>
    </div>
</article>
