<?php get_header(); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col gap-8 items-start">

        <div id="primary" class="w-full transition-all duration-300">

            <div class="content-area">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                    <div class="space-y-4">
                        <div class="h-1 w-20 bg-primary"></div>
                        <h2 class="text-4xl md:text-5xl font-display font-bold"><?php _e('Последние новости', 'city-library'); ?></h2>
                        <p class="text-slate-500 dark:text-slate-400 text-lg"><?php _e('Узнайте о самых интересных событиях и мероприятиях нашей библиотеки', 'city-library'); ?></p>
                    </div>
                    <div class="flex items-center space-x-2 bg-slate-100 dark:bg-slate-800 p-1 rounded-lg">
                        <button id="view-grid" class="p-2 bg-white dark:bg-slate-700 shadow-sm rounded-md">
                            <span class="material-symbols-outlined text-xl">grid_view</span>
                        </button>
                        <button id="view-list" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                            <span class="material-symbols-outlined text-xl">view_list</span>
                        </button>
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
