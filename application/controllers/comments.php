<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends CI_Controller 
{
    var $table          = 'comments';
    var $singular       = 'comment';
    var $plural         = 'comments';
    var $class          = 'comments';
    // {{{ public function Comments()
    public function Comments()
    {
        parent::__construct();
    }
    // }}}
    // {{{ public function index()
    public function index()
    {
        echo 'Hello World';
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
    // {{{ public function manage()
    public function manage()
    {
        $this->is_logged_in();
        // Set up a few parameters
        $params = array( 'type' => 'comments', 'how_many' => 0, 'id' => 0 );
        $offset = ( $this->uri->segment( 2 ) == "" ) ? 0 : $this->uri->segment( 2 );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        $this->load->model( 'comments_model', 'comments' );
        $this->load->helper( 'date' );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;
        $comments = $this->comments->get_comments( 0, 'entries', array( 'approved' => true, 'how_many' => 30, 'offset' => 0, 'get_title' => true, 'order_by' => array( 'column' => 'date', 'direction' => 'desc' ) ) );

        // Main data array.
        $data = array(
            'records'               => $ChiQL,
            'comments'              => $comments,
            'options'               => $Options, 
            'title'                 => 'Blog',
            'type'                  => $this->class, 
            'class'                 => $this->class,
            'singular'              => $this->singular,
            'plural'                => $this->plural,
            'page_type'             => $this->singular,
            'javascript'            => array( 'jquery.color', 'general/admin.basic', $this->class . '/manage' ),
            'main_content'          => 'admin/' . $this->class . '/manage'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $config = array(
            'base_url'           => base_url() . $htfix . $this->class . '/manage',
            'total_rows'         => $this->db->get( $this->table )->num_rows(),
            'per_page'           => $params['how_many'],
            'num_links'          => 8,
            'uri_segment'        => 2,
            'full_tag_open'      => '<div id="pgntn" class="clearfix">',
            'full_tag_close'     => '</div>'
        );
        $this->pagination->initialize( $config );

        // Load view.
        $this->load->view( 'admin/clone', $data ); 
    }
    // }}}
    // {{{ public function settings( $success = false, $warning = false, $error = false )
    public function settings( $success = false, $warning = false, $error = false )
    { 
        $this->is_logged_in();
        $data = array();
        // Set up a few parameters
        $params = array( 
            'type'                  => 'comments', 
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
            'main_content'      => 'admin/' . $this->class . '/settings',
            'javascript'        => array( 'tiny_mce/tiny_mce', 'general/admin.basic', $this->class . '/edit' ),
            'singular'          => $this->singular
        );

        // Load view.
        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function approve()
    public function approve()
    {
        $id = $this->uri->segment( 3 );
        $this->load->model( 'comments_model', 'comments' );
        $this->comments->approve( $id );
    }
    // }}}
    // {{{ public function unapprove()
    public function unapprove()
    {
        $id = $this->uri->segment( 3 );
        $this->load->model( 'comments_model', 'comments' );
        $this->comments->unapprove( $id );
    }
    // }}}
    // {{{ public function remove()
    public function remove()
    {
        $id = $this->uri->segment( 3 );
        $this->load->model( 'comments_model', 'comments' );
        $this->comments->delete( $id );
    }
    // }}}
    // {{{ public function update_settings()
    public function update_settings()
    {
        $this->is_logged_in();
        $this->load->helper( 'text' );
        $this->load->model( 'options_model', 'options' );

        $update = array(
            'comment_captcha'         => $this->input->post( 'comment_captcha' ),
            'comment_approval'        => $this->input->post( 'comment_approval' )
        );

        $change = $this->options->bulk_update( $update );
        $success = $change;
        $this->settings( $success );
    }
    // }}}
}

?>
