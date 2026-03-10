// JavaScript Document

var confirm_delete_entry_photo = function()
{
    var did = $(this).attr("e_id");
    var base = getBaseURL();
    var posturl = ( base + "/entries/delete_photo/" + did );
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
            onConfirm   : 'delete_entry_photo',
            class       : 'light_blue_button',
            args        : myArgs
        }
    }; 
    chi_confirm( 'Delete the main photo?', 'Delete Photo?', buttons );
}

var delete_entry_photo = function( obj ) 
{				   
    close_confirm();
    $.ajax(
    {
        url: obj.url,
        type: 'POST',
        success: function() 
        {
            var holder = $('#photo_info_holder');
            $('#delete_entry_photo').fadeOut('slow');
            holder.fadeOut('slow', function() {
                $('#photo_edit_button').html('<strong>Add Photo</strong>');
                holder.html( '<i>No Image.</i>'); 
                holder.fadeIn('slow');
            });
        }
    });
}

var delete_entry_photo = function( obj ) 
{				   
   close_confirm();
   $.ajax(
   {
      url: obj.url,
      type: 'POST',
      success: function() 
      {
         var holder = $('#photo_info_holder');
         $('#delete_entry_photo').fadeOut('slow');
         holder.fadeOut('slow', function() {
            $('#photo_edit_button').html('<strong>Add Photo</strong>');
            holder.html( '<i>No Image.</i>'); 
            holder.fadeIn('slow');
         });
      }
   });
}

$(document).ready( function() {
    tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
        theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "none",

        // Style formats
        style_formats : [
            { title : 'Bold text', inline : 'b'},
            { title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
            { title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
            { title : 'Example 1', inline : 'span', classes : 'example1'},
            { title : 'Example 2', inline : 'span', classes : 'example2'},
            { title : 'Table styles'},
            { title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
        ],

        formats : {
            alignleft : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'left'},
            aligncenter : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'center'},
            alignright : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'right'},
            alignfull : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'full'},
            bold : {inline : 'span', 'classes' : 'bold'},
            italic : {inline : 'span', 'classes' : 'italic'},
            underline : {inline : 'span', 'classes' : 'underline', exact : true},
            strikethrough : {inline : 'del'}
        },

    });

    $( 'body' ).delegate( '#cancel_button', 'click', close_confirm );
    $( '#delete_entry_photo' ).click( confirm_delete_entry_photo );
});
