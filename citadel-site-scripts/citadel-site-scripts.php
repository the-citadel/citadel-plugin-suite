<?php

defined( 'ABSPATH' ) || exit;

// function is_site_admin(){
//     return in_array('administrator',  wp_get_current_user()->roles);
// }


add_action('admin_menu', 'citadel_plugin_menu_setup');
function citadel_site_scripts_menu_setup(){

	if ( is_super_admin() ) {

    	add_menu_page( 'Site Scripts', 'Site Scripts', 'manage_options', 'citadel-site-scripts', 'citadel_site_scripts_admin_init', 'dashicons-flag' );
	}

}

function citadel_site_scripts_admin_init(){
    include( plugin_dir_path( __FILE__ ) . 'php/admin.php');
}