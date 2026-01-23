<?php
/**
 * Template part for displaying the "Our Partners" section on the homepage.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package City_Library
 */

// Don't display the section if the setting is turned off in the Customizer.
if ( ! get_theme_mod( 'partners_section_show', true ) ) {
    return;
}

// Check if there is at least one partner logo assigned.
$has_partners = false;
for ( $i = 1; $i <= 8; $i++ ) {
    if ( get_theme_mod( "partner_logo_$i" ) ) {
        $has_partners = true;
        break;
    }
}

// If no partners are set, don't display the section.
if ( ! $has_partners ) {
    return;
}
?>

<section class="py-20 bg-slate-100 dark:bg-slate-800/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-display font-bold mb-4"><?php _e( 'Наши партнёры', 'city-library' ); ?></h2>
        <p class="text-slate-500 dark:text-slate-400 mb-12"><?php _e( 'Мы гордимся сотрудничеством с ведущими организациями', 'city-library' ); ?></p>
        <div class="grid grid-cols-2 md:grid-cols-4 items-center justify-center gap-x-12 gap-y-8">
            <?php for ( $i = 1; $i <= 8; $i++ ) : ?>
                <?php
                $logo_url = get_theme_mod( "partner_logo_$i" );
                $link_url = get_theme_mod( "partner_link_$i" );
                ?>
                <?php if ( $logo_url ) : ?>
                    <div class="h-16">
                        <?php if ( $link_url ) : ?>
                            <a href="<?php echo esc_url( $link_url ); ?>" target="_blank" rel="noopener noreferrer">
                        <?php endif; ?>

                        <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php printf( esc_attr__( 'Логотип партнёра %d', 'city-library' ), $i ); ?>" class="max-h-full transition-transform duration-300 hover:scale-110 opacity-60 hover:opacity-100">

                        <?php if ( $link_url ) : ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>
