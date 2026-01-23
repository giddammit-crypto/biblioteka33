<?php get_header(); ?>

<div class="w-full max-w-[95%] mx-auto px-4 sm:px-6 lg:px-8 py-12">
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
                <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white dark:bg-slate-900/50 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800'); ?>>
                    <header class="entry-header mb-8">
                        <?php the_title('<h1 class="entry-title text-3xl md:text-5xl font-bold font-display mb-4 text-slate-900 dark:text-white">', '</h1>'); ?>
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

                        <div class="entry-content flex-grow prose prose-slate dark:prose-invert max-w-none">
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
                            <h3 class="text-2xl font-bold font-display mb-6 text-slate-900 dark:text-white"><?php _e('Галерея', 'city-library'); ?></h3>
                            <div class="flex overflow-x-auto gap-4 py-4 scrollbar-hide snap-x">
                                <?php foreach ($attachments as $attachment) :
                                    $img_url = wp_get_attachment_image_src($attachment->ID, 'full');
                                    $thumb_url = wp_get_attachment_image_src($attachment->ID, 'medium');
                                ?>
                                    <a href="<?php echo esc_url($img_url[0]); ?>" class="glightbox group relative overflow-hidden rounded-lg aspect-[4/3] w-64 flex-shrink-0 snap-center shadow-md border border-slate-100 dark:border-slate-700">
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
                            // Select all links in content that point to images
                            const contentImages = document.querySelectorAll('.entry-content a[href*=".jpg"], .entry-content a[href*=".jpeg"], .entry-content a[href*=".png"], .entry-content a[href*=".gif"], .entry-content a[href*=".webp"]');

                            contentImages.forEach(link => {
                                link.classList.add('glightbox');
                                link.setAttribute('data-gallery', 'post-gallery');
                            });

                            // Also group the featured image and attached gallery
                            const otherImages = document.querySelectorAll('.glightbox');
                            otherImages.forEach(link => {
                                if (!link.hasAttribute('data-gallery')) {
                                    link.setAttribute('data-gallery', 'post-gallery');
                                }
                            });

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
