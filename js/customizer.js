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
			$(".site-header").css({
				"background-image": `url(${new_val})`,
				"background-repeat": "no-repeat",
				"background-position": "top",
				"background-size": "cover",
			});
		});
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
