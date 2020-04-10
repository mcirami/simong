<?php
/**
* File for displaying recently viewed items pulled from cookie generated in content-recently-viewed-cookie.php file
*
* @package boiler
*/
?>
<?php if (is_singular('product') || get_field('show_recent')) : ?>
	<section class="recently_viewed">
		<div class="container">
			<h3>Recently Viewed</h3>
			<div class="recently_viewed_product_wrap">
			<?php
				
				$recentlyViewedItems = json_decode($_COOKIE['recentlyviewed'], true);
				
				$currentItem = $post->ID;
				
				if (is_array($recentlyViewedItems)) {
					if (in_array($currentItem, $recentlyViewedItems)) {
						// get the position of the element in the array
						$itemLocation = array_search($currentItem, $recentlyViewedItems);
						
						// remove the current item from the recently viewed items
						unset($recentlyViewedItems[$itemLocation]);
					}
				}
				
				// check to see if there are any values in the recentlyViewed array
				if ($recentlyViewedItems) :
					
					$args = array (
						'post_type' => 'product',
						'post__in' => $recentlyViewedItems,
						'orderby' => 'post__in',
						'posts_per_page' => 6
					);
				
					$recent = new WP_Query($args);
				
					while( $recent->have_posts() ) : $recent->the_post();
				
			?>
		
			<div class="recent_product">
				<div class="add_to_wishlist">
					<a href="#" class="add_to_wish_list_button js_add_to_wish_list <?php check_wish_list_item( get_the_ID() ); ?>" data-product-id="<?php the_ID(); ?>"><span>add to wish list</span></a>
				</div><!-- add-to-wish-list -->
				<div class="recent_product_image">
					<?php if(has_post_thumbnail()) : ?>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb-660-660'); ?></a>
					<?php else : ?>
						<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url'); ?>/images/placeholder.jpg" /></a>
					<?php endif; ?>
				</div>
			</div><!-- products -->
			
			<?php 	
					endwhile; wp_reset_postdata(); // end while have_posts
				echo '</div>';
				// if there are no values in $recentlyViewedItems
				else :
			?>
		
			<?php endif; // end if ($recentlyViewedItems) has any value ?>
		</div>
	</section>
<?php endif; ?>