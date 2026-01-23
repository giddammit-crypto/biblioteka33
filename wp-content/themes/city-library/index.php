<?php get_header(); ?>

<div class="py-24 pt-48 bg-background-light dark:bg-background-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div class="space-y-4">
                <div class="h-1 w-20 bg-primary"></div>
                <h1 class="text-4xl md:text-5xl font-display font-bold">
                    <?php
                    if ( is_home() && ! is_front_page() ) {
                        single_post_title();
                    } else {
                        _e( 'Новости', 'city-library' );
                    }
                    ?>
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-lg"><?php _e( 'Самые интересные события и мероприятия нашей библиотеки', 'city-library' ); ?></p>
            </div>
        </div>

        <?php if ( have_posts() ) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while ( have_posts() ) : the_post();
                    get_template_part( 'template-parts/content-post-card' );
                endwhile;
                ?>
            </div>

            <div class="mt-20">
                <?php the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => __( '‹', 'city-library' ),
                    'next_text' => __( '›', 'city-library' ),
                ) ); ?>
            </div>

        <?php else : ?>
            <div class="text-center py-20">
                <h2 class="text-2xl font-bold"><?php _e( 'Ничего не найдено', 'city-library' ); ?></h2>
                <p class="mt-4 text-slate-500"><?php _e( 'К сожалению, по вашему запросу ничего не найдено. Попробуйте другой запрос.', 'city-library' ); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
