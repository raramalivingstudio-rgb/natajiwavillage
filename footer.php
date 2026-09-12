<?php
/**
 * Natajiwa Village — site footer.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$logo = get_stylesheet_directory_uri() . '/assets/img/natajiwa-logo-768.webp';
?>
<footer>
	<div class="foot">
		<div class="wrap cols">
			<div>
				<div class="logo"><img src="<?php echo esc_url( $logo ); ?>" alt="Natajiwa Village"></div>
				<p>Jl. Pengubengan Kauh, Kerobokan Kelod, Kec. Kuta Utara, Kabupaten Badung, Bali 80361</p>
			</div>
			<div>
				<h4>Explore</h4>
				<p><a class="lk" href="<?php echo esc_url( home_url( '/rooms/' ) ); ?>">Rooms</a></p>
				<p><a class="lk" href="<?php echo esc_url( home_url( '/#dining' ) ); ?>">Dining</a></p>
				<p><a class="lk" href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>">Gallery</a></p>
				<p><a class="lk" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></p>
			</div>
			<div>
				<h4>Reserve</h4>
				<p><a class="lk" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Book Now</a></p>
				<p><a class="lk" href="https://wa.me/6281000000000">WhatsApp</a></p>
				<p><a class="lk" href="mailto:natajiwavilla@gmail.com">natajiwavilla@gmail.com</a></p>
			</div>
		</div>
	</div>
	<div class="hotels">
		<span class="label">Natajiwa Village</span>
		<h3>Come Stay Awhile</h3>
		<a class="btn light" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Explore &amp; Book</a>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
