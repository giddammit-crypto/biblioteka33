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

    if ($image || $title) {
        $events[] = [
            'image' => $image,
            'title' => $title,
            'link' => $link,
        ];
    }
}

if (empty($events)) {
    return;
}

$section_title = get_theme_mod('afisha_title', 'Афиша Мероприятий');
?>

<section class="py-16 bg-white dark:bg-slate-900 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-12 items-center">

            <div class="md:w-1/3 space-y-6">
                <div class="h-1 w-20 bg-primary"></div>
                <h2 class="text-4xl md:text-5xl font-display font-bold text-slate-900 dark:text-white"><?php echo esc_html($section_title); ?></h2>
                <p class="text-slate-500 dark:text-slate-400 text-lg">
                    <?php _e('Не пропустите самые яркие события нашей библиотеки. Встречи, лекции, мастер-классы и многое другое.', 'city-library'); ?>
                </p>
                <div class="flex space-x-2">
                    <button class="afisha-prev p-3 border border-slate-200 dark:border-slate-700 rounded-full hover:bg-primary hover:text-white hover:border-primary transition-all">
                        <span class="material-symbols-outlined block">arrow_back</span>
                    </button>
                    <button class="afisha-next p-3 border border-slate-200 dark:border-slate-700 rounded-full hover:bg-primary hover:text-white hover:border-primary transition-all">
                        <span class="material-symbols-outlined block">arrow_forward</span>
                    </button>
                </div>
            </div>

            <div class="md:w-2/3 w-full h-[500px]">
                <div class="swiper afisha-slider h-full w-full">
                    <div class="swiper-wrapper">
                        <?php foreach ($events as $event) : ?>
                            <div class="swiper-slide h-full group cursor-pointer" <?php if ($event['link']) echo 'onclick="window.location.href=\'' . esc_url($event['link']) . '\'"'; ?>>
                                <div class="relative h-full w-full rounded-2xl overflow-hidden shadow-lg">
                                    <?php if ($event['image']) : ?>
                                        <img src="<?php echo esc_url($event['image']); ?>" alt="<?php echo esc_attr($event['title']); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    <?php else : ?>
                                        <div class="absolute inset-0 bg-slate-200 dark:bg-slate-800 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-6xl text-slate-400">event</span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent p-8 flex flex-col justify-end">
                                        <h3 class="text-2xl md:text-4xl font-display font-bold text-white mb-2 translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                            <?php echo esc_html($event['title']); ?>
                                        </h3>
                                        <?php if ($event['link']) : ?>
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-2 group-hover:translate-y-0 delay-100">
                                            <span class="inline-flex items-center text-primary font-bold uppercase tracking-wider text-sm bg-white px-4 py-2 rounded-full mt-4">
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
        }
    });
});
</script>
