/**
 * 
 *
 * 
 *
 * 		I did this for the nine six. And we don't stop.
 *   	Page functions for the manage page.
 *   
 *
 * 
 */
// {{{ var confirm_delete_page = function()
var confirm_delete_page = function() 
{
   var did = $(this).parent().attr("id");
   var base = getBaseURL();
   
   var posturl = ( base + "/pages/remove/" + did );
   var thisDiv = $(this).parent();
   var myArgs = { 
      url         : posturl,
      divId       : did    
   };
   var buttons = {
      option1  :  { id : 'cancel_button', title : 'Cancel', class : 'light_grey_button', onConfirm : 'close_confirm' },
      option2  :  { id : 'confirm_button', title : 'Delete', class : 'light_blue_button', onConfirm : 'delete_entry', args : myArgs }
   }; 
   chi_confirm( 'Are you sure that you want to delete \''+ $(this).parent().find("div.edit_mid a").html() +'\'? This cannot be undone.', 'Delete Story', buttons );
   return false;
}
// }}}
// {{{ var delete_entry = function( obj )
var delete_entry = function( obj ) 
{
   $.ajax({
		url: obj.url,
		type: 'POST',
      success: function(){
         close_confirm();
         $( '#' + obj.divId ).slideUp('slow');
      }
	});
}
// }}}
$(document).ready( function() {
	$('.d_pages').click( confirm_delete_page );
});
