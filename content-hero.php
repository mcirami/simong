<div class="hero">
<!-- 	<div class="container"> -->
		<?php if(is_archive()) : ?>
			<?php
				$heroImage = get_field('hero_image', $termString);
				$textAlign = get_field('text_alignment', $termString);
				$textColor = get_field('text_color', $termString);
				$heroTitle = get_field('alt_title');
			?>
			<?php if($heroImage) : ?>
				<div class="container"><img src="<?php echo $heroImage['url']; ?>" />
			<?php else : ?>
				<div class="image_fallback"><div class="container">
			<?php endif; ?>
			<div class="hero_content <?php if($textAlign === 'left') { echo 'left '; } elseif ($textAlign === 'left_indent') { echo 'left_indent '; } else { echo 'center '; } if($textColor === 'white_font') { echo 'white_font'; } else { echo 'black_font'; } ?> <?php if(!$heroImage) { echo 'no_image'; } ?>">
				<?php if($heroTitle) : ?>
					<h1><?php echo $heroTitle; ?></h1>
				<?php else : ?>
					<h1><?php echo $termName . ' Collection'; ?></h1>
				<?php endif; ?>
				<?php if(get_field('subtitle')) : ?>
					<p><?php the_field('subtitle'); ?></p>
				<?php endif; ?>
			</div></div>
			<?php if(!$heroImage) : ?>
				</div></div>
			<?php endif; ?>
		<?php else : ?>
			<?php 
				$heroImage = get_field('hero_image');
				$textAlign = get_field('text_alignment');
				$textColor = get_field('text_color');
				$heroTitle = get_field('alt_title');
			?>
			<?php if($heroImage) : ?>
				<div class="container"><img src="<?php echo $heroImage['url']; ?>" />
			<?php else : ?>
				<div class="image_fallback"><div class="container">
			<?php endif; ?>
			<div class="hero_content <?php if($textAlign === 'left') { echo 'left '; } elseif ($textAlign === 'left_indent') { echo 'left_indent '; } else { echo 'center '; } if($textColor === 'white_font') { echo 'white_font'; } else { echo 'black_font'; } ?> <?php if(!$heroImage) { echo 'no_image'; } ?>">
				<?php if($heroTitle) : ?>
					<h1><?php echo $heroTitle; ?></h1>
				<?php else : ?>
					<h1><?php the_title(); ?></h1>
				<?php endif; ?>
				<?php if(get_field('subtitle')) : ?>
					<p><?php the_field('subtitle'); ?></p>
				<?php endif; ?>
			</div></div>
			<?php if(!$heroImage) : ?>
				</div></div>
			<?php endif; ?>
		<?php endif; ?>
<!-- 	</div> -->
</div>