<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Music Controller
**/
class Music extends CI_Controller
{
    // {{{ VARIABLES
    var $class                  = 'music';
    var $primary_singular       = 'playlist';
    var $primary_plural         = 'playlists';
    var $primary_table          = 'music_playlists';
    var $secondary_singular     = 'song';
    var $secondary_plural       = 'songs';
    var $secondary_table        = 'music_songs';
    var $tertiary_table         = 'music_records';
    // }}}
    // {{{ public function Music()
    public function Music()
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
    // {{{ public function flash_xml()
    public function flash_xml()
    {
        $this->load->model( 'options_model', 'options' );
        $id = $this->options->get_option_by_name( 'main_music_playlist' );
        $params = array( 
            'type'                  => 'music_playlists', 
            'class'                 => $this->class,
            'how_many'              => 1, 
            'id'                    => $id, 
            'offset'                => 0,
            'include_unpublished'   => true,
            'pages'                 => true 
        );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        // Grab Music Decorator
        require( APPPATH . 'libraries/ChiMusic' . EXT );
        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $ChiMusic = new ChiMusic( $ChiQL );
       
        // Main data array.
        $data = array(
            'records'           => $ChiMusic
        );
        // Load view.
        $this->load->view( 'admin/' . $this->class . '/flash_xml', $data );
    }
    // }}}
    // --- BASIC ADMIN FUNCTIONS --- //
    // {{{ public function login_check()
    public function login_check()
    {
        $this->load->model('login_model');
        $query = $this->login_model->validate();
        if( $query['valid'] ) // if the user's credentials validated...
        {
            $data = array(
                'mid'                => $query['id'],
                'login'              => $this->input->post('login'),
                'alias'              => $query['alias'],
                'privilege'          => $query['privilege'],
                'is_logged_in'       => true
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
        $is_logged_in = $this->session->userdata( 'is_logged_in' );
        if( !isset( $is_logged_in ) || $is_logged_in != true ) 
        {
            redirect( 'admin/index' );
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
            'type'                  => 'songs', 
            'how_many'              => 'all', 
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
            'javascript'        => array( 'jquery.ui', 'json2', 'general/admin.basic', $this->class . '/write_playlist' ),
            'main_content'  => 'admin/' . $this->class . '/write_playlist'
        );

        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function edit()
    public function edit()
    { 
        header( 'Location: ' . base_url() . 'music/manage/songs' );
    }
    // }}}
    // {{{ public function edit_song( $success = false, $warning = false, $error = false )
    public function edit_song( $success = false, $warning = false, $error = false )
    {
        $data = array();
        $id = $this->uri->segment( 3 );
        // Set up a few parameters
        $params = array( 
            'type'                  => 'songs', 
            'class'                 => $this->class,
            'how_many'              => 1, 
            'id'                    => $id, 
            'include_unpublished'   => false,
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
            'main_content'      => 'admin/' . $this->class . '/edit_song',
            'javascript'        => array( 'tiny_mce/tiny_mce', 'general/admin.basic', $this->class . '/edit' ),
            'singular'          => $this->secondary_singular
        );

        // Load view.
        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function edit_playlist( $success = false, $warning = false, $error = false )
    public function edit_playlist( $success = false, $warning = false, $error = false )
    {
        $data = array();
        $id = $this->uri->segment( 3 );
        // Set up a few parameters
        $params = array( 
            'type'                  => 'music_playlists', 
            'class'                 => $this->class,
            'how_many'              => 1, 
            'id'                    => $id, 
            'offset'                => 0,
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

        // Grab Music Decorator
        require( APPPATH . 'libraries/ChiMusic' . EXT );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $ChiMusic = new ChiMusic( $ChiQL );
        $Options =& $this->ChiOptions;

        // Main data array.
        $data = array(
            'records'           => $ChiMusic,
            'options'           => $Options, 
            'success'           => $success,
            'warning'           => $warning,
            'error'             => $error,
            'class'             => $this->class,
            'main_content'      => 'admin/' . $this->class . '/edit_playlist',
            'javascript'        => array( 'jquery.ui', 'json2', 'general/admin.basic', $this->class . '/edit_playlist' ),
            'singular'          => $this->primary_singular
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
        $label = ( $this->uri->segment( 3 ) == "" ) ? 0 : $this->uri->segment( 3 );
        if( $label != 'songs' )
        {
            $type = 'music_playlists';
            $singular = $this->primary_singular;
            $plural = $this->primary_plural;
            $table = $this->primary_table;
        }
        else
        {
            $type = 'songs';
            $singular = $this->secondary_singular;
            $plural = $this->secondary_plural;
            $table = $this->secondary_table;
        }
        $offset = ( $this->uri->segment( 4 ) == "" ) ? 0 : $this->uri->segment( 4 );
        $params = array( 
            'type'                  => $type, 
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
            'singular'              => $singular,
            'plural'                => $plural,
            'javascript'            => array( 'general/admin.basic', $this->class . '/manage_' . $type ),
            'main_content'          => 'admin/' . $this->class . '/manage_' . $type
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $this->db->where( "`description` NOT REGEXP '^[~]{3}[a-zA-Z_0-9\|]+[~]{3}$'");
        $config = array(
            'base_url'           => base_url() . $htfix . 'music/manage/' . $type,
            'total_rows'         => $this->db->get( $table )->num_rows(),
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
    // {{{ public function upload_song()
    public function upload_song()
    {   
        $this->is_logged_in();
        $id = 0;
        $aid = 0;
        // Set up a few parameters
        $offset = 0;
        $params = array( 
            'type'                  => 'songs', 
            'how_many'              => 1, 
            'offset'                => $offset, 
            'tumblr'                => 'false', 
            'id'                    => 0,
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
            'upload_function'   => 'song_upload',       // After uploading, what funciton will handle/save/resize the file?
            'file_type'         => 'music',             // What are we uploading? 'image', 'music', or
            'uploader'          => 'multipleFile',      // Which file uploader to use. 'file' or 'multipleFile'?
            'primary_id'        => $id,                 // ID of the page or entry. 
            'secondary_id'      => $aid,                // ID of the album or relative entry
            'human_name'        => 'mp3s',              // If this is set to 'Image', the page will read "Add Image"
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
        $aid = 0;
        // Set up a few parameters
        $offset = 0;
        $params = array( 
            'type'                  => 'songs', 
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
            'upload_function'   => 'song_image_upload', // After uploading, what funciton will handle/save/resize the file?
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
    // {{{ public function add_photo_playlist()
    public function add_photo_playlist()
    {   
        $this->is_logged_in();
        $id = $this->uri->segment( 3 );
        $aid = 0;
        // Set up a few parameters
        $offset = 0;
        $params = array( 
            'type'                  => 'music_playlists', 
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
            'upload_function'   => 'playlist_image_upload',     // After uploading, what funciton will handle/save/resize the file?
            'file_type'         => 'image',                     // What are we uploading? 'image', 'music', or
            'uploader'          => 'file',                      // Which file uploader to use. 'file' or 'multipleFile'?
            'primary_id'        => $id,                         // ID of the page or entry. 
            'secondary_id'      => $aid,                        // ID of the album or relative entry
            'human_name'        => 'image',                     // If this is set to 'Image', the page will read "Add Image"
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
    // {{{ public function create_playlist()
    public function create_playlist()
    {
        if( isset( $_POST ) )
        {
            $post = $_POST;
            $insert = array(
                'title'             => $post['name'],
                'number_of_songs'   => $post['num'],
                'status'            => 'unpublished',
                // Chifix* This will have to be changed to accomadate different users.
                'owner_id'          => 1
            );
            $this->load->model( 'music_model', 'music' );
            $playlist = $this->music->add_playlist( $insert );
            $id = $this->db->insert_id();
            $records = $this->music->create_playlist_records( $id, $post['data'] );
            if( $playlist && $records )
            {
                echo 'success';
            }
            else
            {
                echo 'failure';
            }
        }
    }
    // }}}
    // {{{ public function update_playlist()
    public function update_playlist()
    {
        if( isset( $_POST ) )
        {
            $post  = $_POST; 
            $id = $post['id'];
            $update_playlist = array(
                'title'             => $post['name'],
                'number_of_songs'   => $post['num']
            );

            $this->load->model( 'music_model', 'music' );
            $this->music->update_playlist( $id, $update_playlist );
            $this->music->update_playlist_records( $id, $post['data'] );
            echo 'success';
        }
    }
    // }}}
    // {{{ public function update_song()
    public function update_song()
    {   
        $this->is_logged_in();
        $this->load->helper('text');
        $this->load->library('form_validation');
        //Set validation rules...
        $this->form_validation->set_rules('title', 'Title', 'trim|required');            
        $this->form_validation->set_error_delimiters('<div class="notice error">', '</div>');
        if ( $this->form_validation->run() == TRUE ) 
        {
            $id = $this->uri->segment( 3 );
            $update = array(
                'title'     => $this->input->post('title'),
                'artist'    => $this->input->post('artist')
            );

            $this->load->model( 'music_model', 'music' );
            $up = $this->music->update_song( $id, $update );
            $this->edit_song( $up );
        }
        else
        {
            $this->edit_song( false, false, true );
        }
    }
    // }}}
    // {{{ public function remove_song()
    public function remove_song()
    {
        $id = $this->uri->segment( 3 );
        $this->load->model( 'music_model', 'music' );
        $this->music->delete_song( $id );
    }
    // }}}
    // {{{ public function remove_playlist()
    public function remove_playlist()
    {
        $id = $this->uri->segment( 3 );
        $this->load->model( 'music_model', 'music' );
        $this->music->delete_playlist( $id );
    }
    // }}}
    // {{{ public function make_main_playlist()
    public function make_main_playlist()
    {
        $id = $this->uri->segment( 3 );
        $this->load->model( 'options_model', 'options' );
        $update = $this->options->bulk_update( array( 'main_music_playlist' => $id ) );
        echo $update;
    }
    // }}}
    // {{{ public function song_upload()
    public function song_upload()
    {
        if( count( $_FILES ) > 0 )
        {
            $tmp = $_FILES['Filedata']['tmp_name'];
            $name = $_FILES['Filedata']['name'];
            $move = move_uploaded_file( $tmp, 'music_files/' . $name );
            $this->load->model( 'music_model', 'music' );
            $id = $this->music->make_row();
            $insert = array(
                'title'     => 'New Song ' . $id, 
                'file'      => $name,
                'artist'    => 'unknown',
                'status'    => 'published'
            ); 
            $this->music->update_song( $id, $insert );
        }
    }
    // }}}
    // {{{ public function song_image_upload()
    public function song_image_upload()
    {
        $this->load->model( 'image_model', 'image' );
        $this->load->model( 'image_config' );
        $id = $this->uri->segment( 3 );
        if( count( $_FILES ) > 0 ) 
        {   
            list( $width, $height ) = getimagesize( $_FILES['Filedata']['tmp_name'] );
            $config = $this->image_config->song_image_config( $id, $width, $height );
            $config['table']     = $this->db->dbprefix( $this->secondary_table );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $this->image->configure_class( $config );

            if( $this->image->put_image_crop() )
            {   
                $this->image->clear_config();
                echo 'great.';   
            } 
            else 
            {   
                echo 'error';
            }
        }
    }
    // }}}
    // {{{ public function playlist_imageupload()
    public function playlist_image_upload()
    {
        $this->load->model( 'image_model', 'image' );
        $this->load->model( 'image_config' );
        $id = $this->uri->segment( 3 );
        if( count( $_FILES ) > 0 ) 
        {   
            list( $width, $height ) = getimagesize( $_FILES['Filedata']['tmp_name'] );
            $config = $this->image_config->playlist_image_config( $id );
            $config['table']     = $this->db->dbprefix( $this->primary_table );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $this->image->configure_class( $config );

            if( $this->image->put_image() )
            {   
                $this->image->clear_config();
                echo 'great.';   
            } 
            else 
            {   
                echo 'error';
            }
        }
    }
    // }}}
    // {{{ public function music_image()
    public function music_image()
    {
    }
    // }}}
// END CRUD FUNCTIONS //
} // END CLASS //
?>
