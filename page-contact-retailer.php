<?php 
/**
 * Template Name: Contact a Retailer
 */	
get_header(); ?>

<?php
	$attr = array(
		'src' => $src	
	);
	$productID = ($_GET['productID']) ? esc_attr($_GET['productID']) : null; 
	$productImageSrc = get_the_post_thumbnail($productID, 'post-thumbnail', $attr);
	$productImage = get_the_post_thumbnail($productID);
	$productTitle = get_the_title($productID);
	$productCollection = get_the_terms($productID, 'collection');
	$productCategory = get_the_terms($productID, 'product_cat');
	$categoryTerm = strtoupper($productCategory[0]->name);
	$collectionTerm = $productCollection[0]->name;
	$productLink = get_permalink($productID);
	if(substr($categoryTerm, -1) === 'S') {
		$categoryTerm = strtok($categoryTerm, 's');
	}
?>

<?php //get_template_part('content', 'hero'); ?>

<div class="banner-locator banner-noImage light">
	<div class="container">
		<div class="store_page_title">
			<h1>Contact a retail partner</h1><!-- add .center or .light to change default styles -->
			<p>To find out more about this piece, select a store or search for a retail partner.</p>
		</div>
		<div class="store_page_search">
			<form action="#">
				<label for="">Search by city, state, or zip</label>
				<input class="wtb_search" type="text" maxlength="12" placeholder="Enter zip code" />
				<input class="wtb_go" type="submit" value="Go" />
			</form>
		</div>
	</div>
</div>

<form action="#" method="POST" id="contact-retailer" class="contact-form">
	<fieldset class="retailers">
		
	</fieldset>
</form>

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
					<a href="<?php echo $productLink; ?>">BACK TO <?php echo $categoryTerm; ?></a>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>