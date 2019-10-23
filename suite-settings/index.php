
<?php

// Add admin menu
function citadel_suite_setup_menu(){
    add_menu_page( 'Citadel Plugin Suite Settings', 'Plugin Suite', 'manage_options', 'citadel-plugin-suite', 'show_plugin_suite_settings' );
}
add_action('network_admin_menu', 'citadel_suite_setup_menu'); // Network
add_action('admin_menu', 'citadel_suite_setup_menu'); // Subsite

// Admin page setup
function show_plugin_suite_settings(){
     require_once( plugin_dir_path( __FILE__ ) . 'php/admin.php' );
}

// Get other sub-plugins
$directories = glob( CITSUITE__PLUGIN_DIR . '*', GLOB_ONLYDIR );

foreach ($directories as $directory) {

	$dir = basename( $directory );

	if ( 'suite-settings' !== $dir ) {

		require_once( CITSUITE__PLUGIN_DIR . $dir . '/index.php' );

	}

}