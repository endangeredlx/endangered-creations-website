var check_for_save = function()
{
    // If you're leaving the creation page and you haven't saved, we remind you.
    if( $('input[name=form_submitted]').val() == 'false' && $('#edit_content h2').html().substring(0,6) == 'Create' )
    {
        return 'You may not have saved.';
    }
};

var form_submit = function()
{
    $('input[name=form_submitted]').val( 'true' );
}

var save_first = function()
{
   var buttons = {
      option1  :  { id : 'cancel_button', title : 'Ok', class : 'light_blue_button', onConfirm : 'close_confirm' }
   }; 

   chi_confirm( 'You need to Save at least once before you do that!', 'Save First', buttons );
   return false;
}
$(document).ready(function(){
    window.onbeforeunload = check_for_save;
    $('#form_submit').click( form_submit ); 
    $('.create').click( save_first );
});
