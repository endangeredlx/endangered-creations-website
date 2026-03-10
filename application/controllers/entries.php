<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Entry Controller
**/
class Entries extends CI_Controller
{
    // {{{ VARIABLES
    var $class          = 'entries';
    var $singular       = 'entry';
    var $plural         = 'entries';
    var $table          = 'entries';
    var $tumblr_user    = '';
    // }}}
    // {{{ public function Entries()
    public function Entries()
    {
        parent::__construct();
    }
    // }}}
    // --- BASIC VIEW FUNCTIONS --- ///
    // {{{ public function index()
    public function index()
    {
        $this->listings();
    }
    // }}}
    // {{{ public function check_tumblr()
    public function check_tumblr()
    {
        // You should be aware that I didn't inclucde support for conversations in this version. Honestly,
        // I think tumblr should do away with them. 
        $this->load->model( $this->class . '_model', $this->class );
        $tumblr = $this->entries->get_latest_tumblr( $this->tumblr_user );
        $this->entries->update_with_tumblr( $tumblr );
    }
    // }}}
    // {{{ public function listings_tumblr()
    /**
    * ListingsWTumblr
    *
    * Generally made for displaying a list of records with pagination.
    *
    **/
    public function listings_tumblr()
    {
        // Set up a few parameters
        $offset = ( $this->uri->segment( 2 ) == "" ) ? 0 : $this->uri->segment( 2 );
        $params = array( 'type' => 'post', 'how_many' => 5, 'offset' => $offset, 'tumblr' => 'true' );
        $layout_params = array( 'user_id' => 1, 'page' => 'entries' );
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
        'records'            => $ChiQL,
        'presentation'       => $Presentation,
        'options'            => $Options, 
        'page_title'         => " | Blog",
        'last_stories'       => $this->ChiRecords->get_last( 5 ),
        'archives'           => $this->ChiRecords->get_archives( 5 ),
        'title'              => 'Blog',
        'type'               => $this->class, 
        'page_type'          => 'entry',
        'main_content'       => $Presentation->theme_relative_path() . $this->class . '/list'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $this->db->where( array( 'type' => 'post', 'status' => 'published' ) );
        $config = array(
        'base_url'           => base_url() . $htfix . $this->class . '/listings_tumblr',
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
    // {{{ public function listings()
    /**
    * Listings
    *
    * Generally made for displaying a list of records with pagination.
    *
    **/
    public function listings()
    {
        // Set up a few parameters
        $offset = ( $this->uri->segment( 2 ) == "" ) ? 0 : $this->uri->segment( 2 );
        $offset = ( is_numeric( $offset ) ) ? $offset : 0;
        //$params = array( 'type' => 'post', 'how_many' => 5, 'offset' => $offset, 'tumblr' => 'false' );
        $params = array( 
            'type'                  => 'post', 
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
            'records'            => $ChiQL,
            'presentation'       => $Presentation,
            'options'            => $Options, 
            'page_title'         => 'Blog',
            'last_stories'       => $this->ChiRecords->get_last( 5 ),
            'archives'           => $this->ChiRecords->get_archives( 5 ),
            'active_page'        => 'blog',
            'title'              => 'Blog',
            'type'               => $this->class, 
            'page_type'          => 'entry',
            'main_content'       => $Presentation->theme_relative_path() . $this->class . '/list'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $total_num = $this->entries->get_records_num( $params );
        $config = array(
            'base_url'           => base_url() . $htfix . 'blog',
            'total_rows'         => $total_num,
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
    // {{{ public function archives()
    // Still need to refactor this function to work with the new ChiQL object.
    public function archives()
    {
        // Set up a few parameters
        $year = $this->uri->segment( 3 );
        $month_num = $this->uri->segment( 4 );
        $offset = ( $this->uri->segment( 5 ) == "" ) ? 0 : $this->uri->segment( 5 );
        $offset = ( is_numeric( $offset ) ) ? $offset : 0;
        $params = array( 
            'type'                  => 'post', 
            'how_many'              => 10, 
            'include_unpublished'   => false,
            'offset'                => $offset, 
            'year'                  => $year,
            'month_num'             => $month_num,
            'archives'              => true
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
            'records'            => $ChiQL,
            'presentation'       => $Presentation,
            'options'            => $Options, 
            'page_title'         => 'Archives',
            'last_stories'       => $this->ChiRecords->get_last( 5 ),
            'archives'           => $this->ChiRecords->get_archives( 5 ),
            'is_archive'         => true,
            'year'               => $year,
            'month'              => date( 'F', mktime( 0, 0, 0, $month_num, 1 ) ),
            'title'              => 'Archives',
            'type'               => $this->class, 
            'page_type'          => 'entry',
            'main_content'       => $Presentation->theme_relative_path() . $this->class . '/list'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';
        $this->load->model( 'entries_model', 'entries' );
        $total_num = $this->entries->get_archives_num( $month_num, $year );
        $config = array(
            'base_url'           => base_url() . $htfix . 'blog',
            'total_rows'         => $total_num,
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
    // {{{ public function single()
    public function single()
    {
        // Set up a few parameters
        $id = ( $this->uri->segment( 3 ) == "" ) ? 0 : $this->uri->segment( 3 );
        $params = array( 'type' => 'post', 'how_many' => 1, 'id' => $id );
        $layout_params = array( 'user_id' => 1, 'page' => 'entries_single' );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Presentation =& $this->ChiPresentation;
        $Options =& $this->ChiOptions;


        // Get the extra photos.
        $this->load->model( 'photos_model', 'photos' );
        $this->load->model( 'comments_model', 'comments' );
        $ChiQL->set_next_available_record();
        $aid = $ChiQL->row_value( 'album' );
        $ChiQL->reset_available_records();
        $comments = $this->comments->get_comments( $id, 'entries', array( 'include_unpublished' => false, 'how_many' => 30, 'offset' => 0 ) );
        $photos = $this->photos->get_photos( $aid );

        // Main data array.
        $data = array(
            'photos'                => $photos,
            'records'               => $ChiQL,
            'presentation'          => $Presentation,
            'comments'              => $comments,
            'options'               => $Options, 
            'page_title'            => 'Blog',
            'recaptcha_key'         => '6Lc6k8MSAAAAAAhzG-xt9emu3YRcE-9XxVMfdbjC',
            'title'                 => 'Blog',
            'type'                  => $this->class, 
            'last_stories'          => $this->ChiRecords->get_last( 5 ),
            'archives'              => $this->ChiRecords->get_archives( 5 ),
            'page_type'             => 'entry',
            'main_content'          => $Presentation->theme_relative_path() . $this->class . '/single'
        );

        // Load view.
        $this->load->view( $Presentation->theme_relative_path() . 'clone', $data );
    }
    // }}}
    // {{{ public function search()
    public function search()
    {
        $q = $this->uri->segment( 3 );
        // Set up a few parameters
        $offset = ( $this->uri->segment( 2 ) == "" ) ? 0 : $this->uri->segment( 2 );
        $offset = ( is_numeric( $offset ) ) ? $offset : 0;
        $params = array( 
            'type'                  => 'post', 
            'how_many'              => 5, 
            'include_unpublished'   => false,
            'offset'                => $offset, 
            'query'                 => $q,
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
            'records'            => $ChiQL,
            'presentation'       => $Presentation,
            'options'            => $Options, 
            'page_title'         => 'Blog',
            'last_stories'       => $this->ChiRecords->get_last( 5 ),
            'archives'           => $this->ChiRecords->get_archives( 5 ),
            'title'              => 'Blog',
            'is_search'          => true,
            'query'              => $q,
            'type'               => $this->class, 
            'page_type'          => 'entry',
            'main_content'       => $Presentation->theme_relative_path() . $this->class . '/list'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $config = array(
            'base_url'           => base_url() . $htfix . 'blog',
            'total_rows'         => $ChiQL->number_of_records(),
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
    // {{{ public function validate_comment()
    public function validate_comment()
    {
        $option_params = array( 'user_id' => 1 );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        $options =& $this->ChiOptions;
        $require_captcha = ( $options->option_value( 'comment_captcha' ) == 1 ) ? true : false;
        $comment_approval = ( $options->option_value( 'comment_approval' ) == 1 ) ? true : false;
        if( $require_captcha )
        {
            require( APPPATH . 'libraries/recaptchalib' . EXT );
            $priv_key = '6Lc6k8MSAAAAAInaQC078DCVfalCR5WXBIgtTqe_';
            $resp = recaptcha_check_answer( $priv_key, $_POST['remoteip'], $_POST['challenge'], $_POST['response'] );
            $make_comment = $resp->is_valid;
        }
        else
        {
            $make_comment = true;
        }

        // If the comment isn't posted below, $success remains false.
        $success = false;
        if( $make_comment )
        {
            $status = ( $comment_approval ) ? 'unpublished' : 'published';
            $this->load->model( 'comments_model', 'comments' );
            $insert = array(
                'record_id'         => $this->input->post( 'record_id' ),
                'author'            => $this->input->post( 'author' ),
                'email'             => $this->input->post( 'email' ),
                'website'           => $this->input->post( 'website' ),
                'ip'                => $this->input->post( 'remoteip' ),
                'date'              => time(),
                'parent'            => $this->input->post( 'parent_id' ),
                'content'           => $this->input->post( 'content' ),
                'status'            => $status,
                'type'              => 'entries'
            );
            $success = $this->comments->add( $insert );
        }

        $json = array( 'success' => $success, 'require_captcha' => $require_captcha, 'comment_approval' => $comment_approval  );
        echo json_encode( $json );
    }
    // }}}
    // {{{ public function karma()
    public function karma()
    {
        $id = $this->uri->segment( 3 );
        $this->load->model( 'entries_model', 'entries' );
        if( $this->input->post('type') == 'good' )
        {
            $response = '+1';
            $success = $this->entries->add_good_karma( $id );
        }
        else
        {
            $response = '-1';
            $success = $this->entries->add_bad_karma( $id );
        }

        $json = array( 'success' => $success, 'message' => $response );
        echo json_encode( $json );
    }
    // }}}
    // {{{ public function cat()
    public function cat()
    {
        // Set up a few parameters
        $slug = ( $this->uri->segment( 3 ) == '' ) ? 0 : $this->uri->segment( 3 );
        $offset = ( $this->uri->segment( 4 ) == '' ) ? 0 : $this->uri->segment( 4 );
        $params = array( 
            'type'                  => 'cat', 
            'how_many'              => 5, 
            'slug'                  => $slug,
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
            'records'            => $ChiQL,
            'presentation'       => $Presentation,
            'options'            => $Options, 
            'page_title'         => 'Blog',
            'last_stories'       => $this->ChiRecords->get_last( 5 ),
            'archives'           => $this->ChiRecords->get_archives( 5 ),
            'title'              => 'Blog',
            'type'               => $this->class, 
            'page_type'          => 'entry',
            'main_content'       => $Presentation->theme_relative_path() . $this->class . '/list'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $this->db->where( array( 'type' => 'post', 'status' => 'published' ) );
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
    // {{{ public function cat_page()
    public function cat_page()
    {
        // Set up a few parameters
        $slug = ( $this->uri->segment( 3 ) == '' ) ? 0 : $this->uri->segment( 3 );
        $offset = ( $this->uri->segment( 4 ) == '' ) ? 0 : $this->uri->segment( 4 );
        $how_many = ( $slug == 'videos' ) ? 'all' : 5;
        $params = array( 
            'type'                  => 'cat', 
            'how_many'              => $how_many, 
            'slug'                  => $slug,
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
        if( 
            is_dir( 'application/views/' . $Presentation->theme_relative_path() . $this->class . '/cats/' . $slug ) ||
            file_exists( 'application/views/' . $Presentation->theme_relative_path() . $this->class . '/cats/' . $slug . '/list.php' ) 
        )
        {
            $main_content = $Presentation->theme_relative_path() . $this->class . '/cats/' . $slug . '/list';
        }
        else
        {
            $main_content = $Presentation->theme_relative_path() . $this->class . '/list';
        }

        // Main data array.
        $data = array(
            'records'            => $ChiQL,
            'presentation'       => $Presentation,
            'options'            => $Options, 
            'page_title'         => ucwords( $slug ),
            'active_page'        => $slug,
            'last_stories'       => $this->ChiRecords->get_last( 5 ),
            'archives'           => $this->ChiRecords->get_archives( 5 ),
            'title'              => 'Blog',
            'type'               => $slug, 
            'page_type'          => 'entry',
            'main_content'       => $main_content
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $this->load->model( 'entries_model', 'entries' );
        $total_num = $this->entries->get_records_num( $params );
        $config = array(
            'base_url'           => base_url() . $htfix . $slug,
            'total_rows'         => $total_num,
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
            'type'                  => 'post', 
            'how_many'              => 10, 
            'offset'                => $offset, 
            'tumblr'                => 'false', 
            'get_all_entries'       => true,
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

        $this->load->model( 'entries_model', 'entries' );

        $total = $this->entries->get_records_num( $params );

        $config = array(
            'base_url'           => base_url() . $htfix . $this->class . '/manage',
            'total_rows'         => $total,
            'per_page'           => $params['how_many'],
            'num_links'          => 8,
            'uri_segment'        => 3,
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
     * Loads view and information for editing specific entries
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
        $params = array( 
            'type'      => 'post', 
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
            'type'                  => 'post', 
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
    // {{{ public function add_photos()
    public function add_photos()
    {   
        $this->is_logged_in();
        $this->load->model( 'entries_model' );
        $id = $this->uri->segment(3);
        $data['primary_id'] = $id;
        $data['record'] = $this->entries_model->get_record( $id );
        $data['secondary_id'] = $data['record'][0]->album;
        $data['class'] = 'entries';
        $data['upload_function'] = 'photos_upload';
        $data['human_name'] = 'Image';
        $data['what'] = 'image';
        $data['file_type'] = 'image';
        $data['uploader'] = 'multipleFile';
        $data['main_content'] = "admin/entries/file_upload";
        $data['javascript'] = array( 'swfaddress', 'swfobject', 'general/admin.basic', 'entries/photo' );
        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function delete_photo()
    public function delete_photo()
    {
        $this->is_logged_in();
        $this->load->model( 'entries_model', 'entries' );
        $id = $this->uri->segment( 3 );
        $this->entries->delete_photo( $id );
        echo "photo removed";
    }
    // }}}
    // --- CRUD FUNCTIONS --- //
    // {{{ public function create()
    public function create()
    {
        $this->is_logged_in();
        $this->load->helper('text');
        $this->load->model('entries_model');
        $this->load->library('form_validation');   
        $this->form_validation->set_rules('title', 'Title', 'trim|required');            
        $this->form_validation->set_error_delimiters('<div class="notice error">', '</div>');
        if ( $this->form_validation->run() == TRUE ) 
        {
            // Prepare the data for the database.
            $title = $this->input->post('title');
            $name = url_title( $title, 'dash', true );
            $insert = array(
                'title'         => $title,
                'author'        => $this->input->post('author'),
                'name'          => $name,
                'date'          => time(),
                'content'       => $this->input->post('content')
            );

            // Insert the data array.
            $add = $this->entries_model->add( $insert );
            $id = $this->db->insert_id();

            // Prepare an empty photo album.
            $inst = array(
                'title'        => ucwords( $this->singular ) . ' Photo Album ' . $id,
                'description'  => '~~~entries~~~',
                'ref_id'       => $id,
                'date'         => time()
            );
            $this->load->model( 'photos_model', 'photos' );
            // Create empty photo album.
            $addalbum = $this->photos->add( $inst );

            // Grab the album id and associate it with the entry.
            $aid = $this->db->insert_id();
            $update = $this->entries_model->update( $id, array( 'album' => $aid ) );

            // Update the XML, if need be.
            /* if( $add ) 
            {
                $this->load->library( 'ChiXML' );
                $this->ChiXML->update_entries_xml();
            } */

            if( $add ) 
            {
                redirect( 'entries/edit/' . $id );
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
    // {{{ public function shorten_url( $query ) 
    public function shorten_url( $query ) 
    {
        $this->load->model( 'options_model', 'options' );
		$to_shorten = base_url() . $query;
		$args = func_get_args();
		
        if( isset( $to_shorten ) && !empty( $to_shorten ) )
        {
			$input_url = strip_tags( trim( $to_shorten ) );
			//Ensure that the url is valid, php 5+ required 
            if( !filter_var( $input_url, FILTER_VALIDATE_URL ) )
            {
				echo 'Invalid URL.'.$input_url;
			}
            else
            {
				$url_enc = urlencode( $input_url );
				$version = '2.0.1';
				$login = $this->options->get_option_by_name( 'bitly_username' );
				$api_key = $this->options->get_option_by_name( 'bitly_api_key' );
				$format = 'json';
				$data = file_get_contents('http://api.bit.ly/shorten?version='.$version.'&login='.$login.'&apiKey='.$api_key.'&longUrl='.$url_enc.'&format='.$format);
				$json = json_decode( $data, true );
		        if( isset( $json['results'] ) )
                { 
                    foreach( $json['results'] as $val)
                    {
                        return $val['shortUrl'];
                    }
                }
			}
		}
		else {
			echo 'Null or empty URL given.';
	    }
	}
    // }}}
    // {{{ public function update()
    public function update()
    {   
        $this->is_logged_in();
        $this->load->helper('text');
        $this->load->model( 'entries_model', 'entries' );
        $this->load->model( 'operations_model', 'operate' );
        $this->load->library('form_validation');
        //Set validation rules...
        $this->form_validation->set_rules('title', 'Title', 'trim|required');            
        $this->form_validation->set_error_delimiters('<div class="notice error">', '</div>');

        if ( $this->form_validation->run() == TRUE ) 
        {
            $id = $this->uri->segment( 3 );
            $title = $this->input->post('title');
            $name = url_title( $title, 'dash', true );
            $format_check = $this->input->post('format_check');
            $content = ($format_check == 'clear') ? strip_tags( $this->input->post('content'), '<br><p><strong><u>' ) : $this->input->post('content');
            $excerpt = word_limiter( $content, 50);
            $excerpt = strip_tags( $excerpt );
            // Try to extract the video code and put it in the database.
            $video_code = $this->operate->get_vid_code( $this->input->post('video'), $this->input->post('video_type') );
            // If we don't get a unique id for the video, then we don't store video type.
            $video_type = $video_code == "" ? "" : $this->input->post('video_type');
            $small_url = $this->shorten_url( 'blog/single/' . $id . '/' . url_title( $this->input->post( 'title' ) ) );
            $update = array(
                'title'         => $this->input->post('title'),
                'name'          => $name,
                'content'       => $content,
                'excerpt'       => $excerpt,
                'status'        => $this->input->post('status'),
                'small_url'     => $small_url,
                'video_type'    => $video_type,
                'video'         => $video_code
            );
            $change = $this->entries->update( $id, $update );
            $success = $change;

            $cat = array();
            array_push( $cat, $this->input->post( 'category' ) );
            $this->entries->update_categories( $id, $cat );

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
        $id = $this->uri->segment( 3 );
        $this->load->model( 'entries_model', 'entries' );
        $this->entries->delete( $id );
        redirect( 'entries/manage' );
    }
    // }}}
    // {{{ public function file_upload()
    public function file_upload()
    {
        $this->load->model( 'image_model', 'image' );
        $this->load->model( 'image_config' );
        $id = $this->uri->segment( 3 );
        if( count( $_FILES ) > 0 ) 
        {   
            // Midsize
            $config = $this->image_config->entries_small_config( $id );
            $config['table']     = $this->db->dbprefix( $this->table );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $this->image->configure_class( $config );
            $this->image->put_image();
            $this->image->clear_config();
            echo 'great';
        }
        else
        {
            echo 'error';
        }
    }
    // }}}
    // {{{ public function photos_upload()
    public function photos_upload()
    {
        $this->load->model( 'image_model', 'image' );
        $this->load->model( 'photos_model', 'photos' );
        $this->load->model( 'entries_model', 'entries' );
        $this->load->model( 'image_config' );

        // Get album id.
        $ent = $this->uri->segment( 3 );
        $id = $this->uri->segment( 4 );

        if( count( $_FILES ) > 0 ) 
        {   
            $pid = $this->photos->create_pic_row( $id );
            $config = $this->image_config->entries_extra_config( $pid );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $this->image->configure_class( $config );

            if( $this->image->put_image() )
            {   
                $this->image->clear_config();
                $config = $this->image_config->small_photos_config( $pid );
                $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
                $config['temp_name'] = $_FILES['Filedata']['name'];
                $this->image->configure_class( $config );

                if( $this->image->put_image() )
                {
                    $this->photos->set_order( $id, $pid );
                    $this->photos->update_album_size( $id );
                    echo "uploaded.";   
                }
            } 
            else 
            {   
                echo "error.";
            }
        }
    }
    // }}}
// END CRUD FUNCTIONS //
} // END CLASS //
?>
