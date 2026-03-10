// JavaScript Document
// {{{ var remove_resource = function()
var remove_resource = function()
{
    var elem = $(this);
    elem.remove();
}
// }}}
// {{{ var save_playlist = function()
var save_playlist = function()
{
   var iorder = [], dataObj = {};
   $('.listarea>div').each( function( i ) 
   {
      var tempObj = { "id" : $(this).attr( 'rid'), "order" : (i+1) };
      iorder.push( tempObj );
   });
   
   dataObj.data = iorder;
   dataObj.num = iorder.length;
   dataObj.name = $('#title').val();
   dataObj.id = $('#playlist_id').val();

   if( dataObj.name == '' )
   {
       var buttons = {
          option1  :  { id : 'cancel_button', title : 'Ok', class : 'light_blue_button', onConfirm : 'close_confirm' }
       }; 
       chi_confirm( 'Please provide a playlist name.', 'Playlist Name', buttons );
   }
   else
   {
       var base = getBaseURL();
       $.ajax({  
           type: "POST",  
           url: base + "/music/update_playlist/",  
           data: dataObj,  
           success: function(data) {  
               if( data == 'success' )
               {
                   var buttons = {
                      option1  :  { id : 'cancel_button', title : 'Continue', class : 'light_blue_button', onConfirm : 'close_confirm' }
                   }; 
                   chi_confirm( 'Changes saved.', 'Saved', buttons );
               }
                else
                {
                    alert('something went wrong');
                }
           }  
       }); 
   }
}
// }}}

$(document).ready( function() {
    $('.listarea').sortable({});
    $('.resource_list .resource').draggable({
        connectToSortable: '.listarea',
        helper : 'clone'
    });
    $('body').delegate( '.listarea .resource', 'dblclick', remove_resource );
    $('#save_playlist').click( save_playlist );
});
