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
