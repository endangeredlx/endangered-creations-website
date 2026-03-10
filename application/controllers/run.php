<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Run extends CI_Controller 
{
    // {{{ public function Run()
    public function Run()
    {
        parent::__construct();
        // $this->check_tumblr();
    }
    // }}}
    // {{{ public function index()
    public function index()
    {
        //$this->construction();
        $this->home();
    }
    // }}}
    // {{{ public function construction()
    public function construction()
    {
        $layout_params = array( 'user_id' => 1, 'page' => 'home' );
        $option_params = array( 'user_id' => 1 );
        $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        $Presentation =& $this->ChiPresentation;
        $Options =& $this->ChiOptions;
        $data = array(
            'presentation'          => $Presentation,
            'options'               => $Options 
        );
        // Load view.
        $this->load->view( $Presentation->theme_relative_path() . 'construction', $data );
        
    }
    // }}}
    // {{{ public function rss()
    public function rss()
    {
        // Set up a few parameters
        $offset = 0;
        $ql_params = array( 
            'type'                  => 'post', 
            'how_many'              => 10, 
            'offset'                => $offset, 
            'order_by' => '`order` DESC', 
            'include_unpublished'   => false 
        );

        $layout_params = array( 'user_id' => 1, 'page' => 'home' );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $ql_params, 'ChiRecords' );
        $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Get the features real quick.

        // Main page configuration.
        $QL =& $this->ChiRecords;
        $Presentation =& $this->ChiPresentation;
        $Options =& $this->ChiOptions;

        $data = array(
            'records'               => $QL,
            'presentation'          => $Presentation,
            'options'               => $Options 
        );
        // Load view.
        $this->load->view( 'rss/simple', $data );
    }
    // }}}
    // {{{ public function phpinfo()
    public function phpinfo()
    {
        phpinfo();
    }
    // }}}
    // {{{ public function check_tumblr()
    public function check_tumblr()
    {
        // You should be aware that I didn't inclucde support for conversations in this version. Honestly,
        // I think tumblr should do away with them. 
        // $this->load->model( 'entries_model', 'entries' );
        // $tumblr = $this->entries->get_latest_tumblr( 'djmobeatz' );
        // $this->entries->update_with_tumblr( $tumblr );
    }
    // }}}
    // {{{ public function home() 
    public function home() 
    {
        // Set up a few parameters
        $offset = 0;
        $ql_params = array( 
            'type'                  => 'post', 
            'how_many'              => 5, 
            'offset'                => $offset, 
            'order_by'              => '`order` DESC', 
            'include_unpublished'   => false 
        );
        $layout_params = array( 'user_id' => 1, 'page' => 'home' );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $ql_params, 'ChiRecords' );
        $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Get the features real quick.
        $this->load->model( 'features_model', 'features' );
        $features = $this->features->get_records();

        // Main page configuration.
        $QL =& $this->ChiRecords;
        $Presentation =& $this->ChiPresentation;
        $Options =& $this->ChiOptions;
        $featured_videos = json_decode( $Options->option_value( 'featured_videos' ) );
        $QL->load_features( $features );
        $data = array(
            'features'           => $features,
            'records'            => $QL,
            'featured_videos'    => $featured_videos,
            'presentation'       => $Presentation,
            'options'            => $Options, 
            'active_page'        => 'home',
            'page_title'         => 'Home',
            'title'              => 'Home',
            'type'               => 'home', 
            'page_type'          => 'home',
            'main_content'       => $Presentation->theme_relative_path() . 'general/home'
        );
        // Load view.
        $this->load->view( $Presentation->theme_relative_path() . 'clone', $data );
    }
    // }}}
    // {{{ public function flash()
    public function flash()
    {
        $offset = 0;
        $ql_params = array( 'type' => 'post', 'how_many' => 1, 'offset' => $offset, 'order_by' => 'order DESC', 'include_unpublished' => false );
        $layout_params = array( 'user_id' => 1, 'page' => 'home' );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $ql_params, 'ChiRecords' );
        $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Get the features real quick.
        $this->load->model( 'features_model', 'features' );
        $features = $this->features->get_records( 5 );

        // Main page configuration.
        $QL =& $this->ChiRecords;
        $Presentation =& $this->ChiPresentation;
        $Options =& $this->ChiOptions;
        $data = array(
        'features'           => $features,
        'records'            => $QL,
        'presentation'       => $Presentation,
        'options'            => $Options, 
        'page_title'         => " | Official Site",
        'title'              => 'Home',
        'type'               => 'home', 
        'page_type'          => 'home',
        'main_content'       => $Presentation->theme_relative_path() . 'general/home'
        );

        // Load view.
        $this->load->view( $Presentation->theme_relative_path() . 'clone', $data );
    }
    // }}}
}

?>
