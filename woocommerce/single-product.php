<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_template_part('content', 'recently-viewed-cookies');
get_header( 'shop' ); ?>
	
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
		<div class="container">
			
			<?php 
				global $post;
				
				$current_ID = get_the_ID();
				$current_type = null;
				
				$categories = wp_get_object_terms($current_ID, 'product_cat');
				if($categories) {
					foreach($categories as $category) {
						if($category->slug == 'engagement-rings') {
							$current_type = 'ring';
						} else if($category->slug == 'engagement-sets') {
							$current_type = 'set';
						} else if($category->slug == 'bands') {
							$current_type = 'band';
						} else if($category->slug == 'custom') {
							$current_type = 'custom';
						}
					}
				}
				
				$args = array(
					'post_type' => 'product',
					'meta_query' => array(
						array(
							'key'     => 'productNumber',
							'value'   => get_post_meta($post->ID, 'productNumber', true),
							'compare' => '=',
						),
					),
				);
						
				$query = new WP_Query($args);
				
				$product_types = array();
						
				if($query->have_posts() && $query->found_posts > 1) : ?>
					<div class="related_product_links">
						<?php while($query->have_posts()) : $query->the_post(); ?>
								<?php 
									$categories = wp_get_object_terms(get_the_ID(), 'product_cat');
									if($categories) {
										foreach($categories as $category) {
											if($category->slug == 'engagement-rings') {
												$product_types['ring'] = get_the_ID();
											} else if($category->slug == 'engagement-sets') {
												$product_types['set'] = get_the_ID();
											} else if($category->slug == 'bands') {
												$product_types['band'] = get_the_ID();
											} else if($category->slug == 'custom') {
												$product_types['custom'] = get_the_ID();
											}
										}
									}
								?>		
						<?php endwhile; wp_reset_postdata(); ?>
						<?php if(array_key_exists('set', $product_types)) : ?>
							<a href="#set" <?php if($product_types['set'] == $current_ID) { echo 'class="active"'; } ?>>SET</a>
						<?php endif; ?>
						
						<?php if(array_key_exists('ring', $product_types)) : ?>
							<a href="#ring" <?php if($product_types['ring'] == $current_ID) { echo 'class="active"'; } ?>>RING</a>
						<?php endif; ?>
						
						<?php if(array_key_exists('band', $product_types)) : ?>
							<a href="#band" <?php if($product_types['band'] == $current_ID) { echo 'class="active"'; } ?>>BAND</a>
						<?php endif; ?>
						
						<?php if(array_key_exists('custom', $product_types)) : ?>
							<a href="#custom" <?php if($product_types['custom'] == $current_ID) { echo 'class="active"'; } ?>>CUSTOM</a>
						<?php endif; ?>
					</div>
				<?php
				endif;
			?>
			
			<div id="product_ajax_wrapper">
				
				<?php
					$args = array(
						'post_type' => 'product',
						'meta_query' => array(
							array(
								'key'     => 'productNumber',
								'value'   => get_post_meta($post->ID, 'productNumber', true),
								'compare' => '=',
								'post__not_in' => array($post->ID),
							),
						),
					);
							
					$query = new WP_Query($args);
					
					$product_type = null;
					$product_types = array();
					$related_products = array();
							
					if($query->have_posts() && $query->found_posts > 1) :
						while($query->have_posts()) : $query->the_post();
							$categories = wp_get_object_terms(get_the_ID(), 'product_cat');
							if($categories) {
								foreach($categories as $category) {
									if($category->slug == 'engagement-rings') {
										$product_type = 'ring';
									} else if($category->slug == 'engagement-sets') {
										$product_type = 'set';
									} else if($category->slug == 'bands') {
										$product_type = 'band';
									} else if($category->slug == 'custom') {
										$product_type = 'custom';
									}
								}
							}
							
							if($product_type) { ?>
								<div id="product-<?php echo $product_type; ?>" class="product_type_container" style="display: none;">
									<?php wc_get_template_part( 'content', 'single-product' ); ?>
								</div>
							<?php
							}
						endwhile; wp_reset_postdata(); 
					endif;
				?>
				
				<?php while ( have_posts() ) : the_post(); ?>
				
					<?php if($product_type) { ?>
							<div id="product-<?php echo $product_type; ?>" class="product_type_container">
								<?php wc_get_template_part( 'content', 'single-product' ); ?>
							</div>
					<?php } else { ?>
		
						<?php wc_get_template_part( 'content', 'single-product' ); ?>
						
					<?php } ?>
		
				<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
	
	<?php 
		$collectionTerms = get_the_terms($post->ID, 'collection'); 
		$collectionIDs = array();
		
		foreach ($collectionTerms as $term) {
			array_push($collectionIDs, $term->term_id);
		}
	?>
	
	<?php
		$args = array (
			'post_type' => 'product',
			'posts_per_page' => 5,
				'tax_query' => array(
				array (
					'taxonomy' 	=> 'collection',
					'field'		=> 'id',
					'terms'		=> $collectionIDs,
				),
			),
	
		);
	
		$related = new WP_Query($args); 
		
		if( $related->have_posts() ) :
	?>
		
		<section class="related_products_wrapper">
			<div class="container">
				<h2>Finish the Look</h2>
				<?php while( $related->have_posts() ) : $related->the_post(); ?>
					<?php $productNumber = get_post_meta(get_the_ID(), 'productNumber', true); ?>
					<div class="related_product">
						<div class="add_to_wishlist">
							<a href="#" class="add_to_wish_list_button js_add_to_wish_list dark_background <?php check_wish_list_item( get_the_ID() ); ?>" data-product-id="<?php the_ID(); ?>"><span>add to wish list</span></a>
						</div><!-- add-to-wish-list -->
						<div class="recent_product_image">
							<?php $blueImage = get_field('blue_image'); ?>
							<?php if($blueImage) : ?>
								<a href="<?php the_permalink(); ?>"><img src="<?php echo $blueImage['url']; ?>" alt="<?php echo $blueImage['alt']; ?>" /></a>
							<?php elseif(has_post_thumbnail()) : ?>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb-660-660'); ?></a>
							<?php else : ?>
								<a href="<?php the_permalink(); ?>"><img src="<?php echo bloginfo('template_url'); ?>/images/sample-image-blue.png" alt="placeholder image" /></a>
							<?php endif; ?>
							<h4><?php echo $productNumber; ?></h4>
                            <?php
                            global $post;
                            $collections = get_the_terms($post->ID, 'collection');
                            $i = 0;
                            foreach ($collections as $collection) {
                                if ($i < 1) {
                                    $collectionName = $collection->name.' Collection';
                                }
                                $i++;
                            }
                            ?>
							<p><?php echo $collectionName; ?></p>
							<p><?php echo $product->get_price_html(); ?> <span class="usd">USD</span></p>
						</div>
					</div><!-- products -->
				
				<?php endwhile; ?>
			</div>
		</section>
		
	<?php endif; ?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		//do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>
