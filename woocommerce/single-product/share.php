<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="share">
	<!-- ShareThis Scripts -->
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher: "714cbf23-2350-4942-801a-afd86a8c42c3", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

	<!-- Icons -->
	<span class='st_pinterest_large' displayText='Pinterest'></span>
	<span class='st_facebook_large' displayText='Facebook'></span>
	<span class='st_twitter_large' displayText='Tweet'></span>
	<span class='st_email_large' displayText='Email'></span>
</div>

<?php //do_action( 'woocommerce_share' ); // Sharing plugins can hook into here ?>
