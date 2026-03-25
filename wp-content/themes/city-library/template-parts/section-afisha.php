<?php
/**
 * Afisha (Events) Section
 *
 * "AAA" Quality Animation & Visuals Update
 */

$mods = get_theme_mods() ?: [];

if (!($mods['show_afisha_section'] ?? true)) {
    return;
}

// Collect events data
$events = [];
for ($i = 1; $i <= 5; $i++) {
    $image = $mods["afisha_image_$i"] ?? '';
    $title = $mods["afisha_title_$i"] ?? '';
    $link = $mods["afisha_link_$i"] ?? '';
    $ribbon = $mods["afisha_ribbon_$i"] ?? '';
    $badge = $mods["afisha_badge_$i"] ?? '';
    $date = $mods["afisha_date_$i"] ?? ''; // Assuming this might exist or we use badge as date

    if ($image || $title) {
        $events[] = [
            'image' => $image,
            'title' => $title,
            'link' => $link,
            'ribbon' => $ribbon,
            'badge' => $badge,
            'date' => $date,
        ];
    }
}

if (empty($events)) {
    return;
}

$section_title = $mods['afisha_title'] ?? 'Афиша Мероприятий';
$bg_style = $mods['afisha_bg_style'] ?? 'default';
$card_style = $mods['afisha_card_style'] ?? 'default';

// Container Styles - Adaptive: Full width on mobile but with internal padding, rounded on desktop
$container_classes = "bg-white relative overflow-hidden transition-all duration-500";
$bg_overlay = "";

if ($bg_style === 'gradient') {
    $container_classes = "bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900 text-white relative overflow-hidden shadow-2xl border border-white/10";
    $bg_overlay = '<div class="absolute inset-0 bg-[url(\'https://www.transparenttextures.com/patterns/cubes.png\')] opacity-10 pointer-events-none mix-blend-overlay"></div>';
}

// Card Style Logic
$card_base_classes = 'relative aspect-[3/4] md:aspect-[4/5] lg:h-[500px] lg:aspect-auto w-full overflow-hidden transition-all duration-500 bg-slate-100 select-none group-hover:scale-[1.02] transform-gpu flex flex-col';
$card_extra_classes = 'rounded-[2rem] shadow-lg hover:shadow-2xl hover:shadow-slate-900/20 border border-slate-200'; // Default

if ($card_style === 'card') {
    $card_extra_classes = 'rounded-xl shadow-md hover:shadow-xl border-4 border-white';
} elseif ($card_style === 'clean') {
    $card_extra_classes = 'rounded-3xl border border-slate-100'; // No shadow
} elseif ($card_style === 'overlay') {
    $card_extra_classes = 'rounded-none shadow-none border-0'; // Flat
} elseif ($card_style === 'glass') {
    $card_extra_classes = 'rounded-[2rem] shadow-xl border border-white/30 backdrop-blur-sm bg-white/10';
} elseif ($card_style === 'gradient') {
    $card_extra_classes = 'rounded-2xl shadow-lg border-b-4 border-primary';
} elseif ($card_style === 'brutalism') {
    $card_extra_classes = 'rounded-none shadow-[8px_8px_0px_rgba(0,0,0,1)] hover:shadow-[12px_12px_0px_rgba(0,0,0,1)] border-4 border-black';
} elseif ($card_style === 'minimal-text') {
    $card_extra_classes = 'rounded-[3rem] border border-slate-200 shadow-sm hover:shadow-xl bg-white';
} elseif ($card_style === 'cyberpunk') {
    $card_extra_classes = 'rounded-lg border border-cyan-500/50 shadow-[0_0_15px_rgba(34,211,238,0.3)] hover:shadow-[0_0_25px_rgba(34,211,238,0.6)] bg-slate-900';
} elseif ($card_style === 'rounded-image') {
    $card_extra_classes = 'rounded-full shadow-lg border-8 border-white hover:border-primary transition-colors';
}

$card_classes = $card_base_classes . ' ' . $card_extra_classes;
?>

<section id="afisha" class="py-12 lg:py-24 bg-white overflow-hidden <?php echo city_library_get_animation_class(); ?>">
    <!-- Width Correction: 80% to match other blocks -->
    <div class="w-full lg:max-w-[80%] lg:mx-auto px-4 lg:px-8">

        <div class="<?php echo esc_attr($container_classes); ?> rounded-[2.5rem] shadow-xl border border-slate-100 p-6 md:p-12">
            <?php echo $bg_overlay; ?>

            <!-- Background Decorative Elements -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/5 rounded-full blur-[100px] pointer-events-none"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full blur-[80px] pointer-events-none"></div>

            <div class="flex flex-col gap-12 relative z-10">

                <!-- Header Row: Text Content & Navigation -->
                <div class="w-full flex flex-col xl:flex-row justify-between items-center xl:items-end gap-8 relative z-20">

                    <div class="text-center xl:text-left space-y-6 max-w-3xl">
                        <div class="relative">
                            <div class="h-2 w-24 bg-gradient-to-r from-primary to-green-400 rounded-full mb-6 mx-auto xl:mx-0 shadow-sm"></div>
                            <h2 class="text-4xl md:text-5xl lg:text-6xl font-display font-extrabold tracking-tight leading-tight pb-2 break-words text-slate-900 drop-shadow-sm">
                                <?php echo esc_html($section_title); ?>
                            </h2>
                        </div>

                        <p class="text-slate-600 text-lg md:text-xl leading-relaxed font-light">
                            <?php _e('Откройте для себя мир культурных событий. Лекции, мастер-классы, встречи с авторами и уникальные выставки — все это ждет вас в нашей библиотеке.', 'city-library'); ?>
                        </p>
                    </div>

                    <!-- Enhanced Navigation Buttons (Top Right) -->
                    <div class="flex items-center justify-center xl:justify-end gap-4 shrink-0">
                        <button class="afisha-prev slider-nav-btn group w-14 h-14 rounded-full border border-slate-200 transition-all duration-300 relative overflow-hidden flex items-center justify-center cursor-pointer shadow-md hover:shadow-xl hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-primary/20" aria-label="<?php _e('Предыдущий слайд', 'city-library'); ?>">
                            <span class="material-symbols-outlined text-2xl transition-colors duration-300" aria-hidden="true">arrow_back</span>
                        </button>
                        <button class="afisha-next slider-nav-btn group w-14 h-14 rounded-full border border-slate-200 transition-all duration-300 relative overflow-hidden flex items-center justify-center cursor-pointer shadow-md hover:shadow-xl hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-primary/20" aria-label="<?php _e('Следующий слайд', 'city-library'); ?>">
                            <span class="material-symbols-outlined text-2xl transition-colors duration-300" aria-hidden="true">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- Full Width Slider -->
                <div class="w-full relative z-10">

                    <!-- Slider Container with overflow-visible for depth effect -->
                    <div class="swiper afisha-slider w-full !pb-12 !px-4 md:!px-0 overflow-visible">
                        <div class="swiper-wrapper items-stretch">
                        <?php foreach ($events as $index => $event) : ?>
                            <div class="swiper-slide h-auto group cursor-pointer perspective-1000 afisha-slide-item transition-all duration-500"
                                 data-afisha-image="<?php echo esc_url($event['image']); ?>"
                                 data-afisha-link="<?php echo esc_url($event['link']); ?>"
                                 data-afisha-title="<?php echo esc_attr($event['title']); ?>"
                                 role="button"
                                 tabindex="0"
                                 aria-label="<?php echo esc_attr($event['title']); ?>">

                                <div class="<?php echo esc_attr($card_classes); ?>">

                                    <?php if ($card_style === 'minimal-text') : ?>
                                        <!-- Minimal Text Design Layout -->
                                        <?php if ($event['image']) : ?>
                                            <div class="w-full h-3/5 md:h-2/3 shrink-0 overflow-hidden rounded-t-[3rem]">
                                                <img src="<?php echo esc_url($event['image']); ?>" alt="<?php echo esc_attr($event['title']); ?>" loading="lazy" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                            </div>
                                        <?php else : ?>
                                            <div class="w-full h-3/5 md:h-2/3 bg-slate-200 flex items-center justify-center rounded-t-[3rem] shrink-0">
                                                <span class="material-symbols-outlined text-6xl text-slate-400" aria-hidden="true">event</span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="p-6 md:p-8 flex flex-col justify-between flex-grow bg-white rounded-b-[3rem] z-10 pointer-events-none">
                                            <div class="flex justify-between items-start pointer-events-auto">
                                                <?php if (!empty($event['badge'])) : ?>
                                                    <span class="text-xs font-bold uppercase tracking-widest text-primary bg-primary/10 px-3 py-1 rounded-full"><?php echo esc_html($event['badge']); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <h3 class="text-xl md:text-2xl font-display font-bold text-slate-900 leading-tight line-clamp-3 pointer-events-auto group-hover:text-primary transition-colors"><?php echo esc_html($event['title']); ?></h3>
                                        </div>
                                    <?php elseif ($card_style === 'rounded-image') : ?>
                                         <!-- Circular Image Design Layout -->
                                         <div class="flex flex-col h-full items-center p-8 bg-white/50 backdrop-blur-sm pointer-events-none">
                                            <div class="w-48 h-48 md:w-56 md:h-56 rounded-full overflow-hidden shadow-2xl border-4 border-white mb-6 shrink-0 group-hover:border-primary transition-colors duration-500 z-10">
                                                <?php if ($event['image']) : ?>
                                                    <img src="<?php echo esc_url($event['image']); ?>" alt="<?php echo esc_attr($event['title']); ?>" loading="lazy" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                                                <?php else : ?>
                                                    <div class="w-full h-full bg-slate-200"></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex-grow flex flex-col items-center justify-center text-center w-full z-10 pointer-events-auto">
                                                 <?php if (!empty($event['badge'])) : ?>
                                                    <div class="bg-slate-900 text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-4"><?php echo esc_html($event['badge']); ?></div>
                                                <?php endif; ?>
                                                <h3 class="text-2xl font-serif font-bold text-slate-800 leading-tight line-clamp-3 group-hover:text-primary transition-colors"><?php echo esc_html($event['title']); ?></h3>
                                            </div>
                                         </div>
                                    <?php else : ?>
                                        <!-- Default / Gradient / Glass / Brutalism / Cyberpunk Layout -->
                                        <!-- Image -->
                                        <?php if ($event['image']) : ?>
                                            <div class="absolute inset-0 bg-slate-200 <?php echo ($card_style === 'brutalism') ? 'filter grayscale contrast-125 saturate-0 group-hover:grayscale-0 transition-all duration-500' : ''; ?>">
                                                <img src="<?php echo esc_url($event['image']); ?>"
                                                     alt="<?php echo esc_attr($event['title']); ?>"
                                                     loading="lazy"
                                                     class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-110 opacity-100 will-change-transform <?php echo ($card_style === 'cyberpunk') ? 'mix-blend-luminosity group-hover:mix-blend-normal' : ''; ?>">
                                            </div>
                                        <?php else : ?>
                                            <div class="absolute inset-0 bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-8xl text-slate-300" aria-hidden="true">event</span>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Cyberpunk Overlays -->
                                        <?php if ($card_style === 'cyberpunk') : ?>
                                            <div class="absolute inset-0 bg-slate-900/60 group-hover:bg-slate-900/40 transition-colors duration-500"></div>
                                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-cyan-500/40 to-transparent pointer-events-none"></div>
                                        <?php endif; ?>

                                        <!-- Gradient Overlay (Dark at bottom for text readability) -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-80 transition-opacity duration-500 group-hover:opacity-90 <?php echo ($card_style === 'brutalism' || $card_style === 'cyberpunk') ? 'hidden' : ''; ?>"></div>

                                        <!-- Brutalism Blocky Overlay -->
                                        <?php if ($card_style === 'brutalism') : ?>
                                             <div class="absolute inset-0 bg-white/0 group-hover:bg-primary/20 mix-blend-multiply transition-colors duration-300"></div>
                                        <?php endif; ?>

                                        <!-- Hover Action (Zoom Icon) -->
                                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-500 z-20 pointer-events-none transform scale-75 group-hover:scale-100">
                                            <div class="bg-white/20 backdrop-blur-md border border-white/40 text-white rounded-full p-4 shadow-2xl">
                                                <span class="material-symbols-outlined text-4xl drop-shadow-md" aria-hidden="true">visibility</span>
                                            </div>
                                        </div>

                                        <!-- Content Container -->
                                        <div class="absolute inset-0 p-6 md:p-8 flex flex-col justify-between pointer-events-none">

                                            <!-- Top Area: Badges & Ribbons -->
                                            <div class="flex justify-between items-start pointer-events-auto">
                                                <!-- Date/Category Badge -->
                                                <?php if (!empty($event['badge'])) : ?>
                                                    <div class="bg-white/90 backdrop-blur-md text-slate-900 text-xs font-bold uppercase tracking-wider px-4 py-2 rounded-full shadow-lg transform transition-transform duration-300 group-hover:scale-105 border border-white/50 <?php echo ($card_style === 'brutalism') ? '!rounded-none border-2 !border-black !bg-white !shadow-[4px_4px_0px_rgba(0,0,0,1)]' : ''; ?> <?php echo ($card_style === 'cyberpunk') ? '!bg-slate-900 !border-cyan-500 !text-cyan-400 drop-shadow-[0_0_5px_rgba(34,211,238,0.8)]' : ''; ?>">
                                                        <?php echo esc_html($event['badge']); ?>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Ribbon -->
                                                <?php if (!empty($event['ribbon'])) : ?>
                                                    <div class="bg-red-600 text-white font-bold text-[10px] uppercase py-1.5 px-3 rounded-lg shadow-md transform rotate-3 hover:rotate-0 transition-transform duration-300 <?php echo ($card_style === 'brutalism') ? '!rounded-none border-2 border-black !bg-black' : ''; ?>">
                                                        <?php echo esc_html($event['ribbon']); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Bottom Area: Title & Line -->
                                            <div class="transform transition-transform duration-500 translate-y-2 group-hover:translate-y-0 pointer-events-auto <?php echo ($card_style === 'brutalism') ? 'bg-white p-4 border-4 border-black shadow-[8px_8px_0px_rgba(0,0,0,1)]' : ''; ?>">
                                                <h3 class="text-2xl md:text-3xl font-display font-bold text-white mb-4 drop-shadow-md leading-tight line-clamp-3 <?php echo ($card_style === 'brutalism') ? '!text-black !drop-shadow-none !mb-0 uppercase tracking-tighter' : ''; ?> <?php echo ($card_style === 'cyberpunk') ? 'font-mono !text-cyan-400 drop-shadow-[0_0_8px_rgba(34,211,238,0.5)]' : ''; ?>">
                                                    <?php echo esc_html($event['title']); ?>
                                                </h3>

                                                <!-- Animated Line -->
                                                <div class="h-1 w-12 bg-primary rounded-full transition-all duration-500 group-hover:w-full group-hover:bg-green-400 shadow-[0_0_10px_rgba(74,222,128,0.5)] <?php echo ($card_style === 'brutalism' || $card_style === 'cyberpunk') ? 'hidden' : ''; ?>"></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>

                        <!-- Pagination (Dots) -->
                        <div class="swiper-pagination !bottom-0"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Full Screen Modal for Afisha -->
<div id="afisha-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/95 backdrop-blur-lg transition-all duration-500 opacity-0" aria-hidden="true" role="dialog" aria-modal="true">

    <!-- Background Blur Click Area -->
    <div class="absolute inset-0" id="afisha-modal-bg"></div>

    <!-- Close Button -->
    <button id="afisha-modal-close" class="absolute top-6 right-6 z-[110] p-3 rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/50 cursor-pointer group rotate-0 hover:rotate-90">
        <span class="material-symbols-outlined text-4xl drop-shadow-md" aria-hidden="true">close</span>
        <span class="sr-only"><?php _e('Закрыть', 'city-library'); ?></span>
    </button>

    <!-- Modal Content -->
    <div class="relative w-full h-full max-w-7xl mx-auto flex flex-col items-center justify-center p-4 md:p-8 pointer-events-none">

        <!-- Image Container -->
        <div class="relative w-full flex-grow flex items-center justify-center mb-8 pointer-events-auto transform scale-95 opacity-0 transition-all duration-500 delay-100" id="afisha-modal-content-wrapper">
            <img id="afisha-modal-image" src="" alt="" class="max-w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl ring-1 ring-white/10">
        </div>

        <!-- Action Button -->
        <div class="mt-auto mb-4 pointer-events-auto transform translate-y-4 opacity-0 transition-all duration-500 delay-200" id="afisha-modal-action-wrapper">
            <a id="afisha-modal-link" href="#" class="button inline-flex items-center justify-center px-10 py-4 font-bold text-lg uppercase tracking-wider rounded-full transition-all shadow-lg hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-primary/50 group">
                <?php _e('Подробнее', 'city-library'); ?>
                <span class="material-symbols-outlined ml-2 text-2xl group-hover:translate-x-1 transition-transform" aria-hidden="true">arrow_forward</span>
            </a>
        </div>
    </div>
</div>

<style>
/* Custom Swiper Styles for AAA feel */
.afisha-slider {
    padding-bottom: 3rem;
}

/* Inactive slides styling */
.afisha-slider .swiper-slide:not(.swiper-slide-active) {
    opacity: 0.5;
    transform: scale(0.95);
    filter: grayscale(30%);
}

.afisha-slider .swiper-slide-active {
    opacity: 1;
    transform: scale(1);
    z-index: 10;
    filter: grayscale(0%);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Pagination Dots */
.swiper-pagination-bullet {
    width: 10px;
    height: 10px;
    background: #cbd5e1;
    opacity: 1;
    transition: all 0.3s ease;
}
.swiper-pagination-bullet-active {
    width: 30px;
    border-radius: 5px;
    background: var(--primary-color, #0b7930);
}

/* Modal Open State */
#afisha-modal.open {
    display: flex;
    opacity: 1;
}
#afisha-modal.open #afisha-modal-content-wrapper {
    transform: scale(1);
    opacity: 1;
}
#afisha-modal.open #afisha-modal-action-wrapper {
    transform: translate-y(0);
    opacity: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper with optimized settings for all devices
    const swiper = new Swiper('.afisha-slider', {
        // Core
        loop: true,
        speed: 800,
        spaceBetween: 24,
        grabCursor: true,
        centeredSlides: false, // Default grid-like behavior on desktop

        // Autoplay
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },

        // Navigation
        navigation: {
            nextEl: '.afisha-next',
            prevEl: '.afisha-prev',
        },

        // Pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

        // Responsive Breakpoints (Mobile First)
        breakpoints: {
            // Mobile: Single slide, full width adaptive
            320: {
                slidesPerView: 1,
                spaceBetween: 16,
                centeredSlides: false,
            },
            // Tablet: 2 slides
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
                centeredSlides: false,
            },
            // Desktop: 2 slides comfortable
            1024: {
                slidesPerView: 2,
                spaceBetween: 30,
                centeredSlides: false,
            },
            // Large Desktop: almost 3 or 2 large ones
            1280: {
                slidesPerView: 2.5,
                spaceBetween: 32,
                centeredSlides: false,
            }
        },

        // Accessibility
        a11y: {
            prevSlideMessage: 'Предыдущий слайд',
            nextSlideMessage: 'Следующий слайд',
        },
    });

    // --- Modal Logic ---
    const modal = document.getElementById('afisha-modal');
    const modalImg = document.getElementById('afisha-modal-image');
    const modalLink = document.getElementById('afisha-modal-link');
    const closeBtn = document.getElementById('afisha-modal-close');
    const bgOverlay = document.getElementById('afisha-modal-bg');

    // Delegation for dynamic/cloned slides (loop mode)
    document.querySelector('.afisha-slider').addEventListener('click', function(e) {
        const slide = e.target.closest('.afisha-slide-item');
        if (slide) {
            e.preventDefault();
            const img = slide.dataset.afishaImage;
            const link = slide.dataset.afishaLink;
            const title = slide.dataset.afishaTitle;
            openModal(img, link, title);
        }
    });

    function openModal(imageSrc, linkUrl, title) {
        if (!modal || !modalImg || !modalLink) return;

        // Set Content
        modalImg.src = imageSrc;
        modalImg.alt = title || 'Афиша';

        // Set Link
        if (linkUrl && linkUrl !== '#' && linkUrl !== '') {
            modalLink.href = linkUrl;
            modalLink.classList.remove('hidden');
            modalLink.classList.add('inline-flex');
        } else {
            modalLink.classList.add('hidden');
            modalLink.classList.remove('inline-flex');
        }

        // Show Modal
        modal.classList.remove('hidden');

        // Trigger Animation Frame
        requestAnimationFrame(() => {
            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
            // Focus trap could be added here
            closeBtn.focus();
        });

        document.body.style.overflow = 'hidden'; // Lock Scroll
    }

    function closeModal() {
        if (!modal) return;

        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');

        // Wait for transition
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = ''; // Unlock Scroll
        }, 500);
    }

    // Close Triggers
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (bgOverlay) bgOverlay.addEventListener('click', closeModal);

    // Keyboard Access
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal.classList.contains('open')) {
            closeModal();
        }
    });
});
</script>
