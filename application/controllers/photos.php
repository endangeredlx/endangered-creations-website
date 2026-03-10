<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Photos Controller Class
* Created By : Dennis Mars
* Copyright  : 2010
* Notes      : I did this for the Nine Six http://theninesix.com/
**/

class Photos extends CI_Controller
{
    // {{{ VARIABLES
    var $class                  = 'photos';
    var $primary_singular       = 'album';
    var $primary_plural         = 'albums';
    var $primary_table          = 'photo_albums';
    var $secondary_singular     = 'photo';
    var $secondary_plural       = 'photos';
    var $secondary_table        = 'photos';
    // }}}
    // {{{ public function Photos()
    public function Photos()
    {
        parent::__construct();
    }
    // }}}
    // --- BASIC VIEW FUNCTIONS --- //
    // {{{ public function index()
    public function index()
    {
        $this->listings();
    }
    // }}}
    // {{{ public function listings()
    public function listings()
    {
        $data = array();
        //$params = array( 'type' => 'page', 'how_many' => 1, 'name' => 'clients' );
        $layout_params = array( 'user_id' => 1, 'page' => 'photos' );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        //$this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Main page configuration.
        //$ChiQL =& $this->ChiRecords;
        $Presentation =& $this->ChiPresentation;
        $Options =& $this->ChiOptions;

        $this->load->helper('text');
        // Main data array.
        $data = array(
        'presentation'       => $Presentation,
        'options'            => $Options, 
        'page_title'         => ' | Photos',
        'title'              => 'Photos',
        'type'               => 'photos', 
        'page_type'          => 'page',
        'main_content'       => $Presentation->theme_relative_path() . 'photos/album_list'
        );

        $this->load->model( 'photos_model', 'photos' );
        $this->db->where("status","published");
        $config['base_url'] = base_url()."photos";
        $config['total_rows'] = $this->db->get('photo_albums')->num_rows();
        $config['per_page'] = 5;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<div id="pagination" class="clearfix left">';
        $config['full_tag_close'] = '</div>';
        $this->pagination->initialize($config);
        $offset = ( $this->uri->segment( 3 ) == "" ) ? 0 : $this->uri->segment( 3 );
        if( $query = $this->photos->get_records( $config['per_page'], $offset, false ) ) 
        {
        $data['records'] = $query;
        }
        $this->load->view( $Presentation->theme_relative_path() . 'clone', $data );
    }
    // }}}
    // {{{ public function album()
    public function album()
    {
    $data = array();
    //$params = array( 'type' => 'page', 'how_many' => 1, 'name' => 'clients' );
    $layout_params = array( 'user_id' => 1, 'page' => 'photos' );
    $option_params = array( 'user_id' => 1 );

    // Load the necessary libraries. 
    //$this->load->library( 'ChiRecords', $params, 'ChiRecords' );
    $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
    $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

    // Main page configuration.
    //$ChiQL =& $this->ChiRecords;
    $Presentation =& $this->ChiPresentation;
    $Options =& $this->ChiOptions;

    $this->load->helper('text');
    // Main data array.
    $data = array(
    'presentation'       => $Presentation,
    'options'            => $Options, 
    'page_title'         => ' | Photos',
    'title'              => 'Photos',
    'type'               => 'photos', 
    'page_type'          => 'page',
    'main_content'       => $Presentation->theme_relative_path() . 'photos/photos_list'
    );

    $this->load->helper('text');
    $this->load->model( 'photos_model', 'photos' );
    $this->db->where("status","published");
    $id = $this->uri->segment( 3 );
    if( $query = $this->photos->get_photos( $id ) ) 
    {
    $data['photos'] = $query;
    }
    if( $info = $this->photos->get_record( $id ) )
    {
    $data['album'] = $info;
    }
    $data['page_title'] = '| ' . $info->title;
    $this->load->view( $Presentation->theme_relative_path() . 'clone', $data );
    }
    // }}}
    // {{{ public function photo()
    public function photo()
    {
    $data = array();
    //$params = array( 'type' => 'page', 'how_many' => 1, 'name' => 'clients' );
    $layout_params = array( 'user_id' => 1, 'page' => 'photos' );
    $option_params = array( 'user_id' => 1 );

    // Load the necessary libraries. 
    //$this->load->library( 'ChiRecords', $params, 'ChiRecords' );
    $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
    $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

    // Main page configuration.
    //$ChiQL =& $this->ChiRecords;
    $Presentation =& $this->ChiPresentation;
    $Options =& $this->ChiOptions;

    $this->load->helper('text');
    // Main data array.
    $data = array(
    'presentation'       => $Presentation,
    'options'            => $Options, 
    'page_title'         => ' | Photos',
    'title'              => 'Photos',
    'type'               => 'photos', 
    'page_type'          => 'page',
    'main_content'       => $Presentation->theme_relative_path() . 'photos/single'
    );

    $this->load->helper('text');
    $this->load->model( 'entries_model', 'entries' );
    $data['type'] = 'photos';
    $this->load->model( 'photos_model', 'photos' );
    $this->db->where("status","published");
    $id = $this->uri->segment( 3 );
    if( $query = $this->photos->get_photo_record( $id ) ) 
    {
    $data['photo'] = $query;
    }
    if( $info = $this->photos->get_record( $query->ref_id ) )
    {
    $data['album'] = $info;
    }
    $data['next'] = $this->photos->get_next_id( $query, $info->size );
    $data['prev'] = $this->photos->get_prev_id( $query );
    $data['last_stories'] = $this->entries->get_last( 5 );
    $data['archives'] = $this->entries->get_archives( 5 );
    $data['page_title'] = '| ' . $info->title;
    $this->load->view( $Presentation->theme_relative_path() . 'clone', $data );
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
    // --- ADMIN 'VIEW' FUNCTIONS - ADMIN PAGES --- //
    // {{{ public function write( $success = false, $warning = false, $error = false )
    public function write( $success = false, $warning = false, $error = false )
    {
        $this->is_logged_in();
        // Set up a few parameters
        $offset = 0;
        $params = array( 
            'type'                  => $this->primary_singular, 
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
            'singular'      => $this->primary_singular,
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
        $params = array( 
            'type'                  => $this->primary_singular, 
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
        $this->load->helper( 'date' );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;

        // Main data array.
        $data = array(
            'records'               => $ChiQL,
            'options'               => $Options, 
            'type'                  => $this->class, 
            'class'                 => $this->class,
            'singular'              => $this->primary_singular,
            'plural'                => $this->primary_plural,
            'javascript'            => array( 'general/admin.basic', $this->class . '/manage' ),
            'main_content'          => 'admin/' . $this->class . '/manage'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        // Makes sure we don't grab any albums whose descriptions are formatted like:
        // ~~~entries~~~, ~~~store~~~, etc
        // Those albums are associated with entries on other parts of the website
        $this->db->where( "`description` NOT REGEXP '^[~]{3}(.){1,}[~]{3}$'" );
        $config = array(
            'base_url'           => base_url() . $htfix . 'manage',
            'total_rows'         => $this->db->get( $this->primary_table )->num_rows(),
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
     * Displays information on a specific photo album
     *
     * @access public
     *
     * @param boolean   $success    set to true if the update was a success.
     * @param boolean   $warning    set to true if there are warnings pertaining to the update.
     * @param boolean   $error      set to true if the update has failed.
     */
    public function edit( $success = false, $warning = false, $error = false )
    { 
        $this->is_logged_in();
        $data = array();
        $id = $this->uri->segment( 3 );
        // Set up a few parameters
        $params = array( 
            'type'      => $this->primary_singular, 
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
        // Get the Photos Library
        require( APPPATH . 'libraries/ChiPhotos' . EXT );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $ChiPhotos = new ChiPhotos( $ChiQL );
        $Options =& $this->ChiOptions;

        // Main data array.
        $data = array(
            'records'           => $ChiPhotos,
            'options'           => $Options, 
            'success'           => $success,
            'warning'           => $warning,
            'error'             => $error,
            'class'             => $this->class,
            'main_content'      => 'admin/' . $this->class . '/edit',
            'javascript'        => array( 'tiny_mce/tiny_mce', 'general/admin.basic', $this->class . '/edit' ),
            'singular'          => $this->primary_singular
        );

        // Load view.
        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function edit_photos( $success = false )
    public function edit_photos( $success = false, $warning = false, $error = false )
    {
        $this->is_logged_in();
        $data = array();
        $id = $this->uri->segment( 3 );
        // Set up a few parameters
        $params = array( 
            'type'      => $this->class, 
            'how_many'  => 100, 
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
        // Get the Photos Library
        require( APPPATH . 'libraries/ChiPhotos' . EXT );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $ChiPhotos = new ChiPhotos( $ChiQL );
        $Options =& $this->ChiOptions;

        // Main data array.
        $data = array(
            'records'           => $ChiPhotos,
            'options'           => $Options, 
            'success'           => $success,
            'warning'           => $warning,
            'error'             => $error,
            'class'             => $this->class,
            'main_content'      => 'admin/' . $this->class . '/edit_photos',
            'javascript'        => array( 'tiny_mce/tiny_mce', 'general/admin.basic', $this->class . '/edit_photos' ),
            'singular'          => $this->primary_singular
        );

        // Load view.
        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function edit_order()
    public function edit_order()
    {
        $this->is_logged_in();
        $data = array();
        $id = $this->uri->segment( 3 );
        // Set up a few parameters
        $params = array( 
            'type'      => $this->class, 
            'how_many'  => 100, 
            'id'        => $id, 
            'pages'     => true 
        );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        // Get the Photos Library
        require( APPPATH . 'libraries/ChiPhotos' . EXT );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $ChiPhotos = new ChiPhotos( $ChiQL );
        $Options =& $this->ChiOptions;

        // Main data array.
        $data = array(
            'records'           => $ChiPhotos,
            'options'           => $Options, 
            'class'             => $this->class,
            'main_content'      => 'admin/' . $this->class . '/order',
            'javascript'        => array( 'jquery-ui-1.8.6.custom.min', 'json2', 'general/admin.basic', $this->class . '/edit_order' ),
            'singular'          => $this->primary_singular
        );

        // Load view.
        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function change_order()
    public function change_order()
    {
        if( isset( $_POST ) )
        {
            $post = $_POST['data'];
            $len = intval($_POST['num']);
            $this->load->model('photos_model', 'photos');
            foreach( $post as $photo )
            {
                $order = $len - (intval( $photo['order'] ) - 1); 
                echo "picture " . $photo['id'] . " is order " . $order. ". ";
                $this->photos->set_photo_order( $photo['id'], $order ); 
            }
        }
    }
    // }}}
    // {{{ public function add_photos()
    public function add_photos()
    {   
        $this->is_logged_in();
        $id = $this->uri->segment( 3 );
        // Set up a few parameters
        $offset = 0;
        $params = array( 
            'type'                  => $this->primary_singular, 
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
        $aid = $ChiQL->row_value( 'ref_id' );
        $ChiQL->reset_available_records();

        $data = array(
            // Chi Variables
            'records'                   => $ChiQL,
            'options'                   => $Options,
            // Upload Page Settings
            'upload_function'           => 'upload',            // After uploading, what funciton will handle/save/resize the file?
            'file_type'                 => 'image',             // What are we uploading? 'image', 'music', or
            'uploader'                  => 'multipleFile',      // Which file uploader to use. 'file' or 'multipleFile'?
            'primary_id'                => $id,                 // ID of the page or entry. 
            'secondary_id'              => $aid,                // ID of the album or relative entry
            'human_name'                => 'image',             // If this is set to 'Image', the page will read "Add Image"
            // General variables        
            'class'                     => $this->class,
            'javascript'                => array( 'swfaddress', 'swfobject', 'general/admin.basic', 'general/file_upload' ),
            'main_content'              => 'admin/general/file_upload'
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
    $this->load->model( 'photos_model', 'photos' );
    $this->load->library('form_validation');   
    $this->form_validation->set_rules('title', 'Title', 'trim|required');            
    $this->form_validation->set_error_delimiters('<div class="notice error">', '</div>');
    if ( $this->form_validation->run() == TRUE ) 
    {
    $insert = array(
    'title'        => $this->input->post('title'),
    'description'  => $this->input->post('content'),
    'date'         => time()
    );
    $add = $this->photos->add( $insert );
    $id = $this->db->insert_id();

    if( $add ) 
    {
    redirect( 'photos/edit/' . $id );
    } 
    else 
    {      
    $this->write( false, false, true );
    }
    } 
    else 
    {
    $this->write(false,false,true);
    }
    }
    // }}}
    // {{{ public function update()
    public function update()
    {   
        $this->is_logged_in();
        $this->load->helper( 'text' );
        $this->load->model( 'photos_model', 'photos' );
        $this->load->library( 'form_validation' );
        //Set validation rules...
        $this->form_validation->set_rules( 'title', 'Title', 'trim|required' );            
        $this->form_validation->set_error_delimiters( '<div class="notice error">', '</div>' );

        if ( $this->form_validation->run() == TRUE ) 
        {
            $id = $this->uri->segment(3);
            $update = array(
                'title'              => $this->input->post('title'),
                'description'        => $this->input->post('description'),
                'status'             => $this->input->post('status')
            );
            $change = $this->photos->update( $id, $update );
            $success = $change;
            // {{{ Update XML
            $this->load->library( 'xml/RoyaltyXML', $this, 'royalx' );
            $this->royalx->config( array( 'con' => $this ) );
            $xml_update = $this->photos->get_records();
            $this->royalx->update_photos( $xml_update, $id );
            // }}}
            $this->edit( $success );
        } 
        else 
        {   
            $success = false;
            $this->edit( $success, false, true );
        }
    }
    // }}}
    // {{{ public function update_photos()
    public function update_photos()
    {
    $this->is_logged_in();
    $this->load->model( 'photos_model', 'photos' );
    foreach( $_POST as $key => $val ) 
    {
    if( strstr( $key, 'description_' ) )
    {
    $pid = stristr( $key, "_" );
    $pid = str_replace( "_", "", $pid );
    $this->photos->update_photo_record( $pid, array( 'description' => strip_tags( $val, "<br><a>" ) ) );
    }
    }
    $this->edit_photos(true);
    }
    // }}}
    // {{{ public function make_cover()
    public function make_cover()
    {
    $this->is_logged_in();
    $this->load->model( 'photos_model', 'photos' );
    $pid = $this->uri->segment( 3 );
    $aid = $this->uri->segment( 4 );
    $make = $this->photos->make_cover( $pid, $aid );
    if( $make ) return "success";
    }
    // }}}
    // {{{ public function remove()
    public function remove()
    {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $this->load->model('photos_model', 'photos' );
        $this->photos->delete_record( $id );
        // {{{ Update XML
        $this->load->library( 'xml/RoyaltyXML', $this, 'royalx' );
        $this->royalx->config( array( 'con' => $this ) );
        $xml_update = $this->photos->get_records();
        $this->royalx->update_photos( $xml_update );
        // }}}
    }
    // }}}
    // {{{ public function remove_photo()
    public function remove_photo()
    {
        $this->is_logged_in();
        $pid = $this->uri->segment( 3 );
        $aid = $this->uri->segment( 4 );
        $this->load->model( 'photos_model', 'photos' );
        $this->photos->delete_photo( $pid );
        $this->photos->update_album_size( $aid );
        echo "success";
    }
    // }}}
    // {{{ public function upload()
    public function upload()
    {
        $this->load->model( 'image_model', 'image' );
        $this->load->model( 'photos_model', 'photos' );
        $this->load->model( 'image_config' );
        $id = $this->uri->segment( 3 );
        if( count( $_FILES ) > 0) 
        {   
            $pid = $this->photos->create_pic_row( $id );
            // {{{ Large Pic
            $config = $this->image_config->large_photos_config( $pid );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $config['table'] = $this->db->dbprefix( $this->secondary_table );
            $this->image->configure_class( $config );
            $this->image->put_image(); 
            // }}}

            // {{{ Small Pic
            $this->image->clear_config();
            $config = $this->image_config->small_photos_config( $pid );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $config['table'] = $this->db->dbprefix( $this->secondary_table );
            $this->image->configure_class( $config );
            $this->image->put_image();
            // }}}

            // {{{ Square Pic
            $this->image->clear_config();
            list($wid,$hei) = getimagesize( $_FILES['Filedata']['tmp_name'] );
            $config = $this->image_config->square_photos_config( $pid, $wid, $hei );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $config['table'] = $this->db->dbprefix( $this->secondary_table );
            $this->image->configure_class( $config );
            $this->image->put_image_crop();
            // }}}

            // {{{ Landscape Pic
            $this->image->clear_config();
            list($wid,$hei) = getimagesize( $_FILES['Filedata']['tmp_name'] );
            $config = $this->image_config->landscape_photos_config( $pid );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $config['table'] = $this->db->dbprefix( $this->secondary_table );
            $this->image->configure_class( $config );
            $this->image->put_image();
            // }}}

            $this->image->clear_config();
            $this->photos->set_order( $id, $pid );
            $this->photos->update_album_size( $id );
            echo "uploaded.";   
               
        }
    }
    // }}}
    // END CRUD FUNCTIONS //
} // END CLASS //
?>
