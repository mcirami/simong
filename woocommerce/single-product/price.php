<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>

<div class="product_specs">
	<?php 
		$metal_code = get_post_meta(get_the_ID(), 'metal_code', true);
		$product_colors = get_post_meta(get_the_ID(), 'metal_color', true);
		$color = null;
		if($product_colors) :
			$colors = explode(', ', $product_colors);
			$color = $colors[0];
		endif;
	?>
	<h3><?php if($color) { echo $metal_code.' '.$color; } else { echo $metal_code; } ?> Gold</h3>
</div>

<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
	<p class="price_top">Starting at</p>
	<p class="price"><?php echo $product->get_price_html(); ?> <span class="usd">USD</span></p>
	<p class="price_bottom">Does not include center stone</p>

	<meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

</div>
