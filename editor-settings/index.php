<?php 

defined( 'ABSPATH' ) || exit;

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
		'core-embed/ted'
	);
 
	// if( $post->post_type === 'post' ) {
	// 	$allowed_blocks[] = 'core/shortcode';
	// }
 
	return $allowed_blocks;
 
}

?>