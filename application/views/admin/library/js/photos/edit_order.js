// JavaScript Document
//


var update_order = function()
{
   $('#results .saved').hide();
   $('#results .saving').fadeIn('fast');
   var iorder = [], dataObj = {};
   $('#photo_area>div').each( function( i ) 
   {
      var tempObj = { "id" : $(this).attr( 'pid'), "order" : (i+1) };
      iorder.push( tempObj );
   });
   dataObj.data = iorder;
   dataObj.num = iorder.length;
   var base = getBaseURL();
   $.ajax({  
      type: "POST",  
      url: base + "/photos/change_order",  
      data: dataObj,  
      success: function(data) {  
         $('#results .saving').fadeOut('fast');
         $('#results .saved').fadeIn('fast');
         setTimeout( "$('#results .saved').fadeOut('slow');", 3000);
      }  
   }); 
}

$(document).ready( function() {
   $('#photo_area').sortable({
      update: update_order
   });
});
