<?php 
	$mainCat = get_field('main_category'); 
	$terms = null;
	if($mainCat) :
		$terms = get_term_children($mainCat->term_id, 'product_cat');
		?>
		<div class="cat_filter">
			<h2><a href="#">FILTER BY: <span>Product, Style, Price</span></a></h2>
			<a class="arrow down" href="#"></a>
			<div class="filters">
				<form method="post" id="searchform" class="searchform" action="" role="search">
					<fieldset class="column">
						<h2>Product</h2>
						<div class="column_row">
							<?php 
								if($terms) :
									foreach($terms as $term) :
										$term = get_term_by( 'id', $term, 'product_cat' );
							?>
								<input id="<?php echo $term->slug; ?>" name="<?php echo $term->slug; ?>" value="<?php echo $term->slug; ?>" type="checkbox" <?php echo (isset($_POST[$term->slug]) && $_POST[$term->slug] == $term->slug) ? 'checked' :  '' ; ?>>
								<label <?php echo (isset($_POST[$term->slug]) && $_POST[$term->slug] == $term->slug) ? 'class="checked"' :  '' ; ?>><?php echo $term->name; ?></label>
							<?php 
									endforeach;
								endif;
							?>
						</div>
					</fieldset>
					<?php if($mainCat && ($mainCat->slug == 'engagement' || $mainCat->slug == 'bands')) : ?>
						<fieldset class="column">
							<h2>Style</h2>
							<div class="column_row">
								<?php 
									$taxonomies = array(
										'style'	
									);
									
									$args = array('hide_empty' => 0);
									
									$terms = get_terms($taxonomies, $args);
									
									foreach($terms as $term) :
								?>
									<input id="<?php echo $term->slug; ?>" name="<?php echo $term->slug; ?>" value="<?php echo $term->slug; ?>" type="checkbox" <?php echo (isset($_POST[$term->slug]) && $_POST[$term->slug] == $term->slug) ? 'checked' :  '' ; ?>>
									<label <?php echo (isset($_POST[$term->slug]) && $_POST[$term->slug] == $term->slug) ? 'class="checked"' :  '' ; ?>><?php echo $term->name; ?></label>
								<?php 
									endforeach;
								?>
							</div>
						</fieldset>		
					<?php endif; ?>
					<?php if($mainCat && $mainCat->slug == 'engagement') : ?>
						<fieldset class="column">
							<h2>Setting Style</h2>
							<div class="column_row">
								<?php 
									$taxonomies = array(
										'setting_style'	
									);
									
									$args = array('hide_empty' => 0);
									
									$terms = get_terms($taxonomies, $args);
									
									foreach($terms as $term) :
								?>
									<input id="<?php echo $term->slug; ?>" name="<?php echo $term->slug; ?>" value="<?php echo $term->slug; ?>" type="checkbox" <?php echo (isset($_POST[$term->slug]) && $_POST[$term->slug] == $term->slug) ? 'checked' :  '' ; ?>>
									<label <?php echo (isset($_POST[$term->slug]) && $_POST[$term->slug] == $term->slug) ? 'class="checked"' :  '' ; ?>><?php echo $term->name; ?></label>
									<?php if(get_field('setting_style_image', $term)) : ?>
										<?php $setting_style_image = get_field('setting_style_image', $term); ?>
										<img class="setting_style_image" src="<?php echo $setting_style_image['url']; ?>" alt="<?php echo $setting_style_image['alt']; ?>">
									<?php endif; ?>
								<?php 
									endforeach;
							?>
							</div>
						</fieldset>
					<?php endif; ?>
					<fieldset class="column last_column">
						<?php if($mainCat && $mainCat->slug == 'engagement') : ?>
							<div class="column_row">
								<div class="row_wrap">
								<h2>Center Stone</h2>
									<div id="select_wrapper">
										<div class="select_wrap">
											<?php // "Selected option" logic below can definetely be improved, Applying quick fix in order to make it work for client presentation. ?>
											<select name="center_stone" id="center_stone">
												<option value>Any size</option>
												<option value="0-0.5" <?php echo $_POST['center_stone'] == '0-0.5' ? 'selected="selected"' : null; ?>>0-0.5 carat</option>
												<option value="0.5-1" <?php echo $_POST['center_stone'] == '0.5-1' ? 'selected="selected"' : null; ?>>0.5-1 carat</option>
												<option value="1-1.5" <?php echo $_POST['center_stone'] == '1-1.5' ? 'selected="selected"' : null; ?>>1-1.5 carats</option>
												<option value="1.5-2" <?php echo $_POST['center_stone'] == '1.5-2' ? 'selected="selected"' : null; ?>>1.5-2 carats</option>
												<option value="2-2.5" <?php echo $_POST['center_stone'] == '2-2.5' ? 'selected="selected"' : null; ?>>2-2.5 carats</option>
												<option value="2.5-3" <?php echo $_POST['center_stone'] == '2.5-3' ? 'selected="selected"' : null; ?>>2.5-3 carats</option>
												<option value="3-3.5" <?php echo $_POST['center_stone'] == '3-3.5' ? 'selected="selected"' : null; ?>>3-3.5 carats</option>
												<option value="3.5-4" <?php echo $_POST['center_stone'] == '3.5-4' ? 'selected="selected"' : null; ?>>3.5-4 carats</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if($mainCat && $mainCat->slug != 'fine-jewelry') : ?>
						<div class="column_row row_wrap">
							<div class="row_wrap">
								<h2>Price Range</h2>
								<div class="text_boxes">
									<input name="min_price" id="min_price" type="text" placeholder="No minimum" value="<?php echo empty( $_POST['min_price'] ) ? '$330' : $_POST['min_price']; ?>">
									<input name="max_price" id="max_price" type="text" placeholder="No maximum" value="<?php echo empty( $_POST['max_price'] ) ? '$66,000' : $_POST['max_price']; ?>">
								</div>
							<div id="slider-range" class="slider"></div>
								<p>PRICE DOES NOT INCLUDE CENTER STONE</p>
							</div>
						</div>
						<?php endif; ?>
					</fieldset>
					
					<fieldset class="filter_footer">
						<input type="submit" class="submit" id="search_submit" value="<?php echo esc_attr_x( 'APPLY', 'submit button', 'boiler' ); ?>" />
						<input class="reset_filters" type="button" value="Reset all filters"/>
					</fieldset>
				</form>
			</div>
		</div>		
	<?php endif; ?>

