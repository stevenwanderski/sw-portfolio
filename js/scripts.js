$(function(){
	
	// toggle the contact form
	$('.email a, #contact .close a').click(function(e) {
		$('#contact-wrap').stop(true, true).slideToggle();
		e.preventDefault();
	});
	
	// validate the contact form
	$('form').validate({
		submitHandler: contactSubmit
	});
	
	function contactSubmit(form){
		var $form = $(form);
		// change the submit button value and disable it to prevent multiple submissions
		$form.find('.submit').val('Sending...').attr('disabled', 'disabled');
		// get all the form data
		var data = {
			name: $form.find('#name').val(),
			email: $form.find('#email').val(),
			message: $form.find('#message').val()
		}
		// post the values to our server script
		$.post('php/mail.php', data, function(response){
			// if all good, fade out the fade and display the success message
			if(response == 'success'){
				// scroll to the top
				$('html, body').animate({scrollTop: 0}, 300);
				$('#contact-form').fadeOut(300, function(){
					$('#contact-success').fadeIn(300, function(){
						// hide the success message after 4 seconds
						setTimeout(function(){
							$('#contact-wrap').slideToggle(500);
							$form.find('.submit').val('Send').removeAttr('disabled');
						}, 4000);
					});
				});
			// if an error occurred, display the error message
			}else{
				// scroll to the top
				$('html, body').animate({scrollTop: 0}, 300);
				$('#contact-form').fadeOut(300, function(){
					$('#contact-error').fadeIn(300);
				});
			}
		});
		return false;
	}
	
});