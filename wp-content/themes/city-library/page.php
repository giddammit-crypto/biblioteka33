<?php get_header(); ?>

<div class="w-full max-w-[95%] mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div id="primary" class="w-full transition-all duration-300 max-w-6xl mx-auto">

        <?php
        while (have_posts()) :
            the_post();
            get_template_part('template-parts/content', 'page');
        endwhile; // End of the loop.
        ?>
    </div>
</div>

<?php get_footer(); ?>
