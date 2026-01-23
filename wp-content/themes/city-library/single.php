<?php get_header(); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col gap-8 items-start">

        <div id="primary" class="w-full transition-all duration-300">

            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('prose dark:prose-invert max-w-none'); ?>>
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

                    <div class="flex flex-col md:flex-row gap-8 items-start mb-8">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php
                            $full_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                            ?>
                            <div class="post-thumbnail shrink-0 rounded-lg overflow-hidden shadow-lg w-full md:w-[300px]">
                                <a href="<?php echo esc_url($full_image_url[0]); ?>" class="glightbox">
                                    <?php the_post_thumbnail('medium', ['class' => 'w-full md:w-[300px] h-[200px] object-cover hover:scale-105 transition-transform duration-300']); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="entry-content flex-grow">
                            <?php
                            the_content();

                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'city-library'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>
                    </div>

                    <?php
                    // Get other attached images
                    $attachments = get_posts(array(
                        'post_type'      => 'attachment',
                        'post_mime_type' => 'image',
                        'post_parent'    => get_the_ID(),
                        'posts_per_page' => -1,
                        'exclude'        => get_post_thumbnail_id(),
                        'orderby'        => 'menu_order',
                        'order'          => 'ASC',
                    ));

                    if ($attachments) : ?>
                        <div class="mt-12 border-t border-slate-200 dark:border-slate-700 pt-8">
                            <h3 class="text-2xl font-bold font-display mb-6"><?php _e('Галерея', 'city-library'); ?></h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <?php foreach ($attachments as $attachment) :
                                    $img_url = wp_get_attachment_image_src($attachment->ID, 'full');
                                    $thumb_url = wp_get_attachment_image_src($attachment->ID, 'medium');
                                ?>
                                    <a href="<?php echo esc_url($img_url[0]); ?>" class="glightbox group relative overflow-hidden rounded-lg aspect-[4/3] block">
                                        <img src="<?php echo esc_url($thumb_url[0]); ?>" alt="<?php echo esc_attr($attachment->post_title); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">zoom_in</span>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const lightbox = GLightbox({
                                selector: '.glightbox',
                                touchNavigation: true,
                                loop: true,
                                autoplayVideos: true
                            });
                        });
                    </script>
                </article>

            <?php
            endwhile; // End of the loop.
            ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>
