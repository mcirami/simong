<?php 
/**
 * Template Name: Send A Hint
 */	
get_header(); ?>

<?php
	$attr = array(
		'src' => $src	
	);
	$productID = ($_GET['productID']) ? esc_attr($_GET['productID']) : null; 
	$productImageSrc = wp_get_attachment_url(get_post_thumbnail_id($productID));
	$productImage = get_the_post_thumbnail($productID);
	$productTitle = get_the_title($productID);
	$productCollection = get_the_terms($productID, 'collection');
	$productCategory = get_the_terms($productID, 'product_cat');
	$categoryTerm = $productCategory[0]->name;
	$collectionTerm = $productCollection[0]->name;
	$productLink = get_permalink($productID);
	if(substr($categoryTerm, -1) === 's') {
		$categoryTerm = strtok($categoryTerm, 's');
	}
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
				<div class="product_image">
					<?php echo $productImage; ?>
				</div>
				<div class="product_details">
					<h3><?php echo $productTitle . ' ' . $categoryTerm; ?></h3>
					<h4><?php echo $collectionTerm . ' ' . 'Collection'; ?></h4>
					<a href="<?php echo $productLink; ?>">BACK TO <?php echo strtoupper($categoryTerm); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>