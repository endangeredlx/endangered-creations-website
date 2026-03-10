<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
   /**
   * ChiLayout
   *
   * The Content Handling Interface Presentation Class for interacting with the full layer of presentation for a given site.
   *
   * Package Chi - Content Handling Interface
   **/
class ChiPresentation
{
    // {{{ VARIABLES 
    // Code Igniter Instance.
    private $CI;  
    // Name of Theme. 
    private $theme_name;
    // Array containing theme settings.
    private $theme = array();
    // Array containing set-up parameters.
    private $params = array(); 
    // Absolute path to the theme folder.
    private $theme_path;
    // Array of the css files needed for this page.
    private $css = array();
    // CSS array position.
    private $css_position = -1;
    // Array of the javascript files needed for this page.
    private $js = array();
    // Javascript array position.
    private $js_position = -1;
    // Relative path to the theme folder from ROOT/application/views/
    private $theme_relative_path;
    // Array of information pertinent to the current page.
    private $page_options = array();
    // }}}
    // {{{ public function __construct( $params = array( 'user_id' => 1 ) )
    public function __construct( $params = array( 'user_id' => 1 ) )
    {
        $this->CI =& get_instance();
        $this->params = $this->sanitize( $params );
        $this->initiate();
    }
    // }}}
    // {{{ private function sanitize( $array )
    private function sanitize( $array )
    {
        return $array;
    }
    // }}}
    // {{{ private function initiate()
    private function initiate()
    {
        $this->CI->load->model( 'presentation_model', 'presentation' );
        $this->theme = $this->CI->presentation->get_user_theme( $this->params['user_id'] );
        $this->page_options = $this->CI->presentation->get_theme_page( $this->theme->id, $this->params['page'] );
        $this->css[] = $this->theme->css . '.css';
        $this->setup( $this->page_options );
        $this->theme_name = $this->theme->name;
        $this->theme_relative_path = 'themes/' . $this->theme_name . '/'; 
    }
    // }}}
    // {{{ public function setup( $array )
    public function setup( $array )
    {
        if( isset( $array->css ) )
        {
            $data = array();
            if( strpos( $array->css, "," ) !== FALSE )
            {
                $css_array = explode( ',', $array->css ); 
                foreach( $css_array as $file )
                {
                    $this->css[] = trim( $file ) . '.css';
                }
            } 
            else if( $array->css != '' )
            {
                $this->css[] = trim( $array->css ) . '.css';
            }
        }

        if( isset( $array->javascript ) )
        {
            if( strpos( $array->javascript, "," ) !== FALSE )
            {
                $js_array = explode( ',', $array->javascript ); 
                foreach( $js_array as $file )
                {
                    $this->js[] = trim( $file ) . '.js';
                }
            } 
            else if( $array->javascript != '' )
            {
                $this->js[] = trim( $array->javascript ) . '.js';
            }
        }
    }
    // }}}
    // {{{ public function there_are_scripts()
    public function there_are_scripts()
    {
        $num = count( $this->js );
        if( $num != 0 && ( $this->js_position < ( $num - 1 ) ) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    // }}}
    // {{{ public function get_script()
    public function get_script()
    {
        $this->js_position++;
    }
    // }}}
    // {{{ public function script()
    public function script()
    {
        return $this->js[ $this->js_position ];
    }
    // }}}
    // {{{ public function there_are_stylesheets()
    public function there_are_stylesheets()
    {
        $num = count( $this->css );
        if( $num != 0 && ( $this->css_position < ( $num - 1 ) ) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    // }}}
    // {{{ public function get_stylesheet()
    public function get_stylesheet()
    {
        $this->css_position++;
    }
    // }}}
    // {{{ public function stylesheet()
    public function stylesheet()
    {
        return $this->css[ $this->css_position ];
    }
    // }}}
    // {{{ public function theme_relative_path()
    public function theme_relative_path()
    {
        return $this->theme_relative_path;
    }
    // }}}
    // {{{ public function theme_path()
    public function theme_path()
    {
        return base_url() . 'application/views/' . $this->theme_relative_path;
    }
    // }}}
    // {{{ public function theme_css()
    public function theme_css()
    {
        return $this->theme->css;
    }
    // }}}
    // {{{ public function theme_name()
    public function theme_name()
    {
        return $this->theme_name;
    }
    // }}}
}
