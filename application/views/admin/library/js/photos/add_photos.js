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

var expand_flash_module = function( num )
{
   var newheight = 400 + ( ( num - 6 ) * 50 );
   $('#flashPanel').attr( 'height', newheight );
}

var back_to_edit_page = function( back_url )
{
   var argObj = { posturl : back_url };
   var buttons = {
      option1  :  { id : 'confirm_button', args: argObj, title : 'Continue', onConfirm : 'go_to_edit', class : 'light_blue_button' }
   }; 
   chi_confirm( 
      'The photos have been uploaded to your album!', 
      'Done Loading!', 
      buttons, 
      522 
   );
}; 

var go_to_edit = function ( obj )
{
   window.location = obj.posturl;
}

