<?php get_header(); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-8 items-start">

        <?php get_sidebar(); ?>

        <div id="primary" class="w-full lg:w-[70%] transition-all duration-300">

             <button id="sidebar-toggle" class="mb-6 inline-flex items-center text-slate-500 hover:text-primary transition-colors bg-white dark:bg-slate-800 px-4 py-2 rounded-lg shadow-sm border border-slate-100 dark:border-slate-700">
                <span class="material-symbols-outlined text-xl">dock_to_left</span>
                <span class="ml-2 font-bold text-xs uppercase tracking-wider"><?php _e('Меню', 'city-library'); ?></span>
            </button>

            <div class="content-area">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                    <div class="space-y-4">
                        <div class="h-1 w-20 bg-primary"></div>
                        <h2 class="text-4xl md:text-5xl font-display font-bold"><?php _e('Последние новости', 'city-library'); ?></h2>
                        <p class="text-slate-500 dark:text-slate-400 text-lg"><?php _e('Узнайте о самых интересных событиях и мероприятиях нашей библиотеки', 'city-library'); ?></p>
                    </div>

                </div>

                <?php if (have_posts()) : ?>
                    <div id="posts-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('template-parts/content-post-card');
                        endwhile;
                        ?>
                    </div>
                     <div class="mt-12 text-center">
                        <?php the_posts_pagination(); ?>
                    </div>

                    <div class="mt-16 text-center border-t border-slate-200 dark:border-slate-800 pt-8">
                        <a href="<?php echo get_post_type_archive_link('post'); ?>" class="inline-flex items-center text-secondary dark:text-primary font-bold text-lg hover:underline decoration-2 underline-offset-4">
                            <?php _e('Архив новостей', 'city-library'); ?>
                            <span class="material-symbols-outlined ml-2">arrow_forward</span>
                        </a>
                    </div>

                <?php else : ?>
                    <p><?php _e('К сожалению, по вашему запросу ничего не найдено.', 'city-library'); ?></p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php get_template_part('template-parts/section-afisha'); ?>

<?php get_footer(); ?>
