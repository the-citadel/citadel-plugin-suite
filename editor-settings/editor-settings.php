<?php 

if ( ! function_exists( 'gutenberg_settings_scripts' ) ) {

	function gutenberg_settings_scripts() {

		wp_enqueue_script( 'citadel-gutenberg-settings-scripts', plugin_dir_url( __FILE__ ) . 'js/scripts.js', [] );

	}

	add_action('admin_enqueue_scripts', 'gutenberg_settings_scripts');

}

add_filter( 'allowed_block_types', 'citadel_allowed_block_types', 10, 2 );
function citadel_allowed_block_types( $allowed_blocks, $post ) {
 
	$allowed_blocks = array(
		'core/paragraph',
		'core/heading',
		'core/image',
		'core/list',
		'core/quote',
		'core/file',
		'core/gallery',
		'core/pullquote',
		'core/table',
		'core/media-text',
		'core/separator',
		'core/button',
		'core/text-columns',
		'core-embed/youtube',
		'core-embed/vimeo',
		'core-embed/ted',
		'citadel/paragraph',
	);
 
	// if( $post->post_type === 'post' ) {
	// 	$allowed_blocks[] = 'core/shortcode';
	// }
 
	return $allowed_blocks;
 
}

function citadel_disable_editor_settings() {
    add_theme_support( 'editor-color-palette' );
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support( 'editor-font-sizes', array()
		);
}
add_action( 'after_setup_theme', 'citadel_disable_editor_settings' );

?>