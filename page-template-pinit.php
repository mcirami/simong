<?php
/*
 * Template Name: Contest
 */

get_header(); ?>
<?php 
    $hero = get_field('hero_image');
?>

    <section class="about contest">
        <div class="container">
            <div class="header" style="background: url('<?php echo $hero['url']; ?>') no-repeat"></div>
            <h1 class="title"><?php the_title(); ?></h1>
            <div class="row">
                <div class="contest-copy">
                    <h2 class="sub-title"><?php the_field('alt_title'); ?></h2>
                    <h3 class="sub-text"><?php the_field('subtitle'); ?></h3>
                    <?php the_post_thumbnail(); ?> 
                    <?php the_content(); ?>
                </div>
                <div class="contest-form">
                    <?php 
                        $id = get_field('contest_form_id');
                        gravity_form($id); 
                    ?>
                </div>
            </div>
            <div class="contest-footer row">
                <a href="/<?php the_field('rules_page'); ?>"><i class="fa fa-book"></i> Contest Rules</a>
                <a target="_blank" href="https://www.pinterest.com/simongjewelry/"><i class="fa fa-pinterest"></i> Simon G. Pinterest</a>
            </div>
        </div>
    </section>


<?php get_footer(); ?>