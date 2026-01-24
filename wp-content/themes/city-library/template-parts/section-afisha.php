<?php
/**
 * Afisha (Events) Section
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
// 'default' = existing SVG pattern
// 'gradient' = fancy gradient
// 'image' = custom image (if added later, sticking to CSS for now)

$container_classes = "bg-slate-50 dark:bg-slate-900/50 p-8 md:p-12 rounded-3xl relative overflow-hidden";
$bg_overlay = "";

if ($bg_style === 'gradient') {
    $container_classes = "bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900 text-white p-8 md:p-12 rounded-3xl relative overflow-hidden shadow-2xl border border-white/10";
    $bg_overlay = '<div class="absolute inset-0 bg-[url(\'https://www.transparenttextures.com/patterns/cubes.png\')] opacity-10 pointer-events-none"></div>'; // Texture
}
?>

<section class="py-16 bg-white dark:bg-slate-900 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="<?php echo esc_attr($container_classes); ?>"
             <?php if ($bg_style === 'default') : ?>
             style="background-image: url('data:image/svg+xml,%3Csvg width=\'52\' height=\'26\' viewBox=\'0 0 52 26\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%230b7930\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z\' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"
             <?php endif; ?>
        >
            <?php echo $bg_overlay; ?>

            <div class="flex flex-col md:flex-row gap-12 items-center relative z-10">

                <div class="md:w-1/3 space-y-6">
                    <div class="h-1 w-20 bg-primary"></div>
                    <h2 class="text-4xl md:text-5xl font-display font-bold <?php echo ($bg_style === 'gradient') ? 'text-white' : 'text-slate-900 dark:text-white'; ?>"><?php echo esc_html($section_title); ?></h2>
                    <p class="<?php echo ($bg_style === 'gradient') ? 'text-slate-200' : 'text-slate-500 dark:text-slate-400'; ?> text-lg">
                        <?php _e('Не пропустите самые яркие события нашей библиотеки. Встречи, лекции, мастер-классы и многое другое.', 'city-library'); ?>
                    </p>
                    <div class="flex space-x-2">
                        <button class="afisha-prev p-3 border border-current rounded-full hover:bg-primary hover:text-white hover:border-primary transition-all">
                            <span class="material-symbols-outlined block">arrow_back</span>
                        </button>
                        <button class="afisha-next p-3 border border-current rounded-full hover:bg-primary hover:text-white hover:border-primary transition-all">
                            <span class="material-symbols-outlined block">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <div class="md:w-2/3 w-full h-[500px]">
                    <div class="swiper afisha-slider h-full w-full !overflow-visible"> <!-- Overflow visible for shadows/badges -->
                        <div class="swiper-wrapper">
                        <?php foreach ($events as $event) : ?>
                            <div class="swiper-slide h-full group cursor-pointer perspective-1000" <?php if ($event['link']) echo 'onclick="window.location.href=\'' . esc_url($event['link']) . '\'"'; ?>>
                                <div class="relative h-full w-full rounded-2xl overflow-hidden shadow-xl transform transition-transform duration-500 group-hover:scale-[1.02] bg-slate-800">

                                    <!-- Image -->
                                    <?php if ($event['image']) : ?>
                                        <img src="<?php echo esc_url($event['image']); ?>" alt="<?php echo esc_attr($event['title']); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-90 group-hover:opacity-100">
                                    <?php else : ?>
                                        <div class="absolute inset-0 bg-slate-200 dark:bg-slate-800 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-6xl text-slate-400">event</span>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Gradient Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent p-8 flex flex-col justify-end">

                                        <!-- Corner Badge (Top Left) -->
                                        <?php if (!empty($event['badge'])) : ?>
                                            <div class="absolute top-4 left-4 bg-yellow-500 text-slate-900 text-xs font-black uppercase tracking-wider px-3 py-1 rounded shadow-lg transform -rotate-2">
                                                <?php echo esc_html($event['badge']); ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Ribbon (Top Right) -->
                                        <?php if (!empty($event['ribbon'])) : ?>
                                            <div class="absolute top-0 right-0 overflow-hidden w-32 h-32 pointer-events-none">
                                                <div class="absolute top-0 right-0 transform translate-x-[30%] translate-y-[20%] rotate-45 bg-red-600 text-white font-bold text-xs uppercase py-1 px-10 shadow-md w-[150%] text-center">
                                                    <?php echo esc_html($event['ribbon']); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <h3 class="text-2xl md:text-4xl font-display font-bold text-white mb-2 translate-y-2 group-hover:translate-y-0 transition-transform duration-300 drop-shadow-md">
                                            <?php echo esc_html($event['title']); ?>
                                        </h3>

                                        <?php if ($event['link']) : ?>
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-2 group-hover:translate-y-0 delay-100">
                                            <span class="inline-flex items-center text-primary font-bold uppercase tracking-wider text-sm bg-white px-4 py-2 rounded-full mt-4 shadow-lg">
                                                <?php _e('Подробнее', 'city-library'); ?>
                                                <span class="material-symbols-outlined ml-1 text-sm">arrow_outward</span>
                                            </span>
                                        </div>
                                        <?php endif; ?>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.afisha-slider', {
        direction: 'horizontal',
        slidesPerView: 1,
        spaceBetween: 30,
        centeredSlides: false,
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.afisha-next',
            prevEl: '.afisha-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 2.5,
            }
        }
    });
});
</script>
