<?php 

/*-------------------------------
Dashboard Widgets
-------------------------------*/

// Citadel Admin Quick Links Widget
function my_custom_dashboard_widgets() {
	global $wp_meta_boxes;
	 
	wp_add_dashboard_widget(
		'citadel-quick-links',
		'Citadel Quick Links',
		'custom_dashboard_help'
	);
} add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function custom_dashboard_help() {
	?>

	<a href="<?php network_site_url() ?>post-new.php?post_type=page" class="quick-link">
		<i class="fas fa-fw fa-file"></i>
		<p>Add New Page</p>
	</a>
	<a href="<?php network_site_url() ?>my-sites.php" class="quick-link">
		<i class="fas fa-fw fa-th-list"></i>
		<p>My Sites</p>
	</a>
	<a href="https://web.citadel.edu/help/submit-ticket" target="_blank" class="quick-link">
		<i class="fas fa-fw fa-ticket-alt"></i>
		<p>Webmaster Request</p>
	</a>
	<a href="https://web.citadel.edu/help" target="_blank" class="quick-link">
		<i class="fas fa-fw fa-book"></i>
		<p>Knowledge Base</p>
	</a>
	<a href="https://new.monsido.com/3457/domains/6800?domain_group=" target="_blank" class="quick-link">
		<i class="fas fa-fw fa-universal-access"></i>
		<p>Accessibility &amp; SEO</p>
	</a>
	<a href="https://web.citadel.edu/policy" target="_blank" class="quick-link">
		<i class="fas fa-fw fa-file-invoice"></i>
		<p>Citadel Web Policy</p>
	</a>

	<?php
}

// Citadel Admin Pending Pages Widget

function citadel_network_add_pending_widget() {
	
	if (current_user_can('add_users')) {
		
		wp_add_dashboard_widget(
			'citadel_network_pending_dashboard_widget',
			'Pending Pages',
			'citadel_network_pending_dashboard_widget_function'
		);
	}
}
add_action( 'wp_network_dashboard_setup', 'citadel_network_add_pending_widget' );

function citadel_network_pending_dashboard_widget_function() {
	$args = array(
	  'post_type' 		=> 'page',
	  'orderby'   		=> 'date',
	  'order'     		=> 'DSC',
	  'post_status' 	=> 'pending',
	);

	$sites = get_sites();
	$sitesWithPending = [];

	foreach( $sites as $site ) {

		$site_id = get_object_vars( $site )["blog_id"];
		switch_to_blog( $site_id );
		$pending_posts = new WP_Query( $args );

		if ( $pending_posts->have_posts() ) {

			array_push( $sitesWithPending, $site_id );

		}

	}


	if ( !empty( $sitesWithPending ) ) {
		echo  '<table class="wp-list-table widefat striped">' .
				'<thead>' .
					'<tr>' .
						'<th>Website</th>' .
						'<th style="max-width: 100px; text-align: center;"># of Pages</th>' .
					'</tr>' .
				'</thead>' .
				'<tbody>';
		foreach( $sites as $site ) {
			$site_id = get_object_vars( $site )["blog_id"];
			switch_to_blog( $site_id );
			$pending_posts = new WP_Query( $args );

			if ( $pending_posts->have_posts() ) {
				$count = $pending_posts->found_posts;

				echo  '<tr>' .
						'<td><a href="' . esc_url( get_site_url() ) . '">' . get_bloginfo() . '</a></td>' .
						'<td style="max-width: 100px; text-align: center;"><strong><a href="' . esc_url( get_site_url() ) . '/wp-admin/edit.php?post_status=pending&post_type=page">' . $count . '</a></strong></td>' .
					'</tr>';
				
				wp_reset_postdata();
			}
		}

		echo    '</tbody>' .
				'</table>';
	} else {
		echo '<p>There are no pending pages in this network.</p>';
	}
	
}


function remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );   // Recent Activity
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // Recent Comments
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );  // Incoming Links
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );   // Plugins
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );  // Quick Press
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );  // Recent Drafts
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );   // WordPress blog
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );   // Other WordPress News
	remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); //Removes the 'At a Glance' widget
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );

remove_action( 'welcome_panel', 'wp_welcome_panel' );
remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );

add_action('wp_network_dashboard_setup', 'hhs_remove_network_dashboard_widgets' );
function hhs_remove_network_dashboard_widgets() {
    remove_meta_box ( 'network_dashboard_right_now', 'dashboard-network', 'normal' ); // Right Now
    remove_meta_box ( 'dashboard_plugins', 'dashboard-network', 'normal' ); // Plugins
    remove_meta_box ( 'dashboard_primary', 'dashboard-network', 'side' ); // WordPress Blog
    remove_meta_box ( 'dashboard_secondary', 'dashboard-network', 'side' ); // Other WordPress News
}