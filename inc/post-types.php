<?php 
	
	add_action( 'init', 'create_collection' );
	
	function create_collection() {
		register_taxonomy(
			'collection',
			'product',
			array(
				'label' => __( 'Collections' ),
				'rewrite' => array( 'slug' => 'collection' ),
				'hierarchical' => true,
			)
		);
	}