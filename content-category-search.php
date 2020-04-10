<?php 	
	get_template_part('content', 'filters');
	
	$mainCat = get_field( 'main_category' );
	$terms = null;
	if( $mainCat ) {
		$tax_query_array = $terms = $meta_query_array = $filter_array = array();
		
		// Get all children from main category..
		$terms_ids = get_term_children( $mainCat->term_id, 'product_cat' );

		foreach( $terms_ids as $id ) {
			$term = get_term_by( 'id', $id, 'product_cat' );
			$terms[] = $term->slug;
		}
		
		// Check if selected filters are under the main category..
		foreach ( $_POST as $filter ) {
			if ( in_array( $filter, $terms ) ) {
				$filter_array[] = $filter;
			}
		}
		
		// if there is any filter, add to the query
		if ( count( $filter_array ) > 0 ) {
			$tax_query_array[] = array(
					'taxonomy' => 'product_cat',
					'field' => 'slug',
					'terms' => $filter_array,
			);
		}
		
		// Check filters for specific taxonomies
		if( $mainCat->slug == 'engagement' ) {
			
			// style Taxonomy
			$style_terms = get_terms( 'style', array( 'hide_empty' => 0 ) );
			$style_terms_slug = $filter_array = array();
			
			foreach( $style_terms as $term ) {
				$style_terms_slug[] = $term->slug;
			}
			
			foreach ( $_POST as $filter ) {
				if ( in_array( $filter, $style_terms_slug ) ) {
					$filter_array[] = $filter;
				}
			}

			if ( count( $filter_array ) > 0 ) {
				$tax_query_array[] = array(
						'taxonomy' => 'style',
						'field' => 'slug',
						'terms' => $filter_array,
				);
			}

			// setting_style Taxonomy
			$setting_style_terms = get_terms( 'setting_style', array( 'hide_empty' => 0 ) );
			$setting_style_terms_slug = $filter_array = array();
			
			foreach( $setting_style_terms as $term ) {
				$setting_style_terms_slug[] = $term->slug;
			}
				
			foreach ( $_POST as $filter ) {
				if ( in_array( $filter, $setting_style_terms_slug ) ) {
					$filter_array[] = $filter;
				}
			}
			
			if ( count( $filter_array ) > 0 ) {
				$tax_query_array[] = array(
						'taxonomy' => 'setting_style',
						'field' => 'slug',
						'terms' => $filter_array,
				);
			}


			// Check Center Stone filter
			if ( isset( $_POST['center_stone'] ) && ! empty( $_POST['center_stone'] ) ) {
				$values = explode( '-', $_POST['center_stone'] );
			
				$meta_query_array[] = array(
						'key'	  => 'center_stone',
						'value'   => array( $values[0], $values[1] ),
						'type'    => 'numeric',
						'compare' => 'BETWEEN',
				);
			}
			
		}
		
		// Check price filter
		if ( isset( $_POST['min_price'] ) && isset( $_POST['max_price'] ) ) {
			$min_price = str_replace( array( '$', ',' ), '', $_POST['min_price'] );
			$max_price = str_replace( array( '$', ',' ), '', $_POST['max_price'] );
		
			$meta_query_array[] = array(
					'key'	  => '_regular_price',
					'value'   => array( $min_price, $max_price ),
					'type'    => 'numeric',
					'compare' => 'BETWEEN',
			);		
		}
		
		// Set main query arguments
		$args = array(
				'post_type' => 'product',
				'posts_per_page' => -1,
				'post_status' => 'publish',
		);
		
		if ( count( $tax_query_array ) > 0 ) {
			$args['tax_query']['relation'] = 'AND';
			foreach ( $tax_query_array as $tax_query ) {
				$args['tax_query'][] = $tax_query;
			}			
		} else {
			// No filters selected, list all products from main category
			$tax_query = array(
						'taxonomy' => 'product_cat',
						'field' => 'slug',
						'terms' => $mainCat->slug,
				);
						
			$args['tax_query'][] = $tax_query;
		}

		if ( count( $meta_query_array ) > 0 ) {
			$args['meta_query'] = $meta_query_array;
		}
	
		$query = new WP_Query($args);
	}
?>

<div class="search_results_count">
	<h5>Search results: <span>(<?php echo $query->found_posts; ?> results)</span></h5>
</div>
				
<div class="products">
	<?php while( $query->have_posts() ) : $query->the_post(); ?>
		<?php $price = get_post_meta( get_the_ID(), '_regular_price', true); ?>
		<div class="product">
			<div class="add_to_wish_list">
				<a href="#" class="add_to_wish_list_button js_add_to_wish_list <?php check_wish_list_item( get_the_ID() ); ?>" data-product-id="<?php the_ID(); ?>"><span>add to wishlist</span></a>
			</div>
			<?php if(has_post_thumbnail()) : ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
			<?php else : ?>
				<a href="<?php the_permalink(); ?>"><img src="<?php echo bloginfo('template_url'); ?>/images/placeholder.jpg" alt="placeholder image" /></a>
			<?php endif; ?>							

			<div class="info">
				<h3><?php echo get_post_meta(get_the_ID(), 'productNumber', true); ?></h3>
				<p><?php echo '$' . number_format($price); ?></p>
			</div>
		</div>
	<?php endwhile; ?>
</div>
	
<?php wp_reset_postdata(); ?>