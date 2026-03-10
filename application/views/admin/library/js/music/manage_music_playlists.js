/**
 * 		   I did this for the nine six. And we don't stop.
 *   	   ENTRY FUNCTIONS
 */



function confirm_delete_entry() 
{
   var did = $(this).parent().attr("id");
   var base = getBaseURL();
   var posturl = ( base + '/music/remove_playlist/' + did );
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
         onConfirm   : 'delete_playlist',
         class       : 'light_blue_button',
         args        : myArgs
      }
   }; 
   chi_confirm( 'Are you sure that you want to delete \''+ $(this).parent().find("div.edit_mid a").html() +'\'? This cannot be undone.', 'Delete Playlist', buttons );
}

function delete_playlist( obj ) 
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

var confirm_make_main = function()
{
   var mid = $(this).parent().parent().attr("id");
   var base = getBaseURL();
   var posturl = ( base + "/music/make_main_playlist/" + mid );

   var myArgs = { 
      url         : posturl,
      divId       : mid    
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
         title       : 'Do It!',
         onConfirm   : 'make_main',
         class       : 'light_blue_button',
         args        : myArgs
      }
   }; 
   chi_confirm( 'Make this the main playlist?', 'Change Playlist', buttons );
}

var make_main = function( obj )
{
    show_chi_loading();
    $.ajax({
        url: obj.url,
        type: 'POST',
        success: function( response ){
            // Update old text and class.
            $( '#edit_container' ).find( '.is_main_playlist span' ).html( 'make main playlist' );
            $( '#edit_container' ).find( '.is_main_playlist' ).removeClass( 'is_main_playlist' ).addClass( 'main_playlist' );
            // Update new text and class.
            $( '#' + obj.divId ).find( '.main_playlist span').html( 'main playlist' );
            $( '#' + obj.divId ).find( '.main_playlist' ).removeClass( 'main_playlist' ).addClass( 'is_main_playlist' );
            close_confirm();
        }
    });
}


$(document).ready( function() {
	$(  '.d_music' ).click( confirm_delete_entry );
    $( 'body' ).delegate( '.main_playlist span', 'click', confirm_make_main );
});
