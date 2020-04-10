<?php
/**
 * boiler functions and definitions
 *
 * @package boiler
 */

if ( ! function_exists( 'boiler_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function boiler_setup() {

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'boiler' ),
		'left' => __('Left Menu', 'boiler'),
		'right' => __('Right Menu', 'boiler'),
		'footer-col-left' => __('Footer Col Left', 'boiler'),
		'footer-col-middle' => __('Footer Col Middle', 'boiler'),
		'footer-col-right' => __('Footer Col Right', 'boiler'),
		'mobile_main' => __('Mobile Main', 'boiler'),
		'mobile_sub' => __('Mobile Sub', 'boiler')
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif; // boiler_setup
add_action( 'after_setup_theme', 'boiler_setup' );

// add parent class to menu items 
add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );
function add_menu_parent_class( $items ) {

	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	
	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'parent-item'; 
		}
	}
	
	return $items;
}
	
/* remove some of the header bloat */

// EditURI link
remove_action( 'wp_head', 'rsd_link' );
// windows live writer
remove_action( 'wp_head', 'wlwmanifest_link' );
// index link
remove_action( 'wp_head', 'index_rel_link' );
// previous link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
// start link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
// links for adjacent posts
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
// WP version
remove_action( 'wp_head', 'wp_generator' );

// remove pesky injected css for recent comments widget
add_filter( 'wp_head', 'boiler_remove_wp_widget_recent_comments_style', 1 );
// clean up comment styles in the head
add_action('wp_head', 'boiler_remove_recent_comments_style', 1);
// clean up gallery output in wp
add_filter('gallery_style', 'boiler_gallery_style');

// Thumbnail image sizes
add_image_size( 'thumb-660-660', 660, 660, true );
add_image_size( 'thumb-400-400', 400, 400, true );

// remove injected CSS for recent comments widget
function boiler_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove injected CSS from recent comments widget
function boiler_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// remove injected CSS from gallery
function boiler_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

/**
 * Register widgetized area and update sidebar with default widgets
 */
function boiler_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Search', 'boiler' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'boiler_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function boiler_scripts_styles() {
	// style.css just initializes the theme. This is compiled from /sass
	wp_enqueue_style( 'main-style', get_template_directory_uri() . '/css/main.css');

	wp_enqueue_style( 'noUiSlider-css', get_template_directory_uri() . '/css/vendor/jquery.nouislider.min.css' );
	
	wp_enqueue_script( 'jquery' , array(), '', true );
	
	if ( (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9') !== false)  ) : 
	
	wp_enqueue_script('swiper2', get_template_directory_uri() . '/js/vendor/idangerous.swiper.js', array('jquery'), '', true);
	wp_enqueue_style('swiper2-css', get_template_directory_uri() . '/js/vendor/idangerous.swiper.css');
	
	else :
	
	wp_enqueue_script( 'swiper-js', get_template_directory_uri() . '/js/vendor/swiper.jquery.min.js', array('jquery'), '', true );
	wp_enqueue_style( 'swiper-css', get_template_directory_uri() . '/js/vendor/swiper.css' );
	
	endif;

	wp_enqueue_script( 'noUiSlider-js', get_template_directory_uri() . '/js/vendor/jquery.nouislider.all.min.js', array('jquery'), '', true );

    wp_enqueue_script( 'ddslick', get_template_directory_uri(). '/js/vendor/jquery.ddslick.min.js', array('jquery'), '', true );
    
    wp_enqueue_script( 'simong-where-to-buy', get_template_directory_uri(). '/js/vendor/scripts.js', array('jquery'), '', false );
    
    wp_enqueue_script( 'picturefill', get_template_directory_uri(). '/js/vendor/picturefill/dist/picturefill.js', array('jquery'), '', false );

	//wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/vendor/modernizr-2.6.2.min.js', '2.6.2', true );

	//wp_enqueue_script( 'boiler-plugins', get_template_directory_uri() . '/js/plugins.js', array(), '20120206', true );

	//wp_enqueue_script( 'boiler-main', get_template_directory_uri() . '/js/main.js', array(), '20120205', true );
	
	// Return concatenated version of JS. If you add a new JS file add it to the concatenation queue in the gruntfile. 
	// current files: js/vendor.mordernizr-2.6.2.min.js, js/plugins.js, js/main.js
	wp_enqueue_script( 'boiler-concat', get_template_directory_uri() . '/js/built.min.js', array(), '', true );
	
	wp_localize_script( 'boiler-concat', 'ajaxObject', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

}
add_action( 'wp_enqueue_scripts', 'boiler_scripts_styles' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Post Types
 */
require get_template_directory() . '/inc/post-types.php';

// Auto wrap embeds with video container to make video responsive
function wrap_embed_with_div($html, $url, $attr) {
     return '<div class="video_container">' . $html . '</div>';
}

add_filter('embed_oembed_html', 'wrap_embed_with_div', 10, 3);

// Options Page

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page('Social Media Links');
	acf_add_options_page('Footer Links');
	acf_add_options_page('Header Collections');
}

/**
 * Custom Post Types
 */
function check_wish_list_item( $item_id = '' ) {
	if(!isset($_COOKIE['wishlist'])) {
		return;
	}
	$wish_list_ids = json_decode($_COOKIE['wishlist'], true);
		
	if ( ( $wish_list_ids && in_array( $item_id, $wish_list_ids ) ) ) {
		echo ' selected';
	} elseif ( empty( $item_id ) && count( $wish_list_ids) > 0 ) {
		return 'has-wishlist-items';
	} else return;
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_filter('gform_field_value_productTitle', 
	create_function("", '$title = get_the_title($_GET["productID"]); $value = $title; return $value;'));
	
add_filter('gform_field_value_productCollection', 
	create_function("", '$collections = get_the_terms($_GET["productID"], "collection"); $collection = $collections[0]->name; $value = $collection; return $value;'));
	
add_filter('gform_field_value_productImage', 
	create_function("", '$image = wp_get_attachment_url(get_post_thumbnail_id($_GET["productID"])); $imgSrc = $_SERVER["HTTP_HOST"] . $image; $value = $imgSrc; return $value;'));
	
add_filter('gform_field_value_productLink', 
	create_function("", '$link = $_SERVER["HTTP_HOST"] . get_the_permalink($_GET["productID"]); $value = $link; return $value;'));
	
//Remove default links around images added in wysiwygs
update_option('image_default_link_type', 'none');

add_filter('gform_field_value_wishlistTitle0', 'populate_wishlistTitle0');
function populate_wishlistTitle0() {
	if ($_SESSION['wishlistTitle0']) {
		return $_SESSION['wishlistTitle0'];
	} else {
		return 'null';
	}
}

add_filter('gform_field_value_wishlistCollection0', 'populate_wishlistCollection0');
function populate_wishlistCollection0() {
	if ($_SESSION['wishlistCollection0']) {
		return $_SESSION['wishlistCollection0'];
	}
}

add_filter('gform_field_value_wishlistImage0', 'populate_wishlistImage0');
function populate_wishlistImage0 (){
	if ($_SESSION['wishlistImage0']) {
		if (strpos($_SESSION['wishlistImage0'], 'http://')) {
			return $_SESSION['wishlistImage0'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistImage0'];
		}
	} else {
		return get_bloginfo('template_url').'/images/placeholder.jpg';
	}
}

add_filter('gform_field_value_wishlistLink0', 'populate_wishlistLink0');
function populate_wishlistLink0 (){
	if ($_SESSION['wishlistLink0']) {
		if (strpos($_SESSION['wishlistLink0'], 'http://')) {
			return $_SESSION['wishlistLink0'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistLink0'];
		}
	}
}

add_filter('gform_field_value_wishlistTitle1', 'populate_wishlistTitle1');
function populate_wishlistTitle1() {
	if ($_SESSION['wishlistTitle1']) {
		return $_SESSION['wishlistTitle1'];
	} else {
		return 'null';
	}
}

add_filter('gform_field_value_wishlistCollection1', 'populate_wishlistCollection1');
function populate_wishlistCollection1() {
	if ($_SESSION['wishlistCollection1']) {
		return $_SESSION['wishlistCollection1'];
	}
}

add_filter('gform_field_value_wishlistImage1', 'populate_wishlistImage1');
function populate_wishlistImage1() {
	if ($_SESSION['wishlistImage1']) {
		if (strpos($_SESSION['wishlistImage1'], 'http://')) {
			return $_SESSION['wishlistImage1'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistImage1'];
		}
	} else {
		return get_bloginfo('template_url').'/images/placeholder.jpg';
	}
}

add_filter('gform_field_value_wishlistLink1', 'populate_wishlistLink1');
function populate_wishlistLink1() {
	if ($_SESSION['wishlistLink1']) {
		if (strpos($_SESSION['wishlistLink1'], 'http://')) {
			return $_SESSION['wishlistLink1'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistLink1'];
		}
	}
}

add_filter('gform_field_value_wishlistTitle2', 'populate_wishlistTitle2');
function populate_wishlistTitle2() {
	if ($_SESSION['wishlistTitle2']) {
		return $_SESSION['wishlistTitle2'];
	} else {
		return 'null';
	}
}

add_filter('gform_field_value_wishlistCollection2', 'populate_wishlistCollection2');
function populate_wishlistCollection2() {
	if ($_SESSION['wishlistCollection2']) {
		return $_SESSION['wishlistCollection2'];
	}
}

add_filter('gform_field_value_wishlistImage2', 'populate_wishlistImage2');
function populate_wishlistImage2() {
	if ($_SESSION['wishlistImage2']) {
		if (strpos($_SESSION['wishlistImage2'], 'http://')) {
			return $_SESSION['wishlistImage2'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistImage2'];
		}
	} else {
		return get_bloginfo('template_url').'/images/placeholder.jpg';
	}
}

add_filter('gform_field_value_wishlistLink2', 'populate_wishlistLink2');
function populate_wishlistLink2() {
	if ($_SESSION['wishlistLink2']) {
		if (strpos($_SESSION['wishlistLink2'], 'http://')) {
			return $_SESSION['wishlistLink2'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistLink2'];
		}
	}
}

add_filter('gform_field_value_wishlistTitle3', 'populate_wishlistTitle3');
function populate_wishlistTitle3() {
	if ($_SESSION['wishlistTitle3']) {
		return $_SESSION['wishlistTitle3'];
	} else {
		return 'null';
	}
}

add_filter('gform_field_value_wishlistCollection3', 'populate_wishlistCollection3');
function populate_wishlistCollection3() {
	if ($_SESSION['wishlistCollection3']) {
		return $_SESSION['wishlistCollection3'];
	}
}

add_filter('gform_field_value_wishlistImage3', 'populate_wishlistImage3');
function populate_wishlistImage3() {
	if ($_SESSION['wishlistImage3']) {
		if (strpos($_SESSION['wishlistImage3'], 'http://')) {
			return $_SESSION['wishlistImage3'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistImage3'];
		}
	} else {
		return get_bloginfo('template_url').'/images/placeholder.jpg';
	}
}

add_filter('gform_field_value_wishlistLink3', 'populate_wishlistLink3');
function populate_wishlistLink3() {
	if ($_SESSION['wishlistLink3']) {
		if (strpos($_SESSION['wishlistLink3'], 'http://')) {
			return $_SESSION['wishlistLink3'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistLink3'];
		}
	}
}

add_filter('gform_field_value_wishlistTitle4', 'populate_wishlistTitle4');
function populate_wishlistTitle4() {
	if ($_SESSION['wishlistTitle4']) {
		return $_SESSION['wishlistTitle4'];
	} else {
		return 'null';
	}
}

add_filter('gform_field_value_wishlistCollection4', 'populate_wishlistCollection4');
function populate_wishlistCollection4() {
	if ($_SESSION['wishlistCollection4']) {
		return $_SESSION['wishlistCollection4'];
	}
}

add_filter('gform_field_value_wishlistImage4', 'populate_wishlistImage4');
function populate_wishlistImage4() {
	if ($_SESSION['wishlistImage4']) {
		if (strpos($_SESSION['wishlistImage4'], 'http://')) {
			return $_SESSION['wishlistImage4'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistImage4'];
		}
	} else {
		return get_bloginfo('template_url').'/images/placeholder.jpg';
	}
}

add_filter('gform_field_value_wishlistLink4', 'populate_wishlistLink4');
function populate_wishlistLink4() {
	if ($_SESSION['wishlistLink4']) {
		if (strpos($_SESSION['wishlistLink4'], 'http://')) {
			return $_SESSION['wishlistLink4'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistLink4'];
		}
	}
}

add_filter('gform_field_value_wishlistTitle5', 'populate_wishlistTitle5');
function populate_wishlistTitle5() {
	if ($_SESSION['wishlistTitle5']) {
		return $_SESSION['wishlistTitle5'];
	} else {
		return 'null';
	}
}

add_filter('gform_field_value_wishlistCollection5', 'populate_wishlistCollection5');
function populate_wishlistCollection5() {
	if ($_SESSION['wishlistCollection5']) {
		return $_SESSION['wishlistCollection5'];
	}
}

add_filter('gform_field_value_wishlistImage5', 'populate_wishlistImage5');
function populate_wishlistImage5() {
	if ($_SESSION['wishlistImage5']) {
		if (strpos($_SESSION['wishlistImage5'], 'http://')) {
			return $_SESSION['wishlistImage5'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistImage5'];
		}
	} else {
		return get_bloginfo('template_url').'/images/placeholder.jpg';
	}
}

add_filter('gform_field_value_wishlistLink5', 'populate_wishlistLink5');
function populate_wishlistLink5() {
	if ($_SESSION['wishlistLink5']) {
		if (strpos($_SESSION['wishlistLink5'], 'http://')) {
			return $_SESSION['wishlistLink5'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistLink5'];
		}
	}
}

add_filter('gform_field_value_wishlistTitle6', 'populate_wishlistTitle6');
function populate_wishlistTitle6() {
	if ($_SESSION['wishlistTitle6']) {
		return $_SESSION['wishlistTitle6'];
	} else {
		return 'null';
	}
}

add_filter('gform_field_value_wishlistCollection6', 'populate_wishlistCollection6');
function populate_wishlistCollection6() {
	if ($_SESSION['wishlistCollection6']) {
		return $_SESSION['wishlistCollection6'];
	}
}

add_filter('gform_field_value_wishlistImage6', 'populate_wishlistImage6');
function populate_wishlistImage6() {
	if ($_SESSION['wishlistImage6']) {
		if (strpos($_SESSION['wishlistImage6'], 'http://')) {
			return $_SESSION['wishlistImage6'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistImage6'];
		}
	} else {
		return get_bloginfo('template_url').'/images/placeholder.jpg';
	}
}

add_filter('gform_field_value_wishlistLink6', 'populate_wishlistLink6');
function populate_wishlistLink6() {
	if ($_SESSION['wishlistLink6']) {
		if (strpos($_SESSION['wishlistLink6'], 'http://')) {
			return $_SESSION['wishlistLink6'];
		} else {
			return get_bloginfo('url').$_SESSION['wishlistLink6'];
		}
	}
}

// Custom Login Screen
function simong_loginlogo() {
    echo '<style type="text/css">
        .login h1 a {
        background-image: url(' . get_template_directory_uri() . '/images/logo.png) !important;
        background-size: 100% !important;
        width: 167px;
        height: 50px;
        }
        </style>';
}
add_action('login_head', 'simong_loginlogo');

// Login Image URL
function simong_loginURL () {
    return '/';
}
add_filter('login_headerurl', 'simong_loginURL');

// Check if there any item on wish list and add css class to menu item
function set_wish_list_menu_item_class( $classes, $item ) {

	if ( $item->title == 'Wish List' ) {
		$classes[] = check_wish_list_item();
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'set_wish_list_menu_item_class', 10, 2 );

//Gravity Forms Validation Message

add_filter('gform_validation_message_4', function($message, $form) {
	return '<div class="validation_error">Please make sure all required fields are filled in, and also make sure to choose a retailer from above.</div>';
}, 10, 4);

