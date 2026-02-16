<?php
/**
 * Mobile Bottom Navigation Bar
 */
?>
<nav class="lg:landscape:hidden fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-50 border-t border-slate-200 safe-area-bottom">
    <div class="grid grid-cols-4 items-center h-20">
        <!-- Home -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="group flex flex-col items-center justify-center h-full text-slate-500 hover:text-primary active:text-primary transition-all">
            <span class="material-symbols-outlined text-3xl mb-1 group-active:scale-95 transition-transform">home</span>
            <span class="text-xs font-bold tracking-wide"><?php _e('Главная', 'city-library'); ?></span>
        </a>

        <!-- Events (Afisha) -->
        <a href="#afisha" class="group flex flex-col items-center justify-center h-full text-slate-500 hover:text-primary active:text-primary transition-all">
            <span class="material-symbols-outlined text-3xl mb-1 group-active:scale-95 transition-transform">calendar_month</span>
            <span class="text-xs font-bold tracking-wide"><?php _e('Афиша', 'city-library'); ?></span>
        </a>

        <!-- Search (Using existing modal trigger) -->
        <button onclick="document.getElementById('search-toggle').click();" class="group flex flex-col items-center justify-center h-full text-slate-500 hover:text-primary active:text-primary transition-all focus:outline-none">
            <span class="material-symbols-outlined text-3xl mb-1 group-active:scale-95 transition-transform">search</span>
            <span class="text-xs font-bold tracking-wide"><?php _e('Поиск', 'city-library'); ?></span>
        </button>

        <!-- Menu (Using existing mobile menu trigger) -->
        <button onclick="document.getElementById('mobile-menu-btn').click();" class="group flex flex-col items-center justify-center h-full text-slate-500 hover:text-primary active:text-primary transition-all focus:outline-none">
            <span class="material-symbols-outlined text-3xl mb-1 group-active:scale-95 transition-transform">menu</span>
            <span class="text-xs font-bold tracking-wide"><?php _e('Меню', 'city-library'); ?></span>
        </button>
    </div>
</nav>
