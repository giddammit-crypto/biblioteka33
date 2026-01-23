<?php get_header(); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24" style="padding-top: 10rem;">
    <div class="flex flex-col lg:flex-row gap-12">
        <div id="primary" class="content-area lg:flex-grow">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('prose dark:prose-invert max-w-none'); ?>>
                    <header class="entry-header mb-8">
                        <?php the_title('<h1 class="entry-title text-4xl md:text-5xl font-bold font-display">', '</h1>'); ?>
                        <div class="entry-meta text-slate-500 dark:text-slate-400 text-sm mt-2">
                            <span><?php echo esc_html(get_the_date()); ?></span>
                        </div>
                    </header>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail mb-8 rounded-lg overflow-hidden shadow-lg">
                            <?php the_post_thumbnail('full', ['class' => 'w-full h-auto']); ?>
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
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>
        </div>

        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>
