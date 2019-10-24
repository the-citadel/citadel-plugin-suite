<?php

/*
--------------------
Enqueue styles and scripts
--------------------
*/

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

/*
--------------------
Hide admin toolbar
--------------------
*/

show_admin_bar( false );

/*
--------------------
Replace login logo
--------------------
*/

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

/*
--------------------
Change the URL of Login Logo
--------------------
*/

function citadel_url_login_logo(){
	return 'https://citadel.edu';
}
add_filter('login_headerurl', 'citadel_url_login_logo');

/*
--------------------
Replace login name with Citadel username
--------------------
*/

add_filter(  'gettext',  'register_text'  );
function register_text( $translating ) {
	 $translated = str_ireplace(  'Username or Email Address',  'Citadel Username',  $translating );
	 return $translated;
}

/*
--------------------
Remove lost password link
--------------------
*/

function remove_lostpassword_text ( $text ) {
if ($text == 'Lost your password?'){$text = '';}
	return $text;
}
add_filter( 'gettext', 'remove_lostpassword_text' );

/*
--------------------
Disable password reset
--------------------
*/

function disable_password_reset() {
	return false;
}
add_filter ( 'allow_password_reset', 'disable_password_reset' );

/*
--------------------
Authenticate login agreement
--------------------
*/

function cit_authenticate_user_acc($user, $password) {
	// See if the checkbox #login_accept was checked
	if ( isset( $_REQUEST['login_accept'] ) && $_REQUEST['login_accept'] == 'on' ) {
		// Checkbox on, allow login
		return $user;
	} else {
		// Did NOT check the box, do not allow login
		$error = new WP_Error();
		$error->add('did_not_accept', 'You must agree to using the web policy and guidelines to login' );
		return $error;
	}
}
add_filter('wp_authenticate_user', 'cit_authenticate_user_acc', 99999, 2);

/*
--------------------
Add login agreement
--------------------
*/

function cit_login_form(){
	// Add an element to the login form, which must be checked
	echo '<label><input id="login_accept" type="checkbox" name="login_accept" /> By logging in I agree to the web <a href="https://web.citadel.edu/policy" target="_blank">policy</a> and <a href="https://web.citadel.edu/guidelines" target="_blank">guidelines</a>.</label>';
}
add_filter ( 'login_form', 'cit_login_form' );

/*
--------------------
Remove "Remember Me" Checkbox from WordPress Login Page
--------------------
*/

add_action('login_head', 'remove_remember_me');
function remove_remember_me() {
	echo '<style type="text/css">.forgetmenot { display:none; }</style>' . "\n";
}

/*
--------------------
Remove adminbar items
--------------------
*/

function example_admin_bar_remove_logo() {
	global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'wp-logo' );
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('new-content');
		$wp_admin_bar->remove_menu('my-account');
}
add_action( 'wp_before_admin_bar_render', 'example_admin_bar_remove_logo', 0 );

/*
--------------------
Add adminbar items
--------------------
*/

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

/*
--------------------
Custom admin footer
--------------------
*/

add_filter('admin_footer_text', 'remove_footer_admin');
function remove_footer_admin ()  {
	echo '<span id="footer-thankyou">Developed by <a href="https://web.citadel.edu/" target="_blank">the Citadel Webmaster</a></span>';
}
?>