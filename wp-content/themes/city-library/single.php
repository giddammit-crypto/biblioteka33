<?php get_header(); ?>

<div class="w-full max-w-[95%] sm:max-w-[90%] xl:max-w-[85%] 2xl:max-w-[80%] mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div id="primary" class="w-full transition-all duration-300 max-w-6xl mx-auto">

        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white dark:bg-slate-900/50 p-8 md:p-12 rounded-[2rem] shadow-xl border border-slate-100 dark:border-slate-800 relative overflow-hidden'); ?>>

                <!-- Decorative Background Blur -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex flex-col md:flex-row gap-8 relative z-10">

                    <!-- Left Column: Image (300x200) -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="flex-shrink-0 mx-auto md:mx-0">
                            <?php
                            $full_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                            ?>
                            <a href="<?php echo esc_url($full_image_url[0]); ?>" class="glightbox block rounded-2xl overflow-hidden shadow-lg relative group w-[300px] h-[200px]">
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105']); ?>
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300 flex items-center justify-center">
                                     <span class="material-symbols-outlined text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">zoom_in</span>
                                </div>
                            </a>
                            <?php if (get_the_post_thumbnail_caption()) : ?>
                                <figcaption class="text-center text-slate-500 text-xs mt-2 italic w-[300px]">
                                    <?php the_post_thumbnail_caption(); ?>
                                </figcaption>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Right Column: Content -->
                    <div class="flex-grow min-w-0">
                        <header class="entry-header mb-6">
                            <!-- Category -->
                            <?php if (has_category()) : ?>
                                <div class="mb-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider">
                                        <?php the_category(', '); ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <?php the_title('<h1 class="entry-title text-3xl md:text-4xl font-bold font-display mb-4 text-slate-900 dark:text-white leading-tight">', '</h1>'); ?>

                            <div class="entry-meta flex flex-wrap items-center gap-4 text-slate-500 dark:text-slate-400 text-xs font-medium border-b border-slate-100 dark:border-slate-800 pb-4 mb-6">
                                <span class="flex items-center">
                                    <span class="material-symbols-outlined text-base mr-1 text-primary">calendar_today</span>
                                    <?php echo esc_html(get_the_date()); ?>
                                </span>
                                <span class="flex items-center">
                                    <span class="material-symbols-outlined text-base mr-1 text-primary">person</span>
                                    <?php the_author(); ?>
                                </span>
                            </div>
                        </header>

                        <div class="entry-content prose prose-slate dark:prose-invert max-w-none prose-headings:font-display prose-headings:font-bold prose-a:text-primary hover:prose-a:text-primary/80 prose-img:rounded-xl prose-img:shadow-lg">
                            <?php
                            the_content();

                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'city-library'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>
                    </div>

                </div>

                <!-- Gallery Section (Bottom) -->
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
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <?php foreach ($attachments as $attachment) :
                                $img_url = wp_get_attachment_image_src($attachment->ID, 'full');
                                $thumb_url = wp_get_attachment_image_src($attachment->ID, 'medium');
                            ?>
                                <a href="<?php echo esc_url($img_url[0]); ?>" class="glightbox group relative overflow-hidden rounded-xl aspect-square shadow-md border border-slate-100 dark:border-slate-700 cursor-zoom-in">
                                    <img src="<?php echo esc_url($thumb_url[0]); ?>" alt="<?php echo esc_attr($attachment->post_title); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform scale-75 group-hover:scale-100">zoom_in</span>
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

                        const lightbox = GLightbox({
                            selector: '.glightbox',
                            touchNavigation: true,
                            loop: true,
                            autoplayVideos: true,
                            zoomable: true
                        });
                    });
                </script>
            </article>

        <?php
        endwhile; // End of the loop.
        ?>
    </div>
</div>

<?php get_footer(); ?>
