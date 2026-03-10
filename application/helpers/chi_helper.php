<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// {{{ COMMENTS
/**
 * Chi :: Content Handling Interface
 *
 * A content publishing platform.
 *
 * @package		Code Igniter
 * @author		Dennis "Mars" Porter for Martian Theory
 * @copyright	Copyright (c) 2010-2011, Martian Theory, Inc.
 * @license		http://martiantheory.com/chi/user_guide
 * @link		   http://martiantheory.com/chi
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Chi Helpers
 * 
 * These helpers retrieve information about entry records simply and through semantic functions.
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Dennis "Mars" Porter for Martian Theory
 * @link		   http://martiantheory.com/chi/help
 */
// }}}

// {{{ GLOBALS
$counter = 0;
$chiglob = array();
// }}}
// {{{ function global_presentation()
// References to the main global objects.
function global_presentation()
{
   return $GLOBALS['CI']->load->_ci_cached_vars['presentation'];
}
// }}}
// {{{ function global_records()
function global_records()
{
   return $GLOBALS['CI']->load->_ci_cached_vars['records'];
}
// }}}
// {{{ global_options()
function global_options()
{
    return $GLOBALS['CI']->load->_ci_cached_vars['options'];

}
// }}}
// --- OPTIONS HELPERS --- //
// {{{ option_value()
// Option Value | Returns the value of any given option for the current user.
function option_value( $name )
{
    $options =& global_options();
    return $options->option_value( $name );
}
// }}}
// {{{ Site Option Value | Returns the value of any given option for the current user.
function site_option_value( $name )
{
    $options =& global_options();
    return $options->option_value( $name );
}
// }}}
// {{{ captcha_required()
function captcha_required()
{
    $options =& global_options();
    $captcha_required = $options->option_value( 'comment_captcha' );
    return ( $captcha_required == '1' ) ? true : false;
}
// }}}
// {{{ safe_url()
// Safe Url | Returns the base url for the site. Checks to see if we're using an .htaccess file as well.
function safe_url()
{
   $options =& $GLOBALS['CI']->load->_ci_cached_vars['options'];

   $base = base_url();
 
   if( $options->htaccess() == '0' ) 
   {
      return $base . 'index.php?';
   }
   else 
   {
      return $base;
   }
}
// }}}
// {{{ function get_featured_videos()
function get_featured_videos()
{
    $options =& global_options();
    $fv = $options->option_value( 'featured_videos' );
    $jsfv = json_decode( $fv );
    return $jsfv;
}
// }}}
// --- GENERAL UTILITIES --- //
// {{{ theme_relative_path()
// Relative Theme Path | Retrieves relative theme path from the 'ROOT/applications/views' folder.
function theme_relative_path()
{
   // Create reference to the global records array. 
   $chipresentation =& global_presentation();  

   // return the relative path
   return $chipresentation->theme_relative_path();   
}
// }}}
// {{{ theme_path()
// Theme Path | Retrieves the absolute theme path.
function theme_path()
{
   // Create reference to the global records array. 
   $chipresentation =& global_presentation();  

   // return the relative path
   return $chipresentation->theme_path();   
}
// }}}
// {{{ there_are_stylesheets()
// There Are Stylesheets | Checks to see if there are stylesheet available to be displayed.
function there_are_stylesheets()
{
   $chipresentation =& global_presentation();

   //returns boolean value
   return $chipresentation->there_are_stylesheets();
}
// }}}
// {{{ get_stylesheet()
// Get Stylesheet | Sets up the next available stylesheet.
function get_stylesheet()
{
   $chipresentation =& global_presentation();

   //doesn't return anything.
   $chipresentation->get_stylesheet();
}
// }}}
// {{{ stylesheet()
// Stylesheet | Retrieves the css needed to display the page.
function stylesheet()
{
   $chipresentation =& global_presentation();

   //return the css array.
   return $chipresentation->stylesheet();
}
// }}}
// {{{ there_are_scripts()
// There Are Scripts | Checks to see if there are scripts needed for this page.
function there_are_scripts()
{
   $chipresentation =& global_presentation();

   //returns boolean value
   return $chipresentation->there_are_scripts();
}
// }}}
// {{{ get_script()
// Get Script | Sets up the next available script.
function get_script()
{
   $chipresentation =& global_presentation();

   //doesn't return anything.
   $chipresentation->get_script();
}
// }}}
// {{{ script()
// Script | Retrieves the javascript needed to make the page behave properly.
function script()
{
   $chipresentation =& global_presentation();

   //return the css array.
   return $chipresentation->script();
}
// }}}
// {{{ sidebar()
// Grabs the sidebar.php file and puts it where ever this function is called.
function sidebar()
{
   $chipresentation =& global_presentation();
   $GLOBALS['CI']->load->view( $chipresentation->theme_relative_path() . 'general/sidebar' );
}
// }}}
// {{{ function ordinal( $num )
function ordinal( $num ) 
{
    if( !in_array( ( $num % 100 ),array(11,12,13) ) )
    {
        switch( $num % 10 ) 
        {
            // Handle 1st, 2nd, 3rd
            case 1:  return $num.'st';
            case 2:  return $num.'nd';
            case 3:  return $num.'rd';
        }
    }
    return $num.'th';
}
// }}}
// {{{ function is_relative()
function is_relative()
{
    $chiql =& global_records();
    return $chiql->is_relative();
}
// }}}
// {{{ function relative()
function relative( $label )
{
    $chiql =& global_records();
    return $chiql->relative( $label );
}
// }}}
// {{{ function tab( $n = 1 )
function tab( $n = 1 )
{
    $ret = "";
    for( $i = 0; $i < $n; $i++ )
    {
        $ret .= "\t";
    }
    return $ret;
}
// }}}
// {{{ function newline( $n = 1 )
function newline( $n = 1 )
{
    $ret = "";
    for( $i = 0; $i < $n; $i++ )
    {
        $ret .= "\n";
    }
    return $ret;
}
// }}}
// {{{ function tag( $tag, $info )
function tag( $tag, $info )
{
   if( $tag != 'cdata' )
   {
       return '<' . $tag . '>' . $info . '</' . $tag . '>';
   }
   else
   {
       return '<![CDATA[' . $info . ']]>';
   }
}
// }}}
// --- FEATURE HELPERS --- //
// {{{ function there_are_features()
/**
 *
 * Checks the global $record object to see if it contains features
 *
 * @access	public
 * @return	boolean
 */	
function there_are_features()
{
   $chiql =& global_records();  
   //Check to see if there are records available.
   if( $chiql->number_of_features()  != 0 )
   {
      //Check to see if we are currently in the loop.
      return $chiql->features_looping();
   }
   else
   {
      return false;
   }
}
// }}}
// {{{ function next_feature()
/**
 * Get Next
 *
 * Returns the title of the current entry.
 *
 * @access	public
 * @return	string
 */	
if ( ! function_exists( 'next_feature' ) )
{
	function next_feature()
	{
      $chiql =& global_records(); 
      $chiql->set_next_available_feature();      
	}
}
// }}}	
// {{{ function number_of_features()
/**
 * Name of function
 *
 * Description
 *
 * @return value
 */	
if ( ! function_exists( 'number_of_features' ) )
{
	function number_of_features()
	{
      //Create reference to the global features array. 
      $chiql =& global_features();  

      //Return the number of features available.
      return $chiql->number_of_features();
	}
}
// }}}	
// {{{ function feature_pic()
function feature_pic()
{
    $chiql =& global_records();
    $img = $chiql->feature_value( 'pic' );
    return base_url() . 'images/features/' . $img;
}
// }}}
// {{{ function feature_title()
function feature_title()
{
    $chiql =& global_records();
    return $chiql->feature_value( 'title' );
}
// }}}
// {{{ function feature_subtitle()
function feature_subtitle()
{
    $chiql =& global_records();
    return $chiql->feature_value( 'content' );
}
// }}}
// {{{ function feature_link()
function feature_link()
{
    $chiql =& global_records();
    return $chiql->feature_value( 'link' );
}
// }}}
// {{{ function first_feature()
function first_feature()
{
    $chiql =& global_records();
    if( $chiql->features_position() == 0 ) 
    {
        return true;
    }
    else
    {
        return false;
    }
}
// }}}
// --- PAGE HELPERS --- // 
// {{{ function there_are_pages()
/**
 *
 * Checks the global $record object to see if it contains pages
 *
 * @access	public
 * @return	boolean
 */	
function there_are_pages()
{
   $chiql =& global_records();  
   //Check to see if there are records available.
   if( $chiql->number_of_pages()  != 0 )
   {
      //Check to see if we are currently in the loop.
      return $chiql->page_looping();
   }
   else
   {
      return false;
   }
}
// }}}
// {{{ function next_page()
/**
 * Get Next
 *
 * Returns the title of the current entry.
 *
 * @access	public
 * @return	string
 */	
if ( ! function_exists( 'next_page' ) )
{
	function next_page()
	{
      $chiql =& global_records(); 
      $chiql->set_next_available_page();      
	}
}
// }}}	
// {{{ function page_title()
/**
 * Title
 *
 * Returns the title of the current page.
 *
 * @access	public
 * @return	string
 */	
function page_title()
{
   $chiql =& global_records();  
   return $chiql->page_row_value( 'title' );
}
// }}}
// {{{ function page_id()
/**
 * Get Page ID
 *
 * Grabs ID number for the current page.
 *
 * @return value
 */	
if ( ! function_exists( 'page_id' ) )
{
	function page_id()
	{
      $chiql =& global_records(); 
      return $chiql->page_row_value( 'id' );      
	}
}
// }}}
// {{{ function page_name()
/**
 * Name of page
 *
 * Description
 *
 * @return value
 */	
if ( ! function_exists( 'page_name' ) )
{
	function page_name()
	{
      $chiql =& global_records(); 
      return $chiql->page_row_value( 'name' );      
	}
}
// }}}
// --- RECORD HELPERS --- //
// {{{ function there_are_entries()
/**
 *
 * Checks the global $record object to see if it contains entries
 *
 * @access	public
 * @return	boolean
 */	
function there_are_entries()
{
   $chiql =& global_records();  

   //Check to see if there are records available.
   if( $chiql->number_of_records()  != 0 )
   {
      //Check to see if we are currently in the loop.
      return $chiql->looping();
   }
   else
   {
      return false;
   }
}
// }}}
// {{{ function title()
/**
 * Title
 *
 * Returns the title of the current entry.
 *
 * @access	public
 * @return	string
 */	
function title()
{
   $chiql =& global_records();  
   return $chiql->row_value( 'title' );
}
// }}}
// {{{ function archives()
function archives()
{
   $chiql =& global_records();  
   return $chiql->get_archives();
}
// }}}
// {{{ function links()
function links()
{
   $chiql =& global_records();  
   return $chiql->get_links();
}
// }}}
// {{{ function subtitle()
/**
 * SubTitle
 *
 * Returns the subtitle of the current entry.
 *
 * @access	public
 * @return	string
 */	
function subtitle()
{
   $chiql =& global_records();  
   return $chiql->row_value( 'subtitle' );
}
// }}}
// {{{ function status()
function status()
{
    $chiql =& global_records();
    return $chiql->row_value( 'status' );
}
// }}}
// {{{ function likes()
function likes()
{
    $chiql =& global_records();
    return $chiql->row_value( 'like' );
}
// }}}
// {{{ function dislikes()
function dislikes()
{
    $chiql =& global_records();
    return $chiql->row_value( 'dislike' );
}
// }}}
// {{{ function row_value()
function row_value( $label )
{
   $chiql =& global_records();  
   return $chiql->row_value( $label );
}
// }}}
// {{{ function entry_category()
function entry_category()
{
   $chiql =& global_records();  
   return $chiql->entry_category();
}
// }}}
// {{{ function has_pic()
/**
 * Has Image
 *
 * Checks to see if current post has an image.
 *
 * @return Boolean
 */	
function has_pic()
{
   //Create reference to the global records array. 
   $chiql =& global_records();  

   //Return the number of records available.
   return $chiql->has_pic();
}
// }}}
// {{{ function pic()
/**
 * Record Image
 *
 * Returns the main image for the current entry.
 *
 * @access	public
 * @return	string
 */	
if ( ! function_exists('pic'))
{
	function pic()
	{
      $chiql =& global_records();  
      return $chiql->get_current_pic();
	}
}
// }}}
// {{{ function has_video()
/**
 * Has Video
 *
 * Checks to see if current post has an video.
 *
 * @return Boolean
 */	

if ( ! function_exists( 'has_video' ) )
{
	function has_video()
	{
      //Create reference to the global records array. 
      $chiql =& global_records();  

      //Return the number of records available.
      return $chiql->has_video();
	}
}
// }}}
// {{{ video()
/**
 * Record Video
 *
 * Returns the main video for the current entry.
 *
 * @access	public
 * @return	string
 */	
if ( ! function_exists('video'))
{
	function video( $w = 620, $h = 270, $c = "" )
	{
      $chiql =& global_records();  
      return $chiql->get_current_video( $w, $h, $c );
	}
}
// }}}	
// {{{ function create_video( $link, $w, $h, $color = 'ffffff' )
function create_video( $link, $w = 500, $h = 250, $color = 'ffffff' )
{
    $video = get_video( $link );
    if( $video ) 
    {
      $chiql =& global_records(); 
      return $chiql->make_video( $video['video_type'], $video['video'], $w, $h, $color );      
    }
}
// }}}
// {{{ function get_video( $link )
function get_video( $link )
{
    // WorldStar
    if( preg_match( '/^(((https?):\/\/(www\.)?)|(www\.))?(worldstarhiphop\.com)(\/videos\/video\.php\?v=)([a-zA-Z0-9]+)$/', $link, $matches ) )
    {
        $data = array(
            'video_type'        => 'worldstarhiphop',
            'video'             => $matches[8]
        );
        return $data;
    }        
    if( preg_match( '/^(((https?):\/\/(www\.)?)|(www\.))?((youtube\.com\/watch\?v=)|(youtu.be\/)|(youtube\.com\/v\/))([a-zA-Z0-9_-]+)(&[a-zA-Z0-9_-]+=[a-zA-Z0-9_-]+){0,}$/', $link, $matches ) )
    {
        $data = array(
            'video_type'        => 'youtube',
            'video'             => $matches[10]
        );
        return $data;
    }        
    if( preg_match( '/^(((https?):\/\/(www\.)?)|(www\.))?vimeo\.com\/(\d+)$/', $link, $matches ) )
    {
        $data = array(
            'video_type'        => 'vimeo',
            'video'             => $matches[6]
        );
        return $data;
    }        
    return false;
}
// }}}
// {{{ get_next()
if ( ! function_exists( 'get_next' ) )
{
	function get_next()
	{
      $chiql =& global_records(); 
      $chiql->set_next_available_record();      
	}
}
// }}}	
// {{{ function id()
/**
 * Get ID
 *
 * Grabs ID number for the current record.
 *
 * @return value
 */	
if ( ! function_exists( 'id' ) )
{
	function id()
	{
      $chiql =& global_records(); 
      return $chiql->row_value( 'id' );      
	}
}
// }}}
// {{{ function name()
/**
 * Name of entry
 *
 * Description
 *
 * @return value
 */	
if ( ! function_exists( 'name' ) )
{
	function name()
	{
      $chiql =& global_records(); 
      return $chiql->row_value( 'name' );      
	}
}
// }}}
// {{{ function unix_time()
/**
 * Name of function
 *
 * Description
 *
 * @return value
 */	
if ( ! function_exists( 'unix_time' ) )
{
	function unix_time()
	{
      $chiql =& global_records();
      return $chiql->row_value( 'date' );
	}
}
// }}}
// {{{ function human_date( $format )
function human_date( $format = 'l F j, Y h:ia' )
{
  $chiql =& global_records();
  $time = $chiql->row_value( 'date' );
  return date( $format, $time );
}
// }}}
// {{{ function number_of_records()
/**
 * Name of function
 *
 * Description
 *
 * @return value
 */	
if ( ! function_exists( 'number_of_records' ) )
{
	function number_of_records()
	{
      //Create reference to the global records array. 
      $chiql =& global_records();  

      //Return the number of records available.
      return $chiql->number_of_records();
	}
}
// }}}	
// {{{ function excerpt()
/**
 * Get the excerpt
 *
 * Grabs the excerpt for the current record.
 *
 * @return string
 */	

if ( ! function_exists( 'excerpt' ) )
{
	function excerpt()
	{
      //Create reference to the global records array. 
      $chiql =& global_records();  
      //Return the excerpt.
      return $chiql->row_value( 'excerpt' );
	}
}
// }}}
// {{{ function content()
/**
 * Grabs content body for the current record.
 *
 * @return string
 */	

if ( ! function_exists( 'content' ) )
{
	function content()
	{
      //Create reference to the global records array. 
      $chiql =& global_records();  
      //Get content.
      $content = $chiql->row_value( 'content' );
      // Check to see if we need to parse.
      return $content;
	}
}
// }}}
// {{{ function author()
/**
 * Get Author
 *
 * Retrieves the author for the current record.
 *
 * @return value
 */	

if ( ! function_exists( 'author' ) )
{
	function author()
	{
      //Create reference to the global records array. 
      $chiql =& global_records();  

      //Return the number of records available.
      return $chiql->row_value( 'author' );
	}
}
// }}}
// {{{ function order()
if ( ! function_exists( 'order' ) )
{
	function order()
	{
      //Create reference to the global records array. 
      $chiql =& global_records();  

      //Return the number of records available.
      return $chiql->row_value( 'order' );
	}
}
// }}}
// {{{ function get_recent_cats( $slug )
function get_recent_cats( $slug, $amount = 5 )
{
    $chiql =& global_records();
    return $chiql->get_recent_cats( $slug, $amount );
}
// }}}
// --- COMMENT HELPERS --- //
// {{{ function comment_count()
function comment_count()
{
    global $chiglob;
   $chiql =& global_records();  
   if( $chiql->looping() )
   {
        return row_value( 'comment_count' );
   }
   else
   {
       return count( $chiglob['comments'] );
   }
}
// }}}
// {{{ start_comments()
function start_comments()
{
    global $counter, $chiglob;
   $counter = -1;
   $chiglob['comments'] = array();
   $chiglob['comments'] = $GLOBALS['CI']->load->_ci_cached_vars['comments'];
   reset( $chiglob['comments'] );
}
// }}}
// {{{ there_are_comments()
function there_are_comments()
{
   global $counter, $chiglob;
   if( $counter < ( count( $chiglob['comments'] ) - 1 ) )
   {
      return true;
   }
   else
   {
      return false;
   }
}
// }}}
// {{{ function get_next_comment()
function get_next_comment()
{
   global $chiglob, $counter;
   next( $chiglob['comments'] );
   $counter++;
}
// }}}
// {{{ function comment_email()
function comment_email()
{
   global $chiglob, $counter;
   return $chiglob['comments'][$counter]->email;
}
// }}}
// {{{ function comment_website()
function comment_website()
{
   global $chiglob, $counter;
   return $chiglob['comments'][$counter]->website;
}
// }}}
// {{{ function comment_id()
function comment_id()
{
   global $chiglob, $counter;
   return $chiglob['comments'][$counter]->comment_id;
}
// }}}
// {{{ function comment_record_id()
function comment_record_id()
{
   global $chiglob, $counter;
   return $chiglob['comments'][$counter]->record_id;
}
// }}}
// {{{ function comment_author()
function comment_author()
{
   global $chiglob, $counter;
   return $chiglob['comments'][$counter]->author;
}
// }}}
// {{{ function comment_title()
function comment_title()
{
   global $chiglob, $counter;
   return $chiglob['comments'][$counter]->title;
}
// }}}
// {{{ function approval()
function approval()
{
   global $chiglob, $counter;
   if( $chiglob['comments'][$counter]->status == 'published' )
   {
       return 'approved';
   }
   else
   {
       return 'unapproved';
   }
}
// }}}
// {{{ function comment_content()
function comment_content()
{
   global $chiglob, $counter;
   return $chiglob['comments'][$counter]->content;
}
// }}}
// {{{ function comment_date( $format )
function comment_date( $format = 'l F j, Y h:ia' )
{
    global $chiglob, $counter;
    $time = $chiglob['comments'][$counter]->date;
    return date( $format, $time );
}
// }}}
// --- VIDEO HELPERS --- //
// {{{ function video_type()
function video_type()
{
    $chiql =& global_records();
    return $chiql->row_value( 'video_type' );
}
// }}}
// {{{  function video_file( $char_limit = 256 )
function video_file( $char_limit = 256 )
{
    $chiql =& global_records();
    if( $chiql->row_value( 'h264' ) != '' ) return ( strlen( $chiql->row_value( 'h264' ) )  <= $char_limit ) ? $chiql->row_value( 'h264' ) : substr( $chiql->row_value( 'h264' ), 0, $char_limit ) . '...';
    if( $chiql->row_value( 'ogg' ) != '' ) return ( strlen( $chiql->row_value( 'ogg' ) ) <= $char_limit ) ? $chiql->row_value( 'ogg' ) : substr( $chiql->row_value( 'ogg' ), 0, $char_limit ) . '...';
    if( $chiql->row_value( 'flv' ) != '' ) return ( strlen( $chiql->row_value( 'flv' ) ) <= $char_limit ) ? $chiql->row_value( 'flv' ) : substr( $chiql->row_value( 'flv' ), 0, $char_limit ) . '...';
    return 'none';
}
// }}}
// {{{ function number_of_videos()
function number_of_videos()
{
    $chiql =& global_records();
    return $chiql->row_value('number_of_videos');
}
// }}}
// --- MUSIC HELPERS --- //
//{{{ function artist()
function artist()
{
    $chiql =& global_records();
    return $chiql->row_value('artist');
}
// }}}
// {{{ function playist_name()
function playlist_name()
{
    $chiql =& global_records();
    return $chiql->row_value( 'title' );
}
// }}}
// {{{ function filename( $char_limit = 256 )
function filename( $char_limit = 256 )
{
    $chiql =& global_records();
    $file = $chiql->row_value( 'file' );
    return ( strlen( $file ) <= $char_limit ) ? $file : substr( $file, 0, $char_limit ) . '...';
}
// }}}
// {{{ function number_of_songs()
function number_of_songs()
{
    $chiql =& global_records();
    return $chiql->row_value('number_of_songs');
}
// }}}
// {{{ function there_are_songs()
function there_are_songs()
{
   $chiql =& global_records();  

   //Check to see if there are records available.
   if( $chiql->number_of_songs()  != 0 )
   {
      //Check to see if we are currently in the loop.
      return $chiql->songs_looping();
   }
   else
   {
      return false;
   }
}
// }}}
// {{{ get_next_song()
function get_next_song()
{
  $chiql =& global_records(); 
  $chiql->set_next_available_song();      
}
// }}}	
// {{{ function song_value( $name )
function song_value( $name )
{
    $chiql =& global_records();
    return $chiql->song_value( $name );
}
// }}}
// {{{ function there_are_playlist_records()
function there_are_playlist_records()
{
   $chiql =& global_records();  

   //Check to see if there are records available.
   if( $chiql->number_of_playlist_records()  != 0 )
   {
      //Check to see if we are currently in the loop.
      return $chiql->playlist_records_looping();
   }
   else
   {
      return false;
   }
}
// }}}
// {{{ get_next_playlist_record()
function get_next_playlist_record()
{
  $chiql =& global_records(); 
  $chiql->set_next_available_playlist_record();      
}
// }}}	
// {{{ function playlist_record_value( $name )
function playlist_record_value( $name )
{
    $chiql =& global_records();
    return $chiql->playlist_record_value( $name );
}
// }}}
// --- TEAM HELPERS --- //
// {{{ function facebook()
function facebook()
{
    $chiql =& global_records();
    return $chiql->facebook();
}
// }}}
// {{{ function twitter()
function twitter()
{
    $chiql =& global_records();
    return $chiql->twitter();
}
// }}}
// {{{ function myspace()
function myspace()
{
    $chiql =& global_records();
    return $chiql->myspace();
}
// }}}
// {{{ function linkedin()
function linkedin()
{
    $chiql =& global_records();
    return $chiql->linkedin();
}
// }}}
// {{{ function website()
function website()
{
    $chiql =& global_records();
    return $chiql->website();
}
// }}}
// --- PHOTO HELPERS --- //
// {{{ function description()
/**
 * Grabs he description of the current photo/album
 *
 * @return string
 */	

if ( ! function_exists( 'description' ) )
{
	function description()
	{
      //Create reference to the global records array. 
      $chiql =& global_records();  
      //Get content.
      $content = $chiql->row_value( 'description' );
      // Check to see if we need to parse.
      return $content;
	}
}
// }}}
// {{{ has_album_cover()
function has_album_cover()
{
   //Create reference to the global records array. 
   $chiql =& global_records();  

   //Return the number of records available.
   return $chiql->has_album_cover();
}
// }}}
// {{{ function album_id()
function album_id()
{
   //Create reference to the global records array. 
   $chiql =& global_records();  

   //Return the number of records available.
   return $chiql->get_album_id();
}
// }}}
// {{{ function small_photo()
function small_photo()
{
   //Create reference to the global records array. 
   $chiql =& global_records();  

   //Return the number of records available.
   return $chiql->row_value( 'small' );
}
// }}}
// {{{ function album_small_photo()
function album_small_photo()
{
   //Create reference to the global records array. 
   $chiql =& global_records();  

   //Return the number of records available.
   return $chiql->album_value( 'small' );
}
// }}}
// {{{ function there_are_photos()
function there_are_photos()
{
   $chiql =& global_records();  

   //Check to see if there are records available.
   if( $chiql->number_of_photos()  != 0 )
   {
      //Check to see if we are currently in the loop.
      return $chiql->photos_looping();
   }
   else
   {
      return false;
   }
}
// }}}
// {{{ function get_photo()
function get_photo()
{
    $chiql =& global_records();
    $chiql->set_next_available_photo();
}
// }}}
// --- STORE HELPERS--- //
// {{{ function cart_total_items()
function cart_total_items()
{
   return $GLOBALS['CI']->cart->total_items();
}
// }}}
// {{{ function cart_total()
function cart_total()
{
   return $GLOBALS['CI']->cart->total();
}
// }}}
// {{{ start_cart()
function start_cart()
{
   global $counter, $chiglob;
   $counter = -1;
   $chiglob['cart'] = array();
   $chiglob['cart'] = $GLOBALS['CI']->cart->contents();
   reset( $chiglob['cart'] );
}
// }}}
// {{{ set_next_cart_item()
function set_next_cart_item()
{
   global $chiglob, $counter;
   next( $chiglob['cart'] );
   $counter++;
}
// }}}
// {{{ cart_value()
function cart_value( $label )
{
   global $chiglob;
   $item = current( $chiglob['cart'] );
   return $item[ $label ];
}
// }}}
// {{{ cart_options()
function cart_options()
{
   global $chiglob;
   $item = current( $chiglob['cart'] );
   $options = $item['options'];
   $string = "";
   foreach( $options as $key=>$option )
   {
      $string .= "$key - $option &bull; ";
   }
   $string = substr( $string, 0, -7 );
   return $string;
}
// }}}
// {{{ there_are_cart_items()
function there_are_cart_items()
{
   global $counter;
   if( $counter < ( cart_total_items() - 1 ) )
   {
      return true;
   }
   else
   {
      return false;
   }
}
// }}}
// {{{ price()
// Price Function | Retrieves the price value of a record.
function price()
{
   //Create reference to the global records array. 
   $chiql =& global_records();  

   // Return the price value.
   return $chiql->row_value( 'price' );   
}
// }}}
// {{{ num_options()
function num_options()
{
   $chiql =& global_records();
   return $chiql->num_options();
}
// }}}
// {{{ there_are_item_options()
function there_are_item_options()
{
   $chiql =& global_records();
   return $chiql->there_are_item_options();
}
// }}}
// {{{ there_are_option_values()
function there_are_option_values()
{
   $chiql =& global_records();
   return $chiql->there_are_option_values();
}
// }}}
// {{{ option_values()
function option_values()
{
   $chiql =& global_records();
   return $chiql->option_values();
}
// }}}
// {{{ get_item_options()
function get_item_options()
{
   $chiql =& global_records();
   $chiql->get_item_options();
}
// }}}
// {{{ get_option_values()
function get_option_values()
{
   $chiql =& global_records();
   $chiql->get_option_values();
} 
// }}}
// {{{ option_name()
function option_name()
{
   $chiql =& global_records();
   return $chiql->option_name();
}
// }}}
// {{{ option_label()
function option_label()
{
   $chiql =& global_records();
   return $chiql->option_label();
}
// }}}
// {{{ option_value_name()
function option_value_name()
{
   $chiql =& global_records();
   return $chiql->option_value_name();
}
// }}}
//// {{{ function option_id()
function option_id()
{
    $chiql =& global_records();
    return $chiql->option_id();
}
// }}}
// {{{ option_position()
function option_position()
{
   $chiql =& global_records();
   return $chiql->option_position();
}
// }}}
// --- RELATIVE HELPERS --- //
// {{{ function has_relative_playlist()
function has_relative_music_playlist()
{
    $chiql =& global_records();
    return $chiql->has_relative_music_playlist();
}
// }}}
// {{{ function relative_playlist_id()
function relative_music_playlist_id()
{
    $chiql =& global_records();
    return $chiql->relative_music_playlist_id();
}
// }}}
// {{{ function has_relative_photo_album()
function has_relative_photo_album()
{
    $chiql =& global_records();
    return $chiql->has_relative_photo_album();
}
// }}}
// {{{ relative_photo_album_id()
function relative_photo_album_id()
{
    $chiql =& global_records();
    return $chiql->relative_photo_album_id();
}
// }}}
// {{{ function has_relative_slideshow()
function has_relative_slideshow()
{
    $chiql =& global_records();
    return $chiql->has_relative_slideshow();
}
// }}}
// {{{ relative_slideshow_id()
function relative_slideshow_id()
{
    $chiql =& global_records();
    return $chiql->relative_slideshow_id();
}
// }}}
// --- USER LOGIN HELPERS --- //
// {{{ logged_in()
// Checks to see if user is logged in.
function logged_in()
{
   if( $GLOBALS['CI']->session->userdata( 'is_logged_in' ) == 'true' ) 
   {
      return true;
   }
   else
   {
      return false;
   }
}
// }}}
// {{{ not_logged_in()
// Checks to see if user is not logged in.
function not_logged_in()
{
   if( $GLOBALS['CI']->session->userdata( 'is_logged_in' ) == 'true' ) 
   {
      return false;
   }
   else
   {
      return true;
   }
}
// }}}
// {{{ attempt_failed()
function attempt_failed()
{
   $attempt_failed = $GLOBALS['CI']->session->flashdata( 'attempt_failed' );
   if( ! empty( $attempt_failed ) )
   {
      if( $attempt_failed == 'true' )
      {
         return true;
      }
   }
   return false;
}
// }}}
// {{{ just_logged_in()
function just_logged_in()
{
   $just_logged_in = $GLOBALS['CI']->session->flashdata( 'just_logged_in' ); 
   if( ! empty( $just_logged_in ) )
   {
      if( $just_logged_in == 'true' )
      {
         return true;
      }
   }
   return false;
}
// }}}
// {{{ function cookiedata( $name )
function cookiedata( $name )
{
   return $GLOBALS['CI']->session->userdata( $name );
}
// }}}
// {{{ flash()
function flash( $label )
{
   return $GLOBALS['CI']->session->flashdata( $label );
}
// }}}
// --- SOCIAL HELPERS --- //
// {{{ function twitter_status_update( $link, $message = 'Check this out :' )
function twitter_status_update( $link, $via = '',  $message = 'Check this out :' )
{
    $via = ( $via != '' ) ? ' via @' . $via : '';
    return 'http://twitter.com/?status=' . rawurlencode( $message . ' ' . $link . $via );
}
// }}}
// {{{ function facebook_share( $url, $title = '' )
function facebook_share( $url, $title = '' )
{
    return 'http://facebook.com/sharer.php?u=' . urlencode( $url ) . '&t=' . rawurlencode( $title );
}
// }}}
// --- TUMBLR HELPERS --- //
// {{{ not_tumblr()
// Returns true if the record is not from tumblr.
function not_tumblr()
{
   $chiql =& global_records();  
   $tumblr = $chiql->row_value( 'tumblr' );
   return $tumblr == '' ? true : false;
}
// }}}
// {{{ function parse_content()
function parse_content( $content, $before, $after )
{
   $parts = explode( '~', $content );
   $final = "";
   foreach( $parts as $part )
   {
      $final .= $before . $part . $after;
   }
   return $final;
}
// }}}
/* End of file chi_helper.php */
/* Location: ./application/helpers/chi_helper.php */
