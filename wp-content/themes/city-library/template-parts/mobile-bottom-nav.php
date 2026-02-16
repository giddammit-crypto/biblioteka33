<?php
/**
 * Mobile Bottom Navigation Bar
 */
?>
<nav class="xl:hidden fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-50 border-t border-slate-200">
    <div class="grid grid-cols-4 items-center h-16">
        <!-- Home -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex flex-col items-center justify-center h-full text-slate-500 hover:text-primary active:text-primary transition-colors">
            <span class="material-symbols-outlined text-2xl mb-0.5">home</span>
            <span class="text-[10px] font-medium tracking-wide"><?php _e('Главная', 'city-library'); ?></span>
        </a>

        <!-- Events (Afisha) -->
        <a href="#afisha" class="flex flex-col items-center justify-center h-full text-slate-500 hover:text-primary active:text-primary transition-colors">
            <span class="material-symbols-outlined text-2xl mb-0.5">calendar_month</span>
            <span class="text-[10px] font-medium tracking-wide"><?php _e('Афиша', 'city-library'); ?></span>
        </a>

        <!-- Search (Using existing modal trigger) -->
        <button onclick="document.getElementById('search-toggle').click();" class="flex flex-col items-center justify-center h-full text-slate-500 hover:text-primary active:text-primary transition-colors focus:outline-none">
            <span class="material-symbols-outlined text-2xl mb-0.5">search</span>
            <span class="text-[10px] font-medium tracking-wide"><?php _e('Поиск', 'city-library'); ?></span>
        </button>

        <!-- Menu (Using existing mobile menu trigger) -->
        <button onclick="document.getElementById('mobile-menu-btn').click();" class="flex flex-col items-center justify-center h-full text-slate-500 hover:text-primary active:text-primary transition-colors focus:outline-none">
            <span class="material-symbols-outlined text-2xl mb-0.5">menu</span>
            <span class="text-[10px] font-medium tracking-wide"><?php _e('Меню', 'city-library'); ?></span>
        </button>
    </div>
</nav>
