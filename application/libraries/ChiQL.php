<?php if( ! defined('BASEPATH') ) exit('No direct script access allowed');
/**
* ChiQL
*
* The Content Handling Interface Query Class 
* This is an abstract component class. It should be extended and then can be decorated.
*
* Package Chi - Content Handling Interface
**/
abstract class ChiQL
{
   // {{{ VARIABLES
   // Code Igniter Instance.
   private $CI;  
   // Position of the loop.
   private $loop_position = -1;
   // Number of records returned from the main query.
   private $number_of_records = 0;
   // Parameters passed to the object.
   private $params = array();
   // Holds the names of pages if needed.
   public $pages = array();
   // Position of the pages.
   private $pages_position = -1;
   // Number of pages returned from the main query.
   private $number_of_pages = 0;
   // If this record is relative of another record.
   private $is_relative = false;
   // If this is a relative record, this array contains information about the parent.
   private $relative = array();
   // Hold feature information if needed. 
   private $features = array();
   // Feature position. 
   private $features_position = -1;
   // Number of features loaded.
   private $number_of_features = 0;
   // Whether or not the features are looping.
   private $features_looping = false;
   // Holds the archives if needed.
   public $archives = array();
   // }}}
   // {{{ public function __construct( $params = array() )   
   public function __construct( $params = array() )
   {
      $this->CI =& get_instance();
      $this->params = $this->validate_params( $params );
      $this->initiate();
      $this->get_records();
   }
   // }}}
    // {{{ public function myCI()
   public function myCI()
   {
      return $this->CI;
   }
   // }}}
   // {{{ private function validate_params()
   private function validate_params( $array )
   {
      // Default parameters.
      $default = array(
         'type'      => 'post',
         'unpub'     => false,
         'how_many'  => 5,
         'tumblr'    => 'true',
         'pages'     => false,
         'offset'    => 0
      );

      // Make sure the required parameters are present.
      foreach( $default as $key=>$def )
      {
         if( ! isset( $array[$key] ) )
         {
            $array[$key] = $def;
         }
      }
      return $array;
   }
   // }}}
   // {{{ private function initiate()
   private function initiate()
   {
      // Set class variable. Default is 'entries'.
      $this->class = ( isset( $this->params['class'] ) ) ? $this->params['class'] : 'entries';
   }
   // }}}
    // {{{ public function looping()
   /**
    * Are We Looping?
    *
    * Checks to see if we are in the middle of the main loop.
    *
    * @access	public
    * @return  boolean  
    */	
   public function looping()
   {
      if( ( $this->loop_position + 1 ) < $this->number_of_records )
      {
         $this->looping = true;
      }
      else
      {
         $this->looping = false;
      }
      return $this->looping;
   }
   // }}}
   // --- RELATIONSHIP FUNCTIONS --- //
    // {{{ private function check_for_ref()
    protected function check_for_ref()
    {
        // Check to see if this is a single record.
        if( count( $this->records ) == 1 && isset( $this->params['id'] ) )
        {
            // If the record has a description column we use that. If it has a content column we use that. If niether we leave it blank.
            $body = ( property_exists( $this->records[0], 'description' ) ) ? $this->records[0]->description : 
                        (
                            ( property_exists( $this->records[0], 'content' ) ) ? $this->records[0]->content : '' 
                        );
            // Check to see if it is a feature of another entry (It would fit the pattern ~~~class|function|id~~~
            if( preg_match( '/^[\~]{3}[a-zA-Z0-9\|]+[\~]{3}$/', $body ) )
            {
                $this->is_relative = true;
                $end = strlen($body) - 6;
                $rela = substr( $body, 3, $end);
                $relb = explode( '|', $rela );
                $this->relative['class'] = $relb[0];
                $this->relative['id'] = $relb[2];
                $this->relative['function'] = $relb[1];
                $this->CI->db->select( '`id`, `title`');
                $this->CI->db->where( 'id', $this->relative['id'] );
                $query = $this->CI->db->get( $this->relative['class'] );
                $this->relative['title'] = $query->row()->title;
            }
        }
    }
    // }}}
    // {{{ public function get_options( $relationship_table, $option_table, $type )
    public function get_options( $id, $relationship_table, $option_table, $type )
    {
        // Add the prefix if we have one
        $relationship_table = $this->CI->db->dbprefix( $relationship_table );
        $option_table = $this->CI->db->dbprefix( $option_table );
        $sql  = 'SELECT *';
        $sql .= ' FROM `' . $option_table . '`, `' . $relationship_table . '`';
        $sql .= ' WHERE ( `' . $relationship_table . '`.`record_id` = \'' . $id . '\')'; 
        $sql .= ' AND ( `' . $option_table . '`.`id` = `' . $relationship_table . '`.`type_id` )';
        $sql .= ' AND ( `' . $relationship_table . '`.`type` = \'' . $type . '\' )';
        $sql .= ' ORDER BY `' . $relationship_table . '`.`type_id` ASC;';
        $query = $this->CI->db->query( $sql );
        return $query->result();
    }
    // }}}
   // {{{ public function relative( $label )
   public function relative( $label )
   {
       return $this->relative[ $label ];
   }
   // }}}
    // {{{ public function is_relative()
    public function is_relative()
    {
        return $this->is_relative;
    }
    // }}}
   // --- RECORDS -- //
   // {{{ public function get_last()
   public function get_last( $num = 5 )
   {
	   $this->CI->load->model( 'entries_model', 'records' );
       return $this->CI->records->get_last( $num );
   }
   // }}}
   // {{{ public function get_records()
   /**
    * Get Records
    *
    * Retrieves records from the database based on record type. 
    *
    * @access	public
    * @param   array    | Array of information construct query with.
    */	
    public function get_records()
    {
        // Figure out which model we're going to be working with.
        // ------
        // chifix : I can make this faster by ordering the switch statements by 
        //          the likelyhood that they'll be chosen.
        switch( $this->params['type'] )
        {
            case 'post'             :
            case 'page'             :
            case 'cat'              :
                $this->CI->load->model( 'entries_model',    'records' ); break;

            case 'links'         :
                $this->CI->load->model( 'links_model',   'records' );

            case 'album'            :
            case 'photos'           :
                $this->CI->load->model( 'photos_model',     'records' ); break;

            case 'mailinglist'            :
                $this->CI->load->model( 'mailinglist_model','records' ); break;

            case 'store'            :
                $this->CI->load->model( 'store_model',      'records' ); break;

            case 'downloads'        :
                $this->CI->load->model( 'downloads_model',  'records' ); break;
            case 'music'            :
            case 'music_playlists'  :
            case 'songs' :
                $this->CI->load->model( 'music_model',      'records' ); break;

            case 'video'            :
            case 'video_playlists'  :
            case 'videos'           :
                $this->CI->load->model( 'video_model',      'records' ); break;

            case 'clients'         :
                $this->CI->load->model( 'clients_model',   'records' );

            case 'events'           :
                $this->CI->load->model( 'events_model',     'records' ); break;

            case 'team'             :
                $this->CI->load->model( 'team_model',       'records' ); break;

            case 'features'         :
                $this->CI->load->model( 'features_model',   'records' );

            default                 :
                $this->CI->load->model( 'entries_model',    'records' ); break;
        }

        if( isset( $this->params['id'] ) && $this->params['id'] == 0 )
        {
            // If we set the id to 0 its a signal to only grab the pages.
        }
        // If we're provided the id (and we're not looking for a photo or a song/playlist) we can grab the record by id.
        else if( isset( $this->params['id'] ) && preg_match( '/\b(?!photos|videos|songs|video_playists|music_playlists\b)\w+/i', $this->params['type'] ) ) 
        {
            $this->records = $this->CI->records->get_record( $this->params['id'], true );
        }

        // Special exception for grabbing photos
        else if( isset( $this->params['id'] ) && $this->params['type'] == 'photos' )
        {
            $this->records = $this->CI->records->get_photos( $this->params['id'] ); 
        }
        // Grabbing video
        else if( $this->params['type'] == 'video' || $this->params['type'] == 'video_playlists' )
        {
            $this->records = $this->CI->records->get_playlists( $this->params );
        }
        else if( $this->params['type'] == 'videos' )
        {
            $this->records = $this->CI->records->get_videos( $this->params );
        }
        // Grabbing music
        else if( $this->params['type'] == 'music' || $this->params['type'] == 'music_playlists' )
        {
            $this->records = $this->CI->records->get_playlists( $this->params );
        }
        else if( $this->params['type'] == 'songs' )
        {
            $this->records = $this->CI->records->get_songs( $this->params );
        }

        // If we have the name of the record we'll find it that way.
        // This isn't really the best practice so it'll probably be depreciated,
        // but it solves a problem for the time being.
        else if( isset( $this->params['name'] ) && $this->params['name'] != "" )
        {
            $this->records = $this->CI->records->get_record_by_name( $this->params );
        }

        // Most of the time we'll be grabbing several records.
        else
        {
            $this->records = $this->CI->records->get_records( $this->params );
        }

        // Now we grab the pages if needed, probably for the menu.
        if( isset( $this->params['pages'] ) && $this->params['pages'] == true )
        {
            $this->load_pages();
        }

        $this->number_of_records = ( isset( $this->params['id'] ) && $this->params['id'] == 0 ) ? 0 : count( $this->records );
        if( isset( $this->records ) ) $this->check_for_ref();
    }
   // }}}
   // {{{ public function get_archives()
   public function get_archives( $num = 5 )
   {
	    $this->CI->load->model( 'entries_model', 'entries' );
        $archives = $this->CI->entries->get_archives( $num );
        $ret = '';
        foreach( $archives as $archive )
        {
            $ret .= '<li><a href="' . base_url() . 'entries/archives/' . $archive['year'] . '/' . $archive['month_num'] . '">' . $archive['month'] . ' ' . $archive['year'] . '</a></li>';
        }
        return $ret;
   }
   // }}}
    // {{{ public function get_recent_cats( $slug, $amount = 5 )
    public function get_recent_cats( $slug, $amount = 5 )
    {
	    $this->CI->load->model( 'entries_model', 'entries' );
        $cats = $this->CI->entries->get_records( array( 'how_many' => 6, 'offset' => 0, 'slug' => $slug, 'include_unpublished' => false, 'type' => 'cat' ) );
        $ret = '';
        foreach( $cats as $cat )
        {
            if( $cat->pic != '' )
            {
                $orig = base_url() . 'images/entries/' . $cat->pic;
                list( $w, $h ) = getimagesize( $orig );
                $dim = ( $w > $h ) ? 'height' : 'width';
                $pic = base_url() . 'index.php?admin/resize_img/' . rawurlencode( $orig ) . '/' . $dim . '/105/'; 
            }
            else
            {
                $pic = 'http://placehold.it/103x103/111/222/&text=' . strtoupper( substr( $cat->title, 0, 10 ) );
 
            }
             $ret .= '<li style="background-image:url(' . $pic . ');"><a href="' . base_url() . 'videos/single/' . $cat->id . '"><img src="' . theme_path() . 'images/video_over.png" /></a></li>';
        }
        return $ret;
    }
    // }}}
   // {{{ public function get_links()
   public function get_links( $num = 5 )
   {
	    $this->CI->load->model( 'links_model', 'links' );
        $links = $this->CI->links->get_records( array( 'include_unpublished' => false, 'how_many' => 'all', 'order_by' => '`title` asc' ) );
        $ret = '';
        foreach( $links as $link )
        {
            $ret .= '<li><a href="' . $link->url . '" title="' . $link->description . '">' . $link->title . '</a></li>';
        }
        return $ret;
   }
   // }}}
   // {{{ public function row_value( $column )
   public function row_value( $column )
   {
      return $this->records[ $this->loop_position ]->$column;
   }
   // }}}
   // {{{ public function param_value( $key )
   public function param_value( $key )
   {
      return ( isset ( $this->params[$key] ) ) ? $this->params[$key] : false;
   }
   // }}}
    // {{{ public function entry_category()
    public function entry_category()
    {
        $pre = $this->CI->db->dbprefix;
        $sql = 'SELECT `' . $pre . 'categories`.`id`, `' . $pre . 'categories`.`name` FROM `' . $pre . 'entries`, `' . $pre . 'categories`, `' . $pre . 'categories_relationships` ';
        $sql .= 'WHERE ( `' . $pre . 'entries`.`id` = \'' . $this->row_value( 'id' ) . ' \' ) ';
        $sql .= 'AND ( `' .$pre . 'categories`.`id` = `' . $pre . 'categories_relationships`.`category_id` ) ';
        $sql .= 'AND ( `' .$pre . 'entries`.`id` = `' . $pre . 'categories_relationships`.`record_id` ); ';
        $query = $this->CI->db->query( $sql );
        if( $query->num_rows() > 0 )
        {
            $row = $query->row();
            $data = array( 'name' => $row->name, 'id' => $row->id );
        }
        else
        {
            $data = array( 'name' => 'Regular', 'id' => 0 );
        }
        return $data;
    }
    // }}}
   // --- PAGES --- //
   // {{{ public function load_pages()
   public function load_pages()
   {
       $this->CI->load->model( 'pages_model', 'pages' );
       $pages = $this->CI->pages->get_records( array( 'type' => 'page', 'how_many' => 50, 'offset' => 0, 'include_unpublished' => 0 ) );
       $this->number_of_pages = count( $pages );
       $this->pages = $pages;
   }
   // }}}
   // {{{ public function get_pages()
   public function get_pages()
   {
       return $this->pages;
   }
   // }}}
   // {{{ public function page_looping()
   /**
    * Are We Looping?
    *
    * Checks to see if we are in the middle of the page loop.
    *
    * @access	public
    * @return  boolean  
    */	
   public function page_looping()
   {
      if( ( $this->pages_position + 1 ) < $this->number_of_pages )
      {
         $this->pages_looping = true;
      }
      else
      {
         $this->pages_looping = false;
      }
      return $this->pages_looping;
   }
   // }}}
   // {{{ public function number_of_pages()
   public function number_of_pages()
   {
      return $this->number_of_pages;
   }
   // }}}
   // {{{ public function set_next_available_page()
   public function set_next_available_page()
   {
      $this->pages_position++;
   }
   // }}}
   // {{{ public function page_row_value()
   public function page_row_value( $column )
   {
      return $this->pages[ $this->pages_position ]->$column;
   }
   // }}}
   // --- PIC --- //
   // {{{ public function get_current_pic()
   public function get_current_pic()
   {
        if( isset( $this->records[ $this->loop_position ]->tumblr ) && $this->records[ $this->loop_position ]->tumblr != '' )
        {
            return $this->records[ $this->loop_position ]->pic;
        }
        else
        {
            return base_url() . 'images/' . $this->class . '/' . $this->records[ $this->loop_position ]->pic;
        }
   }
   // }}}
   // {{{ public function has_pic()
   public function has_pic()
   {
      if( preg_match( '/[a-zA-Z0-9_]+\.(gif|jpg|png)$/i', $this->records[ $this->loop_position ]->pic ) )
      {
         return true;
      }
      else 
      {
         return false;
      }
   }
   // }}}
   // --- VIDEO --- //
   // {{{ public function get_current_video()
   public function get_current_video( $w, $h, $c = '' )
   {
	  $this->CI->load->model( 'operations_model', 'operate' );
      $video_type = $this->records[ $this->loop_position ]->video_type;
      $video = $this->records[ $this->loop_position ]->video;
      switch( $video_type )
      {
         case 'vimeo'           : return $this->CI->operate->create_vimeo( $video, $w, $h, $c );  
         case 'youtube'         : return $this->CI->operate->create_youtube( $video, $w, $h, $c );
         case 'worldstarhiphop' : return $this->CI->operate->create_worldstar( $video, $w, $h, $c );
      } 
   }
   // }}}
   // {{{ public function make_video( $type, $video, $w, $h, $c )
   public function make_video( $type, $video, $w, $h, $c )
   {
	  $this->CI->load->model( 'operations_model', 'operate' );
      switch( $type )
      {
         case 'vimeo'           : return $this->CI->operate->create_vimeo( $video, $w, $h, $c );  
         case 'youtube'         : return $this->CI->operate->create_youtube( $video, $w, $h, $c );
         case 'worldstarhiphop' : return $this->CI->operate->create_worldstar( $video, $w, $h, $c );
      } 
   }
   // }}}
   // {{{ public function has_video()
   public function has_video()
   {
      if( $this->records[ $this->loop_position ]->video != "" && $this->records[ $this->loop_position ]->video_type != "" )
      {
         return true;
      }
      else
      {
         return false;
      }
   }
   // }}}
   // --- FEATURES UTILITIES --- //
   // {{{ public function load_features( $features ) 
   public function load_features( $features ) 
   {
       $this->features = $features;
       $this->number_of_features = count( $this->features );
   }
   // }}}
   // {{{ public function number_of_features()
   public function number_of_features()
   {
       return $this->number_of_features;
   }
   // }}}
   // {{{ public function set_next_available_feature()
   public function set_next_available_feature()
   {
       $this->features_position++;
   }
   // }}}
   // {{{ public function features_position()
   public function features_position()
   {
      return $this->features_position;
   }
   // }}}
   // {{{ public function features_looping()
   public function features_looping()
   {
      if( ( $this->features_position + 1 ) < $this->number_of_features )
      {
         $this->features_looping = true;
      }
      else
      {
         $this->features_looping = false;
      }
      return $this->features_looping;
   }
   // }}}
   // {{{ public function feature_value( $column )
   public function feature_value( $column )
   {
       return $this->features[ $this->features_position ]->$column;
   }
   // }}}
   // --- RECORD UTILITIES --- //
   // {{{ public function set_next_available_record()
   public function set_next_available_record()
   {
      $this->loop_position++;
   }
   // }}}
   // {{{ public function reset_available_records()
   public function reset_available_records()
   {
      $this->loop_position = -1;
   }
   // }}}
   // {{{ public function number_of_records()
   public function number_of_records()
   {
      return $this->number_of_records;
   }
   // }}}
   // {{{ public function loop_position()
   public function loop_position()
   {
      return $this->loop_position;
   }
   // }}}
}
