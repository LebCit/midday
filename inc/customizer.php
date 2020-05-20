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
