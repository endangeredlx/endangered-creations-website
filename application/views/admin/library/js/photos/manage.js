/**
 *
 * 		I did this for the nine six. And we don't stop.
 *   	   Photo functions for the manage page.
 *   
 */

function confirm_delete_photo_album() 
{
   var did = $(this).parent().attr("id");
   var base = getBaseURL();
   var posturl = ( base + "/photos/remove/" + did );
   var thisDiv = $(this).parent();
   var myArgs = { 
      url         : posturl,
      divId       : did    
   };
   var buttons = {
      option1  :  {
         id          : 'cancel_button',
         title       : 'Cancel',
         onConfirm   : 'close_confirm',
         class       : 'light_grey_button'
      },
      option2  :  {
         id          : 'confirm_button',
         title       : 'Delete',
         onConfirm   : 'delete_photo_album',
         class       : 'light_blue_button',
         args        : myArgs
      }
   }; 
   chi_confirm( 'Are you sure that you want to delete \''+ $(this).parent().find("div.edit_mid a").html() +'\'? This cannot be undone.', 'Delete Album', buttons );
   return false;
}

function delete_photo_album( obj ) 
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
	
$(document).ready( function() {
   $('body').delegate( '#cancel_button', 'click', close_confirm );
	$('.d_photos').click( confirm_delete_photo_album );
});
