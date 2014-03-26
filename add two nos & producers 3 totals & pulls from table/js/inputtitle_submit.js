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
  $("#totalone").val(response["tot1"]);
  $("#totaltwo").val(response["tot2"]);
  $("#totalthree").val(response["tot3"]);
        }
        );
      return false;
}); 

});
})(jQuery);
});


 

