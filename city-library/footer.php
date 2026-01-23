</main>
<footer class="bg-secondary text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12">
        <div class="space-y-6">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-primary rounded flex items-center justify-center">
                    <span class="material-symbols-outlined text-secondary text-xl font-bold">menu_book</span>
                </div>
                <span class="font-display font-bold text-xl"><?php bloginfo( 'name' ); ?></span>
            </div>
            <p class="text-slate-400 text-sm leading-relaxed">
                <?php bloginfo( 'description' ); ?>
            </p>
        </div>
        <div>
            <h4 class="font-bold mb-6 text-primary uppercase text-xs tracking-widest"><?php _e( 'Контакты', 'city-library' ); ?></h4>
            <ul class="space-y-4 text-sm text-slate-300">
                <li class="flex items-start space-x-3">
                    <span class="material-symbols-outlined text-primary text-sm">location_on</span>
                    <span><?php _e( 'ул. Центральная, д. 42<br>г. Владимир, 600000', 'city-library' ); ?></span>
                </li>
                <li class="flex items-center space-x-3">
                    <span class="material-symbols-outlined text-primary text-sm">call</span>
                    <span>+7 (4922) 32-00-00</span>
                </li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold mb-6 text-primary uppercase text-xs tracking-widest"><?php _e( 'Режим работы', 'city-library' ); ?></h4>
            <ul class="space-y-2 text-sm text-slate-300">
                <li class="flex justify-between">
                    <span><?php _e( 'Пн — Пт:', 'city-library' ); ?></span>
                    <span class="text-white">10:00 – 20:00</span>
                </li>
                <li class="flex justify-between">
                    <span><?php _e( 'Сб:', 'city-library' ); ?></span>
                    <span class="text-white">10:00 – 18:00</span>
                </li>
                <li class="flex justify-between">
                    <span><?php _e( 'Вс:', 'city-library' ); ?></span>
                    <span class="text-primary font-bold"><?php _e( 'Выходной', 'city-library' ); ?></span>
                </li>
            </ul>
        </div>
        <div>
            <h4 class="font-bold mb-6 text-primary uppercase text-xs tracking-widest"><?php _e( 'Подписка', 'city-library' ); ?></h4>
            <p class="text-xs text-slate-400 mb-4"><?php _e( 'Получайте анонсы мероприятий первыми', 'city-library' ); ?></p>
            <form class="flex space-x-2">
                <input class="bg-white/10 border-white/20 rounded-lg text-sm px-4 py-2 w-full focus:ring-primary focus:border-primary" placeholder="<?php esc_attr_e( 'Email', 'city-library' ); ?>" type="email"/>
                <button class="bg-primary text-secondary p-2 rounded-lg hover:bg-yellow-500 transition-colors" aria-label="<?php esc_attr_e( 'Подписаться', 'city-library' ); ?>">
                    <span class="material-symbols-outlined">send</span>
                </button>
            </form>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center text-xs text-slate-500">
        <p>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('Все права защищены.', 'city-library'); ?></p>
        <div class="flex space-x-6 mt-4 md:mt-0">
            <a class="hover:text-white transition-colors" href="#"><?php _e('Политика конфиденциальности', 'city-library'); ?></a>
            <a class="hover:text-white transition-colors" href="#"><?php _e('Карта сайта', 'city-library'); ?></a>
        </div>
    </div>
</footer>

<button class="fixed bottom-8 right-8 w-14 h-14 bg-red-600 hover:bg-red-700 text-white rounded-full shadow-2xl flex items-center justify-center transition-transform hover:scale-110 z-50">
    <span class="material-symbols-outlined text-2xl">person</span>
</button>

<?php wp_footer(); ?>

</body>
</html>
