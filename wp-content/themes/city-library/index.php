<?php get_header(); ?>

<div class="w-full max-w-[95%] mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="flex flex-col lg:flex-row gap-8 relative">

        <!-- Sidebar -->
        <aside id="secondary" class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-slate-800 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 lg:shadow-none lg:w-[30%] lg:block lg:z-auto bg-slate-50 dark:bg-slate-900/50 rounded-xl">
            <div class="h-full overflow-y-auto p-6 lg:p-0 lg:overflow-visible">
                <div class="flex justify-between items-center mb-6 lg:hidden">
                    <span class="font-bold text-lg"><?php _e('Меню', 'city-library'); ?></span>
                    <button id="close-sidebar" class="p-2 text-slate-500 hover:text-primary">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <?php get_sidebar(); ?>
            </div>
        </aside>

        <!-- Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden backdrop-blur-sm"></div>

        <!-- Main Content -->
        <div id="primary" class="w-full lg:w-[70%] transition-all duration-300">

            <div class="mb-6">
                <button id="sidebar-toggle" class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg hover:text-primary transition-colors shadow-sm">
                    <span class="material-symbols-outlined">menu_open</span>
                    <span class="font-medium"><?php _e('Сайдбар', 'city-library'); ?></span>
                </button>
            </div>

            <div class="content-area bg-slate-50 dark:bg-slate-900/50 p-8 rounded-3xl" style="background-image: url('data:image/svg+xml,%3Csvg width=\'52\' height=\'26\' viewBox=\'0 0 52 26\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z\' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                    <div class="space-y-4">
                        <div class="h-1 w-20 bg-primary"></div>
                        <h2 class="text-4xl md:text-5xl font-display font-bold"><?php _e('Последние новости', 'city-library'); ?></h2>
                        <p class="text-slate-500 dark:text-slate-400 text-lg"><?php _e('Узнайте о самых интересных событиях и мероприятиях нашей библиотеки', 'city-library'); ?></p>
                    </div>
                </div>

                <?php if (have_posts()) : ?>
                    <div id="posts-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
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

<?php get_template_part('template-parts/section-important'); ?>

<?php get_footer(); ?>
