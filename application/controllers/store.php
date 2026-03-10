<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Store Controller
**/
class Store extends CI_Controller
{
    // {{{ VARIABLES
    var $class      = 'store';
    var $singular   = 'item';
    var $plural     = 'items';
    var $table      = 'store';
    // }}}
    // {{{ public function Store()
    public function Store()
    {
        parent::__construct();
        $this->load->library('cart');
    }
    // }}}
    // {{{ public function add_to_cart()
    public function add_to_cart()
    {
        $this->load->model( 'store_model', 'store' ); 
        if( $this->store->add_to_cart() == TRUE )
        {
            // What do we do after the thing as been added to the cart.
            /*if( $this->input->post( 'ajax' ) != '1' )
            {
                redirect('store');
            }
            else 
            {
                echo 'true';
            }*/
        }
    }
    // }}}
    // --- BASIC VIEW FUNCTIONS (STORE) --- //
    // {{{ public function index()
    public function index()
    {
        $this->listings();
    }
    // }}}
    // {{{ public function listings()
    /**
    * Listings Function (Store)
    *
    * Generally made for displaying a list of records with pagination.
    *
    **/
    public function listings()
    {
        // Set up a few parameters
        $offset = ( $this->uri->segment( 2 ) == "" ) ? 0 : $this->uri->segment( 2 );
        $params = array( 
            'type'                      => 'store', 
            'how_many'                  => 8, 
            'offset'                    => $offset, 
            'include_unpublished'       => false,
            'class'                     => 'store' 
        );
        $layout_params = array( 'user_id' => 1, 'page' => 'store_single' );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Grab the store decorator.
        require( APPPATH . 'libraries/ChiStore' . EXT );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $ChiStore = new ChiStore( $ChiQL );
        $Presentation =& $this->ChiPresentation;
        $Options =& $this->ChiOptions;

        $data = array(
            'records'            => $ChiStore,  
            'presentation'       => $Presentation,
            'options'            => $Options, 
            'page_title'         => ' | Store',
            'title'              => 'Store',
            'type'               => 'store', 
            'page_type'          => 'store',
            'main_content'       => $Presentation->theme_relative_path() . 'store/list'
        );

        // Pagination Configuration______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';
        $this->db->where( array( 'type' => 'post', 'status' => 'published' ) );
        $config = array(
            'base_url'           => base_url() . 'store',
            'total_rows'         => $this->db->get( 'store' )->num_rows(),
            'per_page'           => $params['how_many'],
            'num_links'          => 8,
            'uri_segment'        => 2,
            'full_tag_open'      => '<div id="pgntn" class="clearfix">',
            'full_tag_close'     => '</div>'
        );
        $this->pagination->initialize( $config );

        // Load view.
        $this->load->view( $Presentation->theme_relative_path() . 'clone_alt', $data );
    }
    // }}}
    // {{{ public function archives()
    // NEEDS TO BE UPDATED TO WORK WITH CHIQ
    public function archives()
    {
    }
    // }}}
    // {{{ public function single()
    public function single()
    {
        // Set up a few parameters
        $id = ( $this->uri->segment( 3 ) == "" ) ? 0 : $this->uri->segment( 3 );
        $params = array( 'type' => 'store', 'how_many' => 1, 'id' => $id, 'grid' => 1, 'class' => 'store' );
        $layout_params = array( 'user_id' => 1, 'page' => 'store_single' );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Grab the store decorator.
        require( APPPATH . 'libraries/ChiStore' . EXT );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $ChiStore =& new ChiStore( $ChiQL );
        $Presentation =& $this->ChiPresentation;
        $Options =& $this->ChiOptions;

        $data = array(
        'records'            => $ChiStore,  
        'presentation'       => $Presentation,
        'options'            => $Options, 
        'page_title'         => " | Store",
        'title'              => 'Store',
        'type'               => 'store', 
        'page_type'          => 'store',
        'main_content'       => $Presentation->theme_relative_path() . 'store/single'
        );

        // Pagination Configuration

        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';
        $this->db->where( array( 'type' => 'post', 'status' => 'published' ) );
        $config = array(
        'base_url'           => base_url() . 'news',
        'total_rows'         => $this->db->get( 'store' )->num_rows(),
        'per_page'           => $params['how_many'],
        'num_links'          => 8,
        'uri_segment'        => 2,
        'full_tag_open'      => '<div id="pgntn" class="clearfix">',
        'full_tag_close'     => '</div>'
        );
        $this->pagination->initialize( $config );

        // Load view.
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
    // --- ADMIN 'VIEW' FUNCTIONS --- //
    // {{{ public function write( $success = false, $warning = false, $error = false )
    public function write( $success = false, $warning = false, $error = false )
    {
        $this->editor( 'create', $success, $warning, $error );
    }
    // }}}
    // {{{ public function edit( $success = false, $warning = false, $error = false )
    public function edit( $success = false, $warning = false, $error = false )
    { 
        $this->editor( 'edit', $success, $warning, $error );
    }
    // }}}
    // {{{ public function editor( $action, $success = false, $warning = false, $error = false )
    /**
     * Loads view and information for editing specific store
     *
     * @access public
     *
     * @param boolean   $success    set to true if the update was a success.
     * @param boolean   $warning    set to true if there are warnings pertaining to the update.
     * @param boolean   $error      set to true if the update has failed.
     */
    public function editor( $action, $success = false, $warning = false, $error = false )
    {
        $this->is_logged_in();
        // We create entry in the database and edit that.
        $id = ( $action == 'create' ) ? $this->create() : $this->uri->segment( 3 );
        
        // Set up a few parameters
        $offset = 0;
        $params = array( 
            'type'                  => $this->class, 
            'class'                 => $this->class, 
            'id'                    => $id,
            'how_many'              => 1, 
            'offset'                => $offset, 
            'tumblr'                => 'false', 
            'include_unpublished'   => true, 
            'pages'                 => true 
        );
        $option_params = array( 'user_id' => 1 );

        // Load necessary libraries and helpers.
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        require( APPPATH . 'libraries/ChiStore' . EXT );
        $this->load->helper('form');

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $ChiStore = new ChiStore( $ChiQL );
        $Options =& $this->ChiOptions;

        // Ensure that any update notifications are true booleans
        $success = ( $success === true || $success === false ) ? $success : false;
        $warning = ( $warning === true || $warning === false ) ? $warning : false;
        $error = ( $error === true || $error === false ) ? $error : false;

        $data = array(
            'records'       => $ChiStore,
            'options'       => $Options,
            'success'       => $success,
            'warning'       => $warning,
            'error'         => $error,
            'class'         => $this->class,
            'action'        => $action,
            'singular'      => $this->singular,
            'javascript'    => array( 'general/admin.basic', $this->class . '/edit' ),
            'main_content'  => 'admin/' . $this->class . '/edit'
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
            'type'                  => $this->class, 
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

        // Main data array.
        $data = array(
            'records'               => $ChiQL,
            'options'               => $Options, 
            'title'                 => 'Blog',
            'type'                  => $this->class, 
            'class'                 => $this->class,
            'singular'              => $this->singular,
            'plural'                => $this->plural,
            'page_type'             => $this->singular,
            'javascript'            => array( 'general/admin.basic', $this->class . '/manage' ),
            'main_content'          => 'admin/' . $this->class . '/manage'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        // Dont' count items marked for trash.
        //$this->db->where( 'tr !=', 1);
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
    // {{{ public function add_photo()
    public function add_photo()
    {   
        $this->is_logged_in();
        $id = $this->uri->segment( 3 );
        // Set up a few parameters
        $offset = 0;
        $params = array( 
            'type'                  => $this->class, 
            'class'                 => $this->class,
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
            'records'                   => $ChiQL,
            'options'                   => $Options,
            // Upload Page Settings
            'upload_function'           => 'file_upload',       // After uploading, what funciton will handle/save/resize the file?
            'file_type'                 => 'image',             // What are we uploading? 'image', 'music', or
            'uploader'                  => 'file',              // Which file uploader to use. 'file' or 'multipleFile'?
            'primary_id'                => $id,                 // ID of the page or entry. 
            'secondary_id'              => '',                  // ID of the album or relative entry
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
    // {{{ public function delete_photo()
    public function delete_photo()
    {
    $this->is_logged_in();
    $this->load->model( 'store_model', 'store' );
    $id = $this->uri->segment( 3 );
    $this->store->delete_photo( $id );
    echo "photo removed";
    }
    // }}}
    // --- CRUD FUNCTIONS --- //
    // {{{ public function create()
    public function create()
    {
        $this->load->helper('text');
        $this->load->model('store_model', 'store');
        // Prepare the data for the database.
        $insert = array(
            'title'         => 'Untitled ' . ucwords( $this->singular ),
            'views'         => 0, 
            'tr'            => 1
        );

        // Insert the data array.
        $add = $this->store->add( $insert );
        $id = $this->db->insert_id();

        // Prepare an empty photo album.
        $inst = array(
            'title'         => ucwords( $this->singular ) . ' Photo Album ' . $id,
            'description'   => '~~~store~~~',
            'ref_id'        => $id,
            'date'          => time(),
            'tr'            => 1
        );
        $this->load->model( 'photos_model', 'photos' );
        // Create empty photo album.
        $addalbum = $this->photos->add( $inst );

        // Grab the album id and associate it with the entry.
        $aid = $this->db->insert_id();
        $update = $this->store->add_option( $id, 'album', $aid, true );
        return $id;
    }
    // }}}
    // {{{ public function update()
    public function update()
    {   
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $this->load->model( 'store_model', 'store' );
        $this->load->helper('text');
        $title = $this->input->post('title');
        $name = url_title( $title, 'dash', true );
        $format_check = $this->input->post('format_check');
        $content = ($format_check == 'clear') ? strip_tags( $this->input->post('content'), '<br><p><strong><u>' ) : $this->input->post('content');
        $excerpt = word_limiter( $content, 50);
        $excerpt = strip_tags( $excerpt );
        // If we don't get a unique id for the video, then we don't store video type.
        $update = array(
            'title'         => $this->input->post('title'),
            'name'          => $name,
            'content'       => $content,
            'excerpt'       => $excerpt,
            'price'         => $this->input->post('price'),
            'status'        => $this->input->post('status'),
            'date'          => time(),
            'tr'            => 0
        );

        $change = $this->store->update( $id, $update );
        $options = $this->store->update_options( $id, $_POST ); 
        $this->edit( $change );
    }
    // }}}
    // {{{ public function remove()
    public function remove()
    {
    $this->is_logged_in();
    $id = $this->uri->segment(3);
    $this->load->model('store_model');
    $this->store_model->delete( $id );
    redirect( 'store/manage' );
    }
    // }}}
    // {{{ public function file_upload()
    public function file_upload()
    {
        $this->load->model( 'image_model', 'image' );
        $this->load->model( 'store_model', 'store' );
        $this->load->model( 'image_config' );
        $id = $this->uri->segment( 3 );
        if( count( $_FILES ) > 0 ) 
        {   
            // {{{ Large Pic
            $config = $this->image_config->large_store_config( $id );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $config['table'] = $this->db->dbprefix( $this->table );
            $this->image->configure_class( $config );
            $this->image->put_image(); 
            // }}}

            // {{{ Small Pic
            $this->image->clear_config();
            $config = $this->image_config->small_store_config( $id );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $config['table'] = $this->db->dbprefix( $this->table );
            $this->image->configure_class( $config );
            $this->image->put_image();
            // }}}
            //
            $this->store->update_pic( $id );

            $this->image->clear_config();
            echo "uploaded.";   
        }
    }
    // }}}
    // END CRUD FUNCTIONS //
} // END CLASS //
?>
