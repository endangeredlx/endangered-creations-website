<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
   /**
   * ChiOptions
   *
   * The Content Handling Interface Options Class for interacting with the options of a given site/user.
   *
   * Package Chi - Content Handling Interface
   **/
class ChiOptions
{
    // {{{ VARIABLES
    // Code Igniter Instance.
    private $CI;  
    // An array containing the option values. 
    private $options = array();
    // Array containing set-up parameters.
    private $params = array(); 
    // }}}
    // {{{ public function ChiOptions( $params = array( 'user_id' => 1 ) )
    public function ChiOptions( $params = array( 'user_id' => 1 ) )
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
        $this->CI->load->model( 'options_model', 'options' );
        $this->options = $this->CI->options->get_options( $this->params );
    }
    // }}}
    // {{{ public function option_value( $name )
    public function option_value( $name )
    {
        return $this->options[ $name ];
    }
    // }}}
    // {{{ public function htaccess()
    public function htaccess()
    {
        return $this->options['htaccess'];
    }
    // }}}
}
