<?php
/* *
 * Template Name: Category
 */
get_header(); ?>

	<?php get_template_part('content', 'hero'); ?>

	<section class="category">
		<div class="container">
			<article class="content">
				<?php 
					if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
						get_template_part( 'content', 'category-search');
					} else {
						get_template_part( 'content', 'category' );
					}
				?>
			</article>
		</div>
	</section>

<?php get_footer(); ?>