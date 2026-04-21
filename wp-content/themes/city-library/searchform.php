<?php
/**
 * Custom Search Form
 */
?>
<form role="search" method="get" class="relative group" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="relative flex items-center">
        <span class="absolute left-4 text-slate-400 group-focus-within:text-primary transition-colors material-symbols-outlined" aria-hidden="true">search</span>
        <input type="search"
               class="w-full pl-12 pr-4 py-3 bg-slate-50 border-2 border-slate-200 focus-visible:border-primary focus-visible:ring-2 focus-visible:ring-primary/20 rounded-full text-slate-800 placeholder-slate-400 outline-none transition-all shadow-inner"
               placeholder="<?php echo esc_attr_x('Поиск...', 'placeholder', 'city-library'); ?>"
               value="<?php echo get_search_query(); ?>"
               name="s"
               title="<?php echo esc_attr_x('Search for:', 'label', 'city-library'); ?>"
               aria-label="<?php echo esc_attr_x('Поиск', 'label', 'city-library'); ?>" />
        <button type="submit" class="absolute right-2 p-2 bg-primary text-white rounded-full hover:bg-primary/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-primary transition-colors shadow-md" title="<?php echo esc_attr_x('Найти', 'tooltip', 'city-library'); ?>" aria-label="<?php echo esc_attr_x('Найти', 'submit button', 'city-library'); ?>">
            <span class="material-symbols-outlined text-sm font-bold" aria-hidden="true">arrow_forward</span>
        </button>
    </div>
</form>
