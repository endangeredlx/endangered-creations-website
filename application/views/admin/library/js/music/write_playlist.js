// JavaScript Document

var remove_resource = function()
{
    var elem = $(this);
    elem.remove();
}

var continue_save = function()
{
   var iorder = [], dataObj = {};
   $('.listarea>div').each( function( i ) 
   {
      var tempObj = { "id" : $(this).attr( 'rid'), "order" : (i+1) };
      iorder.push( tempObj );
   });

   if( iorder.length < 1 )
   {
       var base = getBaseURL();
       var buttons = {
          option1  :  { id : 'cancel_button', title : 'Ok', class : 'light_blue_button', onConfirm : 'close_confirm' }
       }; 
       chi_confirm( 'Drag songs from the list on the lest to the playlist to the right!', 'You Haven\'t Added Any Songs!', buttons );
   }
   else
   {
       $('.list_drag').fadeOut('1000');
       $('#continue').fadeOut('1000', function () { 
           $('.continue_playlist').fadeIn('1000', function() { 
               $('#title').focus();
           });
       });
   }
}

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
           url: base + "/music/create_playlist",  
           data: dataObj,  
           success: function(data) {  
               if( data == 'success' )
               {
                   var buttons = {
                      option1  :  { id : 'cancel_button', title : 'Continue', class : 'light_blue_button', onConfirm : 'back_to_music' }
                   }; 
                   chi_confirm( 'The playlist was successfully created.', 'Playlist Created!', buttons );
               }
                else
                {
                    alert('something went wrong');
                }
           }  
       }); 
   }
}

var back_to_music = function()
{
    var base = getBaseURL();
    window.location = base + '/music/manage/playlists'; 
}

$(document).ready( function() {
    $('.listarea').sortable({});
    $('.resource').draggable({
        connectToSortable: '.listarea',
        helper : 'clone'
    });
    $('body').delegate( '.listarea .resource', 'dblclick', remove_resource );
    $('#continue').click( continue_save );
    $('body').delegate( '#save_playlist', 'click', save_playlist );
});
