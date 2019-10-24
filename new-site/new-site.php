<?php 

defined( 'ABSPATH' ) || exit;

// Default Timezone
add_action( 'wpmu_new_blog', 'set_default_timezone_mu', 0 );
function set_default_timezone_mu( $blog_id ){
    switch_to_blog( $blog_id );
    update_option( 'gmt_offset','UTC-5' );
    restore_current_blog();
}

update_option("timezone_string","America/New_York");

// Make homepage page, not posts
add_action( 'wpmu_new_blog', 'process_extra_field_on_blog_signup', 10, 6 );
function process_extra_field_on_blog_signup( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
    switch_to_blog($blog_id);
    $homepage = get_page_by_title( 'Sample Page' );   
    if ( $homepage )
    {
        update_blog_option( $blog_id, 'page_on_front', $homepage->ID );
        update_blog_option( $blog_id, 'show_on_front', 'page' );
    }

    // 'Hello World!' post
    wp_delete_post( 1, true );

    $blog_title = get_bloginfo('name');

    $post_update = array(
        'ID'         => 2,
        'post_title' => 'Home',
        'post_content' => $blog_title . ' homepage content goes here!'
    );
    wp_update_post( $post_update );

    $menu_name = 'Main Menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );

    // If it doesn't exist, let's create it.
    if( !$menu_exists){
        $menu_id = wp_create_nav_menu($menu_name);

        // Set up default menu items
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Home'),
            'menu-item-classes' => 'home',
            'menu-item-url' => home_url( '/' ), 
            'menu-item-status' => 'publish'));
    }

    restore_current_blog();
}

// Default permalink structure
add_action( 'init', function() {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure( '/%year%/%monthnum%/%postname%/' );
} );

?>