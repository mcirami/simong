<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package boiler
 */

get_header(); ?>

	<div class="hero search_hero">
		<div class="container">
			<div class="image_fallback">
				<div class="hero_content left white_font<?php //if($textAlign === 'left') { echo 'left '; } elseif($textAlign === 'left_indent') { echo 'left_indent '; } else { echo 'center '; } if($textColor === 'white_font') { echo 'white_font'; } else { echo 'black_font'; } ?>">
					<h1>Search Results<?php //printf( __( 'Search Results for: %s', 'boiler' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</div>
			</div>
		</div>
	</div>

	<section class="search_results">
	
		<div class="container">

			<?php if ( have_posts() ) : ?>
	
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
	
					<?php get_template_part( 'content', 'search' ); ?>
	
				<?php endwhile; ?>
	
				<?php //boiler_content_nav( 'nav-below' ); ?>
	
			<?php else : ?>
	
				<?php get_template_part( 'no-results', 'search' ); ?>
	
			<?php endif; ?>
		
		</div>
	
		
	</section>

<?php get_footer(); ?>