/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {
	// Site title and description.
	wp.customize('blogname', function (value) {
		value.bind(function (to) {
			$('.site-title a').text(to);
		});
	});
	wp.customize('blogdescription', function (value) {
		value.bind(function (to) {
			$('.site-description').text(to);
		});
	});

	// Sidebar Image.
	wp.customize("midday_sidebar_setting_image", function (value) {
		value.bind(function (new_val) {
			$(".home.blog .site-header").css({
				"background-image": `url(${new_val})`,
				"background-repeat": "no-repeat",
				"background-position": "top",
				"background-size": "cover",
			});
		});
	});

	// Listen for changes in the Customizer.
	wp.customize.bind( 'change', function ( setting ) {
		// Add/Remove bio (Background Image Overlay) for Sidebar Image.
		if ( 0 === setting.id.indexOf( 'midday_sidebar_setting_image' ) ) {
			// The _value is empty by default so we begin by listening to a non empty _value.
			if ((setting._value) != "") {
				console.log('plain');
				$(".home.blog .site-header").addClass('bio');
			} else {
				console.log('void');
				$(".home.blog .site-header").removeClass('bio');
			}
		}
	});

	// Title Color.
	wp.customize("midday_title_color_setting", function (value) {
		value.bind(function (new_val) {
			$(".site-title a").css("color", new_val);
		});
	});

	// Tagline Color.
	wp.customize("midday_tagline_color_setting", function (value) {
		value.bind(function (new_val) {
			$(".site-description").css("color", new_val);
		});
	});

}(jQuery));
