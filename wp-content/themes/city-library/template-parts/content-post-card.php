<?php
$bg_color = get_theme_mod('news_card_grid_bg_color', '#FFFFFF');
$title_color = get_theme_mod('news_card_grid_title_color', '#1A3C34');
$text_color = get_theme_mod('news_card_grid_text_color', '#334155');
$link_color = get_theme_mod('news_card_grid_link_color', '#0b7930');
?>
<article class="group relative flex flex-col h-full bg-white rounded-[2rem] overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-slate-100 isolate" style="background-color: <?php echo esc_attr($bg_color); ?>;">

    <!-- Image Container -->
    <div class="relative overflow-hidden w-full h-56 shrink-0">
        <a href="<?php the_permalink(); ?>" class="block w-full h-full" tabindex="-1" aria-hidden="true">
            <?php if (has_post_thumbnail()) : ?>
                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            <?php else : ?>
                <div class="absolute inset-0 bg-slate-100 flex items-center justify-center">
                    <span class="material-symbols-outlined text-4xl text-slate-300">image</span>
                </div>
            <?php endif; ?>
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-60 transition-opacity duration-300"></div>
        </a>

        <!-- Floating Category Badge -->
        <?php
        $categories = get_the_category();
        if (!empty($categories)) : ?>
            <div class="absolute top-4 left-4 z-10">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/90 backdrop-blur-sm text-primary shadow-sm border border-white/20">
                    <?php echo esc_html($categories[0]->name); ?>
                </span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Content -->
    <div class="flex flex-col flex-grow p-6 relative">
        <!-- Date -->
        <div class="flex items-center text-slate-400 text-[11px] font-bold tracking-widest uppercase mb-3">
            <span class="material-symbols-outlined text-sm mr-1.5">calendar_month</span>
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
        <div class="pt-4 mt-auto border-t border-slate-100 flex items-center justify-between">
            <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-xs font-bold uppercase tracking-wide group-hover:text-primary transition-colors relative z-10 hover:underline" style="color: <?php echo esc_attr($link_color); ?>;">
                <?php _e('Читать полностью', 'city-library'); ?>
            </a>
            <span class="material-symbols-outlined text-primary transform transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true">arrow_forward</span>
        </div>
    </div>
</article>
