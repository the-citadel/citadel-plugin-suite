<?php

defined( 'ABSPATH' ) || exit;

/*
--------------------
Citadel Admin Pending Pages Widget
--------------------
*/

add_action('admin_menu', 'citadel_plugin_menu_setup');
function citadel_plugin_menu_setup(){

	$args = array(
		'post_type'		=> 'page',
		'post_status'	=> 'publish',
		'date_query' => array(
	        array(
	            'column' => 'post_modified',
	            'before'  => '3 months ago',
	        ),
	    ),
	);

	$the_query = new WP_Query($args);
	$count = $the_query->found_posts;

    add_menu_page( 'Outdated Page List', $count ? sprintf('Outdated <span class="awaiting-mod">%d</span>', $count) : 'Outdated', 'manage_options', 'citadel-outdated-pages', 'citadel_plugin_admin_init', 'dashicons-flag' );
}

function citadel_plugin_scripts() {
	wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css');
}
add_action( 'admin_print_styles', 'citadel_plugin_scripts' );

function citadel_plugin_admin_init(){
    include( plugin_dir_path( __FILE__ ) . 'php/admin.php');
}

