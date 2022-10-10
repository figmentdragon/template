/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

 ( function() {
 	// Wait until the customizer has finished loading.
 	wp.customize.bind( 'ready', function() {
 		// Hide the "respect_user_color_preference" setting if the background-color is dark.
 		if ( 127 > themenameGetHexLum( wp.customize( 'background_color' ).get() ) ) {
 			wp.customize.control( 'respect_user_color_preference' ).deactivate();
 			wp.customize.control( 'respect_user_color_preference_notice' ).deactivate();
 		}

 		// Handle changes to the background-color.
 		wp.customize( 'background_color', function( setting ) {
 			setting.bind( function( value ) {
 				if ( 127 > themenameGetHexLum( value ) ) {
 					wp.customize.control( 'respect_user_color_preference' ).deactivate();
 					wp.customize.control( 'respect_user_color_preference_notice' ).activate();
 				} else {
 					wp.customize.control( 'respect_user_color_preference' ).activate();
 					wp.customize.control( 'respect_user_color_preference_notice' ).deactivate();
 				}
 			} );
 		} );
 	} );
 }() );

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

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-title a, .site-description' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
			} else {
				$( '.absolute-header .site-title a, .absolute-header .site-description' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
				$( '.site-title a, .site-description' ).css( {
					color: to,
				} );
			}
		} );
	} );
}( jQuery ) );

/* global themenameGetHexLum, jQuery */
( function() {
	// Add listener for the "background_color" control.
	wp.customize( 'background_color', function( value ) {
		value.bind( function( to ) {
			var lum = themenameGetHexLum( to ),
				isDark = 127 > lum,
				textColor = ! isDark ? 'var(--dark-gray)' : 'var(--gray)',
				tableColor = ! isDark ? 'var(--gray)' : 'var(--dark-gray)',
				stylesheetID = 'themename-customizer-inline-styles',
				stylesheet,
				styles;

			// Modify the html & body classes depending on whether this is a dark background or not.
			if ( isDark ) {
				document.body.classList.add( 'is-dark-theme' );
				document.documentElement.classList.add( 'is-dark-theme' );
				document.body.classList.remove( 'is-light-theme' );
				document.documentElement.classList.remove( 'is-light-theme' );
				document.documentElement.classList.remove( 'respect-color-scheme-preference' );
			} else {
				document.body.classList.remove( 'is-dark-theme' );
				document.documentElement.classList.remove( 'is-dark-theme' );
				document.body.classList.add( 'is-light-theme' );
				document.documentElement.classList.add( 'is-light-theme' );
				if ( wp.customize( 'respect_user_color_preference' ).get() ) {
					document.documentElement.classList.add( 'respect-color-scheme-preference' );
				}
			}

			// Toggle the white background class.
			if ( 225 <= lum ) {
				document.body.classList.add( 'has-background-white' );
			} else {
				document.body.classList.remove( 'has-background-white' );
			}

			stylesheet = jQuery( '#' + stylesheetID );
			styles = '';
			// If the stylesheet doesn't exist, create it and append it to <head>.
			if ( ! stylesheet.length ) {
				jQuery( '#themename-style-inline-css' ).after( '<style id="' + stylesheetID + '"></style>' );
				stylesheet = jQuery( '#' + stylesheetID );
			}

			// Generate the styles.
			styles += '--primary:' + textColor + ';';
			styles += '--secondary:' + textColor + ';';
			styles += '--Background:' + to + ';';

			styles += '--ButtonBackground:' + textColor + ';';
			styles += '--ButtonText:' + to + ';';
			styles += '--ButtonText-hover:' + textColor + ';';

			styles += '--table--stripes-border-color:' + tableColor + ';';
			styles += '--table--stripes-background-color:' + tableColor + ';';

			// Add the styles.
			stylesheet.html( ':root{' + styles + '}' );
		} );
	} );
}() );
