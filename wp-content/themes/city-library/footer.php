</main>

<?php
if (get_theme_mod('show_partners_section', true)) {
    get_template_part('template-parts/content-partners');
}
?>

<footer class="bg-secondary text-white py-16" style="background-color: <?php echo esc_attr(get_theme_mod('footer_bg_color', '#1A3C34')); ?>; color: <?php echo esc_attr(get_theme_mod('footer_text_color', '#FFFFFF')); ?>;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
        <?php if (is_active_sidebar('footer-1')) : ?>
            <div class="footer-widget-area">
                <?php dynamic_sidebar('footer-1'); ?>
            </div>
        <?php endif; ?>
        <?php if (is_active_sidebar('footer-2')) : ?>
            <div class="footer-widget-area">
                <?php dynamic_sidebar('footer-2'); ?>
            </div>
        <?php endif; ?>
        <?php if (is_active_sidebar('footer-3')) : ?>
            <div class="footer-widget-area">
                <?php dynamic_sidebar('footer-3'); ?>
            </div>
        <?php endif; ?>
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
<button id="back-to-top" class="hidden fixed bottom-8 right-8 w-14 h-14 bg-primary hover:bg-yellow-600 text-secondary rounded-full shadow-2xl flex items-center justify-center transition-transform hover:scale-110 z-50" aria-label="<?php esc_attr_e('Scroll to top', 'city-library'); ?>" title="<?php esc_attr_e('Scroll to top', 'city-library'); ?>">
    <span class="material-symbols-outlined text-2xl">arrow_upward</span>
</button>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
