jQuery(document).ready( function($) {
(function($) {
$(document).ready(function(){
   $('#formsubmit').click(function(){
  $.post(
  PT_Ajax.ajaxurl,
        {
       action : 'ajax-inputtitleSubmit',
       numberofwelds : $('input[name=numberofwelds]').val(),
       numberofconwelds : $('input[name=numberofconwelds]').val(),
       nextNonce : PT_Ajax.nextNonce
        },
  function( response ) {
     console.log( response );
        }
        );
      return false;
}); 

});
})(jQuery);
}); 