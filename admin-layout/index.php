<?php

if ( ! function_exists( 'citadel_admin_scripts' ) ) {
	//Add custom admin CSS
	function citadel_admin_style() {
		// Get the theme data
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		wp_enqueue_style('citadel-admin-styles', plugin_dir_url( __FILE__ ) . 'css/style-editor.css', array() );
		wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css');
		wp_enqueue_style( 'citadel-fonts', 'https://use.typekit.net/onz2qme.css', array() );
	}
	add_action('admin_enqueue_scripts', 'citadel_admin_style');
}

// Hide Admin Toolbar
show_admin_bar( false );

// Change Howdy to Welcome
add_filter('gettext', 'change_howdy', 10, 3);
function change_howdy($translated, $text, $domain) {

	if (!is_admin() || 'default' != $domain)
		return $translated;

	if (false !== strpos($translated, 'Howdy'))
		return str_replace('Howdy', 'Welcome', $translated);

	return $translated;
}

// Replace Login Logo
function my_login_logo() { ?>
	<style type="text/css">
		body { background: #F5F4F2 !important; }
		#login h1 a, .login h1 a {
			background-image: url(<?php echo plugin_dir_url( __FILE__ ); ?>images/Citadel_Logo_Brandmark_Navy_Square.png);
			height: 150px;
			width: 150px;
			background-size: 150px 150px;
			background-repeat: no-repeat;
		}
		.login form {
			border: 1px solid #d4d5d7;
			box-shadow: none !important;
		}
		p#nav {
			display: none;
		}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

// Change the URL of Login Logo
function citadel_url_login_logo(){
	return get_blog_details( 1 )->path;
}
add_filter('login_headerurl', 'citadel_url_login_logo');

// Replace default name info with Citadel Username on login
add_filter(  'gettext',  'register_text'  );
function register_text( $translating ) {
	 $translated = str_ireplace(  'Username or Email Address',  'Citadel Username',  $translating );
	 return $translated;
}

// Remove lost password url from login page
function remove_lostpassword_text ( $text ) {
if ($text == 'Lost your password?'){$text = '';}
	return $text;
}
add_filter( 'gettext', 'remove_lostpassword_text' );

// Disable password reset for all users
function disable_password_reset() {
	return false;
}
add_filter ( 'allow_password_reset', 'disable_password_reset' );

// Remove admin bar items
function example_admin_bar_remove_logo() {
	global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'wp-logo' );
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('new-content');
		$wp_admin_bar->remove_menu('my-account');
}
add_action( 'wp_before_admin_bar_render', 'example_admin_bar_remove_logo', 0 );

// Add admin bar items
add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar){
	$admin_bar->add_menu( array(
		'id'    => 'citadel-logout',
		'title' => 'Logout',
		'href'  => site_url() . '/wp-login.php?action=logout',
		'meta'  => array(
			'title' => __('Logout'),            
		),
	));
};

// Custom admin thank you
add_filter('admin_footer_text', 'remove_footer_admin');
function remove_footer_admin ()  {
	echo '<span id="footer-thankyou">Developed by <a href="https://citadel.edu/web" target="_blank">the Citadel Webmaster</a></span>';
}
?>