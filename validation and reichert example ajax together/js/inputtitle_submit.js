jQuery(document).ready( function($) {
(function($) {
$(document).ready(function(){
  $('#next').click(function(){
  $.post(
  PT_Ajax.ajaxurl,
		{
	   action : 'ajax-inputtitleSubmit',
	   title : $('input[name=title]').val(),
	   nextNonce : PT_Ajax.nextNonce
		},
  function( response ) {
	 alert(response.title);
		}
		);
 	  return false;
});	
		    	
});
})(jQuery);
}); 
