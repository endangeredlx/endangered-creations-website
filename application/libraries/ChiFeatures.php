<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
   /**
   * ChiLayout
   *
   * The Content Handling Interface Features Class for interacting with the full layer of presentation for a given site.
   *
   * Package Chi - Content Handling Interface
   **/
class ChiFeatures
{
    // {{{ VARIABLES 
    // Code Igniter Instance.
    private $CI;  
    // The ChiQL object.
    private $chiql;
    // Array of the features for this page.
    private $features = array();
    // Features array position.
    private $features_position = -1;
    // }}}
    // {{{ public function __construct( $params = array( 'user_id' => 1 ) )
    public function __construct( ChiQL $ChiQL )
    {
        $this->CI =& get_instance();
        $this->chiql = $ChiQL;
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
