/**
 * 
 *
 * 
 *
 * 		I did this for the nine six. And we don't stop.
 *   	   Feature functions for the manage page.
 *   
 *
 * 
 */



function confirm_delete_entry() 
{
   var did = $(this).parent().attr("id");
   var base = getBaseURL();
   var posturl = ( base + "/clients/remove/" + did );
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
         onConfirm   : 'delete_features_entry',
         class       : 'light_blue_button',
         args        : myArgs
      }
   }; 
   chi_confirm( 'Are you sure that you want to delete \''+ $(this).parent().find("div.edit_long a").html() +'\'? This cannot be undone.', 'Delete Client', buttons );
}

function delete_features_entry( obj ) 
{
   $.ajax({
		url: obj.url,
		type: 'POST',
      success: function(){
         $( '#' + obj.divId ).slideUp('slow').hide();
         close_confirm();
      }
	});
}
	
function delete_entry_photo() 
{				   
/*		$.ajax(
		{
			url: "index.php?admin/delete_entry_photo/" + e_id,
			type: 'POST',
			success: function() 
			{
				the_image.fadeOut('slow').hide();
				$('#photo_edit_button').html('Add Photo');
				$(this_item).fadeOut('slow').hide();
			}
		});*/
}


$(document).ready( function() {
	$('.d_clients').click( confirm_delete_entry );
});
