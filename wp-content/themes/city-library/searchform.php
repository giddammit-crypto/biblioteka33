<?php
/**
 * Custom Search Form
 */
?>
<form role="search" method="get" class="relative group" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="relative flex items-center">
        <span class="absolute left-4 text-slate-400 group-focus-within:text-primary transition-colors material-symbols-outlined">search</span>
        <input type="search"
               class="w-full pl-12 pr-4 py-3 bg-slate-100 dark:bg-slate-800 border-2 border-transparent focus:border-primary rounded-full text-slate-800 dark:text-white placeholder-slate-400 outline-none transition-all shadow-inner"
               placeholder="<?php echo esc_attr_x('Поиск...', 'placeholder', 'city-library'); ?>"
               value="<?php echo get_search_query(); ?>"
               name="s"
               title="<?php echo esc_attr_x('Search for:', 'label', 'city-library'); ?>"
               aria-label="<?php echo esc_attr_x('Search for:', 'label', 'city-library'); ?>" />
        <button type="submit" class="absolute right-2 p-2 bg-primary text-white rounded-full hover:bg-primary/90 transition-colors shadow-md" aria-label="<?php echo esc_attr_x('Найти', 'submit button', 'city-library'); ?>">
            <span class="material-symbols-outlined text-sm font-bold">arrow_forward</span>
        </button>
    </div>
</form>
