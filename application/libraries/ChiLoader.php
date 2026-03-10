<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Loader Class
 *
 * Loads views and files
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		ExpressionEngine Dev Team
 * @category	Loader
 * @link		http://codeigniter.com/user_guide/libraries/loader.html
 */
class Chi_Loader extends CI_Loader {

   public function Chi_Loader()
   {
      parent::CI_Loader();
   }
   

	/**
	 * Multiple Class Loader
	 *
	 * This function lets users load and instantiate classes.
	 * It is designed to be called from a user's app controllers.
	 *
	 * @access	public
	 * @param	string	the name of the class
	 * @param	mixed	the optional parameters
	 * @param	string	an optional object name
	 * @return	void
	 */	
	function multi_library( $library = '', $params = NULL, $object_name = NULL)
	{
		if ($library == '')
		{
			return FALSE;
		}

		if ( ! is_null( $params ) AND ! is_array( $params ))
		{
			$params = NULL;
		}

		if ( ! is_null( $object_name ) AND ! is_array( $object_name ))
		{
			$object_name = NULL;
		}

		if( is_array( $library ) )
		{
			foreach ( $library as $key=>$class )
			{
            $args = ( $params != NULL ) ? $params[$key] : NULL;
            $object = ( $object_name != NULL ) ? $object_name[$key] : NULL;
				$this->_ci_load_class( $class, $args, $object );
			}
		}
      else
		{
			return FALSE;
		}
		
		$this->_ci_assign_to_models();
	}

	// --------------------------------------------------------------------

}
