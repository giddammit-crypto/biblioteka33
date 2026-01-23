<?php get_header(); ?>

<section class="relative h-screen flex items-center justify-center hero-gradient pt-20">
    <div class="max-w-4xl mx-auto text-center px-4 space-y-8">
        <div class="inline-flex items-center bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20">
            <span class="w-2 h-2 bg-primary rounded-full mr-3 animate-pulse"></span>
            <span class="text-xs font-bold text-white uppercase tracking-widest"><?php echo esc_html( get_theme_mod( 'hero_badge_text', __( 'Добро пожаловать в мир знаний', 'city-library' ) ) ); ?></span>
        </div>
        <h1 class="text-5xl md:text-7xl lg:text-8xl font-display font-bold text-white leading-tight">
            <?php echo wp_kses_post( get_theme_mod( 'hero_title', __( 'Твой мир, <span class="text-primary italic text-glow">Твоя</span> <br>библиотека', 'city-library' ) ) ); ?>
        </h1>
        <p class="text-lg md:text-xl text-slate-200 max-w-2xl mx-auto font-light leading-relaxed">
            <?php echo esc_html( get_theme_mod( 'hero_description', __( 'Центральная городская библиотека — пространство для открытий, творчества и вдохновения. Мы объединяем традиции и современные технологии.', 'city-library' ) ) ); ?>
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <a class="w-full sm:w-auto px-8 py-4 bg-primary hover:bg-yellow-600 text-slate-900 font-bold rounded-full transition-all flex items-center justify-center space-x-2 shadow-lg shadow-primary/20" href="#events">
                <span class="material-symbols-outlined text-xl">event</span>
                <span><?php _e( 'АФИША МЕРОПРИЯТИЙ', 'city-library' ); ?></span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
            <a class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold rounded-full border border-white/30 transition-all flex items-center justify-center" href="#about">
                <span><?php _e( 'УЗНАТЬ БОЛЬШЕ', 'city-library' ); ?></span>
            </a>
        </div>
    </div>
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
        <span class="material-symbols-outlined text-white text-3xl">expand_more</span>
    </div>
</section>

<section id="latest-news" class="py-24 bg-background-light dark:bg-background-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div class="space-y-4">
                <div class="h-1 w-20 bg-primary"></div>
                <h2 class="text-4xl md:text-5xl font-display font-bold"><?php _e( 'Последние новости', 'city-library' ); ?></h2>
                <p class="text-slate-500 dark:text-slate-400 text-lg"><?php _e( 'Узнайте о самых интересных событиях и мероприятиях нашей библиотеки', 'city-library' ); ?></p>
            </div>
            <div class="flex items-center space-x-2 bg-slate-100 dark:bg-slate-800 p-1 rounded-lg">
                <button class="p-2 bg-white dark:bg-slate-700 shadow-sm rounded-md">
                    <span class="material-symbols-outlined text-xl">grid_view</span>
                </button>
                <button class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                    <span class="material-symbols-outlined text-xl">view_list</span>
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $latest_posts = new WP_Query( array(
                'posts_per_page'      => 5,
                'ignore_sticky_posts' => 1,
            ) );

            if ( $latest_posts->have_posts() ) :
                while ( $latest_posts->have_posts() ) : $latest_posts->the_post();
                    get_template_part( 'template-parts/content-post-card' );
                endwhile;
                wp_reset_postdata();
            endif;
            ?>

            <div class="flex flex-col items-center justify-center bg-slate-100 dark:bg-slate-800/50 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-700 p-8 text-center space-y-6 min-h-[400px]">
                <div class="w-20 h-20 bg-white dark:bg-slate-800 rounded-full flex items-center justify-center shadow-md">
                    <span class="material-symbols-outlined text-4xl text-primary">newspaper</span>
                </div>
                <div class="space-y-2">
                    <h3 class="text-xl font-bold"><?php _e( 'Больше новостей', 'city-library' ); ?></h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm"><?php _e( 'В нашем архиве более 1000 интересных статей и отчетов о мероприятиях', 'city-library' ); ?></p>
                </div>
                <a class="px-8 py-3 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-full font-bold text-sm transition-all shadow-sm" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">
                    <?php _e( 'Архив записей', 'city-library' ); ?>
                </a>
            </div>
        </div>
        <div class="mt-20 text-center">
            <a class="inline-flex items-center px-10 py-4 bg-secondary dark:bg-slate-800 text-white dark:text-primary font-bold rounded-full hover:shadow-2xl transition-all space-x-3 group" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">
                <span><?php _e( 'СМОТРЕТЬ ВСЕ НОВОСТИ', 'city-library' ); ?></span>
                <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward</span>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
