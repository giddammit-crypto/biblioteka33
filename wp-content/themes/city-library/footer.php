
<?php
if (get_theme_mod('show_partners_section', true)) {
    get_template_part('template-parts/content-partners');
}
?>

<?php
$footer_style = get_theme_mod('footer_style', 'default');
$footer_classes = 'bg-slate-100 text-slate-900 py-16 bg-pattern-white ' . city_library_get_animation_class();
$footer_grid_classes = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-6 xl:gap-12';
$footer_container_classes = 'w-full max-w-[80%] mx-auto px-4 sm:px-6 lg:px-8';

// Footer Style Logic
if ($footer_style === 'light-clean') {
    $footer_classes = 'bg-white text-slate-700 py-12 border-t border-slate-100';
} elseif ($footer_style === 'centered') {
    // Modified: White BG, Dark Text, Underline on Hover
    $footer_classes = 'bg-white text-slate-700 py-20 text-center border-t border-slate-200 [&_a:hover]:underline [&_a:hover]:text-slate-900';
    $footer_grid_classes = 'flex flex-col items-center gap-10 max-w-3xl mx-auto';
    $footer_container_classes = 'w-full px-4';
} elseif ($footer_style === 'minimal') {
    $footer_classes = 'bg-white text-slate-500 py-8 border-t border-slate-200 text-sm';
    $footer_grid_classes = 'hidden'; // Hide widgets
} elseif ($footer_style === 'multi-column') {
    $footer_grid_classes = 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8';
}
?>

<footer class="<?php echo esc_attr($footer_classes); ?>" style="<?php if ($footer_style === 'default') { echo 'background-color: ' . esc_attr(get_theme_mod('footer_bg_color', '#F1F5F9')) . '; color: ' . esc_attr(get_theme_mod('footer_text_color', '#0F172A')) . ';'; } ?>">

    <!-- Width Correction: 80% to match other blocks -->
    <div class="<?php echo esc_attr($footer_container_classes); ?> <?php echo esc_attr($footer_grid_classes); ?>">

        <!-- Custom Footer Content / Widget 1 -->
        <div class="footer-column space-y-6">
            <?php if (get_theme_mod('footer_show_map', false)) :
                $map_height = get_theme_mod('footer_map_height', '300px');
                $map_width_desktop = get_theme_mod('footer_map_width_desktop', '250px');
            ?>
                <style>
                    #footer-yandex-map { width: 100%; }
                    @media (min-width: 1024px) {
                        #footer-yandex-map {
                            width: <?php echo esc_attr($map_width_desktop); ?>;
                            max-width: 100%;
                        }
                    }
                </style>
                <div id="footer-yandex-map" class="bg-slate-200 rounded-2xl overflow-hidden shadow-inner border border-slate-200" style="height: <?php echo esc_attr($map_height); ?>;"></div>
            <?php else : ?>
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

    <div class="w-full max-w-[80%] mx-auto px-4 sm:px-6 lg:px-8 mt-16 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center text-xs text-slate-500">
        <p><?php echo esc_html(get_theme_mod('footer_copyright', '© 2024 Центральная городская библиотека. Все права защищены.')); ?></p>

        <!-- Social Icons -->
        <div class="flex items-center space-x-4 mt-4 md:mt-0">
            <?php if (get_theme_mod('footer_social_vk')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('footer_social_vk')); ?>" target="_blank" rel="noopener noreferrer" class="transition-all transform hover:scale-110 shadow-sm rounded-lg overflow-hidden" aria-label="VKontakte">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/vk-logo.png" alt="VK" class="w-10 h-10 object-contain">
                </a>
            <?php endif; ?>
            <?php if (get_theme_mod('footer_social_telegram')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('footer_social_telegram')); ?>" target="_blank" rel="noopener noreferrer" class="p-2 rounded-full bg-slate-800 text-white hover:bg-[#229ED9] hover:text-white transition-all transform hover:scale-110 shadow-sm" aria-label="Telegram">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 11.944 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                </a>
            <?php endif; ?>
            <?php if (get_theme_mod('footer_social_ok')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('footer_social_ok')); ?>" target="_blank" rel="noopener noreferrer" class="p-2 rounded-full bg-slate-800 text-white hover:bg-[#ED812B] hover:text-white transition-all transform hover:scale-110 shadow-sm" aria-label="Odnoklassniki">
                   <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12.001 0a12 12 0 1 0-.001 24 12 12 0 0 0 .001-24zm3.872 7.502c.451 0 .817.366.817.817v.001a.818.818 0 0 1-.817.817 3.873 3.873 0 1 1-3.873-3.872 3.87 3.87 0 0 1 3.873 2.237zm-3.873 6.983c2.513 0 4.743-1.219 6.137-3.097.163-.22.115-.533-.105-.697a.496.496 0 0 0-.697.106 6.74 6.74 0 0 0-5.334 2.688 6.74 6.74 0 0 0-5.335-2.688.496.496 0 0 0-.697-.106.496.496 0 0 0-.105.697 7.915 7.915 0 0 1 6.136 3.097zm3.179 2.261c.217.217.217.569 0 .786L12.786 20a1.112 1.112 0 0 1-1.572 0l-2.321-2.321a.556.556 0 0 1 .786-.786l2.321 2.321 2.321-2.261a.556.556 0 0 1 .786 0z"/></svg>
                </a>
            <?php endif; ?>
            <?php if (get_theme_mod('footer_social_youtube')) : ?>
                <a href="<?php echo esc_url(get_theme_mod('footer_social_youtube')); ?>" target="_blank" rel="noopener noreferrer" class="p-2 rounded-full bg-slate-800 text-white hover:bg-[#FF0000] hover:text-white transition-all transform hover:scale-110 shadow-sm" aria-label="YouTube">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </a>
            <?php endif; ?>
        </div>

        <div class="flex space-x-6 mt-4 md:mt-0">
            <a href="<?php echo esc_url(get_theme_mod('footer_privacy_link', '#')); ?>" class="hover:text-white transition-colors"><?php _e('Политика конфиденциальности', 'city-library'); ?></a>
            <a href="<?php echo esc_url(get_theme_mod('footer_sitemap_link', '#')); ?>" class="hover:text-white transition-colors"><?php _e('Карта сайта', 'city-library'); ?></a>
        </div>
    </div>
</footer>

<!-- Back to top button removed as per request -->

<?php get_template_part('template-parts/mobile-bottom-nav'); ?>

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
    <div class="modal-content bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 relative overflow-hidden animate-fade-in-up max-h-[90vh] overflow-y-auto">
        <button class="modal-close absolute top-4 right-4 text-slate-400 hover:text-red-500 transition-colors z-20 bg-white/80 rounded-full p-1 shadow-sm" aria-label="<?php esc_attr_e('Закрыть модальное окно', 'city-library'); ?>">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>
        <?php if ($modal_video) :
            $file_ext = pathinfo($modal_video, PATHINFO_EXTENSION);
            $mime_type = 'video/' . $file_ext;
            if ($file_ext === 'mov') $mime_type = 'video/quicktime';
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
                <h3 class="text-2xl font-bold font-display text-slate-900"><?php echo esc_html($modal_title); ?></h3>
            <?php endif; ?>
            <div class="prose prose-sm mx-auto text-slate-600 max-w-none">
                <?php
                // Allow HTML including iframes and buttons
                echo city_library_sanitize_html(wpautop($modal_text));
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php get_template_part('template-parts/search-modal'); ?>

<?php wp_footer(); ?>
</body>
</html>
