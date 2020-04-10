<?php
/**
 * Template Name: Template 7
 *
 * @package boiler
 */

get_header(); ?>

    <?php get_template_part('content', 'hero'); ?>

    <section class="flexible_content">
        <?php if( have_rows('columns') ); ?>
            <?php while(have_rows('columns') ) : the_row(); ?>
                <?php if(get_row_layout() == 'full_width_image' ): ?>
                <div class="full_img">
                    <div class="container">
                        <?php
                            $fullImg = get_sub_field('full_width_img');
                        ?>
                        <img src="<?php echo $fullImg['url']; ?>" alt="<?php echo $fullImg['alt']; ?>"/>
                    </div>
                </div>
                <?php elseif ( get_row_layout() =='one_column' ): ?>
                <div class="one_column">
                    <div class="container">
                        <h3><?php the_sub_field('one_col_title'); ?></h3>
                        <h2><?php the_sub_field('one_col_subtitle'); ?></h2>
                        <div class="one_column_content">
                            <span class="<?php if(get_sub_field('italic_text') == TRUE) { echo 'italic_text'; } ?>"><?php the_sub_field('one_col_content'); ?></span>
                        </div>
                    </div>
                </div>
                <?php elseif ( get_row_layout() == 'two_column'): ?>
                    <div class="two_column <?php if(get_sub_field('background_color') == "gray_background" ) { echo "gray"; } else { if(get_sub_field('background_color') == "black_background" ) { echo "black"; } }?>">
                        <div class="container">
                        <?php if( have_rows('two_column_layout') ) : ?>
                            <?php while (have_rows('two_column_layout') ) : the_row(); ?>
                                <div class="two_col_layout">
                                    <h3><?php the_sub_field('two_col_title'); ?></h3>
                                    <div class="acf-wygwig">
                                        <?php the_sub_field('two_col_content'); ?>
                                        <?php
                                        $twoColimg = get_sub_field('two_col_image');
                                        ?>
                                    </div>
                                    <img src="<?php echo $twoColimg['url']; ?>" alt="<?php echo $twoColimg['atl']; ?>"/>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        </div>
                    </div>
                 <?php elseif ( get_row_layout() == 'two_column_graphic'): ?>
                    <div class="two_column_graphic">
                        <div class="container">
                            <?php
                                $colGraphic = get_sub_field('two_col_graphic_image');
                            ?>
                            <div class="half_col">
                                <img src="<?php echo $colGraphic['url']; ?>" alt="<?php echo $colGraphic['alt']; ?>"/>
                            </div>
                            <div class="half_col">
                                <h4><?php the_sub_field('two_col_graphic_title'); ?></h4>
                                <em><?php the_sub_field('two_col_graphic_subtitle'); ?></em>
                                <?php the_sub_field('two_col_graphic_content'); ?>
                            </div>
                        </div>
                    </div>
                 <?php elseif ( get_row_layout() == 'three_column'): ?>
                    <div class="three_columns">
                        <div class="container">
                            <?php if(have_rows('three_column_layout') ): ?>
                                <?php while(have_rows('three_column_layout') ) : the_row(); ?>
                                    <div class="three_col" style="background-image: url('<?php the_sub_field('three_col_background_image'); ?>'); background-repeat: no-repeat; background-position: center;">
                                        <?php
                                        $thecolLink = htmlspecialchars(get_sub_field('three_col_link'));
                                        ?>
                                        <h2><?php the_sub_field('three_col_title'); ?></h2>
                                        <hr/>
                                            <p><?php the_sub_field('three_col_content'); ?></p>
                                        <hr/>
                                        <a href="<?php echo $thecolLink; ?>">LEARN MORE</a>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                 <?php elseif ( get_row_layout() == '2/3_column'): ?>
                    <div class="two_third_column">
                        <div class="container">
                            <div class="two_third_content">
                                <h3><?php the_sub_field('two_thrid_col_title'); ?></h3>
                                <?php the_sub_field('two_thrid_col_content'); ?>
                            </div>
                            <div class="sidebar">
                                <blockqoute><?php the_sub_field('two_thrid_col_side_content'); ?></blockqoute>
                            </div>
                        </div>
                    </div>
                 <?php elseif ( get_row_layout() == 'content_image'): ?>
                    <div class="content_img_column">
                        <div class="container">
                            <div class="content_col">
                                <?php the_sub_field('content_img_content'); ?>
                            </div>
                            <div class="img_col">
                                <?php
                                    $contentImg = get_sub_field('content_img_image');
                                ?>
                                <img src="<?php echo $contentImg['url']; ?>" alt="<?php echo $contentImg['alt']; ?>"/>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php //endif; ?>
    </section>


<?php get_footer(); ?>