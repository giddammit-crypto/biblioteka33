</main>

<?php
if (get_theme_mod('show_partners_section', true)) {
    get_template_part('template-parts/content-partners');
}
?>

<footer class="bg-secondary text-white py-16 reveal-on-scroll bg-pattern-white" style="background-color: <?php echo esc_attr(get_theme_mod('footer_bg_color', '#1A3C34')); ?>; color: <?php echo esc_attr(get_theme_mod('footer_text_color', '#FFFFFF')); ?>;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

        <!-- Custom Footer Content / Widget 1 -->
        <div class="footer-column space-y-6">
            <?php
            $footer_desc = get_theme_mod('footer_description');
            if ($footer_desc) : ?>
                <div class="mb-6 opacity-90 leading-relaxed text-sm">
                    <?php echo wpautop(esc_html($footer_desc)); ?>
                </div>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-1')) : ?>
                 <?php dynamic_sidebar('footer-1'); ?>
            <?php endif; ?>
        </div>

        <!-- Contact Info / Widget 2 -->
        <div class="footer-column space-y-4">
             <?php
            $phone = get_theme_mod('footer_phone');
            $email = get_theme_mod('footer_email');
            $address = get_theme_mod('footer_address');

            if ($phone || $email || $address) : ?>
                <h4 class="font-bold mb-6 text-primary uppercase text-xs tracking-widest"><?php _e('Контакты', 'city-library'); ?></h4>
                <ul class="space-y-4 text-sm">
                    <?php if ($address) : ?>
                        <li class="flex items-start">
                            <span class="material-symbols-outlined mr-3 text-primary shrink-0">location_on</span>
                            <span><?php echo esc_html($address); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if ($phone) : ?>
                        <li class="flex items-center">
                            <span class="material-symbols-outlined mr-3 text-primary shrink-0">call</span>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="hover:text-primary transition-colors"><?php echo esc_html($phone); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($email) : ?>
                        <li class="flex items-center">
                            <span class="material-symbols-outlined mr-3 text-primary shrink-0">mail</span>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="hover:text-primary transition-colors"><?php echo esc_html($email); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>

            <?php if (is_active_sidebar('footer-2')) : ?>
                <div class="mt-8">
                    <?php dynamic_sidebar('footer-2'); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Widget 3 -->
        <?php if (is_active_sidebar('footer-3')) : ?>
            <div class="footer-widget-area">
                <?php dynamic_sidebar('footer-3'); ?>
            </div>
        <?php endif; ?>

        <!-- Widget 4 -->
        <?php if (is_active_sidebar('footer-4')) : ?>
            <div class="footer-widget-area">
                <?php dynamic_sidebar('footer-4'); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center text-xs text-slate-500">
        <p><?php echo esc_html(get_theme_mod('footer_copyright', '© 2024 Центральная городская библиотека. Все права защищены.')); ?></p>
        <div class="flex space-x-6 mt-4 md:mt-0">
            <a href="<?php echo esc_url(get_theme_mod('footer_privacy_link', '#')); ?>" class="hover:text-white transition-colors"><?php _e('Политика конфиденциальности', 'city-library'); ?></a>
            <a href="<?php echo esc_url(get_theme_mod('footer_sitemap_link', '#')); ?>" class="hover:text-white transition-colors"><?php _e('Карта сайта', 'city-library'); ?></a>
        </div>
    </div>
</footer>

<?php if (get_theme_mod('show_back_to_top', true)) : ?>
<button id="back-to-top" class="hidden fixed bottom-8 right-8 w-14 h-14 bg-primary hover:bg-yellow-600 text-secondary rounded-full shadow-2xl flex items-center justify-center transition-transform hover:scale-110 z-50">
    <span class="material-symbols-outlined text-2xl">arrow_upward</span>
</button>
<?php endif; ?>


<?php
// Modal Popup Logic
if (get_theme_mod('show_modal', false)) :
    $modal_image = get_theme_mod('modal_image');
    $modal_video = get_theme_mod('modal_video');
    $modal_title = get_theme_mod('modal_title', 'Специальное предложение!');
    $modal_text = get_theme_mod('modal_text', 'Подпишитесь на нашу рассылку новостей.');
    $modal_delay = get_theme_mod('modal_delay', 3000);
?>
<div id="city-library-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 hidden" data-delay="<?php echo esc_attr($modal_delay); ?>">
    <div class="modal-content bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-2xl w-full mx-4 relative overflow-hidden animate-fade-in-up max-h-[90vh] overflow-y-auto">
        <button class="modal-close absolute top-4 right-4 text-slate-400 hover:text-red-500 transition-colors z-20 bg-white/80 rounded-full p-1 shadow-sm">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>
        <?php if ($modal_video) :
            $file_ext = pathinfo($modal_video, PATHINFO_EXTENSION);
            $mime_type = 'video/' . $file_ext;
            if ($file_ext === 'mov') $mime_type = 'video/quicktime';
        ?>
            <div class="w-full">
                <video class="w-full h-auto max-h-[40vh] object-cover" controls autoplay muted loop playsinline disableRemotePlayback controlsList="nodownload noremoteplayback">
                    <source src="<?php echo esc_url($modal_video); ?>" type="<?php echo esc_attr($mime_type); ?>">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php elseif ($modal_image) : ?>
            <div class="w-full">
                <img src="<?php echo esc_url($modal_image); ?>" alt="<?php echo esc_attr($modal_title); ?>" class="w-full h-auto object-cover max-h-[40vh]">
            </div>
        <?php endif; ?>
        <div class="p-8 text-center space-y-4">
            <?php if ($modal_title) : ?>
                <h3 class="text-2xl font-bold font-display text-slate-900 dark:text-white"><?php echo esc_html($modal_title); ?></h3>
            <?php endif; ?>
            <div class="prose prose-sm dark:prose-invert mx-auto text-slate-600 dark:text-slate-400 max-w-none">
                <?php
                // Allow HTML including iframes and buttons
                echo city_library_sanitize_html(wpautop($modal_text));
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
