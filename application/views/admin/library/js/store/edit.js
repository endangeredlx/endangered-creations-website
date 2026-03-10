// {{{ var add_more_choices = function()
var add_more_choices = function()
{
    var addition = '<input type="text" class="add_item_choice" value="Enter a name for this choice" />';
    addition += '<div class="add_choice_submit">add</div>';
    addition += '<div class="remove_choice_submit">remove</div>';
    $(this).parent().after( addition );
}
// }}}
// {{{ var clear_choice = function()
var clear_choice = function()
{
    var curr = $(this).val();
    var new_val = ( curr == "Enter a name for this choice" ) ? '' : curr;
    $(this).val( new_val );
}
// }}}
// {{{ var repop_choice = function()
var repop_choice = function()
{
    var curr = $(this).val();
    var new_val = ( curr == "" ) ? 'Enter a name for this choice' : curr;
    $(this).val( new_val );
}
// }}}
// {{{ var clear_option = function()
var clear_option = function()
{
    var curr = $(this).val();
    var new_val = ( curr == "Add New Option..." ) ? '' : curr;
    $(this).val( new_val );
}
// }}}
// {{{ var repop_option = function()
var repop_option = function()
{
    var curr = $(this).val();
    var new_val = ( curr == "" ) ? 'Add New Option...' : curr;
    $(this).val( new_val );
}
// }}}
// {{{ var create_choice = function()
var create_choice = function() 
{
    // Grab all the needed references and information
    var choice_input = $(this).parent().find('.add_item_choice');
    var new_choice = choice_input.val();
    var add_button = $(this);
    var remove_button = $(this).parent().find('.remove_choice_submit');
    // Remove the buttons
    add_button.remove();
    remove_button.remove();
    // Create the new choice
    var choice_div = '<div class="item_option_value">';
    choice_div += '<span>' + new_choice + '</span>';
    choice_div += '<div class="remove_item closex" title="delete choice"></div>';
    choice_div += '</div>';
    choice_input.after( choice_div );
    choice_input.remove();
}
// }}}
// {{{ var remove_empty_choice = function()
var remove_empty_choice = function() 
{
    // Grab all the needed references and information
    var choice_input = $(this).parent().find('.add_item_choice');
    var remove_button = $(this);
    var add_button = $(this).parent().find('.add_choice_submit');
    // Remove the buttons
    add_button.remove();
    remove_button.remove();
    choice_input.remove();
}
// }}}
// {{{ var remove_choice = function()
var remove_choice = function()
{
    $(this).parent().remove();
}
// }}}
// {{{ var remove_option = function()
var confirm_remove_option = function()
{
    
    var funcArgs = {
        divId : $(this).parent().parent().attr('id')
    };
    var buttons = {
        option1  :  { id : 'cancel_button', title : 'Cancel', class : 'light_grey_button', onConfirm : 'close_confirm' },
        option2  :  { id : 'proceed_button', title : 'Delete', class : 'light_blue_button', onConfirm : 'remove_option', args : funcArgs }
    }; 
    chi_confirm( 'Delete this option? Keep in mind the option isn\'t fully deleted until you click save.', 'Delete Option', buttons );
}
// }}}
// {{{ var remove_option = function()
var remove_option = function( args )
{
    close_confirm();
    $('#' + args.divId ).remove();
    update_option_order();
}
// }}}
// {{{ var update_option_order = function()
var update_option_order = function()
{
    $('.item_option_container .item_option_editors').each( function( i ){
       $(this).find('label').first().html( ordinal( i ) + ' Option' ); 
    });
}
// }}}
// {{{ var add_new_option = function()
var add_new_option = function()
{
    var new_option = $('#option_clone').clone( true );  
    var new_name = $(this).parent().find('#new_option').val();
    new_option.attr('style', '');
    new_option.find('.item_option_editors .item_option').val( new_name );
    new_option.attr('id', '77');
    $('#option_clone').after( new_option );
    update_option_order();
}
// }}}
// {{{ var form_submit = function()
var form_submit = function()
{
    // A bit of validation. We make sure that the options have at least
    // a name and one choice. 
    var errors = [];
    var hidden = '';
    var num_options = 0;
    $('.item_option_container .item_option_editors').each( function( i ){
        if( $(this).parent().attr('id') != 'option_clone' )
        {
            var id = $(this).find('.item_option').attr('id');
            var name = $(this).find('.item_option').val();
            if( name == '' ) errors.push( '<p class="save_error">The ' + ordinal( i ) + ' option doesn\'t have a name. Enter a name or delete the option.</p>' );
            else hidden += create_hidden_element( 'option_' + i + '_name', name ); 
            hidden += create_hidden_element( 'option_' + i + '_id', id ); 
            var options = $(this).find('.item_option_value');
            if( options.length < 1 ) errors.push( '<p class="save_error">The ' + ordinal( i ) + ' option doesn\'t have any choices. Add choices or delete the option.</p>' ); 
            else options.each(function( j ){ hidden += create_hidden_element( 'option_' +  i  + '_choice_' + ( j + 1 ), $(this).find('span').html() );  });
            hidden += create_hidden_element( 'option_' + i + '_num_choices', options.length );
            num_options++;
        }
    });

    if( $('#title').val() == "" ) errors.push( '<p class="save_error">You must provide a title.</p>' ); 
    if( $('#price').val() == "" ) errors.push( '<p class="save_error">You must provide a price.</p>' ); 

    hidden += create_hidden_element( 'num_options', num_options ); 

    if( errors.length > 0 )
    {
        var error_message = errors.join('');
        var buttons = {
            option1  :  { id : 'cancel_button', title : 'Ok', class : 'light_blue_button', onConfirm : 'close_confirm' }
        }; 
        chi_confirm( 'Error : ' + error_message, 'Errors', buttons );
        return false;
    }
    else
    {
        $(this).before( hidden );
    }
}
// }}}

$(document).ready(function(){
    // Stop us from leaving if there is an error in the javascript
    /*window.onbeforeunload = function(){ return 'false'; };*/

    // Basic Functionality 
    $('.add_more_choices').click( add_more_choices );
    $('.add_option_container .new_option').focus( clear_option );
    $('.add_option_container .new_option').blur( repop_option );
    $('#add_new_option').click( add_new_option );

    // Validate and Submit Form
    $('#form_submit').click( form_submit );

    // Delegations
    $('body').delegate('.item_option_editors .add_item_choice', 'focus', clear_choice );
    $('body').delegate('.item_option_editors .add_item_choice', 'blur', repop_choice );
    $('body').delegate('.item_option_editors .add_choice_submit', 'click', create_choice );
    $('body').delegate('.item_option_editors .remove_choice_submit', 'click', remove_empty_choice );
    $('body').delegate('.item_option_value .remove_item', 'click', remove_choice );
    $('body').delegate('.remove_option .remove_button', 'click', confirm_remove_option );
});
