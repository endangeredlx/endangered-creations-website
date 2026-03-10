<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Links extends CI_Controller 
{
    // {{{ VARIABLES 
    var $class          = 'links';
    var $singular       = 'link';
    var $plural         = 'links';
    var $table          = 'links';
    // }}}
    // {{{ public function __construct()
    public function __construct()
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
    // {{{ public function write( $success = false, $warning = false, $error = false )
    public function write( $success = false, $warning = false, $error = false )
    {
        $this->is_logged_in();
        // Set up a few parameters
        $offset = 0;
        $params = array( 
            'type'                  => 'post', 
            'how_many'              => 0, 
            'offset'                => $offset, 
            'tumblr'                => 'false', 
            'include_unpublished'   => true, 
            'pages'                 => true 
        );
        $option_params = array( 'user_id' => 1 );

        // Load necessary libraries and helpers.
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        $this->load->helper('form');

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;

        $data = array(
            'records'       => $ChiQL,
            'options'       => $Options,
            'success'       => $success,
            'warning'       => $warning,
            'error'         => $error,
            'class'         => $this->class,
            'singular'      => $this->singular,
            'main_content'  => 'admin/' . $this->class . '/write'
        );

        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function edit( $success = false, $warning = false, $error = false )
    public function edit( $success = false, $warning = false, $error = false )
    { 
        $data = array();
        $id = $this->uri->segment( 3 );
        // Set up a few parameters
        $params = array( 
            'type'      => $this->class, 
            'class'     => $this->class,
            'how_many'  => 1, 
            'id'        => $id, 
            'pages'     => true 
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
            'javascript'        => array( 'general/admin.basic', $this->class . '/edit' ),
            'singular'          => $this->singular
        );

        // Load view.
        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function manage()
    public function manage()
    {
        $this->is_logged_in();
        // Set up a few parameters
        $offset = ( $this->uri->segment( 3 ) == "" ) ? 0 : $this->uri->segment( 3 );
        $params = array( 
            'type'                  => $this->class, 
            'class'                 => $this->class,
            'how_many'              => 10, 
            'offset'                => $offset, 
            'tumblr'                => 'false', 
            'include_unpublished'   => true, 
            'pages'                 => true 
        );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        $this->load->helper('date');

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;
        // Main data array.
        $data = array(
            'records'               => $ChiQL,
            'options'               => $Options, 
            'type'                  => $this->class, 
            'class'                 => $this->class,
            'singular'              => $this->singular,
            'plural'                => $this->plural,
            'javascript'            => array( 'general/admin.basic', $this->class . '/manage' ),
            'main_content'          => 'admin/' . $this->class . '/manage'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $config = array(
            'base_url'           => base_url() . $htfix . $this->class . '/manage/',
            'total_rows'         => $this->db->get( $this->table )->num_rows(),
            'per_page'           => $params['how_many'],
            'num_links'          => 8,
            'uri_segment'        => 4,
            'full_tag_open'      => '<div id="pgntn" class="clearfix">',
            'full_tag_close'     => '</div>'
        );
        $this->pagination->initialize( $config );

        // Load view.
        $this->load->view( 'admin/clone', $data ); 
    }
    // }}}
    // --- CRUD FUNCTIONS ---//
    // {{{ public function create()
    public function create()
    {
        $this->is_logged_in();
        $this->load->helper('text');
        $this->load->model('links_model', 'links');
        $this->load->library('form_validation');   
        $this->form_validation->set_error_delimiters('<div class="notice error">', '</div>');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');            
        if ( $this->form_validation->run() == TRUE ) 
        {
            $insert = array(
                'title'             => $this->input->post('title'),
                'url'               => $this->input->post('url'),
                'description'       => $this->input->post('description'),
                'status'            => 'published'
            );
            $add = $this->links->add( $insert );
            $id = $this->db->insert_id();

            if( $add ) 
            {
                redirect( 'links/edit/' . $id );
            } 
            else 
            {      
                $this->write( false, false, true );
            }
        } 
        else 
        {
        $this->write( false, false, true );
        }
    }
    // }}}
    // {{{ public function update()
    public function update()
    {   
        $this->is_logged_in();
        $this->load->helper('text');
        $this->load->model( 'links_model', 'links' );
        $this->load->library('form_validation');
        //Set validation rules...
        $this->form_validation->set_rules('title', 'Title', 'trim|required');            
        $this->form_validation->set_error_delimiters('<div class="notice error">', '</div>');

        if ( $this->form_validation->run() == TRUE ) 
        {
            $id = $this->uri->segment(3);
            $order_was = $this->input->post('order_was');
            $status_was = $this->input->post('status_was');
            $status_is = $this->input->post('status');
            $order = ( $status_was == 'unpublished' && $status_is == 'published' ) ? $this->links->get_next_order( 'links' ) : $order_was;     
            $order = ( $status_was == 'published' && $status_is == 'unpublished' ) ? 0 : $order;     

            $update = array(
                'title'         => $this->input->post('title'),
                'url'           => $this->input->post('url'),
                'description'   => $this->input->post('description'),
                'status'        => $status_is,
                'order'         => $order
            );

            $change = $this->links->update( $id, $update );
            ( $status_was == 'published' && $status_is == 'unpublished' ) ? $this->links->update_order( 'links' ) : "";
            $success = $change;
            //$this->links->rewrite_xml();
            $this->edit( $success );
        } 
        else 
        {   
            $success = false;
            $this->edit( $success, false, true );
        }
    }
    // }}}
    // {{{ public function remove()
    public function remove()
    {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $this->load->model( 'links_model', 'links');
        $this->links->delete( $id );
        $this->links->update_order();
        //$this->links->rewrite_xml();
    }
    // }}}
}

?>
