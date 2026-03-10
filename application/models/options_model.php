<?php if( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Options_model extends CI_Model 
{
    // {{{ public function get_options( $args ) 
    public function get_options( $args ) 
    {
        $this->db->flush_cache();
        $this->db->where( 'owner_id', $args['user_id'] );
        $query = $this->db->get( 'options' );
        $result = $query->result();
        $options = array();
        foreach( $result as $option )
        {
            $options[ $option->name ] = $option->value;
        }
        return $options;
    }
    // }}}
    // {{{ public function get_record( $id )
    public function get_record( $id )
    {
        $this->db->where( array( 'id' => $id, 'status' => 'published' ) );
        $query = $this->db->get( 'options' );
        return $query->result();
    }
    // }}}
    // {{{ public function get_option_by_name( $name )
    public function get_option_by_name( $name )
    {
        $query = $this->db->get_where( 'options', array( 'name' => $name ) );
        $row = $query->row();
        return $row->value;
    }
    // }}}
    // {{{ public function get_category_pages()
    public function get_category_pages()
    {
        $this->db->where( 'owner_id', $args['user_id'] );
        $this->db->where( 'name', 'category_page' );
        $query = $this->db->get( 'options' );
        $result = $query->result();
        $options = array();
        foreach( $result as $option )
        {
            $str = explode( '~', $option->value );
            $options[] = array( 'name' => $str[0], 'slug' =>$str[1] );
        }
        return $options;
    }
    // }}}
    // {{{ public function add( $data ) 
    public function add( $data ) 
    {
        $this->db->insert( 'options', $data );
        return true;
    }
    // }}}
    // {{{ public function update( $id, $data ) 
    public function update( $id, $data ) 
    {
        $this->db->where( 'id', $id );
        $this->db->update( 'options', $data );
        return true;
    }
    // }}}
    // {{{ public function bulk_update( $update )
    public function bulk_update( $update )
    {
        $errors = 0;
        foreach( $update as $name => $value )
        {
            if( !is_numeric( $name ) )
            {
                $this->db->where( 'name', $name );
                $up = $this->db->update( 'options', array( 'value' => $value ) );
                if( !$up ) $errors++;
            }
            else
            {
                $errors++;
            }
        }
        return ( $errors == 0 ) ? true : false;
    }
    // }}}
    // {{{ public function delete( $id ) 
    public function delete( $id ) 
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'options' );
    }
    // }}}
    // {{{ public function delete_photo( $id ) 
    public function delete_photo( $id ) 
    {
        $update = array( 'big_pic' => '', 'small_pic' => '' );
        $this->db->where( 'id', $id );
        $this->db->update( 'options', $update );
        return true;
    }
    // }}}
}

?>
