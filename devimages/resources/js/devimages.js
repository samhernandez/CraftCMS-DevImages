;(function($) {

	var $form = $('form#devimages');
	var $spinner = $form.find('.spinner');
	var $button = $form.find('.submit');
	var action = $form.attr('action');

	function handleSubmit(e)
	{
		e.preventDefault();
		if ($button.hasClass('hidden')) return;

		$spinner.removeClass('hidden');
		$button.hide();

		console.log($form.serialize());

		var jqxhr = $.ajax(action, {
			method: 'post',
			data: $form.serialize(),
			success: function(e) {
				if (typeof e.success !== undefined && e.success) {
					Craft.cp.displayNotice('Images generated');
				}
				else {
					Craft.cp.displayError('Unable generate images')
				}
			},
			error: function(e) {
				Craft.cp.displayError('Unable to generate images')
			}
		});

		jqxhr.always(function() {
			$spinner.addClass('hidden');
			$button.show();
		});
	}

	$form.on('submit', handleSubmit);

})(jQuery);
