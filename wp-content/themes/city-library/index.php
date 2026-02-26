<?php get_header(); ?>

<div class="w-full lg:max-w-[80%] lg:mx-auto px-0 lg:px-8 py-8">

    <?php get_template_part('template-parts/section-promo'); ?>

    <?php $show_sidebar = get_theme_mod('show_sidebar', true); ?>

    <!-- Toggle Button -->
    <?php if ($show_sidebar) : ?>
    <div class="mb-6 px-4 lg:px-0">
         <button id="sidebar-toggle-btn" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg shadow hover:bg-opacity-90 transition-all focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
            <span class="material-symbols-outlined">menu_open</span>
            <span class="text-sm font-bold uppercase"><?php _e('Скрыть/Показать сайдбар', 'city-library'); ?></span>
        </button>
    </div>
    <?php endif; ?>

    <div class="flex flex-col lg:flex-row gap-8 items-start">

        <!-- Sidebar Column (30%) -->
        <?php if ($show_sidebar) : ?>
        <div id="sidebar-column" class="w-full lg:w-[30%] shrink-0 transition-all duration-300 px-4 lg:px-0">
             <?php get_sidebar(); ?>
        </div>
        <?php endif; ?>

        <!-- Main Content (70%) -->
        <div id="primary" class="w-full <?php echo $show_sidebar ? 'lg:w-[70%]' : ''; ?> transition-all duration-300">

            <div class="content-area bg-white p-6 md:p-8 rounded-none border-0 shadow-none lg:rounded-[2rem] lg:shadow-xl lg:border border-slate-100 bg-pattern-slate <?php echo city_library_get_animation_class(); ?>">
                <div class="flex flex-col items-center justify-center mb-12 gap-6 text-center">
                <div class="space-y-4 max-w-2xl mx-auto">
                    <div class="h-1 w-20 bg-primary mx-auto"></div>
                    <!-- Increased size by approx 2px from text-3xl (30px) -> 32px and text-5xl (48px) -> 50px -->
                    <h2 class="text-[32px] md:text-[50px] font-display font-bold leading-tight"><?php _e('Последние новости', 'city-library'); ?></h2>
                    <p class="text-slate-500 text-lg"><?php _e('Узнайте о самых интересных событиях и мероприятиях нашей библиотеки', 'city-library'); ?></p>
                </div>
            </div>

            <?php if (have_posts()) : ?>
                <!-- Responsive Layout: Swiper for Mobile (< lg), Grid for Kiosk/Desktop (>= lg) -->
                <div id="posts-container" class="swiper news-slider w-full">
                    <div class="swiper-wrapper lg:!grid lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 lg:gap-6">
                        <?php
                        while (have_posts()) :
                            the_post();
                            echo '<div class="swiper-slide h-auto">';
                            get_template_part('template-parts/content-post-card');
                            echo '</div>';
                        endwhile;
                        ?>
                    </div>
                    <div class="swiper-pagination lg:hidden !bottom-0 !relative mt-6"></div>
                </div>
                    <div class="mt-12 text-center">
                    <?php the_posts_pagination(); ?>
                </div>

                <div class="mt-16 text-center border-t border-slate-200 pt-8">
                    <a href="<?php echo esc_url(add_query_arg('news_archive', 'true', home_url('/'))); ?>" class="inline-flex items-center text-slate-900 font-bold text-lg hover:underline decoration-2 underline-offset-4">
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
