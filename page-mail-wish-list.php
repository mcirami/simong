<?php 
/**
 * Template Name: Mail Wish List
 */	
get_header(); ?>

<?php $item_ids = json_decode($_COOKIE['wishlist'], true); ?>
<?php
	$args = array (
		'post_type' => 'product',
		'post__in' => $item_ids,
		'orderby' => 'post__in',
	);

	$products = new WP_Query($args);
	$i=0;
	while( $products->have_posts() ) : $products->the_post();

	$productCategory = get_the_terms($post->ID, 'product_cat');
	foreach($productCategory as $category) {
		$categoryTerm = $category->name;
	}
	$productCollection = get_the_terms($post->ID, 'collection');
	foreach($productCollection as $category) {
		$collectionTerm = $category->name;
	}
	
	$_SESSION['wishlistTitle'.$i] = get_the_title(); 
	$_SESSION['wishlistCollection'.$i] = $collectionTerm;
	$_SESSION['wishlistLink'.$i] = get_the_permalink();
	$_SESSION['wishlistImage'.$i] = wp_get_attachment_url( get_post_thumbnail_id($post->ID));
	
	$i++;
	endwhile; wp_reset_postdata();
?>
<?php get_template_part('content', 'hero'); ?>

<section class="send_a_hint">
	<div class="container">
		<div class="hint_wrap">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="hint_form">
				<?php the_content(); ?>
			</div>
			<?php endwhile; else: ?>
			
			<?php endif; ?>
			<div class="hint_info">
				<?php
					$args = array (
						'post_type' => 'product',
						'post__in' => $item_ids,
						'orderby' => 'post__in',
					);
				
					$products = new WP_Query($args);
					$i=0;
					while( $products->have_posts() ) : $products->the_post();
				
					$productCategory = get_the_terms($post->ID, 'product_cat');
					foreach($productCategory as $category) {
						$categoryTerm = $category->name;
					}
					$productCollection = get_the_terms($post->ID, 'collection');
					foreach($productCollection as $category) {
						$collectionTerm = $category->name;
					}
				?>
					<div class="product_info">
						<div class="product_image">
							<?php if(has_post_thumbnail()) : ?>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb-660-660'); ?></a>
							<?php else : ?>
								<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url'); ?>/images/placeholder.jpg" /></a>
							<?php endif; ?>
						</div>
						<div class="product_details">
							<h3><?php the_title(); ?></h3>
							<h4><?php echo $collectionTerm . ' ' . 'Collection'; ?></h4>
<!-- 							<a href="<?php the_permalink(); ?>">BACK TO <?php echo strtoupper($categoryTerm); ?></a> -->
						</div>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>