<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package boiler
 */

get_header(); ?>
	
	<?php
		$queried_object = get_queried_object();
		$taxonomy = $queried_object->taxonomy;
		$term_id = $queried_object->term_id; 
		$termName = $queried_object->name;
		$termSlug = $queried_object->slug;
		$termString = $taxonomy . '_' . $term_id;
		$product_category = isset($wp_query->query_vars['product_category']) ? ($wp_query->query_vars['product_category']) : null;
		$termLink = get_term_link($term_id, $taxonomy);
	?>

	<?php include(locate_template('content-hero.php')); ?>
	
	<section class="collection">
		<div class="container">
			<?php $description = term_description(); ?>
			<?php if($product_category) : ?>
				<?php get_template_part('content', 'filters'); ?>
			<?php endif; ?>
			
			<?php
					$args = array(
						'post_type' => 'product',
						'product_cat' => $termSlug,
						'posts_per_page' => -1
					);
				
			
				$collection = new WP_Query($args); 
				
				if ( $collection->have_posts() ) : 
			?>
			
				<div class="products">
					<div class="row">
						<div class="row_heading">
							<h2><a href="<?php echo $termLink; ?>"><?php echo $termName . ' Collection'; ?></a></h2>
							<?php if($product_category) : ?><a class="view_all" href="<?php echo $termLink; ?>">VIEW ENTIRE COLLECTION</a><?php endif; ?>
						</div>
						<div class="post_count">
							<?php echo $collection->post_count . ' Pieces'; ?>
						</div>
					</div>
					
					<div class="product_grid">
						<div class="product_desc">
							<h2><?php echo $termName . ' Collection'; ?></h2>
							<p><?php echo $description; ?></p>
						</div>
					
						<?php while ( $collection->have_posts() ) : $collection->the_post(); ?>
						
						<?php $price = get_post_meta( get_the_ID(), '_regular_price', true); ?>
						
						<div class="product">
							<div class="add_to_wish_list">
								<a href="#" class="add_to_wish_list_button js_add_to_wish_list <?php check_wish_list_item( get_the_ID() ); ?>" data-product-id="<?php the_ID(); ?>"><span>add to wishlist</span></a>
							</div>
							<?php if(has_post_thumbnail()) : ?>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb-400-400'); ?></a>
							<?php else : ?>
								<a href="<?php the_permalink(); ?>"><img src="<?php echo bloginfo('template_url'); ?>/images/placeholder.jpg" alt="placeholder image" /></a>
							<?php endif; ?>
							<div class="info">
								<h3><?php echo get_post_meta($post->ID, 'productNumber', true); ?></h3>
								<p><?php echo '$' . number_format($price); ?></p>
							</div>
						</div>
						
						<?php endwhile; else: ?>
					
					</div>
					
				</div>
			
			<?php endif; ?>
		</div>
	</section>

<?php get_footer(); ?>