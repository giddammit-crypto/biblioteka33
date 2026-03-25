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
$grid_classes = 'grid grid-cols-4 items-center h-20 px-2';
$item_base_classes = 'group flex flex-col items-center justify-center h-full transition-all relative overflow-hidden rounded-xl';
$icon_classes = 'material-symbols-outlined text-2xl mb-1 transition-transform z-10';
$text_classes = 'text-[10px] font-bold tracking-wide z-10';

switch ($bar_style) {
    case 'default':
        $nav_classes .= ' bottom-6 left-4 right-4 w-[calc(100%-2rem)] rounded-[2rem] bg-slate-900/85 backdrop-blur-3xl shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-white/10';
        $grid_classes = 'grid grid-cols-4 items-center h-[72px] px-2 rounded-[2rem]';
        $item_base_classes = 'group flex flex-col items-center justify-center h-full transition-all relative overflow-hidden rounded-xl';
        break;
    case 'ios-blur':
        $nav_classes .= ' bottom-0 left-0 backdrop-blur-xl border-t border-white/20';
        break;
    case 'material-pill':
        $nav_classes .= ' bottom-4 left-4 right-4 w-[calc(100%-2rem)] rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/50 backdrop-blur-md bg-white/90';
        $grid_classes = 'grid grid-cols-4 items-center h-16 rounded-full overflow-hidden px-1';
        $item_base_classes = 'group flex flex-col items-center justify-center h-full transition-all relative overflow-hidden rounded-full mx-1 hover:bg-slate-100/50';
        break;
    default:
        $nav_classes .= ' bottom-0 left-0 bg-white shadow-lg';
        break;
}

$item_classes = $item_base_classes;
if ($btn_style === 'classic') $item_classes .= ' hover:bg-black/5 active:scale-95';

?>
<style>
.mob-nav-custom {
    <?php if ($bar_style !== 'default' && $bar_style !== 'ios-blur') : ?>
    background-color: var(--mob-menu-bg);
    <?php endif; ?>
    font-family: var(--mob-menu-font);
}

<?php if ($bar_style === 'default') : ?>
.mob-nav-item {
    color: #64748b;
    border-right: 1px solid rgba(255, 255, 255, 0.05);
}
.mob-nav-item:last-child { border-right: none; }
.mob-nav-item .text-[10px] { color: #94a3b8; }

.mob-nav-item:hover .material-symbols-outlined,
.mob-nav-item.active .material-symbols-outlined {
    background: linear-gradient(180deg, #38bdf8, #0ea5e9);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.mob-nav-item.active-home .material-symbols-outlined,
.mob-nav-item.active-home .text-\\[10px\\] {
    background: linear-gradient(180deg, #4ade80, #22c55e) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
}

#mobile-voice-assistant-btn .material-symbols-outlined {
    background: linear-gradient(180deg, #2dd4bf, #06b6d4) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
}
#mobile-voice-assistant-btn .text-\\[10px\\] { color: #a5f3fc !important; }

<?php else : ?>
.mob-nav-item { color: var(--mob-menu-icon); }
.mob-nav-item:hover, .mob-nav-item.active { color: var(--mob-menu-active); }
<?php endif; ?>
</style>

<nav class="<?php echo esc_attr($nav_classes); ?> mob-nav-custom">
    <div class="<?php echo esc_attr($grid_classes); ?>">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="<?php echo esc_attr($item_classes); ?> mob-nav-item <?php echo is_front_page() ? 'active active-home' : ''; ?>">
            <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?>">home</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Главная', 'city-library'); ?></span>
        </a>

        <div id="mob-nav-dynamic-slot" class="flex items-center justify-center relative w-full h-full">
            <a href="#afisha" id="mobile-afisha-btn" class="<?php echo esc_attr($item_classes); ?> mob-nav-item absolute inset-0 w-full">
                <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?>">calendar_month</span>
                <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Афиша', 'city-library'); ?></span>
            </a>
            <!-- Note: The plugin's JS will handle the Voice Assistant button if enabled -->
            <button id="mobile-voice-assistant-btn" class="<?php echo esc_attr($item_classes); ?> mob-nav-item absolute inset-0 w-full hidden" aria-label="Voice">
                <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?>">mic</span>
                <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Ассистент', 'city-library'); ?></span>
            </button>
        </div>

        <button id="search-toggle-mobile" class="<?php echo esc_attr($item_classes); ?> mob-nav-item">
            <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?>">search</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Поиск', 'city-library'); ?></span>
        </button>

        <button class="mobile-menu-toggle-btn <?php echo esc_attr($item_classes); ?> mob-nav-item">
            <span class="<?php echo esc_attr($icon_classes); ?> <?php echo esc_attr($icon_font_class); ?>">menu</span>
            <span class="<?php echo esc_attr($text_classes); ?>"><?php _e('Меню', 'city-library'); ?></span>
        </button>
    </div>
</nav>
