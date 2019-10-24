<?php
/**
 * @package Citadel Plugin Suite
 */

/*
Plugin Name: Citadel Plugin Suite
Plugin URI: https://citadel.edu/web/
Description: A master plugin for all Citadel plugin features
Version: 1.0.0
Author: the Citadel Webmaster
Author URI: https://citadel.edu/web/
License: GPLv2 or Later
Text Domain: citadel-plugin-suite
*/

// Function if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there! I\'m just a plugin, not much I can do when called directly.';
}

// Define globals
define( 'CITSUITE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Require Citadel Suite Settings
require_once( CITSUITE__PLUGIN_DIR . 'suite-settings/suite-settings.php' );
