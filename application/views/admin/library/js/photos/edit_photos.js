/**
 * 
 *
 * 
 *
 * 		I did this for the nine six. And we don't stop.
 *   	   Photo Functions for the edit page.
 *   
 *
 * 
 */

var confirm_delete_photo = function()
{
   var aid = $(this).parent().parent().attr( "aid" );
   var pid = $(this).parent().parent().attr( "pid" );
   var base = getBaseURL();
   var posturl = ( base + "/photos/remove_photo/" + pid + "/" + aid );
   var divId = $(this).parent().parent().attr( 'id' );
   var theImg = $(this).parent().parent().find( 'img' );
   var theImgSrc = theImg.attr( 'src' );
   var myArgs = { 
      url         : posturl,
      divId       : divId
   };
   var buttons = {
      option1  :  { id : 'cancel_button', title : 'Cancel', class : 'light_grey_button', onConfirm : 'close_confirm' },
      option2  :  { id : 'confirm_button', title : 'Delete', class : 'light_blue_button', onConfirm : 'delete_photo', args : myArgs }
   }; 
   chi_confirm( 'Delete this photo?', 'Delete Photo', buttons, 522, theImgSrc );
}

var delete_photo = function( obj )
{
   $.ajax({
		url: obj.url,
		type: 'POST',
      success: function(){
         $( '#' + obj.divId ).slideUp( 'slow' );
         close_confirm();
      }
	});
}

var confirm_make_cover = function()
{
   var aid = $(this).parent().parent().attr( "aid" );
   var pid = $(this).parent().parent().attr( "pid" );
   var base = getBaseURL();
   var posturl = ( base + "/photos/make_cover/" + pid + "/" + aid );
   var divId = $(this).parent().parent().attr( 'id' );
   var theImg = $(this).parent().parent().find( 'img' );
   var theImgSrc = theImg.attr( 'src' );
   var currCover = $('#photo_area').find( '.album_cover' );
   var currId = currCover.attr('id');
   var myArgs = { 
      url         : posturl,
      divId       : divId,
      currId      : currId
   };
   var buttons = {
      option1  :  { id : 'cancel_button', title : 'Cancel', class : 'light_grey_button', onConfirm : 'close_confirm' },
      option2  :  { id : 'confirm_button', title : 'Do It!', class : 'light_blue_button', onConfirm : 'make_album_cover', args : myArgs }
   }; 
   chi_confirm( 'Make this picture the album cover?', 'Change Album Cover', buttons, 522, theImgSrc );
}

var make_album_cover = function( obj )
{
   $.ajax({
		url: obj.url,
		type: 'POST',
      success: function(){
         $( '#' + obj.divId ).addClass( 'album_cover' );
         $( '#' + obj.currId ).removeClass( 'album_cover' );
         close_confirm();
      }
	});
}

$(document).ready( function() {
   $('.make_album_cover').click( confirm_make_cover );
   $('.delete_photo').click( confirm_delete_photo );
   var buttons = {
      option1  :  { id : 'cancel_button', title : 'Close', onConfirm : 'close_confirm', class : 'light_blue_button' }
   }; 
   var albumDiv = $('#edit_album_photos').children( 'div.album_cover' );
   var ad = obj_length( albumDiv );
   var page = getQueryString();
   if( page.search( 'update_photos')  == -1 && ad < 145 ) 
   {
      chi_confirm( 
         'You can set the album cover by clicking the <strong>grey check</strong> to the right of the photos.', 
         'Editing Tip', 
         buttons, 
         522, 
         'http://www.iamdjbunny.com/application/views/admin_images/edit_photos_tip.jpg' 
      );
   }
});
