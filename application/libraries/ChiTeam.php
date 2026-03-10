<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ChiTeam
*
* The Content Handling Interface Events Class (Decorator)
*
* Package Chi - Content Handling Interface
**/

require( APPPATH . 'libraries/ChiDecorator' . EXT );

class ChiTeam extends ChiDecorator
{
    // {{{ VARIABLES
    // Chi Query Object
    var $chiql;
    // --- Extra Options --- //
    // Options Table
    private $relationship_table = 'team_options';
    private $music_playlist;
    private $photo_album;
    private $slideshow;

    //}}}
    // {{{ public function __construct( ChiQL $ChiQL )
    public function __construct( ChiQL $ChiQL )
    {
        $this->chiql =& $ChiQL;
        $this->music_playlist = $this->chiql->get_options( $this->chiql->param_value('id'), $this->relationship_table, 'music_playlists', 'music_playlist' );
        $this->photo_album = $this->chiql->get_options( $this->chiql->param_value('id'), $this->relationship_table, 'photo_albums', 'photo_album' );
        $this->slideshow = $this->chiql->get_options( $this->chiql->param_value('id'), $this->relationship_table, 'photo_albums', 'slideshow' );
    }
    // }}}
    // --- TEAM OPTIONS --- //
    // {{{ public function has_relative_music_playlist()
    public function has_relative_music_playlist()
    {
        return ( count( $this->music_playlist ) < 1 ) ? false : true;
    }
    // }}}
    // {{{ public function relative_music_playlist_id()
    public function relative_music_playlist_id()
    {
        return $this->music_playlist[0]->type_id;
    }
    // }}}
    // {{{ public function has_relative_photo_album()
    public function has_relative_photo_album()
    {
        return ( count( $this->photo_album ) < 1 ) ? false : true;
    }
    // }}}
    // {{{ public function relative_photo_album_id()
    public function relative_photo_album_id()
    {
        return $this->photo_album[0]->type_id;
    }
    // }}}
    // {{{ public function has_relative_slideshow()
    public function has_relative_slideshow()
    {
        return ( count( $this->slideshow ) < 1 ) ? false : true;
    }
    // }}}
    // {{{ public function relative_slideshow_id()
    public function relative_slideshow_id()
    {
        return $this->slideshow[0]->type_id;
    }
    // }}}
    // {{{ public function facebook()
    public function facebook()
    {
        return $this->chiql->row_value( 'facebook' );
    }
    // }}}
    // {{{ public function twitter()
    public function twitter()
    {
        return $this->chiql->row_value( 'twitter' );
    }
    // }}}
    // {{{ public function myspace()
    public function myspace()
    {
        return $this->chiql->row_value( 'myspace' );
    }
    // }}}
    // {{{ public function linkedin()
    public function linkedin()
    {
        return $this->chiql->row_value( 'linkedin' );
    }
    // }}}
    // {{{ public function website()
    public function website()
    {
        return $this->chiql->row_value( 'website' );
    }
    // }}}
}
