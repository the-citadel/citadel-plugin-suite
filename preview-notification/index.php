<?php

$url = $_SERVER['REQUEST_URI'];

if ( strpos($url, 'preview=true') ) {
	
	function cit_preview_scripts() {

		wp_enqueue_style( 'citadel-preview', plugin_dir_url( __FILE__ ) . 'css/styles.css', [] );

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'citadel-preview-scripts', plugin_dir_url( __FILE__ ) . 'js/scripts.js', [] );

	}

	add_action( 'wp_enqueue_scripts', 'cit_preview_scripts' );

}



?>