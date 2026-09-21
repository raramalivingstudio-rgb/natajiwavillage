<?php
/**
 * Natajiwa Village — Hello Elementor child theme
 * Fonts + the shared Scott-derived motion system, cache-busted assets,
 * and SEO structured data. Free plugins only.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NATAJIWA_VER', '1.2.0' );

/**
 * Version string based on file modification time so browsers, LiteSpeed and
 * Cloudflare always fetch the latest CSS/JS after an update (cache-busting).
 */
function natajiwa_asset_ver( $rel_path ) {
	$file = get_stylesheet_directory() . $rel_path;
	return file_exists( $file ) ? (string) filemtime( $file ) : NATAJIWA_VER;
}

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
		natajiwa_asset_ver( '/style.css' )
	);

	// Google Fonts — Fraunces (headings) + Jost (body).
	wp_enqueue_style(
		'natajiwa-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;1,9..144,400&family=Jost:wght@300;400;500&display=swap',
		array(),
		null
	);

	// The shared motion system (cache-busted by file mtime).
	wp_enqueue_style(
		'natajiwa-scott',
		get_stylesheet_directory_uri() . '/assets/css/scott.css',
		array( 'natajiwa-child-style' ),
		natajiwa_asset_ver( '/assets/css/scott.css' )
	);

	// The shared motion behaviour (buttons, reveals, image-wipe, hero slider).
	wp_enqueue_script(
		'natajiwa-scott',
		get_stylesheet_directory_uri() . '/assets/js/scott.js',
		array(),
		natajiwa_asset_ver( '/assets/js/scott.js' ),
		true
	);

}, 20 );

/**
 * Theme supports + nav menu location.
 */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 120,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'natajiwa-child' ),
	) );
} );

/**
 * Helper: URL to a bundled theme image.
 */
function natajiwa_img( $path ) {
	return esc_url( get_stylesheet_directory_uri() . '/assets/img/' . ltrim( $path, '/' ) );
}

/* ==========================================================================
   SEO — Open Graph, Twitter Card, canonical, and LodgingBusiness schema.
   (For per-page titles/descriptions and an XML sitemap, also install the
   free Yoast SEO plugin — it complements this structured data.)
   ========================================================================== */

add_action( 'wp_head', function () {

	$name  = 'Natajiwa Village';
	$desc  = 'A wooden sanctuary in Kerobokan, Bali — teak villas, garden light, an open-air pool and honest island calm, moments from Canggu and Seminyak.';
	$url   = home_url( add_query_arg( null, null ) );
	$img   = get_stylesheet_directory_uri() . '/assets/img/property/villas-twilight.webp';
	$title = function_exists( 'wp_get_document_title' ) ? wp_get_document_title() : $name;

	echo "\n<!-- Natajiwa SEO -->\n";
	// Favicon (only if no WordPress Site Icon has been set in Customizer).
	if ( ! has_site_icon() ) {
		$fav = get_stylesheet_directory_uri() . '/assets/favicon.svg';
		echo '<link rel="icon" href="' . esc_url( $fav ) . '" type="image/svg+xml">' . "\n";
		echo '<link rel="mask-icon" href="' . esc_url( $fav ) . '" color="#005232">' . "\n";
	}
	echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( $name ) . '">' . "\n";
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
	echo '<meta name="twitter:image" content="' . esc_url( $img ) . '">' . "\n";

	// Structured data on the front page only.
	if ( is_front_page() || is_home() ) {
		$base = get_stylesheet_directory_uri() . '/assets/img/property/';
		$schema = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'LodgingBusiness',
			'name'        => $name,
			'description' => $desc,
			'url'         => home_url( '/' ),
			'telephone'   => '+6285956388724',
			'email'       => 'natajiwavilla@gmail.com',
			'priceRange'  => '$$',
			'image'       => array(
				$base . 'villas-twilight.webp',
				$base . 'pool-garden.webp',
				$base . 'garden-lawn.webp',
				$base . 'aerial-property.webp',
			),
			'logo'        => get_stylesheet_directory_uri() . '/assets/img/natajiwa-logo-768.webp',
			'address'     => array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => 'Jl. Pengubengan Kauh, Kerobokan',
				'addressLocality' => 'Kuta Utara',
				'addressRegion'   => 'Bali',
				'postalCode'      => '80361',
				'addressCountry'  => 'ID',
			),
			'geo'         => array(
				'@type'     => 'GeoCoordinates',
				'latitude'  => -8.663358,
				'longitude' => 115.1700089,
			),
			'hasMap'      => 'https://maps.app.goo.gl/wJ7nYRgFbe88w5S26',
			'sameAs'      => array( 'https://www.instagram.com/natajiwavillage' ),
			'amenityFeature' => array(
				array( '@type' => 'LocationFeatureSpecification', 'name' => 'Outdoor swimming pool', 'value' => true ),
				array( '@type' => 'LocationFeatureSpecification', 'name' => 'Free Wi-Fi', 'value' => true ),
				array( '@type' => 'LocationFeatureSpecification', 'name' => 'Air conditioning', 'value' => true ),
				array( '@type' => 'LocationFeatureSpecification', 'name' => 'Restaurant', 'value' => true ),
				array( '@type' => 'LocationFeatureSpecification', 'name' => 'Garden', 'value' => true ),
				array( '@type' => 'LocationFeatureSpecification', 'name' => 'Free parking', 'value' => true ),
			),
			'makesOffer'  => array(
				array( '@type' => 'Offer', 'itemOffered' => array( '@type' => 'Accommodation', 'name' => 'One Bedroom Garden Wooden Villa' ) ),
				array( '@type' => 'Offer', 'itemOffered' => array( '@type' => 'Accommodation', 'name' => 'One Bedroom Deluxe Villa' ) ),
				array( '@type' => 'Offer', 'itemOffered' => array( '@type' => 'Accommodation', 'name' => 'One Bedroom Pool Villa' ) ),
			),
		);
		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	}
	echo "<!-- /Natajiwa SEO -->\n";
}, 5 );
