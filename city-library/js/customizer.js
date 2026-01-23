/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

    // Site title and description.
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            $( '.site-title a' ).text( to );
        } );
    } );
    wp.customize( 'blogdescription', function( value ) {
        value.bind( function( to ) {
            $( '.site-description' ).text( to );
        } );
    } );

    // Header Colors
    wp.customize( 'header_background_color', function( value ) {
        value.bind( function( to ) {
            $( '.site-header' ).css( 'background-color', to );
        } );
    } );

    wp.customize( 'header_text_color', function( value ) {
        value.bind( function( to ) {
            $( '.site-header .text-sm.font-display.font-bold, .site-header .main-navigation a' ).css( 'color', to );
        } );
    } );

    wp.customize( 'header_link_color', function( value ) {
        value.bind( function( to ) {
            // We need to inject a style tag to handle the hover state
            var style = $( '#city-library-header-link-hover-color' );
            if ( ! style.length ) {
                style = $( '<style type="text/css" id="city-library-header-link-hover-color"></style>' ).appendTo( 'head' );
            }
            style.text( '.site-header .main-navigation a:hover { color: ' + to + ' !important; }' );
        } );
    } );

    // Hero Badge Text
    wp.customize( 'hero_badge_text', function( value ) {
        value.bind( function( to ) {
            $( '.hero-gradient .uppercase' ).text( to );
        } );
    } );

    // Hero Title
    wp.customize( 'hero_title', function( value ) {
        value.bind( function( to ) {
            $( '.hero-gradient h1' ).html( to );
        } );
    } );

    // Hero Description
    wp.customize( 'hero_description', function( value ) {
        value.bind( function( to ) {
            $( '.hero-gradient .text-lg' ).text( to );
        } );
    } );

} )( jQuery );
