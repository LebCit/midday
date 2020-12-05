<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MidDay
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site grid">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'midday' ); ?></a>

	<div id="main-nav" aria-label="<?php esc_attr_e( 'Main navigation', 'midday' ); ?>" class="overlay" tabindex="-1">
			<li>
				<a href="javascript:void(0)" id="close-button" class="close-button" aria-label="<?php esc_attr_e( 'Close menu', 'midday' ); ?>" title="<?php esc_attr_e( 'Close menu', 'midday' ); ?>">&times;</a>
			</li>
			<div class="overlay-content">					
					<?php
					wp_nav_menu(
						array(
							'container'      => false,
							'echo'           => true,
							'depth'          => 1,
							'theme_location' => 'menu-1',
							'items_wrap'     => '%3$s',
							'fallback_cb'    => 'midday_fallback_menu',
						)
					);
					?>
			</div>
		</div>

	<?php get_template_part( 'template-parts/masthead' ); ?>
		<div class="sidebar">
			<div class="site-branding">
				<?php
				the_custom_logo();
				?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"
					<?php if ( ! empty( get_theme_mod( 'midday_title_color_setting', '#fff' ) ) ) : ?>
						style = "color: <?php echo esc_attr( get_theme_mod( 'midday_title_color_setting' ) ); ?>"
					<?php endif; ?>
					><?php bloginfo( 'name' ); ?></a></h1>
					<?php
					$midday_description = get_bloginfo( 'description', 'display' );
					if ( $midday_description || is_customize_preview() ) :
						?>
					<p class="site-description"
						<?php if ( ! empty( get_theme_mod( 'midday_tagline_color_setting', 'rgb(176, 202, 219)' ) ) ) : ?>
							style = "color: <?php echo esc_attr( get_theme_mod( 'midday_tagline_color_setting' ) ); ?>"
						<?php endif; ?>
					><?php echo $midday_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<?php endif; ?>
			</div><!-- .site-branding -->

			<nav class="nav">
				<ul class="nav-list">
					<li class="nav-item">
						<a id="menu-button" aria-controls="main-nav" aria-haspopup="true" tabindex="0" role="button">
						<?php esc_html_e( 'MENU', 'midday' ); ?>
							<span class="menu-icon" aria-hidden="true">
								<svg version='1.1' x='0px' y='0px' width='30px' height='30px' viewBox='0 0 30 30' enable-background='new 0 0 30 30'>
									<rect width='30' height='5' />
									<rect y='24' width='30' height='5' />
									<rect y='12' width='30' height='5' /></svg>
							</span>
						</a>
					</li>
				</ul>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content unit-1 unit-lg-3-5">
