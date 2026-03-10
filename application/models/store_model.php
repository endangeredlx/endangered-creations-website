<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store_model extends CI_Model 
{
    // {{{ VARIABLES
    var $class                  = 'store';
    var $singular               = 'item';
    var $plural                 = 'item';
    var $table                  = 'store';
    var $option_table           = 'store_options';
    var $option_value_table     = 'store_item_options';
    // }}}
    // {{{ public function get_records( $args ) 
    public function get_records( $args = array( 'include_unpublished' => false ) ) 
   {
      $this->db->flush_cache();
		
		if( ! $args['include_unpublished'] ) 
		{
			$this->db->where( 'status', 'published' );
		}
        $this->db->where( 'tr', '0' );
		$this->db->order_by( 'id', 'desc' ); 
		$query = $this->db->get( 'store', $args['how_many'], $args['offset'] );
		return $query->result();
	}
   // }}}
   // {{{ public function add_to_cart()
   public function add_to_cart()
   {
      echo $this->input->post( 'id' );
      return TRUE;
   }
   // }}}
   // {{{ public function get_record( $id, $noviews = false )
   public function get_record( $id, $noviews = false )
   {
		$this->db->where( "id", $id );
		$query = $this->db->get('store');
      if( !$noviews )
      {
			$this->update_views($id);
		}
		return $query->result();
	}
   // }}}
   // {{{ public function update_views( $id )
   public function update_views( $id )
   {
	   $query =	$this->db->query( 'Update `chi_store` set views=views+1 where `id` = ' . $id );
	}
   // }}}
   // {{{ public function add( $data ) 
   public function add( $data ) 
   {
		$this->db->insert( 'store', $data );
		return true;
	}
   // }}}
   // {{{ public function update( $id, $data ) 
   public function update( $id, $data ) 
   {
		$this->db->where( 'id', $id );
		$this->db->update( 'store', $data );
		return true;
	}
   // }}}
   // {{{ public function delete( $id ) 
   public function delete( $id ) 
   {
		$this->db->where( 'id', $id );
		$this->db->delete( 'store' );
	}
   // }}}
   // {{{ public function delete_photo( $id ) 
   public function delete_photo( $id ) 
   {
      $update = array( 'big_pic' => '', 'small_pic' => '' );
      $this->db->where( 'id', $id );
      $this->db->update( 'store', $update );
      return true;
   }
   // }}}
    // {{{ public function update_pic( $id )
    public function update_pic( $id )
    {
        $this->db->where( 'id', $id );
        $pic = $this->db->get( 'store' );
        $pic = $pic->row();
        $update = array(
            'pic'   => $pic->big_pic 
        );
        $this->db->where( 'id', $id );
        $this->db->update( 'store', $update );
    }
    // }}}
    // {{{ public function add_option( $id, $type, $type_id )
    public function add_option( $id, $type, $type_id, $mark_for_trash = false )
    {
        $insert = array(
            'type'      => $type,
            'type_id'   => $type_id,
            'record_id'   => $id
        );
        $insert['tr'] = ( $mark_for_trash ) ? 1 : 0;
        $this->db->insert( $this->option_table, $insert );
    }
    // }}}
    // {{{ public function update_options( $options )
    public function update_options( $id, $opt )
    {
        $optids = array();
        $this->load->helper('text');
        // Cycle through each option.
        for( $i = 0; $i < $opt['num_options']; $i++ )
        {
            $update = array();
            $pos = $i+1;
            // We create the choices string.
            $choices = array();
            for( $j = 0; $j < $opt['option_' . $pos . '_num_choices']; $j++ )
            {
                $npos = $j+1;
                $choices[] = $opt['option_' . $pos . '_choice_' . $npos] . '~' . url_title( $opt['option_' . $pos . '_choice_' . $npos], 'dash', true ); 
            }
            
            // Populate array and update the database.
            $op['values'] = implode( ',', $choices );
            $op['option'] = $opt['option_' . $pos . '_name'] . '~' . url_title( $opt['option_' . $pos . '_name'] );
            // If this option already existed.
            if( $opt['option_' . $pos . '_id'] != 0 )
            {
                $this->db->where( 'id', $opt['option_' . $pos . '_id'] );
                $q = $this->db->update( $this->option_value_table, $op );
                $optids[] = $opt['option_' . $pos . '_id'];
            }
            else
            {
                // Insert the option.
                $this->db->insert( $this->option_value_table, $op );
                $dbid = $this->db->insert_id();
                $optids[] = $dbid;
                // Insert the reference row.
                $ref = array(
                    'type_id'       => $dbid,
                    'record_id'     => $id,
                    'type'          => 'item_option',
                    'tr'            => 0
                );
                $this->db->insert( $this->option_table, $ref );
            }
        } 

        // Grab all the options one last time
        $this->db->flush_cache();
        $this->db->where( 'record_id', $id );
        $all_ops = $this->db->get( $this->option_table );

        // If there are options that we didn't interact with here, we delete them.
        // They are no longer associated with this item.
        foreach( $all_ops->result() as $chop )
        {
            if( !in_array( $chop->type_id, $optids ) )
            {
                $this->db->flush_cache();
                $did = $chop->id;
                $diid = $chop->type_id;
                $this->db->where( 'id', $did );  
                $this->db->delete( $this->option_table );
                $this->db->flush_cache();
                $this->db->where( 'id', $diid );  
                $this->db->delete( $this->option_value_table );
            }  
        }
    }
    // }}}
}

?>
