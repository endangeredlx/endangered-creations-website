$(document).ready( function() {
	$('.d_comments').click( confirm_delete_entry );
    $('body').delegate( '.make_approval', 'click', make_approval );
    $('body').delegate( '.make_unapproved', 'click', make_unapproved );
});

var make_approval = function()
{
    var cid = $(this).parent().attr('id');
    var thebutton = $(this);
    var base = getBaseURL();
    $.ajax({
        url: base + '/comments/approve/' + cid,
        type: 'POST',
        success: function(){
            close_confirm();
            $( '#' + cid ).animate({ backgroundColor : '#ffffff' }, 600, function() {
                thebutton.removeClass('make_approval').addClass('make_unapproved');
                thebutton.attr('title', 'unapprove this comment');
                $('#' + cid ).removeClass('unapproved').addClass('approved');
                $('#' + cid ).find('.approval_state').html('approved');
            });
        }
    });
}

var make_unapproved = function()
{
    var cid = $(this).parent().attr('id');
    var thebutton = $(this);
    var base = getBaseURL();
    $.ajax({
        url: base + '/comments/unapprove/' + cid,
        type: 'POST',
        success: function(){
            close_confirm();
            $( '#' + cid ).animate({ backgroundColor : '#effbff' }, 600, function() { 
                thebutton.removeClass('make_unapproved').addClass('make_approval');
                thebutton.attr('title', 'approve this comment');
                $('#' + cid ).removeClass('approved').addClass('unapproved');
                $('#' + cid ).find('.approval_state').html('unapproved');
            });
        }
    });
}

var confirm_delete_entry = function() 
{
   var did = $(this).parent().attr("id");
   var base = getBaseURL();
   var posturl = ( base + "/comments/remove/" + did );
   var thisDiv = $(this).parent();
   var myArgs = { 
      url         : posturl,
      divId       : did    
   };
   var buttons = {
      option1  :  { id : 'cancel_button', title : 'Cancel', class : 'light_grey_button', onConfirm : 'close_confirm' },
      option2  :  { id : 'confirm_button', title : 'Delete', class : 'light_blue_button', onConfirm : 'delete_entry', args : myArgs }
   }; 
   chi_confirm( 'Are you sure that you want to delete this comment? This cannot be undone.', 'Delete Comment', buttons );
   return false;
}

var delete_entry = function( obj ) 
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
	
