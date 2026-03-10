<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
   
   require( APPPATH . 'libraries/ChiQL' . EXT ); 
   /**
   * ChiRecords
   *
   * The Content Handling Interface Records Class (Decorator) 
   *
   * Package Chi - Content Handling Interface
   **/
class ChiRecords extends ChiQL
{
   // {{{ public function  __construct( $params )
   public function __construct( $params = array() )
   {
      parent::__construct( $params );
   }
   // }}}
}
