<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ChiMusic
*
* The Content Handling Interface Events Class (Decorator)
*
* Package Chi - Content Handling Interface
**/

require( APPPATH . 'libraries/ChiDecorator' . EXT );

class ChiMusic extends ChiDecorator
{
    // {{{ VARIABLES
    // Chi Query Object
    var $chiql;
    // Playlist Variables
    var $number_of_playlist_records = 0;
    var $playlist_records;
    var $playlist_records_looping = false;
    var $playlist_records_position = -1;
    // Song Variables
    var $number_of_songs = 0;
    var $songs;
    var $songs_looping = false;
    var $songs_position = -1;
    //---------------------------------
    // Extra Options
    //---------------------------------

    //}}}
    // {{{ public function __construct( ChiQL $ChiQL )
    public function __construct( ChiQL $ChiQL )
    {
        $this->chiql =& $ChiQL;
        $this->get_playlist_records();
        $this->get_songs();
    }
    // }}}
    // --- PLAYLIST RECORDS --- //
    // {{{ private function get_playlist_records()
    private function get_playlist_records()
    {
        $id = $this->chiql->param_value( 'id' );
        $ci = $this->chiql->myCI();
        $stab = $ci->db->dbprefix( 'music_songs' );
        $rtab = $ci->db->dbprefix( 'music_records' );
        // Grab songs from the records table
        $sql  = 'SELECT `' . $stab . '`.`id`, `' . $stab . '`.`title`, `' . $stab . '`.`file`, `' . $stab . '`.`artist`, `' . $stab . '`.`pic`, ';
        $sql .= ' `' . $rtab . '`.`song_id`, `' . $rtab . '`.`playlist_id`';
        $sql .= ' FROM ' . $stab . ', ' . $rtab;
        $sql .= ' WHERE (' . $rtab . '.playlist_id = \'' . $id . '\')';
        $sql .= ' AND (' . $stab . '.id = ' . $rtab . '.song_id )';
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
    // --- SONGS --- //
    // {{{ private function get_songs()
    private function get_songs()
    {
        $id = $this->chiql->param_value( 'id' );
        $ci = $this->chiql->myCI();
        $stab = $ci->db->dbprefix( 'music_songs' );
        $query = $ci->db->get( $stab );
        $this->songs = $query->result(); 
        $this->number_of_songs = count( $this->songs );
    } 
    // }}}
   // {{{ public function songs_looping()
   public function songs_looping()
   {
      if( ( $this->songs_position + 1 ) < $this->number_of_songs )
      {
         $this->songs_looping = true;
      }
      else
      {
         $this->songs_looping = false;
      }
      return $this->songs_looping;
   }
   // }}}
   // {{{ public function number_of_songs()
   public function number_of_songs()
   {
      return $this->number_of_songs;
   }
   // }}}
   // {{{ public function set_next_available_song()
   public function set_next_available_song()
   {
      $this->songs_position++;
   }
   // }}}
   // {{{ public function song_value( $name )
   public function song_value( $name )
   {
       return $this->songs[ $this->songs_position ]->$name;
   }
   // }}}
}
