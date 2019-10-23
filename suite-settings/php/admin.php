<?php

echo '<h1>Citadel Plugin Suite Settings</h1>';

$directories = glob( CITSUITE__PLUGIN_DIR . '*', GLOB_ONLYDIR );

foreach ($directories as $directory) {

	$dir = basename( $directory );

	if ( 'suite-settings' !== $dir ) {

		echo '<label><input type="checkbox" checked>' . $dir . '</label><br/>';

	}

}

echo '<br/><button>Save Settings</button>';