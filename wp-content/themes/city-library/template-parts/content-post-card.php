<?php
$bg_color = get_theme_mod('news_card_grid_bg_color', '#FFFFFF');
$title_color = get_theme_mod('news_card_grid_title_color', '#0f172a');
$text_color = get_theme_mod('news_card_grid_text_color', '#1e293b');
$link_color = get_theme_mod('news_card_grid_link_color', '#0b7930');
?>
<article class="group relative flex flex-col h-full bg-white rounded-[2rem] overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-slate-200 w-full lg:w-auto aspect-[4/5] sm:aspect-[3/4] lg:aspect-auto" style="background-color: <?php echo esc_attr($bg_color); ?>;">

    <!-- Image Container -->
    <div class="absolute inset-0 z-0 h-full w-full lg:relative lg:h-56 lg:w-full lg:z-auto shrink-0 overflow-hidden">
        <a href="<?php the_permalink(); ?>" class="block w-full h-full" tabindex="-1" aria-hidden="true">
            <?php if (has_post_thumbnail()) : ?>
                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            <?php else : ?>
                <div class="absolute inset-0 bg-slate-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-4xl text-slate-300">image</span>
                </div>
            <?php endif; ?>
        </a>

        <!-- Mobile Gradient Overlay (Top) -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-transparent lg:hidden pointer-events-none"></div>
        <!-- Mobile Gradient Overlay (Bottom) -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/70 to-transparent lg:hidden pointer-events-none"></div>

        <!-- Floating Category Badge -->
        <?php
        $categories = get_the_category();
        if (!empty($categories)) : ?>
            <div class="absolute top-4 left-4 z-10">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/90 backdrop-blur-sm text-slate-900 shadow-sm border border-white/20 lg:shadow-none lg:border-none lg:bg-slate-100 lg:text-slate-700">
                    <?php echo esc_html($categories[0]->name); ?>
                </span>
            </div>
        <?php endif; ?>

        <!-- Mobile Date (Top Right) -->
        <div class="absolute top-4 right-4 z-20 lg:hidden">
            <div class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-black/40 backdrop-blur-sm text-white shadow-sm border border-white/10">
                <span class="material-symbols-outlined text-xs mr-1">calendar_month</span>
                <?php echo get_the_date(); ?>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="relative z-10 flex flex-col h-full p-6 lg:pt-6 justify-end lg:justify-start lg:flex-grow lg:bg-transparent pointer-events-none lg:pointer-events-auto">
        <!-- Make links clickable on mobile (overlay) -->
        <a href="<?php the_permalink(); ?>" class="absolute inset-0 lg:hidden pointer-events-auto" aria-hidden="true"></a>

        <!-- Desktop Date -->
        <div class="hidden lg:flex items-center text-slate-500 text-[11px] font-bold tracking-widest uppercase mb-3 pointer-events-auto">
            <span class="material-symbols-outlined text-sm mr-1.5">calendar_month</span>
            <?php echo get_the_date(); ?>
        </div>

        <!-- Title -->
        <h3 class="text-2xl lg:text-xl font-bold font-display leading-tight mb-3 pointer-events-auto relative flex items-start">
            <a href="<?php the_permalink(); ?>" class="transition-colors hover:text-yellow-400 lg:hover:text-primary focus:outline-none focus:underline text-white lg:landscape:text-inherit line-clamp-3 lg:line-clamp-none drop-shadow-md lg:drop-shadow-none z-20 [&_p]:text-[inherit] news-card-title-link" style="--title-color: <?php echo esc_attr($title_color); ?>;">
                <?php the_title(); ?>
                <span class="absolute inset-0 lg:hidden" aria-hidden="true"></span>
            </a>
        </h3>

        <!-- Excerpt -->
        <div class="text-[15px] lg:text-sm leading-relaxed line-clamp-3 mb-4 flex-grow-0 lg:flex-grow text-white lg:landscape:text-inherit pointer-events-auto drop-shadow-sm lg:drop-shadow-none font-medium lg:font-normal relative z-20 [&_p]:text-[inherit] news-card-excerpt-text" style="--text-color: <?php echo esc_attr($text_color); ?>;">
            <?php the_excerpt(); ?>
        </div>

        <!-- Footer / Link -->
        <div class="pt-4 lg:mt-auto border-t border-white/20 lg:border-slate-200 flex items-center justify-between pointer-events-auto relative z-20">
            <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-xs font-bold uppercase tracking-wide transition-colors relative z-10 hover:underline text-white lg:landscape:text-inherit drop-shadow-md lg:drop-shadow-none hover:text-yellow-400 lg:hover:text-primary/80 news-card-link" style="--link-color: <?php echo esc_attr($link_color); ?>;" aria-label="<?php echo esc_attr(sprintf(__('Читать полностью: %s', 'city-library'), get_the_title())); ?>">
                <span aria-hidden="true"><?php _e('Читать полностью', 'city-library'); ?></span>
                <span class="material-symbols-outlined ml-2 text-lg transform transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">arrow_forward</span>
            </a>
        </div>
    </div>
</article>
