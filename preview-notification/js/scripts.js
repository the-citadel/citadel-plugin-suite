jQuery(document).ready( function($) {

	$('.entry-content img').each( function() {

		if ( ! $(this).attr('alt') ) {

			$(this).wrap('<div class="cit-preview-alert cit-alt-alert"></div>');

		}

	});



	var issueCount = $('.cit-preview-alert').length,
		message = 'This is a preview, not the live page.';

	if ( issueCount == 1 ) {

		var issueMessage = 'There is 1 issue on this page.',
			message = message + ' ' + issueMessage;
	
	} else if ( issueCount > 1 ) {

		var issueMessage = 'There are ' + issueCount + ' issues on this page.',
			message = message + ' ' + issueMessage;

	}

	$('body').prepend('<div id="preview-message">' + message + '</div>');

});