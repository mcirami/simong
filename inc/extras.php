<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package boiler
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function boiler_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'boiler_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function boiler_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'boiler_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function boiler_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'boiler_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function boiler_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'boiler' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'boiler_wp_title', 10, 2 );

/**
 * Custom excerpt link 
 * use print_excerpt(int)
 * uses content instead of excerpt field so be be preparred to filter html out 
 */

function print_excerpt($length) {
	global $post;
	$text = $post->post_excerpt;
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
	}
	$text = strip_shortcodes($text);
	$text = strip_tags($text,'<p><a>');
	//$text = strip_tags($text); // use ' $text = strip_tags($text,'<p><a>'); ' if you want to keep some tags

	$text = substr($text,0,$length);
	$excerpt = reverse_strrchr($text, '.', 1);
	if( $excerpt ) {
		echo apply_filters('the_excerpt',$excerpt);
	} else {
		echo apply_filters('the_excerpt',$text);
	}
}

function reverse_strrchr($haystack, $needle, $trail) {
    return strrpos($haystack, $needle) ? substr($haystack, 0, strrpos($haystack, $needle) + $trail) : false;
}

/**
 * Modify the main Query when accessing collections mixed with product category taxonomy
 */
function set_filter_for_collection_by_category( $query ) {
	//gets the global query var object
	global $wp_query;
	
	if ( isset( $wp_query->query_vars['product_category'] ) && $query->is_main_query() ) {
		$query->set( 'tax_query', array(
									array(
											'taxonomy' => 'product_cat',
											'field'    => 'slug',
											'terms'    => $wp_query->query_vars['product_category'],
									),
								) );
				
	}
}
add_action('pre_get_posts','set_filter_for_collection_by_category');

/**
 * Add new Custom Query Variables
 */
function add_custom_query_vars( $vars ) {
	$new_vars = array ( 'product_category' ); // add new variables to the array
	$vars = array_merge($vars, $new_vars);
	return $vars;
}
add_filter('query_vars', 'add_custom_query_vars');

/**
 * Add new Custom Rewrite Rule
*/
function add_custom_rewrite_rules( $rules ) {
	$new_rules = array(
			'collection/([^/]+)/([^/]+)/?' => 'index.php?collection=$matches[1]&product_category=$matches[2]',
			// add more rules here..
	);
	$rules = $new_rules + $rules;
	return $rules;
}
add_filter('rewrite_rules_array', 'add_custom_rewrite_rules');




/**
* Search Ajax: Ajax function to load more search results
*/
/*function load_related_products() {
	
	global $yith_wcmg;
	$yith_wcmg->obj = new YITH_WCMG_Frontend( $yith_wcmg->version );
	
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
	remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
	add_action( 'woocommerce_before_single_product_summary', array( &$yith_wcmg->obj, 'show_product_images' ), 20 );
	add_action( 'woocommerce_product_thumbnails', array( &$yith_wcmg->obj, 'show_product_thumbnails' ), 20 );
	
	ob_start();
	
	$product_id = (isset($_GET['product_id'])) ? $_GET['product_id'] : null;
	
	if($product_id) :
		$args = array('p' => $product_id, 'post_type' => 'product');
				
		$query = new WP_Query($args);
				
		while($query->have_posts()) : $query->the_post();
			wc_get_template_part( 'content', 'single-product' );
		endwhile; wp_reset_postdata();
	endif;
	
	echo ob_get_clean();
	die();
}
add_action("wp_ajax_load_related_products", "load_related_products");
add_action("wp_ajax_nopriv_load_related_products", "load_related_products");*/