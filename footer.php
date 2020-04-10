<?php
/**
 * The template for displaying the footer.
 *
 * @package boiler
 */
?>

	<?php get_template_part('content', 'recently-viewed'); ?>

    <?php get_template_part('content', 'footer-search'); ?>

	<footer id="global_footer" class="site_footer">
		<div class="footer_menu">
			<div class="container">
				<div class="footer_col jewelry">
					<h5>Jewelry</h5>
					<?php wp_nav_menu( array( 'theme_location' => 'footer-col-left', 'container' => false, 'menu_class' => 'jewel_nav' ) ); // remember to assign a menu in the admin to remove the container div ?>
				</div>
				<div class="footer_col about">
					<h5>About Simon G.</h5>
					<?php wp_nav_menu( array('theme_location' => 'footer-col-middle', 'container' => false, ) ); ?>
				</div>
				<div class="footer_col service">
					<h5>Customer Service</h5>
					<?php wp_nav_menu( array( 'theme_location' => 'footer-col-right', 'container' => false, ) ); ?>
					
					
					
					
					<div class="social">
						<?php if(have_rows('social_media_links', 'options') ) : ?>
							<ul>
							<?php while(have_rows('social_media_links', 'options') ) : the_row(); ?>
								<li><a class="social_link" href="<?php the_sub_field('link'); ?>" target="_blank"><img src="<?php the_sub_field('icon'); ?>" alt=""/></a></li>
							<?php endwhile; ?>
							</ul>
						<?php endif; ?>
					</div>
					<?php gravity_form( 1, false, false, false, '', false ); ?>
				</div>
				<div class="bottom_footer">
					<div class="container">
						<p class="copy">&copy; 1990 - <?php echo date('Y'); ?> <?php bloginfo('site_title'); ?> JEWELRY</p>
						<?php if(have_rows('footer_links', 'options') ) : ?>
							<ul class="bottom_links">
							<?php while(have_rows('footer_links', 'options') ) : the_row(); ?>
								<li><a href="<?php the_sub_field('link_url'); ?>"><?php the_sub_field('link_title'); ?></a></li>
							<?php endwhile; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div><!-- end of footer_menu -->
	</footer>
<?php wp_footer(); ?>

</body>
</html>