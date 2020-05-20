<?php
/**
 * MidDay Theme Customizer
 *
 * @package MidDay
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function midday_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->remove_section( 'header_image' );
	$wp_customize->remove_control( 'header_textcolor' );

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'midday_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'midday_customize_partial_blogdescription',
			)
		);
	}

	/**
	 * MidDay Theme Panel
	 */
	$wp_customize->add_panel(
		'midday_panel',
		array(
			'title'       => __( 'MidDay Theme', 'midday' ),
			'description' => esc_html__( 'Customize MidDay Theme', 'midday' ),
			'priority'    => 0,
		)
	);

	/**
	* Sidebar Image Section.
	*/
	$wp_customize->add_section(
		'midday_sidebar_image',
		array(
			'title'           => __( 'Sidebar Image', 'midday' ),
			'description'     => __( 'Set a Background Image for the Sidebar on HomePage, <strong>in Desktop View Only</strong>.', 'midday' ),
			'panel'           => 'midday_panel',
			'priority'        => 5,
			'active_callback' => 'is_front_page',
		)
	);

	/**
	 * Sidebar Image Setting.
	 */
	$wp_customize->add_setting(
		'midday_sidebar_setting_image',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	/**
	 * Sidebar Image Control.
	 */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'midday_sidebar_setting_image',
			array(
				'label'         => __( 'Sidebar Image Control', 'midday' ),
				'description'   => esc_html__( 'Choose sidebar homepage background image.', 'midday' ),
				'section'       => 'midday_sidebar_image',
				'button_labels' => array(
					'select'       => __( 'Select Image', 'midday' ),
					'change'       => __( 'Change Image', 'midday' ),
					'remove'       => __( 'Remove', 'midday' ),
					'default'      => __( 'Default', 'midday' ),
					'placeholder'  => __( 'No image selected', 'midday' ),
					'frame_title'  => __( 'Select Image', 'midday' ),
					'frame_button' => __( 'Choose Image', 'midday' ),
				),
			)
		)
	);

	/**
	* Title & Tagline Color Section.
	*/
	$wp_customize->add_section(
		'midday_title_tagline_color_section',
		array(
			'title'       => __( 'Title & Tagline Color', 'midday' ),
			'description' => __( 'Set Colors of Title & Tagline.', 'midday' ),
			'panel'       => 'midday_panel',
			'priority'    => 10,
		)
	);

	/**
	 * Title Color Setting.
	 */
	$wp_customize->add_setting(
		'midday_title_color_setting',
		array(
			'default'           => '#fff',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	/**
	 * Title Color Control.
	 */
	$wp_customize->add_control(
		'midday_title_color_setting',
		array(
			'label'       => __( 'Title Color Control', 'midday' ),
			'description' => esc_html__( 'Change Title Color', 'midday' ),
			'section'     => 'midday_title_tagline_color_section',
			'priority'    => 5,
			'type'        => 'color',
		)
	);

	/**
	 * Tagline Color Setting.
	 */
	$wp_customize->add_setting(
		'midday_tagline_color_setting',
		array(
			'default'           => 'rgb(176, 202, 219)',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	/**
	 * Tagline Color Control.
	 */
	$wp_customize->add_control(
		'midday_tagline_color_setting',
		array(
			'label'       => __( 'Tagline Color Control', 'midday' ),
			'description' => esc_html__( 'Change Tagline Color', 'midday' ),
			'section'     => 'midday_title_tagline_color_section',
			'priority'    => 10,
			'type'        => 'color',
		)
	);

	/**
	 * Footer Copyright Area Section.
	 */
	$wp_customize->add_section(
		'midday_footer_copyright_area_section',
		array(
			'title'       => esc_html__( 'Footer Copyright Area', 'midday' ),
			'description' => __( 'Modify <b>Footer Copyright Area</b>.', 'midday' ),
			'panel'       => 'midday_panel',
			'priority'    => 15,
		)
	);

	// Default copyright.
	$wp_customize->add_setting(
		'midday_footer_copyright_area_checkbox',
		array(
			'default'           => true,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'midday_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'midday_footer_copyright_area_checkbox',
		array(
			'label'       => __( 'Enable/Disable Default Copyright.', 'midday' ),
			'description' => __( 'This checkbox, once <b>unchecked</b>,<br>removes <b>Default Copyright.</b>', 'midday' ),
			'section'     => 'midday_footer_copyright_area_section',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'midday_footer_copyright_area_checkbox',
		array(
			'selector'        => '#site-info',
			'settings'        => array( 'midday_footer_copyright_area_checkbox' ),
			'render_callback' => 'midday_site_info',
		)
	);

	// Custom copyright.
	$wp_customize->add_setting(
		'midday_custom_copyright_textarea',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'wp_kses_post', // Allow html.
		)
	);

	$wp_customize->add_control(
		'midday_custom_copyright_textarea',
		array(
			'label'       => esc_html__( 'Custom Copyright Textarea', 'midday' ),
			'description' => __( 'To display a <b>Custom Copyright</b>,<br><b>uncheck</b> the <b>Default Copyright</b> checkbox,<br>then type a custom copyright in the textarea.<br><b>HTML</b> is allowed !', 'midday' ),
			'section'     => 'midday_footer_copyright_area_section',
			'type'        => 'textarea',
			'input_attrs' => array(
				'style'       => 'border: 1px solid #999',
				'placeholder' => __( 'Enter Custom Copyright...', 'midday' ),
			),
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'midday_custom_copyright_textarea',
		array(
			'selector'        => '#site-info',
			'settings'        => array( 'midday_custom_copyright_textarea' ),
			'render_callback' => 'midday_site_info',
		)
	);

}
add_action( 'customize_register', 'midday_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function midday_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function midday_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if ( ! function_exists( 'midday_sanitize_checkbox' ) ) {
	/**
	 * Switch sanitization
	 *
	 * @param string $input Switch value.
	 * @return integer  Sanitized value
	 */
	function midday_sanitize_checkbox( $input ) {
		if ( false === $input ) {
			return 0;
		} else {
			return 1;
		}
	}
}

/**
 * Hooking in JS code to affect the controls in the Customizer.
 */
function midday_customize_controls_js() {
	wp_enqueue_script( 'midday-controls', get_template_directory_uri() . '/js/controls.js', array( 'customize-controls' ), filemtime( get_theme_file_path( '/js/controls.js' ) ), true );
}
add_action( 'customize_controls_enqueue_scripts', 'midday_customize_controls_js' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function midday_customize_preview_js() {
	wp_enqueue_script( 'midday-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'midday_customize_preview_js' );
