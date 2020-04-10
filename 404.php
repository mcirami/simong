<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package boiler
 */

get_header(); ?>

    <div class="header_404">
        <div class="container">
            <h1>404</h1>
        </div>
    </div>


	<section class="page_not_found">
        <div class="container">
            <article id="post-0" class="post not-found">
                <p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'boiler' ); ?></p>
                <div class="search_wrapper">
                    <?php get_search_form(); ?>
                </div>
            </article>
        </div>
	</section>

<?php get_footer(); ?>