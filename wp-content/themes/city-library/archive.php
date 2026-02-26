<?php get_header(); ?>

<div class="w-full lg:max-w-[80%] lg:mx-auto px-0 lg:px-8 py-12">

    <!-- Main Content (Full Width) -->
    <div id="primary" class="w-full">

        <div class="content-area bg-white p-6 md:p-8 rounded-none border-0 shadow-none lg:rounded-[2rem] lg:shadow-xl lg:border border-slate-100 bg-pattern-slate">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6 px-4 lg:px-0">
                <div class="space-y-4">
                    <div class="h-1 w-20 bg-primary"></div>
                    <h1 class="text-3xl md:text-5xl font-display font-bold"><?php _e('Архив новостей', 'city-library'); ?></h1>
                    <p class="text-slate-500 text-lg"><?php _e('Все новости и события библиотеки', 'city-library'); ?></p>
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

                <div class="mt-12 text-center px-4 lg:px-0">
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
