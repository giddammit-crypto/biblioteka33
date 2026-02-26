<?php
/**
 * Mobile Bottom Navigation Bar
 */
$style = get_theme_mod('mobile_menu_style', 'default');

// Default Classes
$nav_classes = 'lg:landscape:hidden fixed w-full z-50 safe-area-bottom transition-all duration-300';
$grid_classes = 'grid grid-cols-4 items-center h-20';
$item_classes = 'group flex flex-col items-center justify-center h-full transition-all';
$icon_classes = 'material-symbols-outlined text-3xl mb-1 group-active:scale-95 transition-transform';
$text_classes = 'text-xs font-bold tracking-wide';

// Style Variations
if ($style === 'default') {
    $nav_classes .= ' bottom-0 left-0 border-t border-slate-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]';
    // Colors applied via style tag below
} elseif ($style === 'ios-blur') {
    $nav_classes .= ' bottom-0 left-0 bg-white/80 backdrop-blur-xl border-t border-white/20';
} elseif ($style === 'material-pill') {
    $nav_classes .= ' bottom-4 left-4 right-4 w-[calc(100%-2rem)] rounded-full shadow-2xl border border-slate-100';
    $grid_classes = 'grid grid-cols-4 items-center h-16 rounded-full overflow-hidden';
} elseif ($style === 'neon-glow') {
    $nav_classes .= ' bottom-0 left-0 border-t border-slate-800 shadow-[0_-4px_20px_rgba(0,255,0,0.2)]';
} elseif ($style === 'minimal-border') {
    $nav_classes .= ' bottom-0 left-0 border-t-2';
    $grid_classes = 'grid grid-cols-4 items-center h-16';
    $text_classes .= ' hidden'; // Icons only for minimal
} elseif ($style === 'floating-island') {
    $nav_classes .= ' bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-sm rounded-[2rem] shadow-xl border border-slate-200/50';
    $grid_classes = 'grid grid-cols-4 items-center h-20 rounded-[2rem] overflow-hidden';
}

// Colors CSS Variable Wrapper
?>
<style>
.mob-nav-custom {
    background-color: var(--mob-menu-bg);
}
.mob-nav-item {
    color: var(--mob-menu-icon);
}
.mob-nav-item:hover, .mob-nav-item:active, .mob-nav-item.active {
    color: var(--mob-menu-active);
}
/* Style Overrides */
<?php if ($style === 'ios-blur') : ?>
.mob-nav-custom { background-color: rgba(255,255,255,0.85) !important; backdrop-filter: blur(20px); }
<?php endif; ?>
<?php if ($style === 'neon-glow') : ?>
.mob-nav-custom { background-color: #0f172a !important; color: #94a3b8; }
<?php endif; ?>
</style>

<nav class="<?php echo esc_attr($nav_classes); ?> mob-nav-custom">
    <div class="<?php echo esc_attr($grid_classes); ?>">
        <!-- Home -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="<?php echo esc_attr($item_classes); ?> mob-nav-item">
            <span class="<?php echo esc_attr($icon_classes); ?>">home</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Главная', 'city-library'); ?></span>
        </a>

        <!-- Events (Afisha) -->
        <a href="#afisha" class="<?php echo esc_attr($item_classes); ?> mob-nav-item">
            <span class="<?php echo esc_attr($icon_classes); ?>">calendar_month</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Афиша', 'city-library'); ?></span>
        </a>

        <!-- Search -->
        <button onclick="document.getElementById('search-toggle').click();" class="<?php echo esc_attr($item_classes); ?> mob-nav-item focus:outline-none">
            <span class="<?php echo esc_attr($icon_classes); ?>">search</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Поиск', 'city-library'); ?></span>
        </button>

        <!-- Menu -->
        <button onclick="document.getElementById('mobile-menu-btn').click();" class="<?php echo esc_attr($item_classes); ?> mob-nav-item focus:outline-none">
            <span class="<?php echo esc_attr($icon_classes); ?>">menu</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Меню', 'city-library'); ?></span>
        </button>
    </div>
</nav>
