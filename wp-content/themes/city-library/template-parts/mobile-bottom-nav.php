<?php
/**
 * Template part for the Mobile Bottom Navigation Bar.
 */
?>
<div class="fixed bottom-0 left-0 w-full bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-t border-slate-200 dark:border-slate-800 z-50 lg:hidden pb-[env(safe-area-inset-bottom)]">
    <div class="grid grid-cols-4 h-16">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex flex-col items-center justify-center text-slate-500 dark:text-slate-400 hover:text-primary transition-colors group">
            <span class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">home</span>
            <span class="text-[10px] font-bold mt-1 tracking-wide"><?php _e('Главная', 'city-library'); ?></span>
        </a>

        <a href="<?php echo esc_url(add_query_arg('news_archive', 'true', home_url('/'))); ?>" class="flex flex-col items-center justify-center text-slate-500 dark:text-slate-400 hover:text-primary transition-colors group">
            <span class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">newspaper</span>
            <span class="text-[10px] font-bold mt-1 tracking-wide"><?php _e('Новости', 'city-library'); ?></span>
        </a>

        <a href="<?php echo esc_url(home_url('/#events')); ?>" class="flex flex-col items-center justify-center text-slate-500 dark:text-slate-400 hover:text-primary transition-colors group">
            <span class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">event</span>
            <span class="text-[10px] font-bold mt-1 tracking-wide"><?php _e('Афиша', 'city-library'); ?></span>
        </a>

        <button class="mobile-menu-trigger flex flex-col items-center justify-center text-slate-500 dark:text-slate-400 hover:text-primary transition-colors group focus:outline-none">
            <span class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">menu</span>
            <span class="text-[10px] font-bold mt-1 tracking-wide"><?php _e('Меню', 'city-library'); ?></span>
        </button>
    </div>
</div>
