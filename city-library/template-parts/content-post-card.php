<div class="group bg-white dark:bg-slate-800 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-slate-100 dark:border-slate-700">
    <?php if ( has_post_thumbnail() ) : ?>
    <div class="relative overflow-hidden aspect-[16/10]">
        <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110' ) ); ?>
        <?php
        $categories = get_the_category();
        if ( ! empty( $categories ) ) :
            ?>
            <div class="absolute top-4 left-4 bg-primary text-slate-900 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                <?php echo esc_html( $categories[0]->name ); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="p-8 space-y-4">
        <div class="flex items-center text-slate-400 dark:text-slate-500 text-xs font-semibold tracking-widest uppercase">
            <span class="material-symbols-outlined text-sm mr-2">calendar_today</span>
            <?php echo get_the_date(); ?>
        </div>
        <h3 class="text-xl font-bold font-display group-hover:text-primary transition-colors leading-tight">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <div class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 leading-relaxed">
            <?php the_excerpt(); ?>
        </div>
        <a class="inline-flex items-center text-secondary dark:text-primary font-bold text-sm group/link" href="<?php the_permalink(); ?>">
            <?php _e( 'Читать полностью', 'city-library' ); ?>
            <span class="material-symbols-outlined ml-1 text-lg transition-transform group-hover/link:translate-x-1">arrow_right_alt</span>
        </a>
    </div>
</div>
