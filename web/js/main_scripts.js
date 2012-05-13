/***SHOW-HIDE LEFT MENU AFTER CLICK FUNCTION***/
jQuery(document).ready(function() {
		jQuery('#accordion h3').click(function() {
		if(jQuery(this).hasClass('open')) {
			jQuery(this).removeClass('open');
			jQuery(this).next().slideUp('fast');
		} else {
			jQuery(this).addClass('open');
			jQuery(this).next().slideDown('fast');
		} return false;
	}); });
	
/***CLOSE ALERT MESSAGE AFTER CLICK ON CLOSE BTN***/	
jQuery(document).ready(function(){
		jQuery('.message .close').click(function(){
			jQuery(this).parent().fadeOut();
		});
	});	
	
