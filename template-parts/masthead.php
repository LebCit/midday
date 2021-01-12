<?php
/**
 * This file generates the background header image for the main Sidebar in header.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MidDay
 */

?>

<header id="masthead"
	<?php if ( ! empty( get_theme_mod( 'midday_sidebar_setting_image', '' ) ) || ( ( is_single() || is_page() ) && has_post_thumbnail() ) ) : ?>
		class="site-header unit-1 unit-lg-2-5 bio"
		<?php
		if ( is_front_page() && is_home() ) :
			?>
			style="background-image:url(<?php echo esc_url( get_theme_mod( 'midday_sidebar_setting_image', '' ) ); ?>)"
			<?php
		elseif ( ( is_single() || is_page() ) && has_post_thumbnail() ) :
			$singular_sidebar_background = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			?>
			style="background-image:url(<?php echo esc_url( $singular_sidebar_background[0] ); ?>)"
		<?php endif; ?>
	<?php else : ?>
		class="site-header unit-1 unit-lg-2-5 no-bio"
	<?php endif; ?>
>
