<section class="py-24 bg-white <?php echo city_library_get_animation_class(); ?>">
    <div class="w-full lg:max-w-[80%] lg:mx-auto px-0 lg:px-8">

        <?php
        $bg_color = get_theme_mod('partners_bg_color', '#FFFFFF');
        ?>

        <div class="relative p-0 lg:p-12 md:p-16 rounded-none shadow-none border-0 lg:rounded-[2.5rem] lg:shadow-xl lg:border border-slate-100 bg-pattern-slate overflow-hidden" style="background-color: <?php echo esc_attr($bg_color); ?>;">

            <!-- Decorative Elements -->
            <div class="absolute top-0 left-0 w-32 h-32 bg-primary/5 rounded-br-[4rem] pointer-events-none"></div>
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-primary/5 rounded-tl-[4rem] pointer-events-none"></div>

            <div class="text-center space-y-6 mb-8 lg:mb-16 relative z-10 px-6 py-12 lg:px-0 lg:py-0">
                <div class="h-1.5 w-20 bg-gradient-to-r from-primary to-green-300 mx-auto rounded-full"></div>
                <h2 class="text-4xl md:text-5xl font-display font-bold text-slate-900 tracking-tight">
                    <?php echo esc_html(get_theme_mod('partners_title', 'Наши партнеры')); ?>
                </h2>
                <p class="text-slate-500 text-lg md:text-xl font-light max-w-2xl mx-auto leading-relaxed">
                    <?php echo esc_html(get_theme_mod('partners_subtitle', 'Мы гордимся сотрудничеством с ведущими организациями')); ?>
                </p>
            </div>

            <div class="swiper partners-slider w-full px-4 lg:px-0 pb-12 lg:pb-0">
                <div class="swiper-wrapper flex flex-nowrap lg:flex-wrap justify-center items-center lg:gap-x-12 lg:gap-y-12 md:gap-x-20">
                    <?php for ($i = 1; $i <= 8; $i++) : ?>
                        <?php if (get_theme_mod('partner_logo_' . $i)) : ?>
                            <div class="swiper-slide group relative !h-auto flex justify-center items-center">
                                <a href="<?php echo esc_url(get_theme_mod('partner_link_' . $i, '#')); ?>" target="_blank" rel="noopener noreferrer" class="block p-4 transition-all duration-300 transform group-hover:-translate-y-2">
                                    <img class="h-12 md:h-16 w-auto object-contain grayscale opacity-60 group-hover:opacity-100 group-hover:grayscale-0 transition-all duration-500 filter"
                                        src="<?php echo esc_url(get_theme_mod('partner_logo_' . $i)); ?>"
                                        alt="<?php printf(esc_attr__('Partner %d Logo', 'city-library'), $i); ?>">
                                </a>
                                <!-- Subtle Glow on Hover -->
                                <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/5 rounded-xl blur-xl transition-all duration-300 -z-10"></div>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <div class="swiper-pagination lg:hidden !bottom-0 !relative mt-6"></div>
            </div>

        </div>
    </div>
</section>
