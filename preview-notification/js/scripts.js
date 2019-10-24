jQuery(document).ready( function($) {

	$('.entry-content img').each( function() {

		if ( ! $(this).attr('alt') ) {

			$(this).wrap('<div class="cit-preview-alert cit-alt-alert"></div>');

		}

	});

	var issueCount = $('.cit-preview-alert').length,
		altIssues = $('.cit-alt-alert').length,
		message = 'This is a preview, not the live page.';

	if ( issueCount == 1 ) {

		var issueMessage = 'There is <button>1 issue</button> on this page.',
			message = message + ' ' + issueMessage;
	
	} else if ( issueCount > 1 ) {

		var issueMessage = 'There are <button>' + issueCount + ' issues</button> on this page.',
			message = message + ' ' + issueMessage;

	}

	var errors = '';

	if ( altIssues > 0 ) {
		errors = errors + '<li><strong>(' + altIssues + ')</strong> Images missing alt text</li>';
	}

	if ( issueCount > 0 ) {

		$('body').prepend('<div id="preview-message"><p>' + message + '</p><div class="errors"><ul>' + errors + '</ul></div></div>');

	} else {

		$('body').prepend('<div id="preview-message"><p>' + message + '</p></div>');

	}

	$('#preview-message button').click(function() {

		$('#preview-message .errors').stop().slideToggle(400);

	});
	

});