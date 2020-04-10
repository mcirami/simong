<?php if(get_field('category_description')) : ?>
	<div class="description">
		<?php the_field('category_description'); ?>
	</div>
<?php endif; ?>

<?php get_template_part('content', 'filters'); ?>

<?php
	$mainCat = get_field('main_category');
	
	if( have_rows('collections') ): ?>

		<?php while ( have_rows('collections') ) : the_row(); ?>
			<div class="row">
				<?php $collection = get_sub_field('collection'); ?>
				
				<?php $link = get_term_link($collection->slug, $collection->taxonomy).$mainCat->slug; ?>
				
				<div class="row_heading">
					<h2><a href="<?php echo $link; ?>"><?php echo $collection->name; ?> Collection</a></h2>
					<a class="view_all" href="<?php echo $link; ?>">VIEW ALL</a>
				</div>
				
				<?php
					$args = array(
						'post_type' => 'product',
						'posts_per_page' => 5,
						'order' => 'ASC',
						'tax_query' => array(
							'relation' => 'AND',
								array(
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $mainCat,
									),
								array (
									'taxonomy' => 'collection',
									'field' => 'slug',
									'terms' => $collection,
									)
								),
							);

					$query = new WP_Query($args); 
				?>

				<div class="post_count">
					<p><?php echo $query->found_posts . " " . $mainCat->name; ?> </p>
				</div>
				
				<div class="products">
					<div class="product_grid">
					<?php while( $query->have_posts() ) : $query->the_post(); ?>
						<?php 
							$price = get_post_meta( get_the_ID(), '_regular_price', true);
							$productNumber = get_post_meta(get_the_ID(), 'productNumber', true);
						?>
						<div class="product">
							<div class="add_to_wish_list">
								<a href="#" class="add_to_wish_list_button js_add_to_wish_list <?php check_wish_list_item( get_the_ID() ); ?>" data-product-id="<?php the_ID(); ?>"><span>add to wishlist</span></a>
							</div>
							<?php if(has_post_thumbnail()) : ?>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
							<?php else : ?>
								<a href="<?php the_permalink(); ?>"><img src="<?php echo bloginfo('template_url'); ?>/images/placeholder.jpg" alt="placeholder image" /></a>
							<?php endif; ?>							
							<div class="info">
								<h3><?php echo $productNumber; ?></h3>
								<p><?php echo '$' . number_format($price); ?></p>
							</div>
						</div>
					<?php endwhile; ?>
					</div>
				</div>

			<?php wp_reset_postdata(); ?>
		</div>
	    <?php endwhile; ?>

	<?php endif; ?>