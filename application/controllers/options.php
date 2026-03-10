<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Options extends CI_Controller 
{
    // {{{ VARIABLES 
    var $class          = 'options';
    var $singular       = 'option';
    var $plural         = 'options';
    // }}}
    // {{{ public function Options()
    public function Options()
    {
        parent::__construct();
    }
    // }}}
    // --- BASIC ADMIN FUNCTIONS --- //
    // {{{ public function login_check()
    public function login_check()
    {
        $this->load->model('login_model');
        $query = $this->login_model->validate();
        if($query['valid']) // if the user's credentials validated...
        {
        $data = array(
        'mid'            => $query['id'],
        'login'         => $this->input->post('login'),
        'alias'         => $query['alias'],
        'privilege'    => $query['privilege'],
        'is_logged_in' => true
        );
        //$this->session->set_userdata($data);
        redirect('admin/home');
        }
        else // incorrect username or password
        {
        redirect('admin/index');
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
    // --- BASIC VIEW FUNCTIONS ---//
    // {{{ public function index()
    public function index()
    {
    }
    // }}}
    // {{{ public function edit( $success = false, $warning = false, $error = false )
    public function edit( $success = false, $warning = false, $error = false )
    { 
        $this->is_logged_in();
        $data = array();
        // Set up a few parameters
        $params = array( 
            'type'                  => 'options', 
            'how_many'              => 1, 
            'offset'                => 0, 
            'tumblr'                => 'false', 
            'id'                    => 0,
            'include_unpublished'   => true, 
            'pages'                 => true 
        );

        $option_params = array( 'user_id' => 1 );

        // Ensure that any update notifications are true booleans
        $success = ( $success === true || $success === false ) ? $success : false;
        $warning = ( $warning === true || $warning === false ) ? $warning : false;
        $error = ( $error === true || $error === false ) ? $error : false;

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;

        // Main data array.
        $data = array(
            'records'           => $ChiQL,
            'options'           => $Options, 
            'success'           => $success,
            'warning'           => $warning,
            'error'             => $error,
            'class'             => $this->class,
            'main_content'      => 'admin/' . $this->class . '/edit',
            'javascript'        => array( 'tiny_mce/tiny_mce', 'general/admin.basic', $this->class . '/edit' ),
            'singular'          => $this->singular
        );

        // Load view.
        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function update()
    public function update()
    {
        $this->is_logged_in();
        $this->load->helper( 'text' );
        $this->load->model( 'options_model', 'options' );
        $this->load->library('form_validation');
        //Set validation rules...
        $this->form_validation->set_rules( 'main_email', 'Main Email', 'trim|valid_email|required');            
        $this->form_validation->set_rules( 'site_name', 'Site Name', 'trim||required');            
        $this->form_validation->set_rules( 'facebook_link', 'Facebook Link', 'trim|prep_url');            
        $this->form_validation->set_rules( 'twitter_link', 'Twitter Link', 'trim|prep_url');            
        $this->form_validation->set_rules( 'vimeo_link', 'Vimeo Link', 'trim|prep_url');            
        $this->form_validation->set_rules( 'site_description', 'Site Description', 'trim|strip_tags' );
        //$this->form_validation->set_rules( 'google_ad_300x250', 'Google Ad 300x250', 'trim' );
        //$this->form_validation->set_rules( 'google_ad_728x90', 'Google Ad 728x90', 'trim' );
        $this->form_validation->set_error_delimiters('<div class="notice error">', '</div>');

        if ( $this->form_validation->run() == TRUE ) 
        {
            $main_feature_video = array( 'video' => $this->input->post( 'main_feature_video' ), 'title' => $this->input->post( 'main_feature_video_title' ) ); 
            $second_feature_video = array( 'video' => $this->input->post( 'second_feature_video' ), 'title' => $this->input->post( 'second_feature_video_title' ) ); 
            $third_feature_video = array( 'video' => $this->input->post( 'third_feature_video' ), 'title' => $this->input->post( 'third_feature_video_title' ) ); 
            $featured_videos = array( 
                'main_feature_video'    => $main_feature_video,
                'second_feature_video'  => $second_feature_video,
                'third_feature_video'   => $third_feature_video
            );
            $fv_json = json_encode( $featured_videos );
            $update = array(
                'site_name'             => $this->input->post( 'site_name' ),
                'main_email'            => $this->input->post( 'main_email' ),
                'facebook_link'         => $this->input->post( 'facebook_link' ),
                'twitter_link'          => $this->input->post( 'twitter_link' ),
                'featured_video'        => $this->input->post( 'featured_video' ),
                'site_description'      => $this->input->post( 'site_description' ),
                //'google_ad_300x250'     => $this->input->post( 'google_ad_300x250' ),
                //'google_ad_728x90'      => $this->input->post( 'google_ad_728x90' ),
                'featured_videos'       => $fv_json,
                'vimeo_link'            => $this->input->post( 'vimeo_link' )
            );

            $change = $this->options->bulk_update( $update );
            $success = $change;
            $this->edit( $success );
        } 
        else 
        {   
            $success = false;
            $this->edit( $success, false, true );
        }
    }
    // }}}
}

?>
