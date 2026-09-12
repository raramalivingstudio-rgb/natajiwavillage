<?php
/**
 * Natajiwa Village — Hello Elementor child theme
 * Enqueues fonts + the shared Scott-derived motion system, and wires
 * a few conveniences. Free plugins only.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NATAJIWA_VER', '1.0.0' );

/**
 * Styles & scripts.
 */
add_action( 'wp_enqueue_scripts', function () {

	// Parent (Hello Elementor) base stylesheet.
	wp_enqueue_style(
		'hello-elementor-theme-style',
		get_template_directory_uri() . '/style.css',
		array(),
		NATAJIWA_VER
	);

	// Child theme header stylesheet.
	wp_enqueue_style(
		'natajiwa-child-style',
		get_stylesheet_uri(),
		array( 'hello-elementor-theme-style' ),
		NATAJIWA_VER
	);

	// Google Fonts — Fraunces (headings) + Jost (body).
	wp_enqueue_style(
		'natajiwa-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;1,9..144,400&family=Jost:wght@300;400;500&display=swap',
		array(),
		null
	);

	// The shared motion system (mirrors redesign/assets/css/scott.css).
	wp_enqueue_style(
		'natajiwa-scott',
		get_stylesheet_directory_uri() . '/assets/css/scott.css',
		array( 'natajiwa-child-style' ),
		NATAJIWA_VER
	);

	// The shared motion behaviour (buttons, reveals, image-wipe, mobile nav).
	wp_enqueue_script(
		'natajiwa-scott',
		get_stylesheet_directory_uri() . '/assets/js/scott.js',
		array(),
		NATAJIWA_VER,
		true
	);

}, 20 );

/**
 * Theme supports + nav menu location (optional; header.php falls back to
 * hardcoded links if no menu is assigned).
 */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'    => 120,
		'width'     => 400,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'natajiwa-child' ),
	) );
} );

/**
 * Helper: URL to a bundled theme image.
 * Usage in templates: echo natajiwa_img( 'gallery-01.webp' );
 */
function natajiwa_img( $path ) {
	return esc_url( get_stylesheet_directory_uri() . '/assets/img/' . ltrim( $path, '/' ) );
}
