<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ChiVideo
*
* The Content Handling Interface Events Class (Decorator)
*
* Package Chi - Content Handling Interface
**/

require( APPPATH . 'libraries/ChiDecorator' . EXT );

class ChiVideo extends ChiDecorator
{
    // {{{ VARIABLES
    // Chi Query Object
    var $chiql;
    // Playlist Variables
    var $number_of_playlist_records = 0;
    var $playlist_records;
    var $playlist_records_looping = false;
    var $playlist_records_position = -1;
    // video Variables
    var $number_of_videos = 0;
    var $videos;
    var $videos_looping = false;
    var $videos_position = -1;
    //---------------------------------
    // Extra Options
    //---------------------------------

    //}}}
    // {{{ public function __construct( ChiQL $ChiQL )
    public function __construct( ChiQL $ChiQL )
    {
        $this->chiql =& $ChiQL;
        if( $this->chiql->param_value( 'id' ) ) $this->get_playlist_records();
        $this->get_videos();
    }
    // }}}
    // --- PLAYLIST RECORDS --- //
    // {{{ private function get_playlist_records()
    private function get_playlist_records()
    {
        $id = $this->chiql->param_value( 'id' );
        $ci = $this->chiql->myCI();
        $stab = $ci->db->dbprefix( 'video_videos' );
        $rtab = $ci->db->dbprefix( 'video_records' );
        // Grab videos from the records table
        $sql  = 'SELECT * ';
        $sql .= ' FROM ' . $stab . ', ' . $rtab;
        $sql .= ' WHERE (' . $rtab . '.playlist_id = \'' . $id . '\')';
        $sql .= ' AND (' . $stab . '.id = ' . $rtab . '.video_id )';
        $sql .= ' ORDER BY `order` ASC;';
        $query = $ci->db->query( $sql );
        $this->playlist_records = $query->result(); 
        $this->number_of_playlist_records = count( $this->playlist_records );
    } 
    // }}}
   // {{{ public function playlist_records_looping()
   public function playlist_records_looping()
   {
      if( ( $this->playlist_records_position + 1 ) < $this->number_of_playlist_records )
      {
         $this->playlist_records_looping = true;
      }
      else
      {
         $this->playlist_records_looping = false;
      }
      return $this->playlist_records_looping;
   }
   // }}}
   // {{{ public function number_of_playlist_records()
   public function number_of_playlist_records()
   {
      return $this->number_of_playlist_records;
   }
   // }}}
   // {{{ public function set_next_available_playlist_record()
   public function set_next_available_playlist_record()
   {
      $this->playlist_records_position++;
   }
   // }}}
   // {{{ public function playlist_record_value( $name )
   public function playlist_record_value( $name )
   {
       return $this->playlist_records[ $this->playlist_records_position ]->$name;
   }
   // }}}
    // --- videos --- //
    // {{{ private function get_videos()
    private function get_videos()
    {
        $id = $this->chiql->param_value( 'id' );
        $ci = $this->chiql->myCI();
        $stab = $ci->db->dbprefix( 'video_videos' );
        $query = $ci->db->get( $stab );
        $this->videos = $query->result(); 
        $this->number_of_videos = count( $this->videos );
    } 
    // }}}
   // {{{ public function videos_looping()
   public function videos_looping()
   {
      if( ( $this->videos_position + 1 ) < $this->number_of_videos )
      {
         $this->videos_looping = true;
      }
      else
      {
         $this->videos_looping = false;
      }
      return $this->videos_looping;
   }
   // }}}
   // {{{ public function number_of_videos()
   public function number_of_videos()
   {
      return $this->number_of_videos;
   }
   // }}}
   // {{{ public function set_next_available_video()
   public function set_next_available_video()
   {
      $this->videos_position++;
   }
   // }}}
   // {{{ public function video_value( $name )
   public function video_value( $name )
   {
       return $this->videos[ $this->videos_position ]->$name;
   }
   // }}}
}
