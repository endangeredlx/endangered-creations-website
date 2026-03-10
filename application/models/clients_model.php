<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients_model extends CI_Model 
{
    // {{{ public function get_records( $args = array( 'include_unpublished' => false ) ) 
    public function get_records( $args = array( 'include_unpublished' => false, 'offset' => 0, 'how_many' => 'all' ) ) 
    {
        if( !$args['include_unpublished'] ) 
        {
            $this->db->where( 'status', 'published' );
        }

        $this->db->order_by( 'status', 'asc' );
        $this->db->order_by( 'order', 'asc' ); 

        if( $args['how_many'] == 'all' )
        {
            $query = $this->db->get( 'clients' );
        }
        else 
        {
            $query = $this->db->get( 'clients', $args['how_many'], $args['offset'] );
        }

        return $query->result();
    }
    // }}}
    // {{{ public function get_next_order( $table )
    public function get_next_order( $table )
    {
        $this->db->where( 'status', 'published');
        $this->db->order_by( '`order`', 'desc' );
        $this->db->select('`order`');
        $data = $this->db->get( $table );
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
    // {{{ public function update_order( $table )
    public function update_order( $table )
    {
        $this->db->flush_cache();
        $this->db->where( 'status', 'published' );
        $this->db->order_by( 'order', 'asc' );
        $items = $this->db->get( $table );
        $count = 1;
        foreach( $items->result() as $item )
        {
            $this->db->where( 'id', $item->id );
            $this->db->update( $table, array( 'order' => $count ) ); 
            $count++;
        }
        return true;
    }
    // }}}
    // {{{ public function get_record( $id ) 
    public function get_record( $id ) 
    {
        $this->db->where( 'id', $id );
        $query = $this->db->get( 'clients' );
        return $query->result();
    }
    // }}}
    // {{{ public function add( $data ) 
    public function add( $data ) 
    {	
        $this->db->insert( 'clients', $data );
        return true;
    }
    // }}}
    // {{{ public function update( $id, $data ) 
    public function update( $id, $data ) 
    {
        $this->db->where('id', $id);
        $this->db->update('clients', $data);
        return true;
    }
    // }}}
    // {{{ public function delete( $id ) 
    public function delete( $id ) 
    {	
        $this->db->where( 'id', $id );
        $this->db->delete( 'clients' );
    }
    // }}}
}
?>
