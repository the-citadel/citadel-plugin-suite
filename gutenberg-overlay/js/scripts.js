jQuery(document).ready(function($) {


	$('body.block-editor-page').click( function() {

		if ($(this).find('.editor-block-list__block.is-selected').length !== 0) {

			$('#editor').addClass('block-selected');

		} else {

			$('#editor').removeClass('block-selected');

		}

	});

	$('.edit-post-layout__metaboxes:not(:empty):first').addClass('not-empty');

});