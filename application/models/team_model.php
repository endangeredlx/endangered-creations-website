<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Team_model extends CI_Model 
{
    // {{{ VARIABLES
    var $class          = 'team';
    var $singular       = 'artist';
    var $plural         = 'team';
    var $table          = 'team';
    var $option_table = 'team_options';
    // }}}
    // {{{ public function get_records( $args ) 
    public function get_records( $args = array( 'include_unpublished' => false, 'how_many' => 'all' ) ) 
    {
        $this->db->flush_cache();
        $this->db->where( 'tr !=', 1 );

        if( !isset( $args['include_unpublished'] ) || !$args['include_unpublished'] ) 
        {
            $this->db->where( 'status', 'published' );
        }

        if( isset( $args['order_by'] ) )
        {
            $this->db->order_by( $args['order_by'] );
        }

        if( isset( $args['id'] ) )
        {
            $this->db->where( 'id', $args['id'] );
            $query = $this->db->get( $this->primary_table );
        }
        else if( $args['how_many'] != 'all' )
        {
            $query = $this->db->get( $this->primary_table, $args['how_many'], $args['offset'] );
        }
        else 
        {
            $query = $this->db->get( $this->primary_table );
        }
        $this->db->order_by( 'id', 'ASC' );
        return $query->result();
    }
    // }}}
    // {{{ public function get_record( $id, $noviews = false )
    public function get_record( $id, $noviews = false )
    {
        $this->db->where( 'id', $id );
        $query = $this->db->get( $this->primary_table );
        if( !$noviews )
        {
            $this->update_views($id);
        }
        return $query->result();
    }
    // }}}
    // {{{ public function get_last( $number ) 
    public function get_last( $number ) 
    {
        $this->db->select( 'id, title, excerpt, date, status' );
        $this->db->where( 'status', 'published' );
        $this->db->where( 'type', 'post' );
        $this->db->order_by( 'date', 'desc' );
        $result = $this->db->get( 'team', 5 );
        return $result->result();
    }
    // }}}
    // {{{ public function get_archives( $amount = 5 )
    public function get_archives( $amount = 5 )
    {
        if( $amount === "all" )
        {
        } 
        else if( is_numeric( $amount ) )
        {
            $data = array();
            $today = time();
            $this_month = date( 'n', $today );
            $this_date = date( 'j', $today );
            $this_year = date( 'Y', $today );
            for( $i = 0; $i < $amount; $i++ )
            {
                $curr_month_unix = mktime( 0, 0, 0, ( $this_month - $i ) );
                $curr_month_num = date( 'n', $curr_month_unix );
                $query = $this->db->query( "Select `id` from `" . $this->db->dbprefix('team') . "` where MONTH( FROM_UNIXTIME( `date` ) ) = '$curr_month_num';");
                if( $query->num_rows() > 0 )
                {
                    $data[] = array();
                    $data[ ( count( $data ) - 1 ) ]['month'] = date( 'F', $curr_month_unix );
                    $data[ ( count( $data ) - 1 ) ]['month_num'] = date( 'n', $curr_month_unix );
                    $data[ ( count( $data ) - 1 ) ]['year'] = date( 'Y', $curr_month_unix );
                }
            }
        }
        return $data;
    }
    // }}}
    // {{{ public function update_views( $id )
    public function update_views( $id )
    {
        $query =	$this->db->query( "Update `" . $this->db->dbprefix( $this->primary_table ) . "` set views=views+1 where `id` = " . $id );
    }
    // }}}
    // {{{ public function update_comment_count ( $id )
    public function update_comment_count ( $id )
    {
        $this->db->query( "Update `" . $this->db->dbprefix('team') . "` set comment_count=comment_count+1 where `id` = " . $id );
    }
    // }}}
    // {{{ public function get_comments( $id ) 
    public function get_comments( $id ) 
    {
        $this->db->where('entry_type','entry');
        $this->db->where('entry_id',$id);
        $query = $this->db->get('comments');
        return $query->result();
    }
    // }}}
    // {{{ public function add( $data ) 
    public function add( $data ) 
    {
        $this->db->insert( 'team', $data );
        return true;
    }
    // }}}
    // {{{ public function update( $id, $data ) 
    public function update( $id, $data ) 
    {
        $this->db->where("id", $id);
        $this->db->update('team', $data);
        return true;
    }
    // }}}
    // {{{ public function delete( $id ) 
    public function delete( $id ) 
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'team' );
    }
    // }}}
    // {{{ public function delete_photo( $id ) 
    public function delete_photo( $id ) 
    {
        $update = array( 'pic' => '' );
        $this->db->where( 'id', $id );
        $this->db->update( 'team', $update );
        return true;
    }
    // }}}
    // {{{ public function add_option( $id, $type, $type_id )
    public function add_option( $id, $type, $type_id, $mark_for_trash = false )
    {
        $insert = array(
            'type'          => $type,
            'type_id'       => $type_id,
            'record_id'     => $id
        );
        $insert['tr'] = ( $mark_for_trash ) ? 1 : 0;
        $this->db->insert( $this->option_table, $insert );
    }
    // }}}
    // {{{ public function update_option( $id, $type, $type_id )
    public function update_option( $id, $update )
    {
        $this->db->where( 'id', $id );
        $this->db->update( $this->option_table, $update );
    }
    // }}}
}
?>
