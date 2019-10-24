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
	  'post_type' => 'page',
	  'orderby'   => 'date',
	  'order'     => 'DSC',
	  'post_status' => 'pending',
	  'posts_per_page' => -1
	);

	$subsites = get_sites();


	if (! empty ( $subsites )) {
		echo  '<table class="wp-list-table widefat fixed striped">' .
				'<thead>' .
					'<tr>' .
						'<th class="row-title">Title</th>' .
						'<th>Author</th>' .
						'<th>Website</th>' .
						'<th style="min-width: 100px;">Date</th>' .
					'</tr>' .
				'</thead>' .
				'<tbody>';
		foreach( $subsites as $subsite ) {
			$subsite_id = get_object_vars( $subsite )["blog_id"];
			switch_to_blog( $subsite_id );
			$pending_posts = new WP_Query( $args );

			if ( $pending_posts->have_posts() ) {
				while ( $pending_posts->have_posts() ) {
					$pending_posts->the_post();
					echo  '<tr>' .
							'<td class="row-title"><a href="' . get_edit_post_link() . '">' . get_the_title() . '</a></td>' .
							'<td><a href="mailto:' . get_the_author_meta('email') . '">' . get_the_author() .  '</a></td>' .
							'<td><a href="' . get_site_url() . '/wp-admin/edit.php?post_status=pending&post_type=page">' . get_bloginfo() . '</a></td>' .
							'<td style="min-width: 100px;">' . get_the_date() . '</td>' .
						'</tr>';
				}
				
				wp_reset_postdata();
			}
		}

		echo    '</tbody>' .
				'</table>';
	} else {
		echo '<p>There are no subsites in this network.</p>';
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