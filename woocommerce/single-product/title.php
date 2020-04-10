<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="product_title">
	<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
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
	<h2><?php echo $collectionName; ?></h2>
</div>
