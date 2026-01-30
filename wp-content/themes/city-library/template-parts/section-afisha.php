<?php
/**
 * Afisha (Events) Section
 *
 * "AAA" Quality Animation & Visuals Update
 */

if (!get_theme_mod('show_afisha_section', true)) {
    return;
}

// Collect events data
$events = [];
for ($i = 1; $i <= 5; $i++) {
    $image = get_theme_mod("afisha_image_$i");
    $title = get_theme_mod("afisha_title_$i");
    $link = get_theme_mod("afisha_link_$i");
    $ribbon = get_theme_mod("afisha_ribbon_$i");
    $badge = get_theme_mod("afisha_badge_$i");

    if ($image || $title) {
        $events[] = [
            'image' => $image,
            'title' => $title,
            'link' => $link,
            'ribbon' => $ribbon,
            'badge' => $badge,
        ];
    }
}

if (empty($events)) {
    return;
}

$section_title = get_theme_mod('afisha_title', 'Афиша Мероприятий');
$bg_style = get_theme_mod('afisha_bg_style', 'default');

$container_classes = "bg-slate-50 dark:bg-slate-900/50 p-6 md:p-12 rounded-[2.5rem] relative overflow-hidden";
$bg_overlay = "";

if ($bg_style === 'gradient') {
    $container_classes = "bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900 text-white p-6 md:p-12 rounded-[2.5rem] relative overflow-hidden shadow-2xl border border-white/10";
    $bg_overlay = '<div class="absolute inset-0 bg-[url(\'https://www.transparenttextures.com/patterns/cubes.png\')] opacity-10 pointer-events-none mix-blend-overlay"></div>';
}
?>

<section class="py-20 bg-white dark:bg-slate-900 overflow-hidden <?php echo city_library_get_animation_class(); ?>">
    <!-- Width Correction: 80% to match other blocks -->
    <div class="w-full max-w-[80%] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="<?php echo esc_attr($container_classes); ?> <?php if ($bg_style === 'default') echo 'bg-pattern-slate'; ?>">
            <?php echo $bg_overlay; ?>

            <div class="flex flex-col xl:flex-row gap-12 xl:gap-16 items-center relative z-10">

                <!-- Text Content -->
                <div class="w-full xl:w-1/3 space-y-6 relative z-20">
                    <div class="absolute -top-10 -left-10 w-32 h-32 bg-primary/20 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative">
                        <div class="h-1.5 w-24 bg-gradient-to-r from-primary to-yellow-400 rounded-full mb-6"></div>
                        <!-- Responsive Font Sizes -->
                        <h2 class="afisha-custom-title text-3xl md:text-5xl xl:text-6xl font-display font-extrabold tracking-tight leading-tight <?php echo ($bg_style === 'gradient') ? 'text-white' : 'text-slate-900 dark:text-white'; ?>">
                            <?php echo esc_html($section_title); ?>
                        </h2>
                    </div>

                    <p class="<?php echo ($bg_style === 'gradient') ? 'text-slate-200' : 'text-slate-600 dark:text-slate-300'; ?> text-lg md:text-xl leading-relaxed font-light">
                        <?php _e('Откройте для себя мир культурных событий. Лекции, мастер-классы, встречи с авторами и уникальные выставки — все это ждет вас в нашей библиотеке.', 'city-library'); ?>
                    </p>

                    <div class="flex items-center gap-4 pt-4">
                        <button class="afisha-prev group p-3 md:p-4 rounded-full border border-slate-300 dark:border-slate-600 hover:border-primary hover:bg-primary transition-all duration-300 relative overflow-hidden">
                            <span class="material-symbols-outlined relative z-10 group-hover:text-white transition-colors <?php echo ($bg_style === 'gradient') ? 'text-white' : 'text-slate-700 dark:text-white'; ?>">arrow_back</span>
                        </button>
                        <button class="afisha-next group p-3 md:p-4 rounded-full border border-slate-300 dark:border-slate-600 hover:border-primary hover:bg-primary transition-all duration-300 relative overflow-hidden">
                            <span class="material-symbols-outlined relative z-10 group-hover:text-white transition-colors <?php echo ($bg_style === 'gradient') ? 'text-white' : 'text-slate-700 dark:text-white'; ?>">arrow_forward</span>
                        </button>
                        <span class="text-xs md:text-sm font-medium uppercase tracking-widest text-primary ml-4 animate-pulse hidden sm:inline-block">Листайте афишу</span>
                    </div>
                </div>

                <!-- Slider Content -->
                <div class="w-full xl:w-2/3 h-[500px] md:h-[600px] relative z-10">
                    <!-- Blur effect behind slider for depth -->
                    <div class="absolute inset-0 bg-primary/5 rounded-full blur-[100px] pointer-events-none transform translate-x-1/2"></div>

                    <!-- Removed !overflow-visible to fix overlapping issue -->
                    <div class="swiper afisha-slider h-full w-full !py-10 !px-4 overflow-hidden">
                        <div class="swiper-wrapper">
                        <?php foreach ($events as $event) : ?>
                            <div class="swiper-slide h-full group cursor-pointer perspective-1000" <?php if ($event['link']) echo 'onclick="window.location.href=\'' . esc_url($event['link']) . '\'"'; ?>>
                                <div class="relative h-full w-full rounded-[2rem] overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 bg-slate-900 select-none border border-white/10 ring-1 ring-black/5 group-hover:scale-[1.02] transform">

                                    <!-- Image High Quality rendering -->
                                    <?php if ($event['image']) : ?>
                                        <div class="absolute inset-0 bg-slate-900">
                                            <img src="<?php echo esc_url($event['image']); ?>"
                                                 alt="<?php echo esc_attr($event['title']); ?>"
                                                 loading="lazy"
                                                 class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-110 opacity-95 group-hover:opacity-100 will-change-transform">
                                        </div>
                                    <?php else : ?>
                                        <div class="absolute inset-0 bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-8xl text-slate-700">event</span>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Stylish Gradient Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent opacity-80 transition-opacity duration-500 group-hover:opacity-90"></div>

                                    <!-- Hover Tooltip (Centered) -->
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-20 pointer-events-none">
                                        <div class="bg-white/20 backdrop-blur-md border border-white/30 text-white font-bold uppercase tracking-widest py-3 px-6 rounded-full flex items-center gap-3 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500 delay-100">
                                            <span><?php _e('Подробнее', 'city-library'); ?></span>
                                            <span class="material-symbols-outlined">arrow_forward</span>
                                        </div>
                                    </div>

                                    <!-- Content Container -->
                                    <div class="absolute inset-0 p-6 md:p-8 flex flex-col justify-end">

                                        <!-- Top Badges Area -->
                                        <div class="absolute top-6 left-6 flex flex-col gap-3 items-start">
                                            <?php if (!empty($event['badge'])) : ?>
                                                <div class="bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-bold uppercase tracking-wider px-4 py-2 rounded-full shadow-lg transform transition-transform duration-300 group-hover:scale-105 group-hover:bg-white/20">
                                                    <?php echo esc_html($event['badge']); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Ribbon -->
                                        <?php if (!empty($event['ribbon'])) : ?>
                                            <div class="absolute top-6 right-6">
                                                <div class="bg-red-600 text-white font-bold text-xs uppercase py-2 px-4 rounded-lg shadow-lg transform rotate-3 hover:rotate-0 transition-transform duration-300">
                                                    <?php echo esc_html($event['ribbon']); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Text Content -->
                                        <div class="transform transition-transform duration-500 translate-y-4 group-hover:translate-y-0">
                                            <h3 class="text-2xl md:text-3xl lg:text-4xl font-display font-bold text-white mb-3 drop-shadow-md leading-tight">
                                                <?php echo esc_html($event['title']); ?>
                                            </h3>

                                            <div class="h-1 w-0 bg-primary transition-all duration-500 group-hover:w-full mb-4"></div>

                                            <?php if ($event['link']) : ?>
                                            <div class="opacity-0 group-hover:opacity-100 transition-all duration-500 delay-100 transform translate-y-4 group-hover:translate-y-0">
                                                <span class="inline-flex items-center gap-2 text-white font-semibold uppercase tracking-wider text-sm hover:text-primary transition-colors">
                                                    <?php _e('Подробнее', 'city-library'); ?>
                                                    <span class="material-symbols-outlined text-lg">arrow_right_alt</span>
                                                </span>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
/* Custom Swiper Styles for AAA feel */
.afisha-slider {
    padding-bottom: 3rem; /* Space for shadows/hover effects */
}

/* Smooth Slide Transition */
.swiper-slide {
    transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.6s ease;
    opacity: 0.4; /* Inactive slides are faded */
    transform: scale(0.9); /* Inactive slides are smaller */
}

.swiper-slide-active {
    opacity: 1;
    transform: scale(1);
    z-index: 10;
}

/* Fix for dark mode flicker */
.swiper-slide img {
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.afisha-slider', {
        direction: 'horizontal',
        speed: 800, // Slower, smoother speed
        slidesPerView: 1.1, // Adjusted for better mobile view without overlap
        spaceBetween: 15,
        centeredSlides: true,
        loop: true,
        grabCursor: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        navigation: {
            nextEl: '.afisha-next',
            prevEl: '.afisha-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 1.5,
                centeredSlides: true,
                spaceBetween: 20,
            },
            768: {
                 slidesPerView: 2,
                 centeredSlides: false,
                 spaceBetween: 20,
            },
            1024: {
                slidesPerView: 2,
                centeredSlides: false,
                spaceBetween: 30,
            },
            1280: {
                slidesPerView: 2.2,
                centeredSlides: false,
                spaceBetween: 40,
            }
        },
        // Using Coverflow effect for 3D depth
        effect: 'coverflow',
        coverflowEffect: {
            rotate: 0, // No rotation, keeping it flat modern
            stretch: 0,
            depth: 100, // Reduced depth to prevent overlap visuals
            modifier: 1,
            slideShadows: false, // Custom shadows via CSS are better
        },
    });
});
</script>
