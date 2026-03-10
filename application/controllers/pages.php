<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Pages Controller Class
**/

class Pages extends CI_Controller
{
    // {{{ VARIABLES
    var $class      = 'pages';
    var $singular   = 'page';
    var $plural     = 'pages';
    var $table      = 'entries';
    // }}}
    // {{{ public function Pages()
    public function Pages()
    {
        parent::__construct();
    }
    // }}}
    // --- BEGIN BASIC VIEW FUNCTIONS --- //
    // {{{ public function evaluate()
    public function evaluate()
    {
        $data = array();
        $name = $this->uri->segment( 2 );
        
        // Set up a few parameters
        $params = array( 'type' => 'page', 'how_many' => 1, 'name' => $name );
        $layout_params = array( 'user_id' => 1, 'page' => 'content' );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Presentation =& $this->ChiPresentation;
        $Options =& $this->ChiOptions;

        $ChiQL->set_next_available_record();
        // Main data array.
        $data = array(
            'records'            => $ChiQL,
            'presentation'       => $Presentation,
            'options'            => $Options, 
            'active_page'        => $name,
            'page_title'         => $this->ChiRecords->row_value( 'title' ),
            'title'              => $this->ChiRecords->row_value( 'title' ),
            'type'               => 'entries', 
            'page_type'          => 'page',
            'main_content'       => $Presentation->theme_relative_path() . 'pages/single'
        );

        $ChiQL->reset_available_records();

        // Load view.
        $this->load->view( $Presentation->theme_relative_path() . 'clone', $data );
    }
    // }}}
    // --- END BASIC VIEW FUNCTIONS --- //
    // --- BEGIN BASIC ADMIN FUNCTIONS --- //
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
    // --- END BASIC ADMIN FUNCTIONS --- //
    // --- BEGIN ADMIN 'VIEW' FUNCTIONS --- //
    // {{{ public function write( $success = false, $warning = false, $error = false )
    public function write( $success = false, $warning = false, $error = false )
    {
        $this->is_logged_in();
        // Set up a few parameters
        $offset = ( $this->uri->segment( 2 ) == "" ) ? 0 : $this->uri->segment( 2 );
        $offset = ( is_numeric( $offset ) ) ? $offset : 0;
        $params = array( 
            'type'                  => 'page', 
            'how_many'              => 5, 
            'offset'                => $offset, 
            'tumblr'                => 'false', 
            'include_unpublished'   => true, 
            'pages'                 => true 
        );
        $option_params = array( 'user_id' => 1 );

        // Ensure that any update notifications are true booleans
        $success = ( $success === true || $success === false ) ? $success : false;
        $warning = ( $warning === true || $warning === false ) ? $warning : false;
        $error = ( $error === true || $error === false ) ? $error : false;

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
        $offset = ( $this->uri->segment( 2 ) == "" ) ? 0 : $this->uri->segment( 2 );
        $offset = ( is_numeric( $offset ) ) ? $offset : 0;
        $params = array( 
            'type'                  => 'page', 
            'how_many'              => 5, 
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

        // Main Data Array.
        $data = array(
            'records'            => $ChiQL,
            'options'            => $Options, 
            'type'               => 'entries', 
            'page_type'          => 'entry',
            'javascript'         => array( 'general/admin.basic', $this->class . '/manage' ),
            'main_content'       => 'admin/' . $this->class . '/manage'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $this->db->where( 'type', 'page' );
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
    // {{{ public function edit( $success = false, $warning = false, $error = false )
    /**
     * Loads view and information for editing specific pages
     *
     * @access public
     *
     * @param boolean   $success    set to true if the update was a success.
     * @param boolean   $warning    set to true if there are warnings pertaining to the update.
     * @param boolean   $error      set to true if the update has failed.
     */
    public function edit( $success = false, $warning = false, $error = false )
    {
        $data = array();
        $id = $this->uri->segment( 3 );
        // Set up a few parameters
        $params = array( 'type' => 'page', 'how_many' => 1, 'id' => $id, 'pages' => true );
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

        $ChiQL->set_next_available_record();
        // Main data array.
        $data = array(
            'records'           => $ChiQL,
            'options'           => $Options, 
            'page_title'        => " | " . $this->ChiRecords->row_value( 'title' ),
            'title'             => $this->ChiRecords->row_value( 'title' ),
            'type'              => 'entries', 
            'page_type'         => 'page',
            'main_content'      => 'admin/' . $this->class . '/edit',
            'success'           => $success,
            'warning'           => $warning,
            'error'             => $error,
            'class'             => $this->class,
            'javascript'        => array( 'tiny_mce/tiny_mce', 'general/admin.basic', $this->class . '/edit' ),
            'singular'          => $this->singular
        );

        $ChiQL->reset_available_records();

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
            'type'                  => 'page', 
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

        $ChiQL->set_next_available_record();
        $aid = $ChiQL->row_value( 'album' );
        $ChiQL->reset_available_records();

        $data = array(
            // Chi Variables
            'records'           => $ChiQL,
            'options'           => $Options,
            // Upload Page Settings
            'upload_function'   => 'file_upload',       // After uploading, what funciton will handle/save/resize the file?
            'file_type'         => 'image',             // What are we uploading? 'image', 'music', or
            'uploader'          => 'file',              // Which file uploader to use. 'file' or 'multipleFile'?
            'primary_id'        => $id,                 // ID of the page or entry. 
            'secondary_id'      => $aid,                // ID of the album or relative entry
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
    // --- END ADMIN 'VIEW' FUNCTIONS --- //
    // --- CRUD FUNCTIONS --- //
    // {{{ public function create()
    public function create()
    {
        $this->is_logged_in();
        $this->load->helper( 'text' );
        $this->load->model( 'pages_model', 'pages' );
        $this->load->library( 'form_validation' );   
        $this->form_validation->set_rules( 'title', 'Title', 'trim|required' );            
        $this->form_validation->set_error_delimiters( '<div class="notice error">', '</div>' );
        if ( $this->form_validation->run() == TRUE ) 
        {
            $title = $this->input->post( 'title' );
            $name = url_title( $title, 'dash', true );
            $insert = array(
                'title'     => $title,
                'author'    => 'admin',
                'name'      => $name,
                'type'      => 'page',
                'date'      => time(),
                'status'    => 'unpublished',
                'content'   => $this->input->post( 'description' )
            );
            $add = $this->pages->add( $insert );
            $id = $this->db->insert_id();

            // Prepare an empty photo album.
            $inst = array(
                'title'        => $this->input->post( 'title' ),
                'description'  => '~~~entries~~~',
                'ref_id'       => $id,
                'date'         => time()
            );
            $this->load->model( 'photos_model', 'photos' );
            // Create empty photo album.
            $addalbum = $this->photos->add( $inst );

            // Grab the album id and associate it with the entry.
            $aid = $this->db->insert_id();
            $update = $this->pages->update( $id, array( 'album' => $aid ) );

            // For updating XML if need be.
            /* if( $add )
            {
                $this->load->library( 'ChiXML' );
                $this->ChiXML->update_page_xml();
            }
             */
            ( $add ) ? redirect( $this->class . '/edit/' . $id ) : $this->write( false, false, true );
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
        $this->load->model( 'pages_model', 'pages' );
        $this->load->library('form_validation');
        // Set validation rules...
        $this->form_validation->set_rules('title', 'Title', 'trim|required');            
        $this->form_validation->set_error_delimiters('<div class="notice error">', '</div>');

        if ( $this->form_validation->run() == TRUE ) 
        {
            $id = $this->uri->segment( 3 );
            $format_check = $this->input->post('format_check');
            $content = ( $format_check == 'clear' ) ? strip_tags( $this->input->post('content'), '<br>' ) : $this->input->post('content');
            $title = $this->input->post('title');
            $excerpt = word_limiter( $content, 50);
            $excerpt = strip_tags( $excerpt );
            $name = url_title( $title, 'dash', TRUE );
            $update = array(
                'title'           => $this->input->post('title'),
                'content'         => $content,
                'name'            => $name, 
                'excerpt'         => $excerpt,
                'status'          => $this->input->post('status')
            );
            $change = $this->pages->update( $id, $update );

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
    // {{{ public function remove()
    public function remove()
    {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $this->load->model('pages_model');
        $this->pages_model->delete( $id );
        // For updating XML if need be.
        // $this->load->library( 'ChiXML' );
        // $this->ChiXML->update_page_xml();
    }
    // }}}
    // {{{ public function file_upload()
    public function file_upload()
    {
        $this->load->model('image_model');
        $this->load->model('image_config');
        $id = $this->uri->segment(3);
        if( count( $_FILES ) > 0) 
        {   
            $config = $this->image_config->pages_config( $id );
            $config['table'] = $this->db->dbprefix( $this->table );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $this->image_model->configure_class( $config );
            if( $this->image_model->put_image() )
            {   
                $this->image_model->clear_config();
                echo "great.";   
            } 
            else 
            {   
                echo "error";
            }
        }
    }
    // }}}
    // --- END CRUD FUNCTIONS --- //
}
// --- END CLASS --- //
?>
