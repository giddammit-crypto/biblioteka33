<?php get_header(); ?>

<div id="content-start" class="w-full max-w-[95%] xl:max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-20 scroll-mt-24 focus:outline-none" tabindex="-1">
    <div id="primary" class="w-full flex items-center justify-center min-h-[60vh]">

        <div class="text-center max-w-2xl mx-auto space-y-8 p-12 bg-white rounded-[2rem] shadow-xl border border-slate-100 relative overflow-hidden hover:shadow-2xl transition-shadow duration-500">

            <!-- Decorative Blobs -->
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-primary/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-yellow-500/10 rounded-full blur-3xl pointer-events-none animate-pulse delay-700"></div>

            <div class="relative z-10">
                <h1 class="text-9xl font-black font-display text-transparent bg-clip-text bg-gradient-to-r from-primary to-yellow-500 mb-4 select-none drop-shadow-sm">404</h1>
                <h2 class="text-3xl font-bold text-slate-900 mb-4"><?php _e('Страница не найдена', 'city-library'); ?></h2>
                <p class="text-slate-500 text-lg mb-8"><?php _e('К сожалению, страница, которую вы ищете, не существует или была перемещена. Попробуйте воспользоваться поиском.', 'city-library'); ?></p>

                <div class="max-w-md mx-auto mb-8">
                    <?php get_search_form(); ?>
                </div>

                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center gap-2 text-primary font-bold uppercase tracking-widest hover:text-primary/80 transition-colors group">
                    <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    <?php _e('Вернуться на главную', 'city-library'); ?>
                </a>
            </div>
        </div>

    </div>
</div>

<?php get_footer(); ?>
