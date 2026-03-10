<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments_model extends CI_Model 
{
    // {{{ public function add( $insert )
    public function add( $insert )
    {
        $add = $this->db->insert( 'comments', $insert );
        if( isset( $insert['status'] ) && $insert['status'] == 'published' )
        {
            $this->update_comment_count( $insert['record_id'], $insert['type'] );
        }
        return $add;
    }
    // }}}
    // {{{ public function get_comments( $id, $type, $args = array( 'include_unpublished' => false, 'how_many' => 'all', 'offset' => 0 ) )
    public function get_comments( $id, $type, $args = array( 'include_unpublished' => false, 'how_many' => 'all', 'offset' => 0 ) )
    {
        if( isset( $args['get_title'] ) && $args['get_title'] === true )
        {
            // Make a couple conditions to grab the appropriate title from the entries table.
            $this->db->select( 'comments.id as comment_id, comments.record_id, comments.status, comments.date, comments.author, comments.content, comments.email, comments.website, comments.type');
            $this->db->select( 'entries.title, entries.id');
            $this->db->from( 'entries' );
            $this->db->from( 'comments' );
            $this->db->where( 'entries.id = `'. $this->db->dbprefix( 'comments' ) .'`.`record_id`' );
        }
        else
        {
            $this->db->select( 'comments.id as comment_id, comments.record_id, comments.status, comments.date, comments.author, comments.content, comments.email, comments.website, comments.type');
            $this->db->from( 'comments' );
        }

        if( $id != 0 )
        {
            $this->db->where( 'comments.record_id', $id );
        }

        $this->db->where( 'comments.type', $type );

        if( isset( $args['include_unpublished'] ) && $args['include_unpublished'] == false )
        {
            $this->db->where( 'comments.status', 'published' );
        } 

        if( isset( $args['order_by'] ) && count( $args['order_by'] ) == 2 )
        {
            $this->db->order_by( $args['order_by']['column'], $args['order_by']['direction'] );
        }
        else
        {
            $this->db->order_by( 'comments.date', 'asc' );
        }

        if( isset( $args['how_many'] ) && $args['how_many'] != 'all' )
        {
            $this->db->limit( $args['how_many'], $args['offset'] );
            $query = $this->db->get();
        }
        else 
        {
            $query = $this->db->get();
        }
        return $query->result();
    }
    // }}}
    // {{{ public function get_unapproved( $args( 'include_unpublished' => true, 'how_many' => 'all', 'offset' => 0 ) )
    public function get_unapproved( $args = array( 'how_many' => 'all', 'offset' => 0 ) )
    {
        $this->db->where( 'status', 'unpublished' );
        if( $args['how_many'] == 'all' )
        {
            $query = $this->db->get( 'comments' );
        }
        else if( isset( $args['offset'] ) && isset( $args['how_many'] ) ) 
        {
            $query = $this->db->get( 'comments', $args['how_many'], $args['offset'] );
        }
        else if( isset( $args['how_many'] ) ) 
        {
            $query = $this->db->get( 'comments', $args['how_many'] );
        }
        return $query->result();
    }
    // }}}
    // {{{ public function update_comment_count( $id )
    public function update_comment_count( $id, $type = 'entries' )
    {
        $this->db->select('id');
        $query = $this->db->get_where( 'comments',  array( 'record_id' => $id, 'type' => $type, 'status' => 'published' ) );
        $num = $query->num_rows();
        $this->db->where( 'id', $id );
        $update = array( 'comment_count' => $num );
        $this->db->update( $type, $update );
    }
    // }}}
    // {{{ public function delete( $id )
    public function delete( $id )
    {
        $this->db->select( 'record_id, type' );
        $query = $this->db->get_where( 'comments', array( 'id' => $id ) );
        $row = $query->row();
        $this->db->where( 'id', $id );
        $this->db->delete( 'comments' );
        $this->update_comment_count( $row->record_id, $row->type );
    }
    // }}}
    // {{{ public function approve( $id )
    public function approve( $id )
    {
        $this->db->where( 'id', $id );
        $approve = array( 'status' => 'published' );
        $this->db->update( 'comments', $approve );
        // Grab type for the comment_count update
        $this->db->select( 'record_id, type' );
        $query = $this->db->get_where( 'comments', array( 'id' => $id ) );
        $row = $query->row();
        $this->update_comment_count( $row->record_id, $row->type );
    }
    // }}}
    // {{{ public function unapprove( $id )
    public function unapprove( $id )
    {
        $this->db->where( 'id', $id );
        $unapprove = array( 'status' => 'unpublished' );
        $this->db->update( 'comments', $unapprove );
    }
    // }}}
}

?>
