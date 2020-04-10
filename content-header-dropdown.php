<div class="header_dropdown">
	<div class="container">
		<?php if(have_rows('engagement_collections', 'options')) : ?>
			<div class="header_collections" id="engagement">
				<ul>
					<?php while(have_rows('engagement_collections', 'options')) : the_row(); ?>
						<?php $image = get_sub_field('collection_image', 'options'); ?>
						<div>
							<a href="<?php the_sub_field('collection_link', 'options'); ?>">
								<?php if($image) : ?>
									<img src="<?php echo $image['url']; ?>" />
								<?php endif; ?>
								<p><?php the_sub_field('collection_title', 'options'); ?></p>
							</a>
						</div>
					<?php endwhile; ?>
				</ul>
			</div>
		<?php endif; ?>
		
		<?php if(have_rows('bands_collections', 'options')) : ?>
			<div class="header_collections" id="bands">
				<ul>
					<?php while(have_rows('bands_collections', 'options')) : the_row(); ?>
						<?php $image = get_sub_field('collection_image', 'options'); ?>
						<div>
							<a href="<?php the_sub_field('collection_link', 'options'); ?>">
								<?php if($image) : ?>
									<img src="<?php echo $image['url']; ?>" />
								<?php endif; ?>
								<p><?php the_sub_field('collection_title', 'options'); ?></p>
							</a>
						</div>
					<?php endwhile; ?>
				</ul>
			</div>
		<?php endif; ?>
		
		<?php if(have_rows('mens_collections', 'options')) : ?>
			<div class="header_collections" id="mens">
				<ul>
					<?php while(have_rows('mens_collections', 'options')) : the_row(); ?>
						<?php $image = get_sub_field('collection_image', 'options'); ?>
						<div>
							<a href="<?php the_sub_field('collection_link', 'options'); ?>">
								<?php if($image) : ?>
									<img src="<?php echo $image['url']; ?>" />
								<?php endif; ?>
								<p><?php the_sub_field('collection_title', 'options'); ?></p>
							</a>
						</div>
					<?php endwhile; ?>
				</ul>
			</div>
		<?php endif; ?>
		
		<?php if(have_rows('fine_jewelry_collections', 'options')) : ?>
			<div class="header_collections" id="fine-jewelry">
				<ul>
					<?php while(have_rows('fine_jewelry_collections', 'options')) : the_row(); ?>
						<?php $image = get_sub_field('collection_image', 'options'); ?>
						<div>
							<a href="<?php the_sub_field('collection_link', 'options'); ?>">
								<?php if($image) : ?>
									<img src="<?php echo $image['url']; ?>" />
								<?php endif; ?>
								<p><?php the_sub_field('collection_title', 'options'); ?></p>
							</a>
						</div>
					<?php endwhile; ?>
				</ul>
			</div>
		<?php endif; ?>
		
		<?php if(have_rows('custom_jewelry_collections', 'options')) : ?>
			<div class="header_collections" id="custom-jewelry">
				<ul>
					<?php while(have_rows('custom_jewelry_collections', 'options')) : the_row(); ?>
						<?php $image = get_sub_field('collection_image', 'options'); ?>
						<div>
							<a href="<?php the_sub_field('collection_link', 'options'); ?>">
								<?php if($image) : ?>
									<img src="<?php echo $image['url']; ?>" />
								<?php endif; ?>
								<p><?php the_sub_field('collection_title', 'options'); ?></p>
							</a>
						</div>
					<?php endwhile; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</div>