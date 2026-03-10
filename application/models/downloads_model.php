<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Downloads_model extends CI_Model 
{
    public function get_records( $include_unpub = false ) 
    {
        if( !$include_unpub ) 
        {
            $this->db->where( 'status', 'published' );
        }
        $this->db->order_by( 'status', 'asc' );
        $this->db->order_by( 'order', 'asc' ); 
        $query = $this->db->get( 'downloads' );
        return $query->result();
    }

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

    public function get_record( $id ) 
    {
        $this->db->where( "id", $id );
        $query = $this->db->get( 'downloads' );
        return $query->result();
    }

    public function add( $data ) 
    {	
        $this->db->insert('downloads', $data);
        return true;
    }

    public function update( $id, $data ) 
    {
        $this->db->where("id", $id);
        $this->db->update('downloads', $data);
        return true;
    }

    public function delete( $id ) 
    {	
        $this->db->where( 'id', $id );
        $this->db->delete( 'downloads' );
    }
}
?>
