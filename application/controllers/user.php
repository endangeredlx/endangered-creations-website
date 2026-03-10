
<?php

class User extends CI_Controller 
{
	public function User()
	{
		parent::__construct();	
	}

   /*
    * Register
    *
    * Creates new user and sends off a confirmation email.
    */
   public function register()
   {
      $this->load->library('form_validation');
      //Set validation rules...
      $this->form_validation->set_rules( 'email', 'Email', 'trim|required|valid_email|matches[emailconf]' );            
      $this->form_validation->set_rules( 'emailconf', 'Re-Enter Email', 'trim|required' );            
      $this->form_validation->set_rules( 'first_name', 'First Name', 'trim|required|alpha' );            
      $this->form_validation->set_rules( 'last_name', 'Last Name', 'trim|required|alpha' );            
      $this->form_validation->set_rules( 'username', 'Username', 'trim|required|alpha_numeric|min_length[5]|max_length[20]' );            
      $this->form_validation->set_rules( 'newpassword', 'Password', 'trim|required' );            
      $this->form_validation->set_error_delimiters( '<div class="err prpBg white"> <strong>Error : </strong>' , '</div>' );

      if ( $this->form_validation->run() == TRUE ) 
      {
         $this->load->model( 'user_model', 'user' );
         $user_data = array(
            'first_name'         => $this->input->post( 'first_name' ),
            'last_name'          => $this->input->post( 'last_name' ),
            'email'              => $this->input->post( 'email' ),
            'display_name'       => $this->input->post( 'username' ),
            'privilege'          => 10,
            'verified'           => 0,
            'password'           => md5( $this->input->post( 'newpassword' ) )
         );
         
         $insert = $this->user->add( $user_data );
         $id = $this->db->insert_id();
         $confirm_hash = md5( $id . $this->input->post( 'username' ) );
         $update = $this->user->update( $id, array( 'confirm_hash' => $confirm_hash ) );

         $send_email = $this->user->email_confirmation( $id, $this->input->post( 'email' ), $confirm_hash );
         
         if( $insert && $update && $send_email )
         {
            $this->signin( true );
         }
      }
      else 
      {
         $this->signin( false );
      }
   }

   public function login()
   {
		$this->load->model( 'user_model', 'user' );
		$query = $this->user->validate();
		
		if( $query['valid'] ) // if the user's credentials validated...
		{
			$data = array(
				'uid' 		      => $query['id'],
				'display_name'    => $query['display_name'],
				'privilege' 	   => $query['privilege'],
				'is_logged_in' 	=> true
			);
			$this->session->set_userdata( $data );
         $this->session->set_flashdata( 'just_logged_in', true );
			redirect( 'run/index' );
      }
   }

   public function logout()
   {
      $this->session->unset_userdata( 'uid' );
      $this->session->unset_userdata( 'display_name' );
      $this->session->unset_userdata( 'is_logged_in' );
      $this->session->unset_userdata( 'privilege' );
      $this->session->set_flashdata( 'just_logged_out', true );
      redirect( 'run/index' );
   }
	 
   public function signin( $success = "" ) 
   {
      // Set up a few parameters
      $layout_params = array( 'user_id' => 1, 'page' => 'general' );
      $option_params = array( 'user_id' => 1 );

      // Load the necessary libraries. 
      $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
      $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
     
      // Main page configuration.
      $Presentation =& $this->ChiPresentation;
      $Options =& $this->ChiOptions;
      $data = array(
         'success'            => $success, 
         'presentation'       => $Presentation,
         'options'            => $Options, 
         'page_title'         => " | Sign-In or Register",
         'title'              => 'Sign-In',
         'type'               => 'user', 
         'page_type'          => 'user',
         'main_content'       => $Presentation->theme_relative_path() . 'user/signin'
      );

      // Load view.
      $this->load->view( $Presentation->theme_relative_path() . 'clone', $data );
	}
}

?>
