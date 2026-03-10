<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends CI_Model 
{
    // {{{ public function get_record()
    public function get_record( $name ) 
    {
        $this->db->where( "name", $name );
        $this->db->where( "type", "page" );
        $query = $this->db->get( 'entries' );
        return $query->row();
    }
    // }}}
    // {{{ public function get_records( $args ) 
    public function get_records( $args ) 
    {
        $this->db->flush_cache();

        $this->db->where( 'type', 'page' );

        if( !$args['include_unpublished'] ) 
        {
            $this->db->where( 'status', 'published' );
        }

        if( isset( $args['order_by'] ) )
        {
            $this->db->order_by( $args['order_by'] );
        }
        $this->db->order_by( 'date', 'asc' ); 
        $query = $this->db->get( 'entries', $args['how_many'], $args['offset'] );
        return $query->result();
    }
    // }}}
    // {{{ public function get_record_by_id()
    public function get_record_by_id( $id ) 
    {
        $this->db->where( "id", $id );
        $this->db->where( "type", "page" );
        $query = $this->db->get( 'entries' );
        return $query->row();
    }
    // }}}
    // {{{ public function add()
    public function add( $data ) 
    {	
        $this->db->insert( 'entries', $data );
        return true;
    }
    // }}}
    // {{{ public function update()
    public function update( $id, $data ) 
    {
        $this->db->where("id", $id);
        $this->db->update('entries', $data);
        return true;
    }
    // }}}
    // {{{ public function update_xml( $file, $data )
    public function update_xml( $file, $data )
    {
    }
    // }}}
    // {{{ public function delete()
    public function delete( $id ) 
    {	
        $this->db->where( 'id', $id );
        $this->db->delete( 'entries' );
    }
    // }}}
}

?>
