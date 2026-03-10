<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
   /**
   * Downloads Controller
   **/
class Downloads extends CI_Controller
{
    // {{{ VARIABLES
    var $class          = 'downloads';
    var $singular       = 'download';
    var $plural         = 'downloads';
    var $table          = 'downloads';
    // }}}
    // {{{ public function __construct()
    public function __construct()
    {
        parent::__construct();
        ini_set( 'file_uploads',            'On'   );
        ini_set( 'post_max_filesize',       '300M' );
        ini_set( 'upload_max_filesize',     '300M' );
        ini_set( 'memory_limit',            '300M' );
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
        $offset = ( $this->uri->segment( 2 ) == "" ) ? 0 : $this->uri->segment( 2 );
        $offset = ( is_numeric( $offset ) ) ? $offset : 0;
        //$params = array( 'type' => 'post', 'how_many' => 5, 'offset' => $offset, 'tumblr' => 'false' );
        $params = array( 
            'type'                  => 'downloads', 
            'class'                 => $this->class,
            'how_many'              => 5, 
            'include_unpublished'   => false,
            'offset'                => $offset, 
            'tumblr'                => 'true' 
        );
        $layout_params = array( 'user_id' => 1, 'page' => $this->class );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Presentation =& $this->ChiPresentation;
        $Options =& $this->ChiOptions;

        // Main data array.
        $data = array(
            'records'           => $ChiQL,
            'presentation'      => $Presentation,
            'options'           => $Options, 
            'page_title'        => 'Downloads',
            'class'             => $this->class,
            'title'             => 'Blog',
            'type'              => $this->class, 
            'page_type'         => 'entry',
            'main_content'      => $Presentation->theme_relative_path() . $this->class . '/list'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $this->db->where( array( 'status' => 'published' ) );
        $config = array(
            'base_url'           => base_url() . $htfix . 'blog',
            'total_rows'         => $this->db->get( $this->class )->num_rows(),
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
    // {{{ public function get_file()
    public function get_file()
    {
        $file = $this->uri->segment( 3 );

        $filename = 'dls/' . $file;

        if ( file_exists( $filename ) ) 
        {
            //mysql_query("INSERT INTO `addalo_dl_stats` ( `file`, `dlid`, `time` ) VALUES ('".basename( urldecode($filename) )."', '".$id."', '".time()."');");

            $ext = 'zip';
            switch ( $ext ) 
            {
                case 'pdf'  :   $ctype = 'application/pdf'; break;
                case 'exe'  :   $ctype = 'application/octet-stream'; break;
                case 'zip'  :   $ctype = 'application/zip'; break;
                case 'doc'  :   $ctype = 'application/msword'; break;
                case 'xls'  :   $ctype = 'application/vnd.ms-excel'; break;
                case 'ppt'  :   $ctype = 'application/vnd.ms-powerpoint'; break;
                case 'gif'  :   $ctype = 'image/gif'; break;
                case 'png'  :   $ctype = 'image/png'; break;
                case 'jpeg' :
                case 'jpg'  :   $ctype = 'image/jpg'; break;
                default     :   $ctype = 'application/force-download';
            } 
            

            header( 'Content-Description: File Transfer' );
            //header( 'Content-Type: audio/mpeg' );
            header( 'Content-Type: ' . $ctype );
            header( 'Content-Disposition: attachment; filename='.basename( urldecode($filename) ) );
            header( 'Content-Transfer-Encoding: binary' );
            header( 'Expires: 0' );
            header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
            header( 'Pragma: public' );
            header( 'Content-Length: ' . filesize( $filename ) );
            ob_clean();
            flush();
            readfile( $filename );
            exit;
        }
        else
        {
            echo 'File ' . $filename . ' not found';
        }
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
    //    ADMIN 'VIEW' FUNCTIONS
    // {{{ public function manage()
    public function manage()
    {
        $this->is_logged_in();
        // Set up a few parameters
        $offset = ( $this->uri->segment( 2 ) == "" ) ? 0 : $this->uri->segment( 2 );
        $params = array( 
            'type'          => $this->class, 
            'how_many'      => 8, 
            'offset'        => $offset, 
            'pages'         => true, 
            'class'         => $this->class 
        );

        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        $this->load->helper('date');

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;

        $data = array(
            'records'       => $ChiQL,  
            'options'       => $Options, 
            'class'         => $this->class,
            'type'          => $this->class, 
            'singular'      => $this->singular,
            'plural'        => $this->class,
            'page_type'     => $this->class,
            'main_content'  => 'admin/' . $this->class . '/manage',
            'javascript'    => array( 'general/admin.basic', $this->class . '/manage' )
        );

        // Pagination Configuration______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $config = array(
            'base_url'           => base_url() . $this->class . '/manage',
            'total_rows'         => $this->db->get( $this->class )->num_rows(),
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
    // {{{ public function add_file()
    public function add_file()
    {   
        $this->is_logged_in();
        $id = $this->create();
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
        $this->load->helper( 'form' );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;

        $data = array(
            // Chi Variables
            'records'           => $ChiQL,
            'options'           => $Options,
            // Upload Page Settings
            'upload_function'   => 'file_upload',       // After uploading, what funciton will handle/save/resize the file?
            'file_type'         => 'archive',           // What are we uploading? 'image', 'music', or
            'uploader'          => 'file',              // Which file uploader to use. 'file' or 'multipleFile'?
            'primary_id'        => $id,                 // ID of the page or entry. 
            'secondary_id'      => '',                // ID of the album or relative entry
            'human_name'        => 'file',              // If this is set to 'Image', the page will read "Add Image"
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
        $this->load->helper( 'form' );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;

        $data = array(
            // Chi Variables
            'records'           => $ChiQL,
            'options'           => $Options,
            // Upload Page Settings
            'upload_function'   => 'pic_upload',        // After uploading, what funciton will handle/save/resize the file?
            'file_type'         => 'image',             // What are we uploading? 'image', 'music', or 'archive'
            'uploader'          => 'file',              // Which file uploader to use. 'file' or 'multipleFile'?
            'primary_id'        => $id,                 // ID of the page or entry. 
            'secondary_id'      => '',                  // ID of the album or relative entry
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
        $this->load->helper( 'text' );
        $this->load->model( 'downloads_model', 'downloads' );
        $date = time();
        $insert = array(
            'title'         => 'New File',
            'description'   => 'description',
            'file'          => '',
            'date'          => $date,
            'status'        => 'unpublished',
            'tr'            => 1
        );

        $add = $this->downloads->add( $insert );
        $id = $this->db->insert_id();

        if( $add ) 
        {
            return $id;
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
        $this->load->model( 'downloads_model', 'downloads' );
        $this->load->library('form_validation');
        //Set validation rules...
        $this->form_validation->set_rules( 'title', 'Title', 'trim|required' );            
        $this->form_validation->set_error_delimiters('<div class="notice error">', '</div>');

        if ( $this->form_validation->run() == TRUE ) 
        {
            $id = $this->uri->segment( 3 );
            $order_was = $this->input->post('order_was');
            $status_was = $this->input->post('status_was');
            $status_is = $this->input->post('status');
            $order = ( $status_was == 'unpublished' && $status_is == 'published' ) ? $this->downloads->get_next_order( 'downloads' ) : $order_was;     
            $order = ( $status_was == 'published' && $status_is == 'unpublished' ) ? 0 : $order;     

            $update = array(
                'title'        => $this->input->post('title'),
                'description'  => $this->input->post('description'),
                'file'         => $this->input->post('file'),
                'status'       => $status_is,
                'order'        => $order,
                'tr'           => '0'
            );

            $change = $this->downloads->update( $id, $update );
            ( $status_was == 'published' && $status_is == 'unpublished' ) ? $this->downloads->update_order( 'downloads' ) : "";
            $success = $change;
            //$this->downloads->rewrite_xml();
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
        $this->load->model( 'downloads_model', 'downloads');
        $this->downloads->delete( $id );
        $this->downloads->update_order();
        //$this->downloads->rewrite_xml();
    }
    // }}}
    // {{{ public function file_upload()
    public function file_upload()
    {

        $this->load->model( 'downloads_model', 'downloads' );

        $id = $this->uri->segment( 3 );
        if( count( $_FILES ) > 0 ) 
        {   
            $tmp = $_FILES['Filedata']['tmp_name'];
            $name = $_FILES['Filedata']['name'];
            $move = move_uploaded_file( $tmp, 'dls/' . $name );
            if( $move ) 
            {
                $new_data = array ( 'file' => $name );
                $update = $this->downloads->update( $id , $new_data );
                if( $update ) echo 'success';
            }
        }
    }
    // }}}
    // {{{ public function pic_upload()
    public function pic_upload()
    {
        $this->load->model( 'downloads_model', 'downloads' );
        $this->load->model( 'image_model', 'image' );
        $this->load->model( 'image_config' );
        $id = $this->uri->segment( 3 );
        if( count( $_FILES ) > 0) 
        {   
            //Configure photo dimensions.
            $config = $this->image_config->downloads_config( $id );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $config['table'] = $this->db->dbprefix( 'downloads' );
            $this->image->configure_class( $config );
            //Do it.
            if( $this->image->put_image() )
            {   
                echo 'uploaded.';   
            } 
            else 
            {   
                echo 'error.';
            }
        }
    }
    // }}}
    // END CRUD FUNCTIONS //
} // END CLASS //
?>
