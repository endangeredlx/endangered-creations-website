<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
   /**
   * ChiUtils
   *
   * The Content Handling Interface Utility Class.
   *
   * Package Chi - Content Handling Interface
   **/
class Utils
{
   public function isset_notblank( $value ) 
   {
      if( isset( $value ) && $value != "" ) 
      {
         return true;
      }
      else 
      {
         return false; 
      }
   }
}
