<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Entries_model extends CI_Model 
{
    // {{{ VARIABLES
    var $class      = 'entries';
    var $singular   = 'entry';
    var $plural     = 'entries';
    var $table      = 'entries';
    // }}}
    // {{{ public function get_records( $args ) 
    public function get_records( $args = array( 'include_unpublished' => false, 'type' => 'all', 'offset' => 0 ) ) 
    {
        $this->db->flush_cache();
        $this->load->model( 'options_model', 'options' );
        if( !isset( $args['archives'] ) || $args['archives'] == false )
        {
            if( isset( $args['get_all_entries'] ) )
            // {{{ GRAB EVERY ENTRY THAT'S NOT A PAGE
            {
                $this->db->select('*');
                $this->db->from( 'entries' );
                $this->db->where( 'type', 'post' );
                if( !$args['include_unpublished'] ) 
                {
                    $this->db->where( 'entries.status', 'published' );
                }
                if( isset( $args['order_by'] ) )
                {
                    $this->db->order_by( $args['order_by'] );
                }
                $this->db->order_by( 'entries.date', 'desc' ); 

                if( $args['type'] == 'all' )
                {
                    $query = $this->db->get();
                }
                else
                {
                    $this->db->limit( $args['how_many'], $args['offset'] );
                    $query = $this->db->get();
                }
            }
            // }}}
            // If we're getting pages from a specific category we construct the Query that does so.
            else if( isset( $args['type'] ) && $args['type'] == 'cat' && !( $args['how_many'] == 1 && isset( $args['id'] ) ) )
            // {{{ GRAB SPECIFIC CATEGORY 
            {
                $this->db->select( 'entries.id, entries.video, entries.video_type, entries.title, entries.pic, entries.author, entries.date, entries.excerpt, entries.status, entries.name, entries.album, entries.category, entries.type, entries.comment_count, entries.views, entries.small_url, entries.like, entries.dislike' );
                $this->db->from(   'entries' );
                $this->db->from(   'categories' );
                $this->db->from(   'categories_relationships' );
                $this->db->where(  'entries.id = `'. $this->db->dbprefix( 'categories_relationships' ) .'`.`record_id`' );
                $this->db->where(  'categories_relationships.category_id = `'. $this->db->dbprefix( 'categories' ) .'`.`id`' );
                $this->db->where(  'categories.slug', $args['slug'] );

                $this->db->where( 'entries.type', 'post' );

                if( !$args['include_unpublished'] ) 
                {
                    $this->db->where( 'entries.status', 'published' );
                }

                if( isset( $args['order_by'] ) )
                {
                    $this->db->order_by( $args['order_by'] );
                }

                $this->db->order_by( 'entries.date', 'desc' ); 

                if( $args['how_many'] == 'all' )
                {
                    $query = $this->db->get();
                }
                else
                {
                    $this->db->limit( $args['how_many'], $args['offset'] );
                    $query = $this->db->get();
                }
            }
            // }}}
            // If we're getting regular pages we need to make sure that we're not getting any pages that are associated with category pages.
            else if( !( $args['how_many'] == 1 && isset( $args['id'] ) ) ) 
            // {{{ GRAB ONLY REGULAR ENTRIES
            {
                // A couple substitutions if needed.
                $offset = ( isset( $args['offset'] ) ) ? $args['offset'] : 0;
                $how_many = ( isset( $args['how_many'] ) ) ? $args['how_many'] : 0;
                $pre = $this->db->dbprefix;

                // Select everything and make sure you don't select a entry associated with a category_page
                $sql  = 'SELECT ' . $pre . 'entries.id, ' . $pre . 'entries.title, ' . $pre . 'entries.pic, ' . $pre . 'entries.author, ' . $pre . 'entries.date, ' . $pre . 'entries.excerpt, ' . $pre . 'entries.status, ' . $pre . 'entries.name, ' . $pre . 'entries.album, ' . $pre . 'entries.category, ' . $pre . 'entries.type, ' . $pre . 'entries.comment_count, ' . $pre . 'entries.views, ' . $pre . 'entries.small_url, ' . $pre . 'entries.like, ' . $pre . 'entries.dislike, ' . $pre . 'entries.video, ' . $pre . 'entries.video_type ';
                $sql .= 'FROM ' . $pre . 'entries ';
                $sql .= 'WHERE ' . $pre . 'entries.id NOT IN ( ';
                    $sql .= 'SELECT ' . $pre . 'entries.id ';
                    $sql .= 'FROM ' . $pre . 'entries, ' . $pre . 'categories, ' . $pre . 'categories_relationships ';
                    $sql .= 'WHERE ( ' . $pre . 'categories.id = ' . $pre . 'categories_relationships.category_id ) ';
                    $sql .= 'AND ( ' . $pre . 'entries.id = ' . $pre . 'categories_relationships.record_id ) ';
                    $sql .= 'AND ' . $pre . 'categories.id IN ( ';
                        $sql .= 'SELECT ' . $pre . 'options.value as id FROM ' . $pre . 'options WHERE ( `' . $pre . 'options`.`name` = \'category_page\' ) ';
                    $sql .= ' ) ';
                $sql .= ' ) ';
                $sql .= ( !$args['include_unpublished'] ) ? ' AND ( ' . $pre . 'entries.status = \'published\' ) ' : '';
                $sql .= ( $args['type'] != 'all' ) ? ' AND ( ' . $pre . 'entries.type = \'' . $args['type'] . '\' ) ' : '';
                $sql .= ( isset( $args['query'] ) ) ? ' AND ( ( ' . $pre . 'entries.title LIKE \'%' . $args['query'] . '%\' ) OR ( ' . $pre . 'entries.content LIKE \'%'. $args['query'] . '%\' ) ) ' : '';
                $sql .= 'ORDER BY ';
                $sql .= ( isset( $args['order_by'] ) ) ? $args['order_by'] . ', ' : '';
                $sql .= $pre . 'entries.date DESC ';
                $sql .= ( $args['type'] != 'all' ) ? 'LIMIT ' . $offset . ', ' . $how_many : '' ;
                $sql .= ';';
                $query = $this->db->query( $sql );
            }
            // }}}
            // If we're getting a specfic record we don't care whether or not its a category page
            // We don't care about much really. We just return the page.
            else if( $args['how_many'] == 1 && isset( $args['id'] ) )  
            {
                return $this->get_record( $args['id'] ); 
            }
            //echo $this->db->last_query();
            return $query->result();
        }
        else if( isset( $args['archives'] ) && $args['archives'] == true )
        {
            return $this->get_archive_records( $args['month_num'], $args['year'], $args['how_many'], $args['offset'] );
        }
    }
    // }}}
    // {{{ public function get_records_num( $args ) 
    public function get_records_num( $args = array( 'include_unpublished' => false, 'type' => 'all', 'offset' => 0 ) ) 
    {
        $this->db->flush_cache();
        $this->load->model( 'options_model', 'options' );

        if( isset( $args['get_all_entries'] ) )
        // {{{ GRAB EVERY ENTRY THAT'S NOT A PAGE
        {
            $this->db->select('*');
            $this->db->from( 'entries' );
            $this->db->where( 'type', 'post' );
            if( !$args['include_unpublished'] ) 
            {
                $this->db->where( 'entries.status', 'published' );
            }
            if( isset( $args['order_by'] ) )
            {
                $this->db->order_by( $args['order_by'] );
            }
            $this->db->order_by( 'entries.date', 'desc' ); 

            $query = $this->db->get();
        }
        // }}}
        // If we're getting pages from a specific category we construct the Query that does so.
        else if( isset( $args['type'] ) && $args['type'] == 'cat' && !( $args['how_many'] == 1 && isset( $args['id'] ) ) )
        // {{{ GRAB SPECIFIC CATEGORY 
        {
            $this->db->select( 'entries.id, entries.title, entries.pic, entries.author, entries.date, entries.excerpt, entries.status, entries.name, entries.album, entries.category, entries.type, entries.comment_count, entries.views, entries.small_url, entries.like, entries.dislike' );
            $this->db->from(   'entries' );
            $this->db->from(   'categories' );
            $this->db->from(   'categories_relationships' );
            $this->db->where(  'entries.id = `'. $this->db->dbprefix( 'categories_relationships' ) .'`.`record_id`' );
            $this->db->where(  'categories_relationships.category_id = `'. $this->db->dbprefix( 'categories' ) .'`.`id`' );
            $this->db->where(  'categories.slug', $args['slug'] );

            $this->db->where( 'entries.type', 'post' );

            if( !$args['include_unpublished'] ) 
            {
                $this->db->where( 'entries.status', 'published' );
            }

            if( isset( $args['order_by'] ) )
            {
                $this->db->order_by( $args['order_by'] );
            }

            $this->db->order_by( 'entries.date', 'desc' ); 

            $query = $this->db->get();
        }
        // }}}
        // If we're getting regular pages we need to make sure that we're not getting any pages that are associated with category pages.
        else if( !( $args['how_many'] == 1 && isset( $args['id'] ) ) ) 
        // {{{ GRAB ONLY REGULAR ENTRIES
        {
            // A couple substitutions if needed.
            $offset = ( isset( $args['offset'] ) ) ? $args['offset'] : 0;
            $how_many = ( isset( $args['how_many'] ) ) ? $args['how_many'] : 0;
            $pre = $this->db->dbprefix;

            // Select everything and make sure you don't select a entry associated with a category_page
            $sql  = 'SELECT ' . $pre . 'entries.id, ' . $pre . 'entries.title, ' . $pre . 'entries.pic, ' . $pre . 'entries.author, ' . $pre . 'entries.date, ' . $pre . 'entries.excerpt, ' . $pre . 'entries.status, ' . $pre . 'entries.name, ' . $pre . 'entries.album, ' . $pre . 'entries.category, ' . $pre . 'entries.type, ' . $pre . 'entries.comment_count, ' . $pre . 'entries.views, ' . $pre . 'entries.small_url, ' . $pre . 'entries.like, ' . $pre . 'entries.dislike ';
            $sql .= 'FROM ' . $pre . 'entries ';
            $sql .= 'WHERE ' . $pre . 'entries.id NOT IN ( ';
                $sql .= 'SELECT ' . $pre . 'entries.id ';
                $sql .= 'FROM ' . $pre . 'entries, ' . $pre . 'categories, ' . $pre . 'categories_relationships ';
                $sql .= 'WHERE ( ' . $pre . 'categories.id = ' . $pre . 'categories_relationships.category_id ) ';
                $sql .= 'AND ( ' . $pre . 'entries.id = ' . $pre . 'categories_relationships.record_id ) ';
                $sql .= 'AND ' . $pre . 'categories.id IN ( ';
                    $sql .= 'SELECT ' . $pre . 'options.value as id FROM ' . $pre . 'options WHERE ( `' . $pre . 'options`.`name` = \'category_page\' ) ';
                $sql .= ' ) ';
            $sql .= ' ) ';
            $sql .= ( !$args['include_unpublished'] ) ? ' AND ( ' . $pre . 'entries.status = \'published\' ) ' : '';
            $sql .= ( $args['type'] != 'all' ) ? ' AND ( ' . $pre . 'entries.type = \'' . $args['type'] . '\' ) ' : '';
            $sql .= ( isset( $args['query'] ) ) ? ' AND ( ( ' . $pre . 'entries.title LIKE \'%' . $args['query'] . '%\' ) OR ( ' . $pre . 'entries.content LIKE \'%'. $args['query'] . '%\' ) ) ' : '';
            $sql .= 'ORDER BY ';
            $sql .= ( isset( $args['order_by'] ) ) ? $args['order_by'] . ', ' : '';
            $sql .= $pre . 'entries.date DESC ';
            $sql .= ';';
            $query = $this->db->query( $sql );
        }
        // }}}
        // If we're getting a specfic record we don't care whether or not its a category page
        // We don't care about much really. We just return the page.
        else if( $args['how_many'] == 1 && isset( $args['id'] ) )  
        {
            return $this->get_record( $args['id'] ); 
        }
        //echo $this->db->last_query();
        return $query->num_rows();
    }
    // }}}
    // {{{ public function get_record_by_name( $args )
    public function get_record_by_name( $args )
    {
        $this->db->flush_cache();
        if( $args['type'] != "all" )
        {
            $this->db->where( 'type', $args['type'] );
        }
        else
        {
            $this->db->where( 'type', 'post' );
        }

        $this->db->where( 'name', $args['name'] );

        $query = $this->db->get( 'entries' );
        return $query->result();
    }
    // }}}
    // {{{ public function get_archive_records( $month, $year, $how_many, $offset ) 
    public function get_archive_records( $month, $year, $how_many, $offset ) 
    {
        $this->db->order_by( 'date', 'desc' ); 
        $this->db->where( "MONTH( FROM_UNIXTIME( `date` ) ) = '$month' AND YEAR( FROM_UNIXTIME( `date` ) ) = '$year' AND `status` = 'published' AND `type` = 'post'" );
        $this->db->limit( $how_many, $offset ); 
        $this->db->select( '*' );
        $query = $this->db->get( 'entries' );
        return $query->result();
    }
    // }}}
    // {{{ public function get_archives_num( $month, $year ) 
    public function get_archives_num( $month, $year ) 
    {
        $this->db->order_by( 'date', 'desc' ); 
        $this->db->where( "MONTH( FROM_UNIXTIME( `date` ) ) = '$month' AND YEAR( FROM_UNIXTIME( `date` ) ) = '$year' AND `status` = 'published' AND `type` = 'post'" );
        $this->db->select( '`id`' );
        $query = $this->db->get( 'entries' );
        return $query->num_rows();
    }
    // }}}
    // {{{ public function get_pop_records ( $type = "all", $how_many, $offset = 0, $unpub = false ) 
    public function get_pop_records ( $type = "all", $how_many, $offset = 0, $unpub = false ) 
    {
        if ( $type != "all" ) 
        {
            $this->db->where( 'type', $type );
        }

        if( !$unpub ) 
        {
            $this->db->where( 'status', 'published' );
        }

        $aweekago = time() - 604800;
        $this->db->where('date >',$aweekago);
        $this->db->order_by("views", "desc"); 
        $query = $this->db->get('entries',$how_many,$offset);
        return $query->result();
    }
    // }}}
    // {{{ public function get_last( $number ) 
    public function get_last( $number ) 
    {
        $this->db->select( 'id, title, excerpt, date, status' );
        $this->db->where( 'status', 'published' );
        $this->db->where( 'type', 'post' );
        $this->db->order_by( 'date', 'desc' );
        $result = $this->db->get( 'entries', 5 );
        return $result->result();
    }
    // }}}
    // {{{ public function get_archives( $amount = 5 )
    public function get_archives( $amount = 5 )
    {
        if( $amount === "all" )
        {
        } 
        else if( is_numeric( $amount ) )
        {
            $data = array();
            $today = time();
            $this_month = date( 'n', $today );
            $this_date  = date( 'j', $today );
            $this_year  = date( 'Y', $today );
            for( $i = 0; $i < $amount; $i++ )
            {
                // We set the date for the query to the first of the current month. 
                // If we didn't explicit change it to the first (or a date below the 28th), February would give us some problems.
                $curr_month_unix = mktime( 0, 0, 0, ( $this_month - $i ), 1 );
                // We then convert that to the number of the current month (for instance, March would be 3)
                $curr_month_num = date( 'n', $curr_month_unix );
                $query = $this->db->query( "SELECT `id` FROM `" . $this->db->dbprefix('entries') . "` WHERE ( MONTH( FROM_UNIXTIME( `date` ) ) = '$curr_month_num' ) AND ( `type` = 'post' ) AND ( `status` = 'published' );");
                if( $query->num_rows() > 0 )
                {
                    $data[] = array();
                    $data[ ( count( $data ) - 1 ) ]['month'] = date( 'F', $curr_month_unix );
                    $data[ ( count( $data ) - 1 ) ]['month_num'] = date( 'n', $curr_month_unix );
                    $data[ ( count( $data ) - 1 ) ]['year'] = date( 'Y', $curr_month_unix );
                }
            }
        }
        return $data;
    }
    // }}}
    // {{{ public function get_record( $id, $noviews = false )
    public function get_record( $id, $noviews = false )
    {
        $this->db->where( 'id', $id );
        $query = $this->db->get('entries');
        if( !$noviews )
        {
            $this->update_views($id);
        }
        return $query->result();
    }
    // }}}
    // {{{ public function add_good_karma( $id )
    public function add_good_karma( $id )
    {
        $this->db->query( 'UPDATE `' . $this->db->dbprefix( 'entries' ) . '` SET `like` = `like` + 1 WHERE `id` = ' . $id . ';' );
        return true;
    }
    // }}}
    // {{{ public function add_bad_karma( $id )
    public function add_bad_karma( $id )
    {
        $this->db->query( 'UPDATE `' . $this->db->dbprefix( 'entries' ) . '` SET `dislike` = `dislike` + 1 WHERE `id` = ' . $id . ';' );
        return true;
    }
    // }}}
    // {{{ public function update_views( $id )
    public function update_views( $id )
    {
        $query =	$this->db->query( "Update `" . $this->db->dbprefix( $this->table ) . "` set views=views+1 where `id` = " . $id );
    }
    // }}}
    // {{{ public function update_comment_count ( $id )
    public function update_comment_count ( $id )
    {
        $this->db->query( "Update `" . $this->db->dbprefix('entries') . "` set comment_count=comment_count+1 where `id` = " . $id );
    }
    // }}}
    // {{{ public function get_comments( $id ) 
    public function get_comments( $id ) 
    {
        $this->db->where('entry_type','entry');
        $this->db->where('entry_id',$id);
        $query = $this->db->get('comments');
        return $query->result();
    }
    // }}}
    // {{{ public function add( $data ) 
    public function add( $data ) 
    {
        $this->db->insert( 'entries', $data );
        return true;
    }
    // }}}
    // {{{ public function update( $id, $data ) 
    public function update( $id, $data ) 
    {
        $this->db->where("id", $id);
        $this->db->update('entries', $data);
        return true;
    }
    // }}}
    // {{{ public function update_categories( $id, $data ) 
    public function update_categories( $id, $categories ) 
    {
        // Add categories that are needed.
        foreach( $categories as $cat )
        {
            if( is_numeric( $cat ) && $cat != 0 )
            {
                $this->db->where( 'record_id', $id );
                $this->db->where( 'category_id', $cat );
                $find = $this->db->get( 'categories_relationships' );
                if( $find->num_rows() > 0 )
                {
                    // Do nothing.
                }
                else
                {
                    $make_cat = array( 'record_id' => $id, 'category_id' => $cat, 'type' => 'entries' );
                    $this->db->insert( 'categories_relationships', $make_cat );
                }
            }
        }

        // Remove categories that are not needed.
        $this->db->select( 'category_id, id' );
        $this->db->where( 'record_id', $id );
        $curr = $this->db->get( 'categories_relationships' );
        foreach( $curr->result() as $assoc )
        {
            if( !in_array( $assoc->category_id, $categories ) )
            {
                $this->db->where( 'id', $assoc->id );
                $this->db->delete( 'categories_relationships' );
            }
        }
        return true;
    }
    // }}}
    // {{{ public function delete( $id ) 
    public function delete( $id ) 
    {
        $this->db->where( 'id', $id );
        $this->db->delete( 'entries' );
    }
    // }}}
    // {{{ public function delete_photo( $id ) 
    public function delete_photo( $id ) 
    {
        $update = array( 'pic' => '' );
        $this->db->where( 'id', $id );
        $this->db->update( 'entries', $update );
        return true;
    }
    // }}}
    // {{{ public function get_latest_tumblr( $user )
    public function get_latest_tumblr( $user )
    {
        // Get tumblr info and place into an array.
        $tumblr_link = "http://" . $user . ".tumblr.com/api/read/?filter=text";
        //$tumblr_link = "http://" . $user . ".tumblr.com/api/read/";
        $xml = @file_get_contents( $tumblr_link );
        $p = xml_parser_create();
        xml_parse_into_struct( $p, $xml, $vals, $index );
        xml_parser_free( $p );

        // Create our own more usable arrays.
        $data = array();
        $data['post'] = array();
        $data['photo'] = array();
        $data['video'] = array();
        $data['quote'] = array();
        $data['audio'] = array();
        $data['regular'] = array();

        $post_index = -1;
        foreach( $vals as $node )
        {
            // Gather main information about the post.
            if( $node['tag'] == 'POST' && $node['level'] == 3 && $node['type'] == 'open' )
            {
                $data['post'][] = $node;
                $post_index = count( $data['post'] ) - 1;
            }

            ///////////// "REGULAR" POST

            // If this is a "regular" post, get the title.
            if( $node['tag'] == 'REGULAR-TITLE' )
            {
                $data['regular'][$post_index]['regular_title'] = $node['value'] != '' ? $node['value'] : 'none'; 
            }

            // If this is a "regular" post, get the body.
            if( $node['tag'] == 'REGULAR-BODY' )
            {
                $data['regular'][$post_index]['regular_body'] = $node['value'] != '' ? $node['value'] : 'none'; 
            }

            ///////////// "ANSWER" POST

            // If this is an "answer" post, get the question.
            if( $node['tag'] == 'QUESTION' )
            {
                $data['answer'][$post_index]['question'] = $node['value'] != '' ? $node['value'] : 'none';
            }

            // If this is an "answer" post, get the answer.
            if( $node['tag'] == 'ANSWER' )
            {
                $data['answer'][$post_index]['answer'] = $node['value'] != '' ? $node['value'] : 'none';
            }

            ///////////// PHOTO POST

            // If there is a photo, get photo caption. 
            if( $node['tag'] == 'PHOTO-CAPTION' )
            {
                $data['photo'][$post_index]['photo_caption'] = $node['value'] != '' ? $node['value'] : 'none' ;
            } 

            // If this is a photo post, get the different dimensions of the photo. 
            if( $node['tag'] == 'PHOTO-URL' && $node['level'] == 4 )
            {
                if( $node['attributes']['MAX-WIDTH'] != '' )
                {
                    $dim = $node['attributes']['MAX-WIDTH'];
                    $data['photo'][$post_index]['photo_url_' . $dim ] = $node['value'] != '' ? $node['value'] : 'none' ;
                }
            } 

            ///////////// VIDEO POST

            // If this is a video post, get video caption. 
            if( $node['tag'] == 'VIDEO-CAPTION' && $node['level'] == 4 )
            {
                $data['video'][$post_index]['video_caption'] = $node['value'] != '' ? $node['value'] : 'none' ;
            } 

            // If this is a video post, get the video source. 
            if( $node['tag'] == 'VIDEO-SOURCE' && $node['level'] == 4 )
            {
                $data['video'][$post_index]['video_source'] = $node['value'] != '' ? $node['value'] : 'none' ;
            } 

            // If this is a video post, get the video player. 
            if( $node['tag'] == 'VIDEO-PLAYER' && $node['level'] == 4 )
            {
                $data['video'][$post_index]['video_player'] = $node['value'] != '' ? $node['value'] : 'none' ;
                $data['video'][$post_index]['video_player'] = str_replace( 'width="400"', 'width="620"', $data['video'][$post_index]['video_player']);
                $data['video'][$post_index]['video_player'] = str_replace( 'height="225"', 'height="360"', $data['video'][$post_index]['video_player']);
            } 

            ///////////// QUOTE POST

            // If this is a quote post, get quote text. 
            if( $node['tag'] == 'QUOTE-TEXT' && $node['level'] == 4 )
            {
                $data['quote'][$post_index]['quote_text'] = $node['value'] != '' ? $node['value'] : 'none' ;
            } 

            // If this is a quote post, get quote source. 
            if( $node['tag'] == 'QUOTE-SOURCE' && $node['level'] == 4 )
            {
                $data['quote'][$post_index]['quote_source'] = $node['value'] != '' ? $node['value'] : 'none' ;
            } 

            ///////////// LINK POST

            // If this is a link post, get the link text.
            if( $node['tag'] == 'LINK-TEXT' )
            {
                $data['link'][$post_index]['link_text'] = $node['value'] != '' ? $node['value'] : 'none' ;
            }

            // If this is a link post, get the link url.
            if( $node['tag'] == 'LINK-URL' )
            { 
                $data['link'][$post_index]['link_url'] = $node['value'] != '' ? $node['value'] : 'none';
            }

            ///////////// AUDIO POST

            // If this is an audio post, get the audio caption.
            if( $node['tag'] == 'AUDIO-CAPTION' )
            {
                $data['audio'][$post_index]['audio_caption'] = $node['value'] != '' ? $node['value'] : 'none';
            }

            // If this is an audio post, get the audio player.
            if( $node['tag'] == 'AUDIO-PLAYER' )
            {
                $data['audio'][$post_index]['audio_player'] = $node['value'] != '' ? $node['value'] : 'none';
            }
        }
        return $data;
    }
    // }}}
    // {{{ private function tumblr_dupe( $id )
    private function tumblr_dupe( $id )
    {
        $this->db->where( 'tumblr', $id );
        $query = $this->db->get( 'entries' );
        $num = $query->num_rows();
        $dupe = $num > 0 ? true : false; 
        return $dupe;
    }
    // }}}
   // {{{ public function update_with_tumblr( $data ) 
    public function update_with_tumblr( $data ) 
    {
        $added = 0;
        foreach( $data['post'] as $key=>$post )
        {
            $dupe = $this->tumblr_dupe( $post['attributes']['ID'] );
            if( !$dupe )
            {
                $insert = array(
                    'tumblr'        => $post['attributes']['ID'],
                    'date'          => $post['attributes']['UNIX-TIMESTAMP'],
                    'name'          => $post['attributes']['SLUG'],
                    'small_url'     => $post['attributes']['URL'],
                    'status'        => 'published'
                );

                switch( $post['attributes']['TYPE'] )
                {
                    case 'photo' :
                        $insert['pic'] = $data['photo'][$key]['photo_url_500'];
                        $insert['title'] = $data['photo'][$key]['photo_caption']; 
                        break;
                    case 'video' :
                        $insert['title'] = $data['video'][$key]['video_caption'];
                        $insert['content'] = '<center>' . $data['video'][$key]['video_player'] . '</center>';
                        break;
                    case 'quote' :
                        $insert['title'] = '<span>Tumblr</span>Quote';
                        $insert['content'] = '<blockquote>' . $data['quote'][$key]['quote_text'] . '</blockquote><span class="quote_source">' . $data['quote'][$key]['quote_source'] . '</span>';
                        break;
                    case 'link' :
                        $insert['title'] = '<span>Tumblr</span>Link';
                        $insert['content'] = '<a href="' . $data['link'][$key]['link_url'] . '" class="tumblr_link">' . $data['link'][$key]['link_text'] . '</a>';
                        break;
                    case 'audio' :
                        $insert['title'] = $data['audio'][$key]['audio_caption'];
                        $insert['content'] = '<center>' . $data['audio'][$key]['audio_player'] . '</center>';
                        break;
                    default :
                        break;
                }
                $this->add( $insert );
                $added++;
            }
            //echo $added . ' new tumblr entries added.';
        }
    }
   // }}}
}
?>
