
<?php

// Add admin menu to site
function citadel_suite_setup_menu(){

	add_menu_page( 'Citadel Settings', 'Citadel Settings', 'administrator', 'citadel-plugin-suite' );
    add_submenu_page( 'citadel-plugin-suite', 'Citadel Plugin Suite Settings', 'Plugin Suite', 'administrator', 'citadel-plugin-suite', 'show_plugin_suite_settings' );

}
add_action('admin_menu', 'citadel_suite_setup_menu'); // Subsite
add_action('network_admin_menu', 'citadel_suite_setup_menu'); // Network


function register_cit_suite_settings() {
	
	add_settings_section(
        'cps_settings_section',
        'Citadel Plugin Suite Options',
        'cps_settings_section_callback',
        'general'
    );

    $directories = glob( CITSUITE__PLUGIN_DIR . '*', GLOB_ONLYDIR );

    foreach ($directories as $directory) {

		$dir = basename( $directory );
		$cleanDir = str_replace("-", " ", $dir);

		if ( is_network_admin() ) {
			$settingName = 'network-' . $dir . '-plugin';
		} else {
			$settingName = $dir . '-plugin';
		}

		add_settings_field(
			$settingName,
			$cleanDir,
			'cps_settings_field_callback',
			'general',
			'cps_settings_section',
			array(
				$dir,
				$cleanDir,
				$settingName,
			)
		);

	}

}
add_action( 'admin_init', 'register_cit_suite_settings' );

function cps_settings_section_callback() {
    echo '<p>Select which areas of content you wish to display.</p>';
}

function cps_settings_field_callback($args) {
	$html = '<input type="checkbox" id="'  . $args[0] . '" name="'  . $args[0] . '" value="1" ' . checked( 1, get_option( $args[2] ), false ) . '/>'; 

	echo $html;
}

// Admin page setup
function show_plugin_suite_settings(){

     //require_once( plugin_dir_path( __FILE__ ) . 'php/admin.php' );

?>

<div id="cps-settings" class="wrap">

	<h1>Citadel Plugin Suite Settings</h1>

	<form method="post" action="options.php">

	</form>

</div>


<?php


}

function cps_scripts() {

	wp_enqueue_style( 'citadel-plugin-suite', plugin_dir_url( __FILE__ ) . 'css/styles.css', [] );

}

add_action( 'admin_enqueue_scripts', 'cps_scripts' );

// Get other sub-plugins
$directories = glob( CITSUITE__PLUGIN_DIR . '*', GLOB_ONLYDIR );

foreach ($directories as $directory) {

	$dir = basename( $directory );

	if ( 'suite-settings' !== $dir ) {

		$filePath = CITSUITE__PLUGIN_DIR . $dir . '/' . $dir . '.php';

		if ( file_exists( $filePath ) ) {
			require_once( $filePath );
		}

	}

}