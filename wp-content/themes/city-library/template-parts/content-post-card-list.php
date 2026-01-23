<?php
$bg_color = get_theme_mod('news_card_list_bg_color', '#FFFFFF');
$title_color = get_theme_mod('news_card_list_title_color', '#1A3C34');
$text_color = get_theme_mod('news_card_list_text_color', '#334155');
$link_color = get_theme_mod('news_card_list_link_color', '#0b7930');
?>
<div class="group bg-white dark:bg-slate-800 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100 dark:border-slate-700 flex flex-col md:flex-row" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="md:w-1/3 relative overflow-hidden aspect-[16/10] md:aspect-auto">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large', array('class' => 'absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105')); ?>
        <?php else : ?>
            <div class="absolute inset-0 bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                <span class="material-symbols-outlined text-4xl text-slate-400">image</span>
            </div>
        <?php endif; ?>
         <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent md:bg-none pointer-events-none"></div>
    </div>
    <div class="md:w-2/3 p-8 space-y-4 flex flex-col justify-center">
        <div class="flex items-center text-slate-400 dark:text-slate-500 text-xs font-semibold tracking-widest uppercase">
            <span class="material-symbols-outlined text-sm mr-2">calendar_today</span>
            <?php echo get_the_date(); ?>
        </div>
        <h3 class="text-xl font-bold font-display group-hover:text-primary transition-colors leading-tight" style="color: <?php echo esc_attr($title_color); ?>;">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <div class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 leading-relaxed" style="color: <?php echo esc_attr($text_color); ?>;">
            <?php the_excerpt(); ?>
        </div>
        <a class="inline-flex items-center text-secondary dark:text-primary font-bold text-sm group/link mt-auto" href="<?php the_permalink(); ?>" style="color: <?php echo esc_attr($link_color); ?>;">
            <?php _e('Читать полностью', 'city-library'); ?>
            <span class="material-symbols-outlined ml-1 text-lg transition-transform group-hover/link:translate-x-1">arrow_right_alt</span>
        </a>
    </div>
</div>
