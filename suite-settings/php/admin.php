<?php

echo '<main id="cps-settings">';

	echo '<h1>Citadel Plugin Suite Settings</h1>';

	echo '<form method="post" action="' . plugin_dir_path( __FILE__ ) . 'options.php">';

	$directories = glob( CITSUITE__PLUGIN_DIR . '*', GLOB_ONLYDIR );

	foreach ($directories as $directory) {

		$dir = basename( $directory );
		$cleanDir = str_replace("-", " ", $dir);

		if ( 'suite-settings' !== $dir ) {

			echo '<label><input type="checkbox" name="cps-option" value="' . $dir . '" checked>' . $cleanDir . '</label><br/>';

		}

	}

	echo '</form>';

	echo submit_button();

echo '</main>';