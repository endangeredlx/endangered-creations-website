<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Photos_model extends CI_Model 
{
    // {{{ VARIABLES
    var $class                  = 'photos';
    var $primary_singular       = 'album';
    var $primary_plural         = 'albums';
    var $primary_table          = 'photo_albums';
    var $secondary_singular     = 'photo';
    var $secondary_plural       = 'photos';
    var $secondary_table        = 'photos';
    // }}}
    // {{{ public function add( $data )
    public function add( $data )
    {
        $this->db->insert( $this->primary_table, $data ); 
        return true;
    }
    // }}}
    // {{{ public function get_record( $id )
    public function get_record( $id )
    {
        $this->db->where( 'id', $id );
        $query = $this->db->get( $this->primary_table );
        return $query->result();
    }
    // }}}
    // {{{ public function get_comments( $id ) 
    public function get_comments( $id ) 
    {
        $this->db->where('entry_type','photo');
        $this->db->where('entry_id',$id);
        $query = $this->db->get('comments');
        return $query->result();
    }
    // }}}
    // {{{ public function get_records( $args ) 
    public function get_records( $args = array( 'include_unpublished' => false, 'offset' => 0, 'how_many' => 'all' ) ) 
    {
        $this->db->flush_cache();
        $this->db->where( 'tr !=', 1 );
        $this->db->where( "`description` NOT REGEXP '^[~]{3}[a-zA-Z_0-9\|]+[~]{3}$'");

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
        $this->db->order_by( 'id', 'DESC' );
        return $query->result();
    }
    // }}}
    // {{{ public function update( $id, $data ) 
    public function update( $id, $data ) 
    {
        $this->db->where( 'id', $id );
        $update = $this->db->update( $this->primary_table, $data );
        return $update;
    }
    // }}}
    // {{{ public function update_photo_record( $id, $data ) 
    public function update_photo_record( $id, $data ) 
    {
        $this->db->where( 'id', $id );
        $this->db->update( $this->secondary_table, $data );
    }
    // }}}
    // {{{ public function update_album_size( $id ) 
    public function update_album_size( $id ) 
    {
        $this->db->flush_cache();
        $this->db->where( 'ref_id', $id );
        $this->db->select( 'id' );
        $query = $this->db->get( $this->secondary_table );
        $num = $query->num_rows();
        $this->db->flush_cache();
        $this->db->where( 'id', $id );
        $this->db->update( $this->primary_table, array( 'size' => $num ) );
    }
    // }}}
    // {{{ public function create_pic_row ( $id ) 
    public function create_pic_row ( $id ) 
    {
        $data = array(
            'ref_id' => $id,
            'date' 	 => time(),
        );
        $this->db->insert( $this->secondary_table, $data ); 
        return $this->db->insert_id();
    }
    // }}}
    // {{{ public function make_cover( $pid, $aid ) 
    public function make_cover( $pid, $aid ) 
    {
        $this->db->where( 'id', $pid );
        $photo_query = $this->db->get( $this->secondary_table );
        $photo = $photo_query->row();
        $this->db->flush_cache();
        $update = array(
            'large' 	  	=> $photo->large,
            'large_width' 	=> $photo->large_width,
            'large_height'	=> $photo->large_height,
            'small'		  	=> $photo->small,
            'small_width' 	=> $photo->small_width,
            'small_height' 	=> $photo->small_height,
            'square' 		=> $photo->square,
            'square_width'	=> $photo->square_width
        );
        $this->db->where( 'id', $aid );
        $this->db->update( $this->primary_table, $update );
        return true;
    }
    // }}}
    // {{{ public function delete_record( $id ) 
    public function delete_record( $id ) 
    {
        $this->db->where( 'id', $id );
        $this->db->delete( $this->primary_table );
    }
    // }}}
    // {{{ public function get_photos( $id ) 
    public function get_photos( $id ) 
    {
        $this->db->flush_cache();
        $this->db->where( 'ref_id', $id );
        $this->db->order_by( 'order desc' );
        $query = $this->db->get( $this->secondary_table );
        return $query->result();
    }
    // }}}
    // {{{ public function set_photo_order( $pid, $order )
    public function set_photo_order( $pid, $order )
    {
        $this->db->where( 'id', $pid );
        $this->db->update( $this->secondary_table, array( 'order' => $order ) );
    }
    // }}}
    // {{{ public function delete_photo( $id ) 
    public function delete_photo( $id ) 
    {
        $this->db->where('id',$id);
        $this->db->delete( $this->secondary_table );
        $this->db->flush_cache();
    }
    // }}}
    // {{{ public function set_order( $aid, $pid )
    public function set_order( $aid, $pid )
    {
        $get_order = mysql_query( "Select max(`order`) from `" . $this->db->dbprefix( $this->secondary_table ) . "` where `ref_id` = '$aid' order by `order` desc;" );
        $photo_order = mysql_fetch_array( $get_order );
        $new_order = $photo_order['max(`order`)'] + 1; 
        $make_order = mysql_query( "Update `" . $this->db->dbprefix( $this->secondary_table ) . "` set `order` = '$new_order' where `id` = '$pid';" );
    }
    // }}}
    // {{{ public function reorder_photos( $aid ) 
    public function reorder_photos( $aid ) 
    {
        $this->db->where( 'ref_id', $aid );
        $this->db->order_by( 'order asc' );
        $records = $this->db->get( $this->secondary_table );
        $count = 1;

        if( $records->num_rows() > 0 ) 
        { 
            foreach( $records->result() as $row ) 
            {
                $this->db->flush_cache();
                $this->db->where( 'id', $row->id );
                $update = array( 'order' => $count );
                $this->db->update( $this->secondary_table, $update );
                $count++;
            }
        }
        return true;
    }
    // }}}
    // {{{ public function get_photo_record( $id )
    public function get_photo_record( $id )
    {
        $this->db->where( 'id', $id );
        $query = $this->db->get( $this->secondary_table );
        return $query->row();
    }
    // }}}
    // {{{ public function get_next_id( $data, $num )
    public function get_next_id( $data, $num )
    {
        $this->db->flush_cache();
        $this->db->where( array( 'ref_id' => $data->ref_id, 'order' => ( ( $data->order ) - 1 ) ) );
        $next_info = $this->db->get( $this->secondary_table );
        if( $next_info->num_rows() == 0 )
        {
            $this->db->flush_cache();
            $this->db->where( array( 'ref_id' => $data->ref_id, 'order' => $num ) );
            $true_next = $this->db->get( $this->secondary_table );
            //print_r($true_next);
            $true_next_info = $true_next->row();
            $next = $true_next_info->id;
        }
        else
        {
            $next_num = $next_info->row();
            $next = $next_num->id;
        }
        return $next;
    }
    // }}}
    // {{{ public function get_prev_id( $data )
    public function get_prev_id( $data )
    {
        $this->db->where( array( 'ref_id' => $data->ref_id, 'order' => ( ( $data->order ) + 1 ) ) );
        $prev_info = $this->db->get( $this->secondary_table );
        if( $prev_info->num_rows() == 0 ) 
        {
            $this->db->flush_cache();
            $this->db->where( array( 'ref_id' => $data->ref_id, 'order' => 1 ) );
            $true_prev = $this->db->get( $this->secondary_table );
            $true_prev_info = $true_prev->row();
            $prev = $true_prev_info->id;
        }
        else
        {
            $prev_num = $prev_info->row();
            $prev = $prev_num->id;
        }
        return $prev;
    }
    // }}}
    // {{{ public function switch_order($myid, $swid) 
    public function switch_order( $myid, $swid ) 
    {
        $this->db->where( 'id', $myid );
        $myid_order = $this->db->get( $this->secondary_table );
        $my_order = $myid_order->row();
        $this->db->flush_cache();

        $this->db->where( 'id', $swid );
        $swid_order = $this->db->get( $this->secondary_table );
        $sw_order = $swid_order->row();
        $this->db->flush_cache();

        $this->db->where( 'id', $myid );
        $this->db->update( $this->secondary_table, array( 'order' => $sw_order->order ) );
        $this->db->flush_cache();

        $this->db->where( 'id', $swid );
        $this->db->update( $this->secondary_table, array( 'order' => $my_order->order ) );
        $this->db->flush_cache();
    }
    // }}}
}
?>
