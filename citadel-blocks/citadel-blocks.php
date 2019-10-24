<?php

function citadel_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'citadel',
				'title' => __( 'Citadel Blocks', 'citadel' ),
			),
		)
	);
}
add_filter( 'block_categories', 'citadel_block_category', 10, 2);

function loadCitBlocks() {
  wp_enqueue_script( 'citadel-blocks', plugin_dir_url(__FILE__) . 'js/citadel-blocks.js', array('wp-blocks','wp-editor'), true );
}
   
add_action('enqueue_block_editor_assets', 'loadCitBlocks');