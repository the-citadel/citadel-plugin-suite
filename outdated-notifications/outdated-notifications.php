<?php

defined( 'ABSPATH' ) || exit;

/*
--------------------
Citadel Admin Pending Pages Menu Item
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
?>
<div class="wrap">

	<h1 class="wp-heading-inline">Outdated Pages</h1>
	<hr class="wp-header-end">
	<?php include( plugin_dir_path( __FILE__ ) . 'php/admin.php');?>

		<style type="text/css">
			.outdated-pages {
				margin-top: 10px;
			}

			.outdated-pages .actions a {
				font-size: 1.2em;
				margin-right: 10px;
			}

			.page-numbers {
				margin-right: 3px;
			}
		</style>

</div>
<?php
}

/*
--------------------
Citadel Admin Pending Pages Dashboard Widget
--------------------
*/

function cit_outdated_dashboard_widget() {
	global $wp_meta_boxes;
	 
	wp_add_dashboard_widget(
		'citadel-outdated-pages',
		'Outdated Pages',
		'cit_dashboard_outdated'
	);
} add_action('wp_dashboard_setup', 'cit_outdated_dashboard_widget');

function cit_dashboard_outdated() {


	include( plugin_dir_path( __FILE__ ) . 'php/admin.php');


}

