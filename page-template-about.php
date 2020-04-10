<?php
/*
 * Template Name: About
 */

get_header(); ?>

    <section class="about">
        <div class="container">
            <div class="header" style="background: url('<?php the_field('background_image'); ?>') no-repeat">
                <h1><?php the_title(); ?></h1>
            </div>

            <?php if(have_posts() ) : while (have_posts() ) : the_post(); ?>
                <?php get_template_part('content', 'about'); ?>
            <?php endwhile; endif; ?>

            <img class="bottom_img" src="<?php the_field('bottom_image'); ?>" alt=""/>
        </div>
    </section>


<?php get_footer(); ?>