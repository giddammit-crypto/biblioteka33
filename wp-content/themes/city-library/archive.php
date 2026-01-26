<?php get_header(); ?>

<div class="w-full max-w-[95%] lg:max-w-[90%] xl:max-w-[80%] mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Main Content (Full Width) -->
    <div id="primary" class="w-full">

        <div class="content-area bg-white dark:bg-slate-900/50 p-8 rounded-3xl border border-slate-100 dark:border-slate-800" style="background-image: url('data:image/svg+xml,%3Csvg width=\'52\' height=\'26\' viewBox=\'0 0 52 26\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z\' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div class="space-y-4">
                    <div class="h-1 w-20 bg-primary"></div>
                    <h1 class="text-3xl md:text-5xl font-display font-bold"><?php _e('Архив новостей', 'city-library'); ?></h1>
                    <p class="text-slate-500 dark:text-slate-400 text-lg"><?php _e('Все новости и события библиотеки', 'city-library'); ?></p>
                </div>
            </div>

            <?php if (have_posts()) : ?>
                <div id="posts-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-6">
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
                <p><?php _e('Записей не найдено.', 'city-library'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
