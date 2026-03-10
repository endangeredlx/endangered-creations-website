<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
   /**
   * ChiDecorator
   *
   * The Content Handling Interface Query Decorator Class (Decorator)
   *
   * Package Chi - Content Handling Interface
   **/
abstract class ChiDecorator 
{
    public function __construct( ChiQL $ChiQL )
    {
    }
    // {{{ public function get_ci_instance()
    public function get_ci_instance()
    {
        return parent::CI;
    }
    // }}}
    // {{{ public function row_value( $label )
    public function row_value( $label )
    {
        return $this->chiql->row_value( $label );
    }
    // }}}
    // --- PAGES --- //
    // {{{ public function page_row_value( $column )
    public function page_row_value( $column )
    {
        return $this->chiql->page_row_value( $column );
    }
   // }}}
    // {{{ public function page_looping()
    public function page_looping()
    {
        return $this->chiql->page_looping();
    }
    // }}}
    // {{{ public function number_of_pages()
    public function number_of_pages()
    {
        return $this->chiql->number_of_pages();
    }
    // }}}
    // {{{ public function set_next_available_page()
    public function set_next_available_page()
    {
        $this->chiql->set_next_available_page();
    }
    // }}}
    // {{{ public function load_pages()
    public function load_pages()
    {
        $this->chiql->load_pages();
    }
    // }}}
    // {{{ public function get_pages()
    public function get_pages()
    {
        return $this->chiql->get_pages();
    }
    // }}}
    // --- PHOTOS --- //
    // {{{ public function photos_looping()
    public function photos_looping()
    {
        return $this->chiql->looping();
    }
    // }}}
    // {{{ public function set_next_available_photo()
    public function set_next_available_photo()
    {
        $this->chiql->set_next_available_record();
    }
    // }}}
    // --- RECORDS --- //
    // {{{ public function looping() 
    public function looping() 
    {
    	return $this->chiql->looping();
    }
    // }}}
    // {{{ public function get_records()
    public function get_records()
    {
    	return $this->chiql->get_records();
    }
    // }}}
    // {{{ public function has_pic()
    public function has_pic()
    {
    	return $this->chiql->has_pic();
    }
    // }}}
    // {{{ public function has_video()
    public function has_video()
    {
    	return $this->chiql->has_video();
    }
    // }}}
    // {{{ public function get_current_video()
    public function get_current_video()
    {
    	return $this->chiql->get_current_video();
    }
    // }}}
    // {{{ public function get_current_pic()
    public function get_current_pic()
    {
    	return $this->chiql->get_current_pic();
    }
    // }}}
    // {{{ public function set_next_available_record()
    public function set_next_available_record()
    {
        $this->chiql->set_next_available_record();
    }
    // }}}
    // {{{ public function number_of_records()
    public function number_of_records()
    {
    	return $this->chiql->number_of_records();
    }
    // }}}
    // {{{ public function loop_position()
    public function loop_position()
    {
    	return $this->chiql->loop_position();
    }
    // }}}
    // --- RELATIVE HELPERS --- //
    // {{{ public function relative( $label )
    public function relative( $label )
    {
        return $this->chiql->relative( $label );
    }
    // }}}
    // {{{ public function is_relative()
    public function is_relative()
    {
        return $this->chiql->is_relative();
    }
    // }}}
}
