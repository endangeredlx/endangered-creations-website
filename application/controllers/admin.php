<?php
class Admin extends CI_Controller 
{
    var $trash_enabled = array( 'team', 'team_options', 'photo_albums', 'store', 'store_options', 'music_playlists' );
    // {{{ public function Admin()
	public function Admin()
	{
        define('CHECK_UPDATES', false);
		parent::__construct();	
	}
    // }}}
    // {{{ public function index()
	public function index($error = false, $warning = false) 
	{
      $layout_params = array( 'user_id' => 1, 'page' => 'entries' );
      $option_params = array( 'user_id' => 1 );

      // Load the necessary libraries. 
      $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
      $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
      
      // Main page configuration.
      $Presentation =& $this->ChiPresentation;
      $Options =& $this->ChiOptions;

		/* CHECK TO SEE IF USER IS LOGGED IN */
      
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true) 
		{
		
			$data = array();
			$data['main_content'] = 'admin/login/login_view';
			$data['error'] = $error;
			$data['warning'] = $warning;
			// IF THEY ARE NOT LOGGED IN SEND THEM BACK TO THE LOGIN AREA.
			$this->load->view( 'admin/clone',$data);
			//die();
		} 
		else 
		{
			// OTHERWISE SEND THEM TO THE DASHBOARD.
			redirect( 'admin/home' );
		}
	}
    // }}}
	// --- UTILITES --- //
    // {{{ public function login_check() 
	public function login_check() 
	{
		$this->load->model('login_model');
		$query = $this->login_model->validate();
		
		if($query['valid']) // if the user's credentials validated...
		{
			$data = array(
				'mid' 		    => $query['id'],
				'login'		    => $this->input->post('login'),
				'alias'         => $query['alias'],
				'privilege'	    => $query['privilege'],
				'is_logged_in' 	=> true
			);
			$this->session->set_userdata($data);
			redirect('admin/home');
		}
		else // incorrect username or password
		{
			$this->index();
		}
	}
    // }}}
    // {{{ public function logout() 
	public function logout() 
	{
		$this->session->sess_destroy();
		$this->index();
	}
    // }}}
    // {{{ public function is_logged_in()
	public function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true) 
		{
			redirect('admin/index');
		}	
	}
    // }}}
	// --- HOME/LAYOUT FUNCTIONS --- //
    // {{{ public function home( $success = false, $warning = false, $error = false )
	public function home( $success = false, $warning = false, $error = false )
	{
        // Set up a few parameters
        $offset = 0;
        $params = array( 'type' => 'page', 'how_many' => 0, 'offset' => $offset, 'tumblr' => 'false', 'include_unpublished' => true, 'pages' => true );
        $option_params = array( 'user_id' => 1 );

        // Load necessary libraries and helpers.
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        $this->load->helper('form');
        $this->load->model( 'comments_model', 'comments' );
        $comments = $this->comments->get_unapproved();
        $num_unapproved = count( $comments );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;

		$this->is_logged_in();
        $data = array();

        // Grab dashboard notifications.
        $this->db->order_by('date', 'desc');
        $notifications = $this->db->get('notifications');
        
		$success = ( $success === true || $success === false ) ? $success : false;
        $data = array(
            'records'           => $ChiQL,
            'num_unapproved'    => $num_unapproved,
            'options'           => $Options,
            'notifications'     => $notifications,
            'success'           => $success,
            'warning'           => $warning,
            'error'             => $error,
            'main_content'      => "admin/dashboard"
        );
		$this->load->view('admin/clone',$data);
	}
    // }}}
    // {{{ public function resize_img()
	//END "RESIZE IMAGE LAYOUT" FUNCTION
	/*
		This function changes the dimensions of a image and immediate displays it in the browser. 
		It helps if you don't want to save several sizes of the images.
	*/
	public function resize_img()
	{
		$data = array();
		$this->load->model( 'resize_model' );
		$image = urldecode( $this->uri->segment(3) );
		$by = $this->uri->segment( 4 );
		$dim = $this->uri->segment( 5 );
		$this->resize_model->load( $image );
		if( $by == "width" )
		{
			$this->resize_model->resizeToWidth( $dim );
		}
		else if( $by == "height" )
		{
			$this->resize_model->resizeToHeight( $dim );
		}
		$this->resize_model->output();
		
	}
    // }}}
    // {{{ public function empty_trash( $tables = 'all' )
    public function empty_trash( $tables = 'all' )
    {
        if( is_array( $tables ) )
        {
            foreach( $tables as $table )
            {
                $this->db->where( 'tr', 1 );
                $this->db->delete( $trash );
            } 
        }
        else if( $tables == 'all' )
        {
            foreach( $this->trash_enabled as $trash )
            {
                $this->db->where( 'tr', 1 );
                $this->db->delete( $trash );
            }
        }
    }
    // }}}
}

/* End of file admin.php */
/* Location: ./system/application/controllers/admin.php */

?>
