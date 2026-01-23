<?php get_header(); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col lg:flex-row gap-8 items-start">

        <?php get_sidebar(); ?>

        <div id="primary" class="w-full lg:w-[70%] transition-all duration-300">

            <button id="sidebar-toggle" class="mb-6 inline-flex items-center text-slate-500 hover:text-primary transition-colors bg-white dark:bg-slate-800 px-4 py-2 rounded-lg shadow-sm border border-slate-100 dark:border-slate-700">
                <span class="material-symbols-outlined text-xl">dock_to_left</span>
                <span class="ml-2 font-bold text-xs uppercase tracking-wider"><?php _e('Меню', 'city-library'); ?></span>
            </button>

            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('prose dark:prose-invert max-w-none bg-white dark:bg-slate-800 p-8 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700'); ?>>
                    <header class="entry-header mb-8">
                        <?php the_title('<h1 class="entry-title text-3xl md:text-5xl font-bold font-display mb-4">', '</h1>'); ?>
                        <div class="entry-meta flex items-center text-slate-500 dark:text-slate-400 text-sm">
                            <span class="flex items-center mr-4">
                                <span class="material-symbols-outlined text-base mr-1">calendar_today</span>
                                <?php echo esc_html(get_the_date()); ?>
                            </span>
                            <?php if (has_category()) : ?>
                                <span class="flex items-center">
                                    <span class="material-symbols-outlined text-base mr-1">folder</span>
                                    <?php the_category(', '); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail mb-8 rounded-lg overflow-hidden shadow-lg">
                            <?php the_post_thumbnail('full', ['class' => 'w-full h-auto object-cover']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'city-library'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </article>

            <?php
            endwhile; // End of the loop.
            ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>
