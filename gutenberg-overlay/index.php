<?php

if ( ! function_exists( 'gutenberg_overlay_scripts' ) ) {

	function gutenberg_overlay_scripts() {

		wp_enqueue_style( 'citadel-gutenberg-overlay', plugin_dir_url( __FILE__ ) . 'css/styles.css', [] );
		wp_enqueue_script( 'citadel-gutenberg-overlay-scripts', plugin_dir_url( __FILE__ ) . 'js/scripts.js', [] );

	}

	add_action('admin_enqueue_scripts', 'gutenberg_overlay_scripts');

}

?>