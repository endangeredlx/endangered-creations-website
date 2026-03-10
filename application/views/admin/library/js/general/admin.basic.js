/**
 *
 * 		I did this for the nine six. And we don't stop.
 *   	BASIC FUNCTIONS - To be used for and in all 
 *		modules on the site. 
 * 
 */
// {{{ Function.prototype.defaults = function()
/*
 * Allows functions to accept default arguments
 *
 * There are certain situations in which javascript programs will need default
 * arguments. This function allows us to write programs like :
 * var foo = function( a, b )
 * {
 *    doStuff( a, b );
 * }.defaults( c, d );
 *
 * This sometimes makes life easier
 */
Function.prototype.defaults = function()
{
  var _f = this;
  var _a = Array(_f.length-arguments.length).concat(
    Array.prototype.slice.apply(arguments));
  return function()
  {
    return _f.apply(_f, Array.prototype.slice.apply(arguments).concat(
      _a.slice(arguments.length, _a.length)));
  }
}
// }}}
// {{{ var chi_confirm = function()
/*
 * Code for revealing and positioning the custom chi alert/dialog window
 */
var chi_confirm = function( message, title, buttons, width, image )
{
   var pop_dialog = $("#popup_dialog");
   var big_div = pop_dialog.parent().parent();
   // Position the dialog.
   pop_dialog.css( 'width', width );
   big_div.css( 'margin-left', (width/2*-1) );
   // Set the title.
   $('#dialog_title').html( title );
   var control_html = "";
   // Cycle through the buttons and add them to the bottom.
   for( option in buttons )
   {
      control_html += '<a id="' + buttons[option].id + '"';
      control_html += ( buttons[option].onConfirm != 'undefined' ) ? ' onclick="' + buttons[option].onConfirm + '(' : '';
      if( obj_length( buttons[option].args ) != 0 )
      {
         control_html += '{';
         var argarray = [];
         for( a in buttons[option].args )
         {
            argarray.push( a + ':\'' + buttons[option].args[a] + '\'');
         }
         control_html += argarray.join(',') + '}';
      }
      control_html += ')"';
      control_html += ( buttons[option].class != 'undefined' ) ? ' class="' + buttons[option].class + '"': '';
      control_html += '>' + buttons[option].title + '</a>';
   } 
   $('#popup_controls').html( control_html );
   var num_args = [];
   if( image == 'none' )
   {
      $("#dialog_content").html( '<p class="popup_centered">' + message + '</p>' );
   }
   else 
   {
      $("#dialog_content").html( '<p class="popup_right"><img src="' + image + '" class="left" />' + message + '</p>' );
   }
   // When its all said and done reveal the dialog.
   big_div.show();
}.defaults( 'No Message.', 'Alert', {}, 522, 'none' );
// }}} 
// {{{ var chi_confirm = function()
/*
 * Code for revealing and positioning the custom chi alert/dialog window
 */
var show_chi_loading = function()
{
   var pop_dialog = $("#dialog_content p");
   var loading_text = '<p class="save_error">loading...</p>';
   var loading_gif = '<img class="chi_loading" src="' + getBaseURL() + '/application/views/admin/library/js/prettyPhoto/images/prettyPhoto/light_square/loader.gif" />';
   pop_dialog.html( loading_text + loading_gif );
}
// }}} 
// {{{ var obj_length = function( obj )
var obj_length = function( obj )
{
   var length = 0;
   for( o in obj ) length++;
   return length;
}
// }}}
// {{{ var close_confirm = function()
var close_confirm = function()
{
   var big_div = $('#dialog_wrapper');
   big_div.fadeOut('slow');
}
// }}}
// {{{ var stripUI = function( string )
var stripUI = function( string )
{
	var ns = string.substr(5);
	ns = ns.split("\"");
	return ns[0];
}
// }}}
// {{{ var getBaseURL = function()
var getBaseURL = function()
{
    // Check to see if we've been given the BaseURL
    if( window.ChiBaseURL === undefined )
    {
        // If not, make a decent guess based on the url.
        var url = location.href;  // entire url including querystring - also: window.location.href;
        // We'll use these variable to decide if the url contains these fragments, as they'll help us make our guess.
        var local = url.search( 'localhost' );
        var remote = url.search( '.com' );
        // If it's remote server we just assume the base url is the domain name.
        // ex : 'http://yourdomain.com'
        // There's a chance this may be wrong, because chi may have been installed
        // into a specific directory so it may be something like http://yourdomian.com/blog
        if( remote && !local )
        {
            var baseURL = url.substring(0, url.indexOf('/', 14));
            return baseURL;
        }
        else 
        {
            var baseURL = url.substring(0, url.indexOf('/', 17));
            return baseURL;
        }
    }
    // If we have the ChiBaseURL variable, we just return it!
    else
    {
        return ChiBaseURL;
    }

    return baseURL;
}   
// }}}
// {{{ var getQueryString = function()
var getQueryString = function()
{
   var url = location.href;  // entire url including querystring - also: window.location.href;
   var queryString = url.substring( url.indexOf( '/', 14 ) );
   return queryString;
}
// }}}
// {{{ var drop_down = function ()
var drop_down = function() 
{ 
	$(this).parent().find("ul.sub_menu").slideDown('fast').show();
	$(this).parent().hover(
		function() { }, 
		function() { $(this).parent().find("ul.sub_menu").slideUp('slow'); }
	);
}
// }}}
// {{{ var clear_me = function()
var clear_me = function(element)
{
	var elem = "#"+element.id;
	if( $(elem).val() == element.id ) {
		$(elem).val("");
	}
}
// }}}
// {{{ var submit_form = function( elem )
var submit_form = function(elem) 
{
	elem.submit();	
}
// }}}
// {{{ var ordinal = function( num )
// Returns values such as 1st, 2nd, and 3rd when given 1, 2, or 3.
var ordinal = function( num )
{
    if( ![11,12,13].has( num ) )
    {
        switch( num%10 )
        {
            case 1  : return num + 'st';
            case 2  : return num + 'nd';
            case 3  : return num + 'rd';
        }
    }
    return num + 'th';
}
// }}}
// {{{ Array.prototype.has = function(obj)
// Tests to see if a given value is in the array
Array.prototype.has = function(obj) {
  return this.indexOf(obj) >= 0;
} 
// }}}
// {{{ Array.prototype.indexOf = function(obj)
Array.prototype.indexOf = function(obj) {
  for (var i = 0; i < this.length; i++) {
    if (this[i] == obj)
      return i;
  }
  return -1;
}
// }}}
// {{{ var create_hidden_element( name, value )
var create_hidden_element = function( name, value )
{
    return '<input type="hidden" name="' + name + '" value="' + value + '" />';    
}
// }}}

