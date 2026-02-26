<?php
/**
 * Mobile Bottom Navigation Bar
 */
$bar_style = get_theme_mod('mobile_menu_style', 'default');
$btn_style = get_theme_mod('mobile_menu_btn_style', 'classic');
$icon_set = get_theme_mod('mobile_menu_icon_set', 'outlined');

// Icon Logic
$icon_base_class = 'material-symbols-' . $icon_set;
$icon_font_class = 'material-symbols-outlined';
if ($icon_set === 'rounded') $icon_font_class = 'material-symbols-rounded';
if ($icon_set === 'sharp') $icon_font_class = 'material-symbols-sharp';

// Base Classes
$nav_classes = 'lg:landscape:hidden fixed w-full z-50 safe-area-bottom transition-all duration-300';
$grid_classes = 'grid grid-cols-4 items-center h-20 px-2'; // Added padding
$item_base_classes = 'group flex flex-col items-center justify-center h-full transition-all relative overflow-hidden rounded-xl'; // Added rounded
$icon_classes = 'material-symbols-outlined text-2xl mb-1 transition-transform z-10';
$text_classes = 'text-[10px] font-bold tracking-wide z-10';

/* --- 1. Bar Styles (Container) --- */
// The user requested "One background color". We rely on the Customizer 'mobile_menu_bg_color' variable.
// We apply specific shapes/shadows based on style, but override BG.

switch ($bar_style) {
    case 'default':
        $nav_classes .= ' bottom-0 left-0 border-t border-slate-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]';
        break;
    case 'ios-blur':
        // User asked for "one color", but blur implies translucency. We'll keep the class but the inline style might override if opacity is 1.
        $nav_classes .= ' bottom-0 left-0 backdrop-blur-xl border-t border-white/20';
        break;
    case 'material-pill':
        $nav_classes .= ' bottom-4 left-4 right-4 w-[calc(100%-2rem)] rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/50 backdrop-blur-md bg-white/90';
        $grid_classes = 'grid grid-cols-4 items-center h-16 rounded-full overflow-hidden px-1';
        $item_base_classes = 'group flex flex-col items-center justify-center h-full transition-all relative overflow-hidden rounded-full mx-1 hover:bg-slate-100/50';
        break;
    case 'neon-glow':
        $nav_classes .= ' bottom-0 left-0 border-t border-slate-800 shadow-[0_-4px_20px_rgba(0,255,0,0.2)]';
        break;
    case 'minimal-border':
        $nav_classes .= ' bottom-0 left-0 border-t-2';
        $grid_classes = 'grid grid-cols-4 items-center h-16';
        break;
    case 'floating-island':
        $nav_classes .= ' bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-sm rounded-[2rem] shadow-xl border border-slate-200/50';
        $grid_classes = 'grid grid-cols-4 items-center h-20 rounded-[2rem] overflow-hidden';
        break;
    case 'glassmorphism':
        $nav_classes .= ' bottom-4 left-4 right-4 w-[calc(100%-2rem)] rounded-2xl shadow-xl border border-white/30 backdrop-blur-lg';
        $grid_classes = 'grid grid-cols-4 items-center h-20 rounded-2xl';
        break;
    case 'gradient-bar':
        $nav_classes .= ' bottom-0 left-0 shadow-lg';
        // Gradient logic handled in CSS
        break;
    case 'tab-bar':
        $nav_classes .= ' bottom-0 left-0 shadow-[0_-2px_10px_rgba(0,0,0,0.05)]';
        $grid_classes = 'flex justify-around items-center h-16';
        $item_base_classes = 'group flex-1 flex flex-col items-center justify-center h-full relative';
        break;
    case 'floating-dock':
        $nav_classes .= ' bottom-4 left-1/2 -translate-x-1/2 w-auto min-w-[300px] px-6 rounded-3xl shadow-2xl backdrop-blur-md border border-slate-200/50';
        $grid_classes = 'flex gap-6 items-center h-20 justify-center';
        break;
    case 'minimal-icons':
        $nav_classes .= ' bottom-0 left-0 border-t border-slate-100';
        $grid_classes = 'flex justify-around items-center h-16';
        break;
    case 'text-only':
        $nav_classes .= ' bottom-0 left-0 border-t border-slate-200';
        $grid_classes = 'grid grid-cols-4 items-center h-14';
        break;
    case 'cyberpunk':
        $nav_classes .= ' bottom-0 left-0 border-t-2 border-primary clip-path-polygon';
        $grid_classes = 'grid grid-cols-4 items-center h-20';
        break;
    case 'neumorphism':
        $nav_classes .= ' bottom-0 left-0 shadow-[inset_0_1px_0_rgba(255,255,255,0.5)]';
        $grid_classes = 'flex justify-around items-center h-20';
        break;
    case 'retro-pixel':
        $nav_classes .= ' bottom-0 left-0 border-t-4 border-black';
        $grid_classes = 'grid grid-cols-4 items-center h-16';
        break;
    case 'sidebar-drawer':
        $nav_classes .= ' bottom-0 left-0 rounded-t-3xl shadow-[0_-10px_40px_rgba(0,0,0,0.1)] border-t border-slate-100';
        $grid_classes = 'grid grid-cols-4 items-center h-24 pb-4';
        break;
}

/* --- 2. Button Styles (Items) --- */
$item_classes = $item_base_classes;

switch ($btn_style) {
    case 'classic':
        // Default: Icon + Text
        $item_classes .= ' hover:bg-black/5 active:scale-95';
        break;
    case 'minimal':
        // Icon Only (Hide Text)
        $text_classes .= ' hidden';
        $icon_classes .= ' text-3xl';
        $item_classes .= ' hover:bg-black/5 rounded-full aspect-square w-12 mx-auto';
        break;
    case 'bold':
        // Thick Icons
        $icon_classes .= ' font-bold'; // Requires font support or stroke adjustment
        $text_classes .= ' uppercase';
        $item_classes .= ' hover:-translate-y-1';
        break;
    case 'soft':
        // Pastel Colors handled in CSS
        $item_classes .= ' hover:bg-primary/10 rounded-xl mx-2 h-14 w-auto';
        break;
    case 'bubble':
        // Circle Background
        $item_classes = 'group flex flex-col items-center justify-center h-12 w-12 rounded-full mx-auto transition-all relative overflow-hidden hover:shadow-md';
        $text_classes .= ' hidden';
        $icon_classes .= ' mb-0';
        // Active state logic via CSS
        break;
    case 'square':
        // Square Background
        $item_classes = 'group flex flex-col items-center justify-center h-14 w-14 rounded-lg mx-auto transition-all relative overflow-hidden';
        $text_classes .= ' hidden';
        $icon_classes .= ' mb-0 text-3xl';
        break;
    case 'underline':
        // Active Underline
        // Handled in CSS
        $item_classes .= ' hover:bg-transparent';
        break;
    case 'glow':
        // Text Shadow
        $item_classes .= ' hover:scale-110';
        break;
    case 'floating':
        // Lift on Hover
        $item_classes .= ' hover:-translate-y-2 shadow-sm hover:shadow-lg rounded-2xl bg-white/50 border border-transparent hover:border-slate-100 mx-2 h-16';
        break;
    case 'glass-btn':
        // Glass Effect on Buttons
        $item_classes .= ' bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl mx-2 h-14 hover:bg-white/30';
        break;
}

// Ensure Text Only hides icons
if ($bar_style === 'text-only') {
    $icon_classes .= ' hidden';
}

?>
<style>
/* Dynamic Variables */
.mob-nav-custom {
    background-color: var(--mob-menu-bg);
    font-family: var(--mob-menu-font);
}
.mob-nav-item {
    color: var(--mob-menu-icon);
}
.mob-nav-item .text-[10px], .mob-nav-item .text-xs, .mob-nav-item .text-sm {
    color: var(--mob-menu-font-color);
}
.mob-nav-item:hover, .mob-nav-item:active, .mob-nav-item.active {
    color: var(--mob-menu-active);
}
.mob-nav-item:hover .text-[10px], .mob-nav-item:hover .text-xs {
    color: var(--mob-menu-active);
}

/* Button Style Specifics via CSS */
<?php if ($btn_style === 'bubble') : ?>
.mob-nav-item:hover, .mob-nav-item.active {
    background-color: var(--mob-menu-active);
    color: #ffffff !important;
}
.mob-nav-item:hover span, .mob-nav-item.active span {
    color: #ffffff !important;
}
<?php endif; ?>

<?php if ($btn_style === 'square') : ?>
.mob-nav-item:hover, .mob-nav-item.active {
    background-color: var(--mob-menu-active);
    color: #ffffff !important;
}
.mob-nav-item:hover span, .mob-nav-item.active span {
    color: #ffffff !important;
}
<?php endif; ?>

<?php if ($btn_style === 'soft') : ?>
.mob-nav-item.active {
    background-color: rgba(var(--primary-color-rgb), 0.1); /* Fallback or use opacity */
    background-color: #f0fdf4; /* Light green fallback */
}
<?php endif; ?>

<?php if ($btn_style === 'underline') : ?>
.mob-nav-item { position: relative; }
.mob-nav-item.active::after {
    content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
    width: 20px; height: 3px; background-color: var(--mob-menu-active); border-radius: 99px;
}
<?php endif; ?>

<?php if ($btn_style === 'glow') : ?>
.mob-nav-item.active {
    text-shadow: 0 0 8px var(--mob-menu-active);
}
<?php endif; ?>

/* Bar Style Specific Overrides */
<?php if ($bar_style === 'neon-glow') : ?>
.mob-nav-custom { background-color: #0f172a !important; color: #94a3b8; border-top: 1px solid #1e293b; }
<?php endif; ?>

<?php if ($bar_style === 'gradient-bar') : ?>
.mob-nav-custom { background: linear-gradient(to right, var(--primary-color), var(--secondary-color)) !important; }
.mob-nav-item, .mob-nav-item span { color: rgba(255,255,255,0.8) !important; }
.mob-nav-item:hover, .mob-nav-item.active { color: #ffffff !important; }
<?php endif; ?>

<?php if ($bar_style === 'retro-pixel') : ?>
.mob-nav-custom { font-family: 'Courier New', monospace; letter-spacing: -1px; }
.mob-nav-item { border-right: 2px solid #000; }
.mob-nav-item:last-child { border-right: none; }
<?php endif; ?>

</style>

<nav class="<?php echo esc_attr($nav_classes); ?> mob-nav-custom">
    <div class="<?php echo esc_attr($grid_classes); ?>">
        <!-- Home -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="<?php echo esc_attr($item_classes); ?> mob-nav-item <?php echo is_front_page() ? 'active' : ''; ?>">
            <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?> <?php echo esc_attr($icon_base_class); ?>">home</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Главная', 'city-library'); ?></span>
        </a>

        <!-- Events (Afisha) -->
        <a href="#afisha" class="<?php echo esc_attr($item_classes); ?> mob-nav-item">
            <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?> <?php echo esc_attr($icon_base_class); ?>">calendar_month</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Афиша', 'city-library'); ?></span>
        </a>

        <!-- Search (Opens Modal) -->
        <button id="search-toggle-mobile" class="<?php echo esc_attr($item_classes); ?> mob-nav-item focus:outline-none" aria-label="<?php esc_attr_e('Поиск', 'city-library'); ?>">
            <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?> <?php echo esc_attr($icon_base_class); ?>">search</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Поиск', 'city-library'); ?></span>
        </button>

        <!-- Menu (Opens Header Overlay) -->
        <button id="mobile-menu-toggle" class="<?php echo esc_attr($item_classes); ?> mob-nav-item focus:outline-none" aria-label="<?php esc_attr_e('Меню', 'city-library'); ?>">
            <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?> <?php echo esc_attr($icon_base_class); ?>">menu</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Меню', 'city-library'); ?></span>
        </button>
    </div>
</nav>
