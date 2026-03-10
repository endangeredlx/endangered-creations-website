<?php if( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Presentation_model extends CI_Model 
{
   public function get_records( $args ) 
   {
      $this->db->flush_cache();
		
		if( ! $args['unpub'] ) 
		{
			$this->db->where( 'status', 'published' );
		}
		$this->db->order_by( 'id', 'desc' ); 
		$query = $this->db->get( 'presentation_themes', $args['how_many'], $args['offset'] );
		return $query->result();
	}

   public function get_record( $id )
   {
		$this->db->where( array( 'id' => $id, 'status' => 'published' ) );
		$query = $this->db->get( 'presentation_themes' );
		return $query->result();
	}

   public function get_theme_page( $id, $page )
   {
      $this->db->flush_cache();
      $this->db->where( array( 'theme_id' => $id, 'name' => $page ) );
      $query = $this->db->get( 'presentation_pages', 1 );

      // If that query returns nothing we get options for the 'general' page
      if( $query->num_rows() < 1 )
      {
          unset( $query );
          $this->db->flush_cache();
          $this->db->where( array( 'theme_id' => $id, 'name' => 'general' ) );
          $query = $this->db->get( 'presentation_pages', 1 );
      }

      return $query->row();
   } 

   public function get_user_theme( $id )
   {
      $this->db->select( 'theme_id', 'id', 'verified' )->where( array( 'id' => $id, 'verified' => 1 ) ); 
      $user = $this->db->get( 'user' )->row();
      $this->db->flush_cache();
      $this->db->where( array( 'id' => $user->theme_id, 'status' => 'published' ) );
      $theme = $this->db->get( 'presentation_themes' );
      return $theme->row();
   }
	
   public function add( $data ) 
   {
		$this->db->insert( 'presentation_themes', $data );
		return true;
	}
	
   public function update( $id, $data ) 
   {
		$this->db->where( 'id', $id );
		$this->db->update( 'presentation_themes', $data );
		return true;
	}
	
   public function delete( $id ) 
   {
		$this->db->where( 'id', $id );
		$this->db->delete( 'presentation_themes' );
	}

   public function delete_photo( $id ) 
   {
      $update = array( 'big_pic' => '', 'small_pic' => '' );
      $this->db->where( 'id', $id );
      $this->db->update( 'presentation_themes', $update );
      return true;
   }
}

?>
