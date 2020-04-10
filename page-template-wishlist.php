<?php
/* *
 * Template Name: Wish List
 */
get_header(); ?>

    <?php
        $item_ids = json_decode($_COOKIE['wishlist'], true);
    ?>


    <?php get_template_part('content', 'hero'); ?>

	<section class="wish_list">
        <div class="container">
	        <div class="email_print">
                <button class="print"><?php if(function_exists('pf_show_link')){echo pf_show_link();} ?></button>
                <?php $itemCount = count($item_ids); ?>
                <button class="email"><a href="/mail-wish-list<?php //echo 'mail-wish-list?'; $i=0; foreach($item_ids as $item) { echo 'product'.$i.'='.$item; $i++; if($i < $itemCount) { echo '&'; } } ?>">Email All</a></button>
            </div>
            <div class="wish_list_counter">
                <p>Items in wish list: <span><span class="wish-list-count"><?php echo $itemCount; ?></span> items</span></p>
            </div>
                <article class="wish-list">
                    <?php

                        if ( $item_ids ) {
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => 10,
                                'post__in' => $item_ids,
                                'orderby' => 'post__in',
                            );

                            $post_query = new WP_Query($args);

                            if($post_query->have_posts()) :
                                while ( $post_query->have_posts() ) : $post_query->the_post(); ?>

                                    <div class="wish-list-product product-id-<?php the_ID(); ?>">
                                        <div class="wist_list_border"></div>
                                        <p><?php the_title(); ?></p>
                                        <?php
                                            $collectName = wp_get_post_terms(get_the_ID(), 'collection', array("fields" => "names"));
                                        ?>
                                        <?php if ( ! empty( $collectName ) && ! is_wp_error( $collectName ) ) : ?>
                                       		<span class="collection"><?php echo $collectName[0]; ?> Collection</span>
                                        <?php endif; ?>
                                        <div class="recent_product_image">
                                            <?php if(has_post_thumbnail()) : ?>
                                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full' ); ?></a>
                                            <?php else : ?>
                                                <a href="<?php the_permalink(); ?>"><img src="<?php echo bloginfo('template_url'); ?>/images/placeholder.jpg" alt="placeholder image" /></a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="info_container">
                                            <a class="hint" href="/send-a-hint?productID=<?php the_ID(); ?>" title="Send a hint">send a hint</a>|<a class="remove" data-product-id="<?php the_ID(); ?>" href="#" title="Remove">remove</a>
                                            <a class="button" href="/contact-a-retailer?productID=<?php the_ID(); ?>" title="Contact a Retail Partner">Contact a Retail Partner</a>
                                        </div>
                                    </div><!-- products -->

                                <?php endwhile; // end of the loop. ?>
                            <?php endif; wp_reset_postdata();
                        } else {
                            echo "No items to display";
                        }
                    ?>
                </article>
            </div>
	</section>

<?php get_footer(); ?>