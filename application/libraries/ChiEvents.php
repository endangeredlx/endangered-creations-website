<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* ChiEvents
*
* The Content Handling Interface Events Class (Decorator)
*
* Package Chi - Content Handling Interface
**/

require( APPPATH . 'libraries/ChiDecorator' . EXT );

class ChiEvents extends ChiDecorator
{
    // {{{ VARIABLES
    // Chi Query Object
    var $chiql;
    // CI instance
    private $CI;

    //---------------------------------
    // Extra Options
    //---------------------------------

    //}}}
    // {{{ public function __construct( ChiQL $ChiQL )
    public function __construct( ChiQL $ChiQL )
    {
        $this->chiql = $ChiQL;
        $this->CI = $this->chiql->myCI();
    }
    // }}}
}
