<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );

?>
<div class="product_meta">
	
	<a href="/contact-a-retailer?productID=<?php echo the_ID(); ?>" class="contact_retailer">Contact a Retail Partner</a>
	
	<div id="cis12P" style="z-index: 100;position: absolute;"></div>
	<div id="scs12P" style="display: inline;">
		<a href="#" onclick="pss12Pow(); return false;">
			<span id="pss12Pl">
				<h5>Have a question?<br><span>Online Concierge Desk</span></h5>
			</span>
		</a>
	</div>
	<div id="sds12P" style="display:none">
		<script type="text/javascript" src="http://image.providesupport.com/js/0e7p9xx6pogu10up80o6nv1y67/safe-textlink.js?ps_h=s12P&amp;ps_t=1426539714968&amp;online-link-html=%3Ch5%3EHave%20a%20question%3F%3Cbr%3E%0A%3Cspan%3EOnline%20Concierge%20Desk%3C/span%3E%3C/h5%3E&amp;offline-link-html=%3Ch5%3EHave%20a%20question%3F%20Concierge%20Desk%20offline%3Cbr%3E%0A%3Cspan%3ELeave%20a%20message%3C/span%3E%3C/h5%3E"></script>
	</div>
	
	<script type="text/javascript">
	var ses12P=document.createElement("script");ses12P.type="text/javascript";var ses12Ps=(location.protocol.indexOf("https")==0?"https":"http")+"://image.providesupport.com/js/0e7p9xx6pogu10up80o6nv1y67/safe-textlink.js?ps_h=s12P&ps_t="+new Date().getTime()+"&online-link-html=%3Ch5%3EHave%20a%20question%3F%3Cbr%3E%0A%3Cspan%3EOnline%20Concierge%20Desk%3C/span%3E%3C/h5%3E&offline-link-html=%3Ch5%3EHave%20a%20question%3F%20Concierge%20Desk%20offline%3Cbr%3E%0A%3Cspan%3ELeave%20a%20message%3C/span%3E%3C/h5%3E";setTimeout("ses12P.src=ses12Ps;document.getElementById('sds12P').appendChild(ses12P)",1);
	</script>
	<noscript>
		<div style="display:inline"><a href="http://www.providesupport.com?messenger=0e7p9xx6pogu10up80o6nv1y67" >Online Customer Service</a></div>
	</noscript>
	
	<ul class="meta_links">
		<a href="#" class="meta_add_to_wish_list js_add_to_wish_list <?php check_wish_list_item( get_the_ID() ); ?>" data-product-id="<?php the_ID(); ?>"><span>Add to Wish List</span></a>
		<a href="/send-a-hint?productID=<?php echo the_ID(); ?>" class="send_hint">Send a hint</a>
        <?php 
	        if(function_exists('pf_show_link')) {
	        	echo pf_show_link();
	        } 
	    ?>
	</ul>
	
	<div class="also_available">
		<p class="fine-text">
			Also available in <span class="platinum">Platinum</span>, <span class="rose-gold">Rose Gold</span>, or <span class="gold">18K Gold</span>. Can accommodate a variety of center diamond sizes, starting at 0.50 carats. Can accommodate different diamond cuts, available by special order.
		</p>
	</div>
	
	<a class="learn_about_customizing" href="/custom-jewelry">Learn about customizing this piece</a>

<!--
	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<span class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></span>.</span>

	<?php endif; ?>

	<?php echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $cat_count, 'woocommerce' ) . ' ', '.</span>' ); ?>

	<?php echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' ', '.</span>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>
-->

</div>
