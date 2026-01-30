<section class="py-24 bg-white dark:bg-slate-900">
    <div class="w-full max-w-[80%] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-4 mb-16">
            <div class="h-1 w-20 bg-primary mx-auto"></div>
            <h2 class="text-4xl md:text-5xl font-display font-bold"><?php echo esc_html(get_theme_mod('partners_title', 'Наши партнеры')); ?></h2>
            <p class="text-slate-500 dark:text-slate-400 text-lg"><?php echo esc_html(get_theme_mod('partners_subtitle', 'Мы гордимся сотрудничеством с ведущими организациями')); ?></p>
        </div>
        <div class="flex flex-wrap justify-center items-center gap-x-16 gap-y-10">
            <?php for ($i = 1; $i <= 8; $i++) : ?>
                <?php if (get_theme_mod('partner_logo_' . $i)) : ?>
                    <a href="<?php echo esc_url(get_theme_mod('partner_link_' . $i, '#')); ?>" target="_blank" rel="noopener noreferrer">
                        <img class="h-12 grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300" src="<?php echo esc_url(get_theme_mod('partner_logo_' . $i)); ?>" alt="<?php printf(esc_attr__('Partner %d Logo', 'city-library'), $i); ?>">
                    </a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>
