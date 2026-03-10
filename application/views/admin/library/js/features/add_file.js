/**
 * 
 *
 * 
 *
 * 		I did this for the nine six. And we don't stop.
 *   	   Features functions for the photo upload page.  
 *   
 *
 * 
 */

var back_to_edit_page = function( back_url )
{
   var argObj = { posturl : back_url };
   var buttons = {
      option1  :  { id : 'confirm_button', args: argObj, title : 'Continue', onConfirm : 'go_to_edit', class : 'light_blue_button' }
   }; 
   chi_confirm( 
      'The photo is done loading. Click below to continue.', 
      'Done Loading!', 
      buttons, 
      522 
   );
}; 

var go_to_edit = function ( obj )
{
   window.location = obj.posturl;
}
