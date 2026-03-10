/**
 * 
 *
 * 
 *
 * 		I did this for the nine six. And we don't stop.
 *   	   Music Functions for the music cover art upload page.
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
      'The cover art file is done loading. Continue and add more details to the song!', 
      'Done Loading!', 
      buttons, 
      522 
   );
}; 

var go_to_edit = function ( obj )
{
   window.location = obj.posturl;
}
