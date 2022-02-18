(function($) {
   "use strict";

$(document).ready(function() {

/*----------------------------------------------------*/
/*  Common
/*----------------------------------------------------*/

// Preloader 
function preloader() {
    $("#preloader_image").fadeOut();
    $("#preloader").delay(200).fadeOut("slow").delay(200, function() {
       $ (this).remove();
    });
} preloader();

// Currency
$('#form-currency #currency-list').on('change', function(e) {
	e.preventDefault();
	$('#form-currency input[name=\'code\']').val($(this).val());
	$('#form-currency').submit();
});

// Makes tooltips work on ajax generated content
$(document).ajaxStop(function() {
    $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
});

// tooltip remove
$('[data-toggle=\'tooltip\']').on('remove', function() {
    $(this).tooltip('dispose');
});  

// Toggle Show Password
$(document).on('click', '#button-show-password', function(e) {
	let inputElement = $(this).parent().parent().find('input');
	e.preventDefault();
	if (inputElement.attr('type') === "password") {
		 inputElement.attr('type', 'text');
		 $(this).html('<i class="fas fa-eye"></i>');
  } else {
        inputElement.attr('type', 'password');
        $(this).html('<i class="fas fa-eye-slash"></i>');
  }
});
/*----------------------------------------------------*/
/*  Inline CSS replacement for backgrounds
/*----------------------------------------------------*/
	function inlineBG() {

		// Common Inline CSS
		$(".jumbotron-image").each(function() {
			var attrImageBG = $(this).attr('data-background-image');

	        if(typeof attrImageBG !== typeof undefined && attrImageBG !== false) {
	        	$(this).css('background', 'url(' + attrImageBG + ') no-repeat center center');
	        	$(this).append('<div class="jumbotron-background-image-container"></div>');
	            $('.jumbotron-background-image-container').css('background-image', 'url('+attrImageBG+')');
	        }
		});

	} inlineBG();

/*----------------------------------------------------*/
/* Loading button plugin (removed from BS4)
/*----------------------------------------------------*/
  $.fn.button = function(action) {
    if (action === 'loading' && this.data('loading-text')) {
      this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled', true);
    }
    if (action === 'reset' && this.data('original-text')) {
      this.html(this.data('original-text')).prop('disabled', false);
    }
  };

   
   });// ------------------------------------------------
})(this.jQuery);