<?php
/**
 * Mobile Bottom Navigation Bar
 */
?>
<nav class="lg:landscape:hidden fixed bottom-0 left-0 w-full bg-white/80 backdrop-blur-xl shadow-[0_-4px_24px_rgba(0,0,0,0.08)] z-50 border-t border-white/20 safe-area-bottom transition-all duration-300">
    <div class="grid grid-cols-4 items-center h-16 pb-safe">
        <!-- Home -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="group flex flex-col items-center justify-center h-full <?php echo is_front_page() ? 'text-primary' : 'text-slate-400'; ?> hover:text-primary active:text-primary transition-all relative">
            <span class="material-symbols-outlined text-[28px] mb-0.5 group-active:scale-90 transition-transform duration-200">home</span>
            <span class="text-[10px] font-bold tracking-wide"><?php _e('Главная', 'city-library'); ?></span>
            <?php if (is_front_page()) : ?>
                <span class="absolute top-0 w-8 h-1 bg-primary rounded-b-full shadow-[0_2px_8px_rgba(var(--color-primary-rgb),0.4)]"></span>
            <?php endif; ?>
        </a>

        <!-- Events (Afisha) -->
        <a href="#afisha" class="group flex flex-col items-center justify-center h-full text-slate-400 hover:text-primary active:text-primary transition-all relative">
            <span class="material-symbols-outlined text-[28px] mb-0.5 group-active:scale-90 transition-transform duration-200">calendar_month</span>
            <span class="text-[10px] font-bold tracking-wide"><?php _e('Афиша', 'city-library'); ?></span>
        </a>

        <!-- Search -->
        <button onclick="document.getElementById('search-toggle').click();" class="group flex flex-col items-center justify-center h-full text-slate-400 hover:text-primary active:text-primary transition-all focus:outline-none relative">
            <span class="material-symbols-outlined text-[28px] mb-0.5 group-active:scale-90 transition-transform duration-200">search</span>
            <span class="text-[10px] font-bold tracking-wide"><?php _e('Поиск', 'city-library'); ?></span>
        </button>

        <!-- Menu -->
        <button onclick="const mm = document.getElementById('mobile-menu'); if(mm) { mm.classList.remove('translate-x-full'); document.body.style.overflow = 'hidden'; }" class="group flex flex-col items-center justify-center h-full text-slate-400 hover:text-primary active:text-primary transition-all focus:outline-none relative">
            <span class="material-symbols-outlined text-[28px] mb-0.5 group-active:scale-90 transition-transform duration-200">menu</span>
            <span class="text-[10px] font-bold tracking-wide"><?php _e('Меню', 'city-library'); ?></span>
        </button>
    </div>
</nav>
