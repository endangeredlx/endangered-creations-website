<?php if( ! defined('BASEPATH') ) exit('No direct script access allowed');
/**
* ChiXML
*
* The Content Handling Interface XML editing class
* This is an abstract component class. It should be extended and then can be decorated.
*
* Package Chi - Content Handling Interface
**/
class ChiXML
{
   // {{{ public function __construct()   
   public function __construct()
   {
   }
   // }}}
   // {{{ public function update_xml( $str, $del, $new )
   public function update_xml( $str, $del, $new )
   {
       $end_delim = $this->end_delim();
       $start_delim = $this->full_start_delim( $del );
       $pcsa = explode( $start_delim, $str );
       $top = $pcsa[0];
       $pcsb = explode( $end_delim, $pcsa[1], 2 );
       $bottom = $pcsb[1];
       $ret = $top . $start_delim . $new . $end_delim .  $bottom;
       return $ret;
   }
   // }}}
   // {{{ private function full_start_delim( $name )
   private function full_start_delim( $name )
   {
       return '<!--{{{ ' . $name . ' -->';
   }
   // }}}
   // {{{ private function end_delim()
   private function end_delim()
   {
       return '<!--}}}-->';
   }
   // }}}
   // {{{ public function tag( $tag, $info )
   public function tag( $tag, $info )
   {
       $ret = '<' . $tag . '>' . $info . '</' . $tag . '>';
       return $ret;
   }
   // }}}
}
