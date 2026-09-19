<?php
/**
 * Natajiwa Village — site header (nav + mobile overlay).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$logo = get_stylesheet_directory_uri() . '/assets/img/natajiwa-logo-768.webp';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) { wp_body_open(); } ?>

<header id="hdr">
	<nav class="nav">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $logo ); ?>" alt="Natajiwa Village"></a>
		<ul>
			<li><a href="<?php echo esc_url( home_url( '/rooms/' ) ); ?>">Rooms</a></li>
			<li><a href="<?php echo esc_url( home_url( '/#dining' ) ); ?>">Dining</a></li>
			<li><a href="<?php echo esc_url( home_url( '/#experiences' ) ); ?>">Experiences</a></li>
			<li><a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>">Gallery</a></li>
			<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
		</ul>
		<div class="right">
			<a class="btn light" href="https://beds24.com/book-natajiwa" target="_blank" rel="noopener">Reserve</a>
			<button class="burger" id="burger" aria-label="Menu" aria-expanded="false"><span></span><span></span><span></span></button>
		</div>
	</nav>
</header>

<nav class="mobile-nav" id="mnav">
	<a href="<?php echo esc_url( home_url( '/rooms/' ) ); ?>">Rooms</a>
	<a href="<?php echo esc_url( home_url( '/#dining' ) ); ?>">Dining</a>
	<a href="<?php echo esc_url( home_url( '/#experiences' ) ); ?>">Experiences</a>
	<a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>">Gallery</a>
	<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
	<a class="btn light m-btn" href="https://beds24.com/book-natajiwa" target="_blank" rel="noopener">Reserve</a>
</nav>
