<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ChiPhotos
*
* The Content Handling Interface Events Class (Decorator)
*
* Package Chi - Content Handling Interface
**/

require( APPPATH . 'libraries/ChiDecorator' . EXT );

class ChiPhotos extends ChiDecorator
{
    // {{{ VARIABLES
    // Chi Query Object
    var $chiql;
    // Holds number of photos
    var $number_of_photos = 0;
    var $album;
    var $is_relative = false;
    var $relative;
    //---------------------------------
    // Extra Options
    //---------------------------------

    //}}}
    // {{{ public function __construct( ChiQL $ChiQL )
    public function __construct( ChiQL $ChiQL )
    {
        $this->chiql =& $ChiQL;
        $this->number_of_photos = $this->chiql->number_of_records();
        $this->get_album_info();
        $this->check_for_relative();
    }
    // }}}
    // {{{ private function get_album_info()
    private function get_album_info()
    {
        $aid = $this->get_album_id();
        $ci = $this->chiql->myCI();
        $result = $ci->records->get_record( $aid );
        $this->album = $result[0];
    } 
    // }}}
    // {{{ public function album_value( $key ) 
    public function album_value( $key )
    {
        return $this->album->$key;
    }
    // }}}
    // {{{ public function check_for_relative()
    public function check_for_relative()
    {
        // Check to see if this is a single record.
        if( count( $this->album ) == 1 && isset( $this->album->id ) )
        {
            $body = $this->album->description;
            // Check to see if it is a feature of another entry (It would fit the pattern ~~~class|function|id~~~
            if( preg_match( '/^[\~]{3}[a-zA-Z0-9\|]+[\~]{3}$/', $body ) )
            {
                $this->is_relative = true;
                $end = strlen($body) - 6;
                $rela = substr( $body, 3, $end);
                $relb = explode( '|', $rela );
                $this->relative['class'] = $relb[0];
                $this->relative['id'] = $relb[2];
                $this->relative['function'] = $relb[1];
                $ci = $this->chiql->myCI();
                $ci->db->select( '`id`, `title`');
                $ci->db->where( 'id', $this->relative['id'] );
                $query = $ci->db->get( $this->relative['class'] );
                $this->relative['title'] = $query->row()->title;
            }
        }
    }
    // }}}
    // {{{ public function is_relative()
    public function is_relative()
    {
        return $this->is_relative;
    }
    // }}}
    // {{{ public function relative( $label )
    public function relative( $label )
    {
        return $this->relative[ $label ];
    }
    // }}}
    // --- PHOTO UTILITIES --- //
    // {{{ public function has_album_cover()
    public function has_album_cover()
    {
        $pic = $this->chiql->row_value( 'small' );
        return ( preg_match( '/[a-zA-Z0-9_]+\.(gif|jpg|png)$/i', $pic ) ) ? true : false;
    }
    // }}}
    // {{{ public function photos_looping()
    public function photos_looping()
    {
        return $this->chiql->looping();
    }
    // }}}
    // {{{ public function set_next_available_photo()
    public function set_next_available_photo()
    {
        $this->chiql->set_next_available_record();
    }
    // }}}
    // {{{ public function number_of_photos()
    public function number_of_photos()
    {
        return $this->number_of_photos;
    }
    // }}}
    // {{{ public function get_album_id()
    public function get_album_id()
    {
        return $this->chiql->param_value('id');
    }
    // }}}
}
