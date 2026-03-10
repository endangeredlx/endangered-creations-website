<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
   /**
   * Features Controller
   **/

class Features extends CI_Controller
{
    // {{{ VARIABLES
    var $class          = 'features';
    var $singular       = 'feature';
    var $plural         = 'features';
    var $table          = 'features';
    // }}}
    // {{{ public function Features()
    public function Features()
    {
        parent::__construct();
    }
    // }}}
    // --- BASIC VIEW FUNCTIONS --- //
    // {{{ public function index()
    public function index()
    {
        echo "Hello World.";
    }
    // }}}
    // {{{ public function listings()
    public function listings()
    {
    }
    // }}}
    // {{{ public function single()
    public function single()
    {
    }
    // }}}
    // --- BASIC ADMIN FUNCTIONS --- //
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
    // --- ADMIN 'VIEW' FUNCTIONS --- //
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
            'javascript'        => array( 'tiny_mce/tiny_mce', 'general/admin.basic', $this->class . '/edit' ),
            'singular'          => $this->singular
        );

        // Load view.
        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function add_photo()
    public function add_photo()
    {   
        $this->is_logged_in();
        $id = $this->uri->segment( 3 );
        // Set up a few parameters
        $offset = 0;
        $params = array( 
            'type'                  => $this->class, 
            'how_many'              => 1, 
            'offset'                => $offset, 
            'tumblr'                => 'false', 
            'id'                    => $id,
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
            // Chi Variables
            'records'           => $ChiQL,
            'options'           => $Options,
            // Upload Page Settings
            'upload_function'   => 'file_upload',       // After uploading, what funciton will handle/save/resize the file?
            'file_type'         => 'image',             // What are we uploading? 'image', 'music', or
            'uploader'          => 'file',              // Which file uploader to use. 'file' or 'multipleFile'?
            'primary_id'        => $id,                 // ID of the page or entry. 
            'secondary_id'      => 0,                // ID of the album or relative entry
            'human_name'        => 'image',             // If this is set to 'Image', the page will read "Add Image"
            // General variables
            'class'             => $this->class,
            'javascript'        => array( 'swfaddress', 'swfobject', 'general/admin.basic', 'general/file_upload' ),
            'main_content'      => 'admin/general/file_upload'
        );
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // --- CRUD FUNCTIONS --- //
    // {{{ public function create()
    public function create()
    {
        $this->is_logged_in();
        $this->load->helper('text');
        $this->load->model('features_model', 'features');
        $this->load->library('form_validation');   
        $this->form_validation->set_error_delimiters('<div class="notice error">', '</div>');
        $this->form_validation->set_rules('title', 'Title', 'trim|required');            
        if ( $this->form_validation->run() == TRUE ) 
        {
            $insert = array(
                'title'         => $this->input->post('title'),
                'link'          => $this->input->post('link'),
                'content'       => $this->input->post('content'),
                'status'        => 'unpublished'
            );
            $add = $this->features->add( $insert );
            $id = $this->db->insert_id();

            if( $add ) 
            {
                redirect( 'features/add_photo/' . $id );
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
        $this->load->model( 'features_model', 'features' );
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
            $order = ( $status_was == 'unpublished' && $status_is == 'published' ) ? $this->features->get_next_order( 'features' ) : $order_was;     
            $order = ( $status_was == 'published' && $status_is == 'unpublished' ) ? 0 : $order;     

            $update = array(
                'title'     => $this->input->post('title'),
                'link'      => $this->input->post('link'),
                'content'   => $this->input->post('content'),
                'status'    => $status_is,
                'order'     => $order
            );

            $change = $this->features->update( $id, $update );
            ( $status_was == 'published' && $status_is == 'unpublished' ) ? $this->features->update_order( 'features' ) : "";
            $success = $change;
            //$this->features->rewrite_xml();
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
    $this->load->model( 'features_model', 'features');
    $this->features->delete( $id );
    $this->features->update_order();
    //$this->features->rewrite_xml();
    }
    // }}}
    // {{{ public function file_upload()
    public function file_upload()
    {
        $this->load->model( 'features_model', 'features' );
        $this->load->model( 'image_model', 'image' );
        $this->load->model( 'image_config' );
        $id = $this->uri->segment( 3 );
        if( count( $_FILES ) > 0) 
        {   
            //Configure photo dimensions.
            $config = $this->image_config->features_config( $id );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $config['table']    = $this->db->dbprefix( $this->table );
            $this->image->configure_class( $config );
            //Do it.
            if( $this->image->put_image() )
            {   
                echo "uploaded.";   
            } 
            else 
            {   
                echo "error.";
            }
        }
    }
    // }}}
} // END CLASS //
?>
