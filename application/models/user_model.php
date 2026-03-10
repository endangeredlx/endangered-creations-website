<?php if( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class User_model extends CI_Model 
{
   public function get_records( $args ) 
   {
      $this->db->flush_cache();
		
		if( ! $args['unpub'] ) 
		{
			$this->db->where( 'verified', '1' );
		}
		$this->db->order_by( 'id', 'desc' ); 
		$query = $this->db->get( 'user', $args['how_many'], $args['offset'] );
		return $query->result();
	}

   public function get_record( $id )
   {
		$this->db->where( 'id', $id );
		$query = $this->db->get( 'user' );
		return $query->result();
	}

   public function add( $data ) 
   {
		$add = $this->db->insert( 'user', $data );
		return $add;
	}
	
   public function update( $id, $data ) 
   {
		$this->db->where( 'id', $id );
		$update = $this->db->update( 'user', $data );
		return $update;
	}
	
   public function delete( $id ) 
   {
		$this->db->where( 'id', $id );
		$this->db->delete( 'user' );
	}

   public function delete_photo( $id ) 
   {
      $update = array( 'big_pic' => '', 'small_pic' => '' );
      $this->db->where( 'id', $id );
      $this->db->update( 'user', $update );
      return true;
   }

   /*---------------------------------------------------------------------------------------*/
   /////////////////////////////////////////////////////////////////////////////////////////
   // SPECIAL USER FUNCTIONS
   /////////////////////////////////////////////////////////////////////////////////////////
   /*---------------------------------------------------------------------------------------*/

   public function validate()
   {
      $login = $this->input->post( 'login' );
		$this->db->where( "`display_name` = '" . $login . "' OR `email` = '" . $login . "'" );
		$this->db->where( 'password', md5( $this->input->post('password') ) );
		$query = $this->db->get( 'user' );
		$data = array();
		
		if( $query->num_rows == 1 )
		{
			foreach( $query->result() as $row ) 
			{	
				$data['id']	= $row->id;
				$data['display_name'] = $row->display_name;
				$data['privilege'] = $row->privilege;
				$data['valid'] = true;
			}
		} 
		else 
		{
			$data['valid'] = false;
		}
		return $data;
   }

   private function construct_confirm_message( $raw, $link )
   {
      $m_array = explode( '|', $raw );
      $data = array();
      foreach( $m_array as $slice )
      {
         $piece = explode( '~', $slice );
         switch( $piece[0] )
         {
            case 'subject' :
               $data['subject'] = $piece[1];
               break; 
            case 'message' :
               $data['message'] = $piece[1];
               break; 
         }
      }
      if( !empty( $data['message'] ) )
      {
         $data['message'] = str_replace( '{confirm_link}', $link, $data['message'] );
      }
      //$data['message'] = nl2br( $data['message'] );
      return $data;
   }

   public function email_confirmation( $id, $email, $hash )
   {
      // Load the email library.
      $this->load->library( 'email' );

      // Get the default 'email confirmation' email from the database.
      $this->db->where( 'name', 'email_confirm' );
      $get_message = $this->db->get( 'options' );
      $raw_message = $get_message->row();
      $confirm_link = base_url() . 'index.php?user/confirm_account/' . $id . '/' . $hash;
      $message = $this->construct_confirm_message( $raw_message->value, $confirm_link );

      // Set up the email and send. 
      $this->email->from( 'accounts@dominiquedebeau.com', 'Dominique Debeau' );
      $this->email->to( $email );
      $this->email->subject( $message['subject'] );
      $this->email->message( $message['message'] );
      if( $this->email->send() )
      {
         return true;
      }
      else
      {
         return false;
      }
   }
}

?>
