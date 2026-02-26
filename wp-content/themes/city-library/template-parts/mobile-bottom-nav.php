<?php
/**
 * Mobile Bottom Navigation Bar
 */
$style = get_theme_mod('mobile_menu_style', 'default');
$icon_set = get_theme_mod('mobile_menu_icon_set', 'outlined');

// Icon Set Logic (Material Symbols variation)
$icon_base_class = 'material-symbols-' . $icon_set;
// If google font only loads 'material-symbols-outlined', we might need to rely on that or assume stylesheet supports others.
// Defaulting to standard class if custom one isn't loaded, but usually 'material-symbols-outlined' is the class.
// Let's use the standard class and rely on font-variation-settings if needed, or simple class swap if the font supports it.
// For compatibility with the existing setup which loads 'Material+Symbols+Outlined', we will stick to that or 'material-icons' if standard.
// Ideally, the font loader in functions.php should support these variants. Assuming 'outlined' is default.
$icon_font_class = 'material-symbols-outlined'; // Default
if ($icon_set === 'rounded') $icon_font_class = 'material-symbols-rounded'; // Requires font load
if ($icon_set === 'sharp') $icon_font_class = 'material-symbols-sharp'; // Requires font load
// Note: We are using the variable to inject class, but if the font isn't enqueued, it falls back or shows nothing.
// For this task, we assume the user might enqueue them or we stick to outlined styling changes.
// Let's stick to 'material-symbols-outlined' but add a data attribute or class for potential CSS manipulation.

// Default Classes
$nav_classes = 'lg:landscape:hidden fixed w-full z-50 safe-area-bottom transition-all duration-300';
$grid_classes = 'grid grid-cols-4 items-center h-20';
$item_classes = 'group flex flex-col items-center justify-center h-full transition-all relative overflow-hidden'; // Added relative/overflow for effects
$icon_classes = 'material-symbols-outlined text-3xl mb-1 group-active:scale-95 transition-transform z-10';
$text_classes = 'text-xs font-bold tracking-wide z-10';

// Style Variations Logic
switch ($style) {
    case 'default':
        $nav_classes .= ' bottom-0 left-0 border-t border-slate-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]';
        break;
    case 'ios-blur':
        $nav_classes .= ' bottom-0 left-0 bg-white/80 backdrop-blur-xl border-t border-white/20';
        break;
    case 'material-pill':
        $nav_classes .= ' bottom-4 left-4 right-4 w-[calc(100%-2rem)] rounded-full shadow-2xl border border-slate-100';
        $grid_classes = 'grid grid-cols-4 items-center h-16 rounded-full overflow-hidden';
        break;
    case 'neon-glow':
        $nav_classes .= ' bottom-0 left-0 border-t border-slate-800 shadow-[0_-4px_20px_rgba(0,255,0,0.2)]';
        break;
    case 'minimal-border':
        $nav_classes .= ' bottom-0 left-0 border-t-2';
        $grid_classes = 'grid grid-cols-4 items-center h-16';
        $text_classes .= ' hidden';
        break;
    case 'floating-island':
        $nav_classes .= ' bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-sm rounded-[2rem] shadow-xl border border-slate-200/50';
        $grid_classes = 'grid grid-cols-4 items-center h-20 rounded-[2rem] overflow-hidden';
        break;
    case 'glassmorphism':
        $nav_classes .= ' bottom-4 left-4 right-4 w-[calc(100%-2rem)] rounded-2xl shadow-xl border border-white/30 backdrop-blur-lg bg-white/20';
        $grid_classes = 'grid grid-cols-4 items-center h-20 rounded-2xl';
        break;
    case 'gradient-bar':
        $nav_classes .= ' bottom-0 left-0 shadow-lg';
        $grid_classes = 'grid grid-cols-4 items-center h-16 bg-gradient-to-r from-primary to-blue-500 text-white';
        break;
    case 'tab-bar':
        $nav_classes .= ' bottom-0 left-0 bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.05)]';
        $grid_classes = 'flex justify-around items-center h-16';
        $item_classes = 'group flex-1 flex flex-col items-center justify-center h-full relative';
        break;
    case 'floating-dock':
        $nav_classes .= ' bottom-4 left-1/2 -translate-x-1/2 w-auto min-w-[300px] px-6 rounded-3xl shadow-2xl bg-white/90 backdrop-blur-md border border-slate-200/50';
        $grid_classes = 'flex gap-6 items-center h-20 justify-center';
        $item_classes = 'group flex flex-col items-center justify-center transition-all hover:-translate-y-2 duration-300';
        break;
    case 'minimal-icons':
        $nav_classes .= ' bottom-0 left-0 bg-white border-t border-slate-100';
        $grid_classes = 'flex justify-around items-center h-16';
        $text_classes .= ' hidden';
        $icon_classes .= ' text-2xl';
        break;
    case 'text-only':
        $nav_classes .= ' bottom-0 left-0 bg-white border-t border-slate-200';
        $grid_classes = 'grid grid-cols-4 items-center h-14';
        $icon_classes .= ' hidden';
        $text_classes = 'text-sm font-bold uppercase tracking-widest';
        break;
    case 'cyberpunk':
        $nav_classes .= ' bottom-0 left-0 border-t-2 border-primary bg-slate-900 clip-path-polygon';
        $grid_classes = 'grid grid-cols-4 items-center h-20';
        $item_classes .= ' hover:bg-primary/20';
        break;
    case 'neumorphism':
        $nav_classes .= ' bottom-0 left-0 bg-[#e0e5ec] shadow-[inset_0_1px_0_rgba(255,255,255,0.5)]';
        $grid_classes = 'flex justify-around items-center h-20';
        $item_classes = 'w-14 h-14 rounded-full flex items-center justify-center shadow-[6px_6px_12px_#b8b9be,-6px_-6px_12px_#ffffff] active:shadow-[inset_6px_6px_12px_#b8b9be,inset_-6px_-6px_12px_#ffffff] text-slate-500';
        $text_classes .= ' hidden';
        break;
    case 'retro-pixel':
        $nav_classes .= ' bottom-0 left-0 border-t-4 border-black bg-white';
        $grid_classes = 'grid grid-cols-4 items-center h-16';
        $item_classes .= ' border-r-2 border-black last:border-r-0 active:bg-slate-200';
        break;
    case 'sidebar-drawer':
        $nav_classes .= ' bottom-0 left-0 rounded-t-3xl shadow-[0_-10px_40px_rgba(0,0,0,0.1)] border-t border-slate-100';
        $grid_classes = 'grid grid-cols-4 items-center h-24 pb-4';
        break;
}

// Colors CSS Variable Wrapper
?>
<style>
.mob-nav-custom {
    background-color: var(--mob-menu-bg);
    font-family: var(--mob-menu-font);
}
.mob-nav-item {
    color: var(--mob-menu-icon);
}
.mob-nav-item .text-xs, .mob-nav-item .text-sm {
    color: var(--mob-menu-font-color);
}
.mob-nav-item:hover, .mob-nav-item:active, .mob-nav-item.active {
    color: var(--mob-menu-active);
}
.mob-nav-item:hover .text-xs, .mob-nav-item:hover .text-sm {
    color: var(--mob-menu-active);
}

/* Style Specific Overrides */
<?php if ($style === 'ios-blur') : ?>
.mob-nav-custom { background-color: rgba(255,255,255,0.85) !important; backdrop-filter: blur(20px); }
<?php endif; ?>
<?php if ($style === 'neon-glow') : ?>
.mob-nav-custom { background-color: #0f172a !important; color: #94a3b8; }
.mob-nav-item.active { text-shadow: 0 0 10px var(--mob-menu-active); }
<?php endif; ?>
<?php if ($style === 'gradient-bar') : ?>
.mob-nav-custom { background: linear-gradient(to right, var(--primary-color), var(--secondary-color)) !important; }
.mob-nav-item, .mob-nav-item .text-xs { color: rgba(255,255,255,0.8) !important; }
.mob-nav-item:hover, .mob-nav-item.active { color: #ffffff !important; transform: scale(1.1); }
<?php endif; ?>
<?php if ($style === 'tab-bar') : ?>
.mob-nav-item.active::after { content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 40px; height: 3px; background: var(--mob-menu-active); border-radius: 0 0 4px 4px; }
<?php endif; ?>
<?php if ($style === 'retro-pixel') : ?>
.mob-nav-custom { font-family: 'Courier New', monospace; letter-spacing: -1px; }
<?php endif; ?>
</style>

<nav class="<?php echo esc_attr($nav_classes); ?> mob-nav-custom">
    <div class="<?php echo esc_attr($grid_classes); ?>">
        <!-- Home -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="<?php echo esc_attr($item_classes); ?> mob-nav-item">
            <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?> <?php echo esc_attr($icon_base_class); ?>">home</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Главная', 'city-library'); ?></span>
        </a>

        <!-- Events (Afisha) -->
        <a href="#afisha" class="<?php echo esc_attr($item_classes); ?> mob-nav-item">
            <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?> <?php echo esc_attr($icon_base_class); ?>">calendar_month</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Афиша', 'city-library'); ?></span>
        </a>

        <!-- Search -->
        <button onclick="document.getElementById('search-toggle').click();" class="<?php echo esc_attr($item_classes); ?> mob-nav-item focus:outline-none">
            <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?> <?php echo esc_attr($icon_base_class); ?>">search</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Поиск', 'city-library'); ?></span>
        </button>

        <!-- Menu -->
        <button onclick="window.openMobileMenu && window.openMobileMenu()" class="<?php echo esc_attr($item_classes); ?> mob-nav-item focus:outline-none">
            <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?> <?php echo esc_attr($icon_base_class); ?>">menu</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Меню', 'city-library'); ?></span>
        </button>
    </div>
</nav>
