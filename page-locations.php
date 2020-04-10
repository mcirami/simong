<?php

/*
 * Template Name: Locations
 */

get_header(); ?>

	<div class="where_to_buy">
		<div class="banner-locator banner-noImage light">
			<div class="container">
				<div class="store_page_title">
					<h1>Where to Buy</h1><!-- add .center or .light to change default styles -->
					<p>Simon G. is only available through authorized retailers.</p>
				</div>
				<div class="store_page_search">
					<form action="#">
						<label for="">Search by city, state, or zip</label>
						<input class="wtb_search" type="text" maxlength="100" placeholder="enter zip code" />
						<input class="wtb_go" type="submit" value="Go" />
					</form>
				</div>
			</div>
		</div>
	
	    <section class="locations">
	    	
			<div id="store-info">
				<p class="no-data-msg">To find a jeweler near you, enter your zip code above.</p>
			</div>
			<div id="map"></div>
	    </section>
	</div>

<?php get_footer(); ?>
