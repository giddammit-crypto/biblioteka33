<?php get_header(); ?>

<div class="w-full max-w-[95%] xl:max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div id="primary" class="w-full">

        <div class="content-area bg-white dark:bg-slate-900/50 p-8 rounded-3xl border border-slate-100 dark:border-slate-800" style="background-image: url('data:image/svg+xml,%3Csvg width=\'52\' height=\'26\' viewBox=\'0 0 52 26\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z\' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">

            <header class="mb-12 text-center max-w-2xl mx-auto">
                <p class="text-primary font-bold uppercase tracking-widest mb-2"><?php _e('Результаты поиска', 'city-library'); ?></p>
                <h1 class="text-3xl md:text-5xl font-display font-bold text-slate-900 dark:text-white mb-6">
                    <?php printf(esc_html__('"%s"', 'city-library'), '<span>' . get_search_query() . '</span>'); ?>
                </h1>
                <div class="max-w-md mx-auto">
                    <?php get_search_form(); ?>
                </div>
            </header>

            <?php if (have_posts()) : ?>
                <div id="posts-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/content-post-card');
                    endwhile;
                    ?>
                </div>

                <div class="mt-12 text-center">
                    <?php the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => '<span class="material-symbols-outlined">chevron_left</span>',
                        'next_text' => '<span class="material-symbols-outlined">chevron_right</span>',
                        'screen_reader_text' => __('Навигация по записям', 'city-library'),
                    )); ?>
                </div>

            <?php else : ?>
                <div class="text-center py-12">
                    <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">sentiment_dissatisfied</span>
                    <h2 class="text-2xl font-bold text-slate-700 dark:text-slate-300 mb-2"><?php _e('Ничего не найдено', 'city-library'); ?></h2>
                    <p class="text-slate-500 mb-8"><?php _e('Попробуйте изменить запрос или вернитесь на главную.', 'city-library'); ?></p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center px-8 py-3 bg-primary text-white rounded-full font-bold hover:bg-primary/90 transition-colors">
                        <?php _e('На главную', 'city-library'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
