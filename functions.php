<?php 

	add_action('nb_woocommerce_product_gallery', 'custom_gallery');
	function custom_gallery() {

		// Enqueue Required scripts & Styles
		wp_enqueue_script( 'lightbox', 'https://cdn.jsdelivr.net/npm/bs5-lightbox@1.7.8/dist/index.bundle.min.js'); // Lightbox/modelbox
		wp_enqueue_script( 'slick-js', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js'); // Slick Slider
		wp_enqueue_style( 'slick-css', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css'); // Slick Slider


		echo "<div id='woo-gallery-em'>";
			echo "<div class='gallery-list'>";
				global $product;

				$attachment_ids = $product->get_gallery_image_ids();

				foreach( $attachment_ids as $attachment_id ) {
					$image_link = wp_get_attachment_url( $attachment_id, 'full' );
					?>
					<!-- <a href="<?php echo $image_link; ?>" data-lightbox="woo-gallery"> -->
						<img src="<?php echo $image_link; ?>" alt="woo-gallery-image" class="w-100 img-fluid">
					<!-- </a> -->
					<?php 
				}
			echo "</div>";
			echo "<div class='nav-list'>";
				foreach( $attachment_ids as $attachment_id ) {
					$image_link = wp_get_attachment_url( $attachment_id, 'thumbnail' );
					?>
					<img src="<?php echo $image_link; ?>" alt="woo-gallery-image" class="w-100 img-fluid">
					<?php 
				}
			echo "</div>";
		echo "</div>";
		?>
		<script>
			jQuery(window).ready(function(){
				jQuery('#woo-gallery-em .gallery-list').slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
					fade: true,
					asNavFor: '#woo-gallery-nb .nav-list'
				});

				jQuery('#woo-gallery-em .nav-list').slick({
					slidesToShow: 5,
					slidesToScroll: 1,
					asNavFor: '#woo-gallery-nb .gallery-list',
					dots: true,
					centerMode: true,
					focusOnSelect: true,
					responsive: [{
						breakpoint: 1024,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 3,
							infinite: true,
							dots: true
						}
					}]
				});
			})				
		</script>
	<?php 
	}
?>
