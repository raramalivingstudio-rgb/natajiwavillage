<?php
/**
 * Template Name: Natajiwa Full Width
 *
 * Renders the page content edge-to-edge (no content wrapper) so the
 * curtain-drop hero, full-bleed bands and image-wipe sections display
 * exactly like the prototype. Keeps the theme header + footer.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

echo '<main id="main">';
while ( have_posts() ) :
	the_post();
	// Output the raw page content (section HTML) with no extra markup.
	the_content();
endwhile;
echo '</main>';

get_footer();
