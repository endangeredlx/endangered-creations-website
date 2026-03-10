/**
 *
 * 		I did this for the nine six. And we don't stop.
 * 		Functions for the file upload page.
 * 
 */

var back_to_edit_page = function( back_url, upload_type )
{
   var argObj = { posturl : back_url };
   var buttons = {
      option1  :  { id : 'confirm_button', args: argObj, title : 'Continue', onConfirm : 'go_to_edit', class : 'light_blue_button' }
   }; 
   chi_confirm( 
      'The ' + upload_type + ' is done loading. Continue editing.', 
      'Done Loading!', 
      buttons, 
      522 
   );
}; 

var go_to_edit = function ( obj )
{
   window.location = obj.posturl;
}
