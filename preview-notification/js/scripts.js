jQuery(document).ready(function($) {

	$message = 'This is a preview, not the live page.';

	$('body').prepend('<div id="preview-message">' + $message + '</div>');

});