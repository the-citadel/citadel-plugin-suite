<?php

add_action( 'admin_menu', 'remove_built_in_roles' );
 
function remove_built_in_roles() {
    global $wp_roles;
 
    $roles_to_remove = array( 'subscriber', 'contributor', 'author', 'editor' );
 
    foreach ($roles_to_remove as $role) {
        if (isset($wp_roles->roles[$role])) {
            $wp_roles->remove_role($role);
        }
    }
}

// Editor
add_role(
	'citadel_editor',
	__( 'Citadel Editor' ),
	array(
		'delete_pages'				=> true,
		'delete_others_pages'		=> true,
		'delete_published_pages'	=> true,
		'edit_others_pages'			=> true,
		'edit_pages'				=> true,
		'edit_published_pages'		=> true,
		'read'						=> true,
		'upload_files'				=> true,
	)
);

// Intermediate Editor
add_role(
	'citadel_intermediate_editor',
	__( 'Citadel Intermediate Editor' ),
	array(
		'delete_pages'				=> true,
		'delete_others_pages'		=> true,
		'delete_published_pages'	=> true,
		'edit_others_pages'			=> true,
		'edit_pages'				=> true,
		'edit_published_pages'		=> true,
		'publish_pages'				=> true,
		'read'						=> true,
		'upload_files'				=> true,
	)
);

// Advanced Editor
add_role(
	'citadel_advanced_editor',
	__( 'Citadel Advanced Editor' ),
	array(
		'delete_pages'				=> true,
		'delete_others_pages'		=> true,
		'delete_published_pages'	=> true,
		'edit_others_pages'			=> true,
		'edit_pages'				=> true,
		'edit_published_pages'		=> true,
		'edit_theme_options'		=> true,
		'publish_pages'				=> true,
		'read'						=> true,
		'upload_files'				=> true,
	)
);

function hide_menu() {

	remove_submenu_page( 'themes.php', 'theme-install.php' );
	remove_submenu_page( 'themes.php', 'theme-editor.php' );
	remove_submenu_page( 'plugins.php', 'plugin-install.php' );
	remove_submenu_page( 'plugins.php', 'plugin-editor.php' );

    if ( !current_user_can( 'administrator' ) ) {

    	remove_submenu_page( 'themes.php', 'themes.php' );
    	remove_menu_page('profile.php');
        remove_submenu_page('users.php', 'profile.php');

    }
}
add_action('admin_head', 'hide_menu');