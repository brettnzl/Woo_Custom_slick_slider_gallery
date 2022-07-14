<?php 

add_action('nb_woocommerce_product_gallery', 'custom_gallery');
function custom_gallery() {
	if (isset($_GET['brett'])) {
		
		// Enqueue Required scripts & Styles
		// wp_enqueue_script( 'lightbox', 'https://cdn.jsdelivr.net/npm/bs5-lightbox@1.7.8/dist/index.bundle.min.js'); // Lightbox/modelbox
		wp_enqueue_script( 'slick-js', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js'); // Slick Slider
		wp_enqueue_style( 'slick-css', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css'); // Slick Slider
		

		echo "<div id='woo-gallery-nb'>";
			echo "<div class='gallery-list'>";
				global $product;
				
				// get main image + gallery images
				$main_id = get_post_thumbnail_id( $product->get_ID() );
				$gallery_ids = $product->get_gallery_image_ids();

				// Get Variation images
				$variations = $product->get_available_variations();
				
				// Merge the ID's
				$all_ids = array();
				$all_ids[] = $main_id;
				$all_ids = array_merge($all_ids, $gallery_ids);

				if (!empty($variations)) {
					foreach ( $variations as $variation ) {
						$all_ids[] = $variation['image_id'];
					}
				}				
				
				if (!empty($all_ids)) {
					$add_list = array();
					foreach( $all_ids as $attachment_id ) {
						$image_link = wp_get_attachment_url( $attachment_id, 'full' );
						
						//prevent duplicate images:
						if (in_array($image_link, $add_list)) {
							continue;
						}
						$add_list[] = $image_link;
						?>
						<!-- <a href="<?php echo $image_link; ?>" data-lightbox="woo-gallery"> -->
							<div class="gallery-image" data-thumbnail-id="<?php echo $attachment_id; ?>"><img src="<?php echo $image_link; ?>" alt="woo-gallery-image" class="w-100 img-fluid"></div>
						<!-- </a> -->
						<?php 
					}
				}
			echo "</div>";
			if (!empty($all_ids) && sizeof($add_list) > 1 ) {
				echo "<div class='nav-list'>";
					$add_list = array();
						foreach( $all_ids as $attachment_id ) {
							$image_link = wp_get_attachment_url( $attachment_id, 'thumbnail' );
							
							//prevent duplicate images:
							if (in_array($image_link, $add_list)) {
								continue;
							}
							$add_list[] = $image_link;
							?>

							<div class="thumbnail-image" data-thumbnail-id="<?php echo $attachment_id; ?>"><img src="<?php echo $image_link; ?>" alt="woo-gallery-image" class="w-100 img-fluid"></div>
							<?php 
						}
				echo "</div>";
			}
		echo "</div>";
		?>
		<script>

			jQuery(window).ready(function(){
				
				// Activate the Slider
				jQuery('#woo-gallery-nb .gallery-list').slick({
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
					fade: true,
					asNavFor: '#woo-gallery-nb .nav-list'
				});

				jQuery('#woo-gallery-nb .nav-list').slick({
					slidesToShow: 5,
					slidesToScroll: 1,
					asNavFor: '#woo-gallery-nb .gallery-list',
					dots: true,
					centerMode: false,
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


				//Variation Image Swapping
				jQuery(document).on('found_variation', function(e, a) {
					console.log(a.image_id);
					jQuery('.thumbnail-image[data-thumbnail-id='+a.image_id+']').click();
				});
			})		
		</script>
		<?php 

	} else {
		do_action( 'woocommerce_before_single_product_summary' );
	}
}
