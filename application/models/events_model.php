<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events_model extends CI_Model 
{
    // {{{ VARIABLES
    var $class      = 'events';
    var $singular   = 'event';
    var $plural     = 'events';
    var $table      = 'events';
    // }}}
    // {{{ public function get_records( $include_unpub = false ) 
    public function get_records( $include_unpub = false ) 
    {
        if( !$include_unpub ) 
        {
            $this->db->where( 'status', 'published' );
        }
        $this->db->order_by( "date", "asc" );
        $this->db->order_by( "order", "asc" ); 
        $query = $this->db->get( 'events' );
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
    // {{{ public function update_views( $id )
    public function update_views( $id )
    {
        $query =	$this->db->query( "Update `" . $this->db->dbprefix( $this->table ) . "` set views=views+1 where `id` = " . $id );
    }
    // }}}
    // {{{ public function get_record( $id, $noviews = false ) 
    public function get_record( $id, $noviews = false )
    {
        $this->db->where( 'id', $id );
        $query = $this->db->get( $this->table );
        if( !$noviews )
        {
            $this->update_views($id);
        }
        return $query->result();
    }
    // }}}
    // {{{ public function add( $data ) 
    public function add( $data ) 
    {	
        $this->db->insert('events', $data);
        return true;
    }
    // }}}
    // {{{ public function update( $id, $data ) 
    public function update( $id, $data ) 
    {
        $this->db->where( 'id', $id );
        $this->db->update( 'events', $data);
        return true;
    }
    // }}}
    // {{{ public function delete( $id ) 
    public function delete( $id ) 
    {	
        $this->db->where( 'id', $id );
        $this->db->delete( 'events' );
    }
    // }}}
}
?>
