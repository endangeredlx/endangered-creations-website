<?php if( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Mailinglist_model extends CI_Model 
{
    // {{{ VARIABLES 
    var $class          = 'mailinglist';
    var $singular       = 'contact';
    var $plural         = 'contacts';
    var $table          = 'contacts';
    // }}}
    // {{{ public function get_records( $args = array( 'include_unpublished' => false ) ) 
    public function get_records( $args = array( 'include_unpublished' => false, 'offset' => 0, 'how_many' => 'all' ) ) 
    {
        if( !$args['include_unpublished'] ) 
        {
            $this->db->where( 'status', 's' );
        }

        $this->db->order_by( 'status', 'asc' );

        if( $args['how_many'] == 'all' )
        {
            $query = $this->db->get( $this->table );
        }
        else if( isset( $args['id'] ) )
        {
            $query = $this->db->get_where( $this->table, array( 'id' => $args['id'] ) );
        }
        else 
        {
            $query = $this->db->get( $this->table, $args['how_many'], $args['offset'] );
        }

        return $query->result();
    }
    // }}}
    // {{{ public function get_record( $id )
    public function get_record( $id )
    {
        $query = $this->db->get_where( $this->table, array( 'id' => $id ) );
        return $query->result();
    }
    // }}}
    // {{{ public function is_duplicate( $email )
    public function is_duplicate( $email )
    {
        $this->db->where( 'email', $email );
        $query = $this->db->get( 'contacts' );
        if( $query->num_rows() > 0 )
        {
            return true; 
        }
        else
        {
            return false;
        }
    }    
    // }}}
    // {{{ public function add_to_list( $data )
    public function add_to_list( $data )
    {
        $this->db->insert( 'contacts', $data );
        $id = $this->db->insert_id();
        return $id;
    }
    // }}}
    // {{{ public function verify( $confirm, $id, $email )
    public function verify( $confirm, $id, $email )
    {
        if( md5( $id . $email ) == $confirm )
        {
            $update = array( 'status' => 's' );
            $this->update( $id, $update );
            return true;
        }
        else
        {
            return false;
        }
    }
    // }}}
    // {{{ public function update( $id, $data ) 
    public function update( $id, $data ) 
    {
        $this->db->where( 'id', $id );
        $this->db->update( $this->table, $data );
        return true;
    }
    // }}}
    // {{{ public function delete( $id ) 
    public function delete( $id ) 
    {	
        $this->db->where( 'id', $id );
        $this->db->delete( $this->table );
    }
    // }}}
}
