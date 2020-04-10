<?php 
/**
 * Template Name: Home
 */
 	
 get_header(); ?>

<section class="homepage">
	<div class="swiper-container">
		<div class="swiper-wrapper">
			<?php if(have_rows('homepage_slide')) : ?>
				<?php while(have_rows('homepage_slide')) : the_row(); ?>
					<?php $image = get_sub_field('slide_image'); ?>
					<div class="swiper-slide" style="background-image: url(<?php echo $image['url']; ?>);">
						<?php
							$color = get_sub_field('text_color');
							$position = get_sub_field('text_position');	 
						?>
						<?php if($color && $position) : ?>
							<div class="details <?php echo $color . ' ' . $position; ?>">
								<div class="details_flex">
									<?php the_sub_field('slide_content'); ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
		<div class="swiper-pagination"></div>
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>
</section>

<?php get_footer(); ?>