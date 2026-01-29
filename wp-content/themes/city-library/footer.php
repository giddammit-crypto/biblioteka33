</main>

<?php
if (get_theme_mod('show_partners_section', true)) {
    get_template_part('template-parts/content-partners');
}
?>

<footer class="bg-slate-950 text-slate-300 py-20 relative overflow-hidden <?php echo city_library_get_animation_class(); ?>">
    <!-- Decorative Background Blob -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

    <div class="w-full max-w-[95%] sm:max-w-[90%] xl:max-w-[85%] 2xl:max-w-[80%] mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 relative z-10">

        <!-- Column 1: Brand & Description -->
        <div class="footer-column space-y-8">
            <div class="flex items-center gap-3">
                 <?php if (has_custom_logo()) :
                     the_custom_logo();
                 else : ?>
                    <div class="w-10 h-10 bg-primary/20 backdrop-blur-md rounded-lg flex items-center justify-center border border-primary/30">
                        <span class="material-symbols-outlined text-primary">menu_book</span>
                    </div>
                 <?php endif; ?>
                 <span class="font-display font-bold text-xl text-white tracking-wide"><?php echo esc_html(get_theme_mod('header_title', 'Библиотека')); ?></span>
            </div>

            <?php
            $footer_desc = get_theme_mod('footer_description');
            if ($footer_desc) : ?>
                <div class="opacity-80 leading-relaxed text-sm font-light">
                    <?php echo wpautop(esc_html($footer_desc)); ?>
                </div>
            <?php endif; ?>

            <div class="flex gap-4">
                <!-- Social Placeholders -->
                <a href="#" class="w-10 h-10 rounded-full bg-slate-900 flex items-center justify-center hover:bg-primary hover:text-white transition-all duration-300 border border-slate-800">
                    <span class="text-xs font-bold">VK</span>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-slate-900 flex items-center justify-center hover:bg-primary hover:text-white transition-all duration-300 border border-slate-800">
                    <span class="text-xs font-bold">TG</span>
                </a>
            </div>

            <?php if (is_active_sidebar('footer-1')) : ?>
                 <?php dynamic_sidebar('footer-1'); ?>
            <?php endif; ?>
        </div>

        <!-- Column 2: Contacts -->
        <div class="footer-column space-y-6">
             <?php
            $phone = get_theme_mod('footer_phone');
            $email = get_theme_mod('footer_email');
            $address = get_theme_mod('footer_address');
            ?>
            <h4 class="font-bold text-white uppercase text-xs tracking-[0.2em] mb-8 relative inline-block after:content-[''] after:absolute after:-bottom-3 after:left-0 after:w-8 after:h-0.5 after:bg-secondary"><?php _e('Контакты', 'city-library'); ?></h4>

            <?php if ($phone || $email || $address) : ?>
                <ul class="space-y-6 text-sm">
                    <?php if ($address) : ?>
                        <li class="flex items-start group">
                            <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center mr-4 shrink-0 border border-slate-800 group-hover:border-primary transition-colors">
                                <span class="material-symbols-outlined text-sm text-primary">location_on</span>
                            </div>
                            <span class="pt-1.5"><?php echo esc_html($address); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if ($phone) : ?>
                        <li class="flex items-center group">
                            <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center mr-4 shrink-0 border border-slate-800 group-hover:border-primary transition-colors">
                                <span class="material-symbols-outlined text-sm text-primary">call</span>
                            </div>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="hover:text-white transition-colors pt-0.5"><?php echo esc_html($phone); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if ($email) : ?>
                        <li class="flex items-center group">
                             <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center mr-4 shrink-0 border border-slate-800 group-hover:border-primary transition-colors">
                                <span class="material-symbols-outlined text-sm text-primary">mail</span>
                            </div>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="hover:text-white transition-colors pt-0.5"><?php echo esc_html($email); ?></a>
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
    <div class="w-full max-w-[95%] sm:max-w-[90%] xl:max-w-[85%] 2xl:max-w-[80%] mx-auto px-4 sm:px-6 lg:px-8 mt-20 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center text-xs text-slate-500 font-medium">
        <p><?php echo esc_html(get_theme_mod('footer_copyright', '© 2024 Центральная городская библиотека. Все права защищены.')); ?></p>
        <div class="flex space-x-8 mt-4 md:mt-0">
            <a href="<?php echo esc_url(get_theme_mod('footer_privacy_link', '#')); ?>" class="hover:text-secondary transition-colors"><?php _e('Политика конфиденциальности', 'city-library'); ?></a>
            <a href="<?php echo esc_url(get_theme_mod('footer_sitemap_link', '#')); ?>" class="hover:text-secondary transition-colors"><?php _e('Карта сайта', 'city-library'); ?></a>
        </div>
    </div>
</footer>

<?php if (get_theme_mod('show_back_to_top', true)) : ?>
<button id="back-to-top" class="hidden fixed bottom-8 right-8 w-12 h-12 bg-white/10 hover:bg-secondary backdrop-blur-md text-white rounded-full shadow-glass flex items-center justify-center transition-all hover:scale-110 z-50 border border-white/10 group">
    <span class="material-symbols-outlined text-xl group-hover:animate-bounce">arrow_upward</span>
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
            $file_ext = strtolower(pathinfo($modal_video, PATHINFO_EXTENSION));
            $mime_type = 'video/' . $file_ext;
            if ($file_ext === 'mov' || $file_ext === 'qt') $mime_type = 'video/quicktime';
            if ($file_ext === 'avi') $mime_type = 'video/x-msvideo';
            if ($file_ext === 'mkv') $mime_type = 'video/x-matroska';
        ?>
            <div class="w-full aspect-video">
                <video class="w-full h-full object-cover rounded-t-2xl" controls autoplay muted loop playsinline disableRemotePlayback controlsList="nodownload noremoteplayback">
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
                echo city_library_sanitize_html(do_shortcode(wpautop($modal_text)));
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
