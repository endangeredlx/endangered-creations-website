<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ChiStore
*
* The Content Handling Interface Store Class (Decorator)
*
* Package Chi - Content Handling Interface
**/

require( APPPATH . 'libraries/ChiDecorator' . EXT );

class ChiStore extends ChiDecorator
{
    // {{{ VARIABLES
    // Chi Query Object
    var $chiql;
    // CI instance
    private $CI;
    //---------------------------------
    // Extra Options
    //---------------------------------

    // id of the options.
    private $option_id          = array();
    // The human readable name of the first option.
    private $option_labels      = array();
    // Array of first of option values (store).
    private $option_values      = array();
    // Current position of loop through option values.
    private $option_position    = -1;
    // Current option being interated through.
    private $current_option     = -1;
    // The number of options found.
    private $number_of_options = 0;
    // Options Table
    private $relationship_table      = 'store_options';
    //}}}
    // {{{ public function __construct( ChiQL $ChiQL )
    public function __construct( ChiQL $ChiQL )
    {
        $this->chiql = $ChiQL;
        $this->CI = $this->chiql->myCI();
    }
    // }}}
    // {{{ public function set_next_available_record()
    public function set_next_available_record()
    {
        $this->chiql->set_next_available_record();
        $this->set_item_options();
    }
    // }}}
    // {{{ private function set_item_options()
    private function set_item_options()
    {
        $this->CI->load->library( 'Utils' );
        $options = $this->chiql->get_options( $this->chiql->param_value('id'), $this->relationship_table, 'store_item_options', 'item_option' );
        $num_options = count( $options );
        if( $num_options > 0 )
        {
            foreach( $options as $option ) 
            { 
                $opt = explode( '~', $option->option );
                $this->option_label[] = $opt[0];
                $this->option_id[] = $option->type_id;
                $exopt = explode( ',', $option->values );
                $currkey = count( $this->option_values ); 
                foreach( $exopt as $exploded )
                {
                    $parts = explode( '~', $exploded );
                    $this->option_values[ $currkey ][] = array( 'name' => $parts[0], 'value' => $parts[1] );
                }
            }
        }
        $this->number_of_options = $num_options;
    }
    // }}}
    // {{{ public function num_options()
    public function num_options()
    {
        return $this->number_of_options;
    }
    // }}}
    // {{{ public function there_are_item_options()
    public function there_are_item_options()
    {
        if( ( $this->number_of_options > 0 ) &&  $this->current_option < ( $this->number_of_options - 1 ) )
        {
            return true;
        }
        else 
        {
            return false;
        }
    }
    // }}}
    // {{{ public function there_are_option_values()
    public function there_are_option_values()
    {
        $co = $this->current_option;
        $num_values = count( $this->option_values[ $co ] );
        if( $num_values > 0 && $this->option_position < ( $num_values -1 ) )
        {
            return true; 
        }
        else
        {
            return false;
        }
    }
    // }}}
    // {{{ public function get_item_options()
    public function get_item_options()
    {
        $this->current_option++;
        $this->option_position = -1;
    }
    // }}}
    // {{{ public function get_option_values()
    public function get_option_values()
    {
        $this->option_position++;
    }   
    // }}}
    // {{{ public function option_position()
    // The Human Readable position. (i.e. if the current position is 0 we return 1) get it?
    public function option_position()
    {
        return $this->current_option + 1;
    }
    // }}}
    // {{{ public function option_id()
    public function option_id()
    {
        return $this->option_id[ $this->current_option ]; 
    }
    // }}}
    // {{{ public function option_label()
    public function option_label()
    {
        return $this->option_label[ $this->current_option ]; 
    }
    // }}}
    // {{{ public function option_value_name()
    public function option_value_name()
    {
        return $this->option_values[ $this->current_option ][ $this->option_position ][ 'name' ];
    }
    // }}}
    // {{{ public function option_value_value()
    public function option_value_value()
    {
    }
    // }}}
}
