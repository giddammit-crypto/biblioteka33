<div id="search-modal" class="fixed inset-0 z-[100] hidden bg-black/80 backdrop-blur-sm transition-opacity duration-300 opacity-0" aria-hidden="true">
    <div class="absolute inset-0 flex items-center justify-center md:p-4">
        <div class="w-full h-full md:h-auto md:max-w-3xl bg-white md:rounded-[2rem] shadow-2xl p-6 md:p-8 pt-16 md:pt-8 relative transform scale-95 transition-all duration-300 flex flex-col justify-start md:block" id="search-modal-content" role="dialog" aria-modal="true" aria-labelledby="search-modal-title">
            <button id="search-modal-close" class="absolute top-4 right-4 p-2 text-slate-400 hover:text-red-500 transition-colors rounded-full hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-200" aria-label="<?php esc_attr_e('Закрыть поиск', 'city-library'); ?>" title="<?php esc_attr_e('Закрыть поиск', 'city-library'); ?>">
                <span class="material-symbols-outlined text-3xl" aria-hidden="true">close</span>
            </button>
            <h2 id="search-modal-title" class="text-2xl font-bold font-display text-center mb-8 text-slate-900 mt-8 md:mt-0"><?php _e('Поиск по сайту', 'city-library'); ?></h2>
            <div class="search-form-wrapper">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
</div>
