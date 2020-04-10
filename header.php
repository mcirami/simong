<?php
/**
 * The Header for our theme.
 *
 * @package boiler
 */

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php if(is_front_page()) { echo 'id="home_html"'; } ?> class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<link href='http://fonts.googleapis.com/css?family=Libre+didot:400,700,400italic|Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="//cloud.typography.com/7475354/688506/css/fonts.css" />
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcj7KjtWqqcZB1t3nGoSwN6rHwCJ4qOMk"></script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
	<header id="global_header">
		<a href="#" class="mobile_nav_btn">
			MENU
		</a>
		<div class="mobile_search">
			<a href="#"></a>
		</div>
		<div class="container">

			<nav role="navigation" class="navigation">
				<div class="top_nav">
					<div class="sub_nav">
						<?php wp_nav_menu( array( 'theme_location' => 'left', 'container' => false, 'menu_class' => 'left_menu' ) ); // remember to assign a menu in the admin to remove the container div ?>
					</div>
					<a class="logo" href="/"><img src="<?php echo bloginfo('template_url'); ?>/images/logo.png" /></h1></a>
					<div class="sub_nav">
						<?php wp_nav_menu( array( 'theme_location' => 'right', 'container' => false, 'menu_class' => 'right_menu' ) ); // remember to assign a menu in the admin to remove the container div ?>
					</div>
				</div>
				<div class="main_nav">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'main_menu' ) ); // remember to assign a menu in the admin to remove the container div ?>
					<a class="search_icon" href=""><img src="<?php echo bloginfo('template_url'); ?>/images/search-icon.png" /></a>
				</div>
			</nav>
			<div class="header_search_box">
				<form method="get" id="search" action="<?php bloginfo('url'); ?>">
					<input type="hidden" name="submit" value="Search">
					<input class="search" type="text" value=""  name="s" id="s" onblur="if (this.value == '') {this.value = '<?php if(isset($search_text)) { echo $search_text; } ?>';}" onfocus="if (this.value == '<?php if(isset($search_text)) { echo $search_text; } ?>') {this.value = '';}">
					<input type="submit" class="search_button" value="SEARCH"/>
				</form>
			</div>
		</div>
		<nav class="mobile-nav" role="navigation">
			<a href="#" class="white simon-g-logo"></a><a href="#" class="close"></a>
			<?php wp_nav_menu( array( 'theme_location' => 'mobile_main', 'container' => false, 'menu_class' => 'mobile_main_menu' ) ); ?>
			<hr>
			<?php wp_nav_menu( array( 'theme_location' => 'mobile_sub', 'container' => false, 'menu_class' => 'mobile_sub_menu' ) ); ?>
		</nav>
	</header>
	
	<?php get_template_part('content', 'header-dropdown'); ?>