<?php get_header(); ?>

<div class="w-full max-w-[95%] sm:max-w-[90%] xl:max-w-[85%] 2xl:max-w-[80%] mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <?php get_template_part('template-parts/section-promo'); ?>

    <?php $show_sidebar = get_theme_mod('show_sidebar', true); ?>

    <!-- Toggle Button -->
    <?php if ($show_sidebar) : ?>
    <div class="mb-6">
         <button id="sidebar-toggle-btn" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg shadow hover:bg-opacity-90 transition-all focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
            <span class="material-symbols-outlined">menu_open</span>
            <span class="text-sm font-bold uppercase"><?php _e('Скрыть/Показать сайдбар', 'city-library'); ?></span>
        </button>
    </div>
    <?php endif; ?>

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        <!-- Sidebar Column (30%) -->
        <?php if ($show_sidebar) : ?>
        <div id="sidebar-column" class="w-full lg:w-[30%] shrink-0 transition-all duration-300">
             <?php get_sidebar(); ?>
        </div>
        <?php endif; ?>

        <!-- Main Content (70%) -->
        <div id="primary" class="w-full <?php echo $show_sidebar ? 'lg:w-[70%]' : ''; ?> transition-all duration-300">

            <div class="content-area bg-slate-50 dark:bg-slate-900/50 p-8 rounded-3xl border border-slate-100 dark:border-slate-800 bg-pattern-slate <?php echo city_library_get_animation_class(); ?>">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div class="space-y-4">
                    <div class="h-1 w-20 bg-primary"></div>
                    <h2 class="text-3xl md:text-5xl font-display font-bold"><?php _e('Последние новости', 'city-library'); ?></h2>
                    <p class="text-slate-500 dark:text-slate-400 text-lg"><?php _e('Узнайте о самых интересных событиях и мероприятиях нашей библиотеки', 'city-library'); ?></p>
                </div>
            </div>

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
                    <?php the_posts_pagination(); ?>
                </div>

                <div class="mt-16 text-center border-t border-slate-200 dark:border-slate-800 pt-8">
                    <a href="<?php echo esc_url(add_query_arg('news_archive', 'true', home_url('/'))); ?>" class="inline-flex items-center text-secondary dark:text-primary font-bold text-lg hover:underline decoration-2 underline-offset-4">
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
