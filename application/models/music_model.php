<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music_model extends CI_Model 
{
    // {{{ public function get_records( $args ) 
    public function get_records( $args ) 
    {
        return $this->get_playlists( $args );
    }
    // }}}
    // {{{ public function get_playlists( $args )
    public function get_playlists( $args )
    {
        if( !$args['include_unpublished'] ) 
        {
            $this->db->where( 'status', 'published' );
        }
        $this->db->order_by( 'status', 'asc' );
        $this->db->order_by( 'order', 'asc' ); 
        $this->db->where( "`description` NOT REGEXP '^[~]{3}[a-zA-Z_0-9\|]+[~]{3}$'");
        if( isset( $args['id'] ) )
        {
            $this->db->where( 'id', $args['id'] );
            $query = $this->db->get( 'music_playlists' );
        }
        else if( $args['how_many'] != 'all' )
        {
            $query = $this->db->get( 'music_playlists', $args['how_many'], $args['offset'] );
        }
        else 
        {
            $query = $this->db->get( 'music_playlists' );
        }
        return $query->result();
    }
    // }}}
    // {{{ public function get_songs( $args )
    public function get_songs( $args )
    {
        if( !$args['include_unpublished'] ) 
        {
            $this->db->where( 'status', 'published' );
        }
        $this->db->order_by( 'status', 'asc' );
        if( isset( $args['id'] ) )
        {
            $this->db->where( 'id', $args['id'] );
            $query = $this->db->get( 'music_songs' );
        }
        else if( $args['how_many'] != 'all' )
        {
            $query = $this->db->get( 'music_songs', $args['how_many'], $args['offset'] );
        }
        else 
        {
            $query = $this->db->get( 'music_songs' );
        }
        return $query->result();
    }
    // }}}
    // {{{ public function make_row()
    public function make_row()
    {
        $this->db->insert( 'music_songs', array( 'title' => 'title' ) );
        $id = $this->db->insert_id();
        return $id;
    }
    // }}}
    // {{{ public function rewrite_xml()
    public function rewrite_xml()
    {
        $this->db->flush_cache();
        $this->db->where( 'status', 'published' );
        $this->db->order_by( '`order`', 'asc' );
        $songs = $this->db->get( 'music' );
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\"?>\n";
        $xml .= '<content>';
        foreach( $songs->result() as $song )
        {
            $image = ( $song->image != "" ) ? $song->image : 'default.jpg';
            $xml .= "\n\t<mp3 Thumb=\"" . base_url() . "music_files/images/" . $image . "\" ";
            $xml .= "Title=\"" . htmlspecialchars( $song->artist ) . " - " . htmlspecialchars( $song->title ) . "\" ";
            $xml .= "Path=\"" . base_url() . "music_files/" . $song->file . "\" />";
        }
        $xml .= "\n</content>";
        $xml_filename = "swf/content.xml";
        $fp = fopen( $xml_filename, "w" );
        $write = fwrite( $fp, $xml );
    }
    // }}}
    // {{{ public function add_playlist( $data ) 
    public function add_playlist( $data ) 
    {	
        $this->db->insert( 'music_playlists', $data );
        return true;
    }
    // }}}
    // {{{ public function create_playlist_records( $id, $data )
    public function create_playlist_records( $id, $data )
    {
        foreach( $data as $song )
        {
            $insert = array(
                'song_id'       => $song['id'],
                'playlist_id'   => $id,
                'order'         => $song['order']
            );
            $this->db->insert( 'music_records', $insert );
        }
        return true;
    }
    // }}}
    // {{{ public function get_next_order()
    public function get_next_order()
    {
        $this->db->where( 'status', 'published');
        $this->db->order_by( '`order`', 'desc' );
        $this->db->select('`order`');
        $data = $this->db->get( 'music' );
        if( $data->num_rows() != 0 )
        {
            $row = $data->row();
            $order = $row->order + 1;
        }
        else 
        {
            $order = 1;
        }
        return $order;
    }
    // }}}
    // {{{ public function update_order()
    public function update_order()
    {
        $this->db->flush_cache();
        $this->db->where( 'status', 'published' );
        $this->db->order_by( 'order', 'asc' );
        $songs = $this->db->get('music');
        $count = 1;
        foreach( $songs->result() as $song )
        {
            $this->db->where('id', $song->id );
            $this->db->update( 'music', array( 'order' => $count ) ); 
            $count++;
        }
        return true;
    }
    // }}}
    // {{{ public function update_song( $id, $data ) 
    public function update_song( $id, $data ) 
    {
        $this->db->where( 'id', $id );
        $this->db->update( 'music_songs', $data );
        return true;
    }
    // }}}
    // {{{ public function update_playlist( $id, $data )
    public function update_playlist( $id, $data )
    {
        $this->db->where( 'id', $id );
        $this->db->update( 'music_playlists', $data );
    }
    // }}}
    // {{{ public function update_playlist_records( $data )
    public function update_playlist_records( $id, $data )
    {
        $data_bool = array();
        foreach( $data as $record )
        {
            $this->db->flush_cache();
            $this->db->where( array( 'order' => $record['order'], 'playlist_id' => $id ) );
            $query = $this->db->get( 'music_records' );
            
            $this->db->flush_cache();

            if( $query->num_rows() > 0 )
            { 
                $update = array(
                    'song_id'  => $record['id']
                ); 
                $this->db->where( array( 'order' => $record['order'], 'playlist_id' => $id ) );
                $up = $this->db->update( 'music_records', $update );
                if( ! $up ) echo 'failure';
            }
            else
            {
                $insert = array(
                    'song_id'       => $record['id'],
                    'playlist_id'   => $id,
                    'order'         => $record['order']
                 );
                $add = $this->db->insert( 'music_records', $insert );
                if( ! $add ) echo 'failure';
            }
        }
    }
    // }}}
    // {{{ public function delete_song( $id ) 
    public function delete_song( $id ) 
    {	
        $this->db->where( 'id', $id );
        $this->db->delete( 'music_songs' );
    }
    // }}}
    // {{{ public function delete_playlist( $id ) 
    public function delete_playlist( $id ) 
    {	
        $this->db->where( 'id', $id );
        $this->db->delete( 'music_playlists' );
        $this->db->flush_cache();
        $this->db->where( 'playlist_id', $id );
        $this->db->delete( 'music_records' );
    }
    // }}}
}

?>
