<?php
/**
 * MidDay functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package MidDay
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'midday_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function midday_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on MidDay, use a find and replace
		 * to change 'midday' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'midday', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'midday' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'midday_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'midday_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function midday_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'midday_content_width', 640 );
}
add_action( 'after_setup_theme', 'midday_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function midday_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'midday' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'midday' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'midday_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function midday_scripts() {
	wp_enqueue_style( 'midday-style', get_stylesheet_uri(), array(), _S_VERSION );

	wp_enqueue_script( 'midday-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'midday-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'midday_scripts' );

/**
 * Load and localize midday.js.
 */
function midday_js() {
	wp_enqueue_script( 'midday-js', get_theme_file_uri( '/js/midday.js' ), array(), _S_VERSION, true );
	// Localize the script with new data and pass php variables to JS.
	$midday_js_data = array(
		'midday_home'         => is_front_page() && is_home(),
		'midday_get_header_i' => get_header_image(),
		'midday_header_image' => header_image(),
	);
	wp_localize_script( 'midday-js', 'midday_vars', $midday_js_data );
}
add_action( 'wp_enqueue_scripts', 'midday_js' );

/**
 * Filter the excerpt length to 30 words.
 *
 * @see https://developer.wordpress.org/reference/functions/the_excerpt/#comment-325
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function midday_custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'midday_custom_excerpt_length', 999 );

/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @see https://developer.wordpress.org/reference/functions/the_excerpt/#comment-327
 * @param string $more Link to the article.
 */
function midday_excerpt_more( $more ) {
	if ( ! is_single() ) {
		$more = sprintf(
			'<p><a href="%1$s" class="read-more-link" role="button">%2$s</a></p>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( __( 'Read More&hellip; %s', 'midday' ), '<span class="screen-reader-text">' . esc_html( 'Continue reading ' ) . get_the_title( get_the_ID() ) . '</span>' )
		);
		return '&hellip; ' . $more;
	}
}
add_filter( 'excerpt_more', 'midday_excerpt_more' );

/**
 * Provide a fallback menu featuring a 'Home' link and a theme documentation link,
 * if no other menu has been provided.
 * Add 'Create a new menu' link only if the current_user_can('edit_theme_options').
 * Theme documentation link is added because navigation needs at least 2 links to work,
 * so if a user is not logged in, he will have 2 links and a working menu.
 * This behaviour is to ensure trap TAB inside the navigation once opened.
 */
function midday_fallback_menu() {
	$html          = '<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item menu-item-home">';
		$html     .= '<a href="' . esc_url( home_url() ) . '">';
			$html .= esc_html__( 'Home', 'midday' );
		$html     .= '</a>';
	$html         .= '</li>';
	$html         .= '<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item menu-item-home">';
		$html     .= '<a href="' . esc_url( 'https://wordpress.org/' ) . '" target="_blank">';
			$html .= esc_html__( 'Theme Documentation', 'midday' );
		$html     .= '</a>';
	$html         .= '</li>';
	if ( current_user_can( 'edit_theme_options' ) ) {
		$html         .= '<li class="menu-item menu-item-type-custom menu-item-object-custom ">';
			$html     .= '<a href="' . esc_url( admin_url( 'nav-menus.php?action=edit&menu=0' ) ) . '">';
				$html .= esc_html__( 'Create a new menu', 'midday' );
			$html     .= '</a>';
		$html         .= '</li>';
	}
	echo wp_kses(
		$html,
		array(
			'li' => array(
				'class' => array(),
			),
			'a'  => array(
				'href'   => array(),
				'target' => array(),
			),
		)
	);
}

/**
 * Output the theme's footer depending on user's choice.
 */
function midday_site_info() {
	$midday_footer_copyright_area_checkbox = get_theme_mod( 'midday_footer_copyright_area_checkbox', true );
	$midday_custom_copyright_textarea      = get_theme_mod( 'midday_custom_copyright_textarea', '' );
	if ( ! empty( $midday_footer_copyright_area_checkbox ) ) :
			$html  = '<a href="' . esc_url( 'https://wordpress.org/' ) . '">' . esc_html( 'Proudly powered by WordPress' ) . '</a>';
			$html .= '<br>';
			$html .= esc_html( 'Theme: MidDay by ' ) . '<a href="' . esc_url( 'https://lebcit.github.io/' ) . '">' . esc_html( 'LebCit' ) . '</a>';
			echo wp_kses(
				$html,
				array(
					'a'  => array(
						'href' => array(),
					),
					'br' => array(),
				)
			);
	elseif ( empty( $midday_footer_copyright_area_checkbox ) && ! empty( $midday_custom_copyright_textarea ) ) :
		echo wp_kses_post( $midday_custom_copyright_textarea ); // Allow html.
	endif;
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
