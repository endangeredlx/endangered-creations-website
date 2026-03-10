<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Team Controller
**/
class Team extends CI_Controller
{
    // {{{ VARIABLES
    var $class          = 'team';
    var $singular       = 'artist';
    var $plural         = 'artists';
    var $table          = 'team';
    var $primary_table  = 'team';
    // }}}
    // {{{ public function Team()
    public function Team()
    {
        parent::__construct();
    }
    // }}}
    // --- BASIC VIEW FUNCTIONS --- ///
    // {{{ public function index()
    public function index()
    {
    }
    // }}}
    // {{{ public function single()
    public function single()
    {
    }
    // }}}
    // --- BASIC ADMIN FUNCTIONS --- //
    // {{{ public function login_check()
    public function login_check()
    {
        $this->load->model('login_model');
        $query = $this->login_model->validate();
        if($query['valid']) // if the user's credentials validated...
        {
            $data = array(
                'mid'            => $query['id'],
                'login'         => $this->input->post('login'),
                'alias'         => $query['alias'],
                'privilege'    => $query['privilege'],
                'is_logged_in' => true
            );
            //$this->session->set_userdata($data);
            redirect('admin/home');
        }
        else // incorrect username or password
        {
        redirect('admin/index');
        }
    }
    // }}}
    // {{{ public function logout()
    public function logout()
    {
        $this->session->sess_destroy();
        $this->index();
    }
    // }}}
    // {{{ public function is_logged_in()
    public function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if(!isset($is_logged_in) || $is_logged_in != true) 
        {
        redirect('admin/index');
        }   
    }
    // }}}
    // --- ADMIN 'VIEW' FUNCTIONS --- // 
    // {{{ public function write( $success = false, $warning = false, $error = false )
    public function write( $success = false, $warning = false, $error = false )
    {
        $this->editor( 'create', $success, $warning, $error );
    }
    // }}}
    // {{{ public function edit( $success = false, $warning = false, $error = false )
    public function edit( $success = false, $warning = false, $error = false )
    { 
        $this->editor( 'edit', $success, $warning, $error );
    }
    // }}}
    // {{{ public function editor( $action, $success = false, $warning = false, $error = false )
    /**
     * Loads view and information for editing specific team
     *
     * @access public
     *
     * @param boolean   $success    set to true if the update was a success.
     * @param boolean   $warning    set to true if there are warnings pertaining to the update.
     * @param boolean   $error      set to true if the update has failed.
     */
    public function editor( $action, $success = false, $warning = false, $error = false )
    {
        $this->is_logged_in();
        // We create entry in the database and edit that.
        $id = ( $action == 'create' ) ? $this->create() : $this->uri->segment( 3 );
        
        // Set up a few parameters
        $offset = 0;
        $params = array( 
            'type'                  => $this->class, 
            'class'                 => $this->class,
            'id'                    => $id,
            'how_many'              => 1, 
            'offset'                => $offset, 
            'tumblr'                => 'false', 
            'include_unpublished'   => true, 
            'pages'                 => true 
        );
        $option_params = array( 'user_id' => 1 );

        // Load necessary libraries and helpers.
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        require( APPPATH . 'libraries/ChiTeam' . EXT );
        $this->load->helper('form');

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $ChiTeam = new ChiTeam( $ChiQL );
        $Options =& $this->ChiOptions;

        // Ensure that any update notifications are true booleans
        $success = ( $success === true || $success === false ) ? $success : false;
        $warning = ( $warning === true || $warning === false ) ? $warning : false;
        $error = ( $error === true || $error === false ) ? $error : false;

        $data = array(
            'records'       => $ChiTeam,
            'options'       => $Options,
            'success'       => $success,
            'warning'       => $warning,
            'error'         => $error,
            'class'         => $this->class,
            'action'        => $action,
            'singular'      => $this->singular,
            'javascript'    => array( 'general/admin.basic', $this->class . '/edit' ),
            'main_content'  => 'admin/' . $this->class . '/edit'
        );

        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $this->load->view( 'admin/clone', $data );

    }
    // }}}
    // {{{ public function manage()
    public function manage()
    {
        $this->is_logged_in();
        // Set up a few parameters
        $offset = ( $this->uri->segment( 2 ) == "" ) ? 0 : $this->uri->segment( 2 );
        $params = array( 
            'type'                  => $this->class, 
            'how_many'              => 5, 
            'offset'                => $offset, 
            'tumblr'                => 'false', 
            'include_unpublished'   => true, 
            'pages'                 => true 
        );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        $this->load->helper('date');

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;

        // Main data array.
        $data = array(
            'records'               => $ChiQL,
            'options'               => $Options, 
            'title'                 => 'Blog',
            'type'                  => $this->class, 
            'class'                 => $this->class,
            'singular'              => $this->singular,
            'plural'                => $this->plural,
            'page_type'             => $this->singular,
            'javascript'            => array( 'general/admin.basic', $this->class . '/manage' ),
            'main_content'          => 'admin/' . $this->class . '/manage'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        // Dont' count items marked for trash.
        ////$this->db->where( 'tr !=', 1);
        $config = array(
            'base_url'           => base_url() . $htfix . $this->class . '/manage',
            'total_rows'         => $this->db->get( $this->table )->num_rows(),
            'per_page'           => $params['how_many'],
            'num_links'          => 8,
            'uri_segment'        => 2,
            'full_tag_open'      => '<div id="pgntn" class="clearfix">',
            'full_tag_close'     => '</div>'
        );
        $this->pagination->initialize( $config );

        // Load view.
        $this->load->view( 'admin/clone', $data ); 
    }
    // }}}
    // {{{ public function add_photo()
    public function add_photo()
    {   
        $this->is_logged_in();
        $id = $this->uri->segment( 3 );
        // Set up a few parameters
        $offset = 0;
        $params = array( 
            'type'                  => 'post', 
            'how_many'              => 1, 
            'offset'                => $offset, 
            'tumblr'                => 'false', 
            'id'                    => $id,
            'include_unpublished'   => true, 
            'pages'                 => true 
        );

        $option_params = array( 'user_id' => 1 );

        // Load necessary libraries and helpers.
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        $this->load->helper('form');

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;

        $ChiQL->set_next_available_record();
        $ChiQL->reset_available_records();

        $data = array(
            // Chi Variables
            'records'           => $ChiQL,
            'options'           => $Options,
            // Upload Page Settings
            'upload_function'   => 'file_upload',       // After uploading, what funciton will handle/save/resize the file?
            'file_type'         => 'image',             // What are we uploading? 'image', 'music', or
            'uploader'          => 'file',              // Which file uploader to use. 'file' or 'multipleFile'?
            'primary_id'        => $id,                 // ID of the page or entry. 
            'secondary_id'      => '',                  // ID of the album or relative entry
            'human_name'        => 'image',             // If this is set to 'Image', the page will read "Add Image"
            // General variables
            'class'             => $this->class,
            'javascript'        => array( 'swfaddress', 'swfobject', 'general/admin.basic', 'general/file_upload' ),
            'main_content'      => 'admin/general/file_upload'
        );
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function add_photos()
    public function add_photos()
    {   
        $this->is_logged_in();
        $this->load->model( 'team_model' );
        $id = $this->uri->segment(3);
        $data['primary_id'] = $id;
        $data['record'] = $this->team_model->get_record( $id );
        $data['secondary_id'] = $data['record'][0]->album;
        $data['class'] = 'team';
        $data['upload_function'] = 'photos_upload';
        $data['human_name'] = 'Image';
        $data['what'] = 'image';
        $data['file_type'] = 'image';
        $data['uploader'] = 'multipleFile';
        $data['main_content'] = "admin/team/file_upload";
        $data['javascript'] = array( 'swfaddress', 'swfobject', 'general/admin.basic', 'team/photo' );
        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function delete_photo()
    public function delete_photo()
    {
        $this->is_logged_in();
        $this->load->model( 'team_model', 'team' );
        $id = $this->uri->segment( 3 );
        $this->team->delete_photo( $id );
        echo "photo removed";
    }
    // }}}
    // --- CRUD FUNCTIONS --- //
    // {{{ public function create()
    private function create()
    {
        $this->load->helper('text');
        $this->load->model('team_model');
        // Prepare the data for the database.
        $insert = array(
            'title'         => 'Untitled ' . ucwords( $this->singular ),
            'subtitle'      => '',
            'views'         => 0, 
            'tr'            => 1
        );

        // Insert the data array.
        $add = $this->team_model->add( $insert );
        $id = $this->db->insert_id();

        // {{{ Prepare an empty photo album.
        $inst = array(
            'title'         => $this->singular . ' photo album ' . $id,
            'description'   => '~~~team|edit|' . $id . '~~~',
            'ref_id'        => $id,
            'date'          => time(),
            'tr'            => 1
        );
        $this->load->model( 'photos_model', 'photos' );
        // Create empty photo album.
        $addalbum = $this->photos->add( $inst );

        // Grab the album id and associate it with the entry.
        $aid = $this->db->insert_id();

        // Since these options are created before the user saves anything they are
        // marked for trash until the first save.
        $addalbumoption = $this->team_model->add_option( $id, 'photo_album', $aid, true );
        // }}} 
        // {{{ Prepare an empty photo album.
        $inst = array(
            'title'         => $this->singular . ' photo album ' . $id,
            'description'   => '~~~team|edit|' . $id . '~~~',
            'ref_id'        => $id,
            'date'          => time(),
            'tr'            => 1
        );
        $this->load->model( 'photos_model', 'photos' );
        // Create empty photo album.
        $addalbum = $this->photos->add( $inst );

        // Grab the album id and associate it with the entry.
        $aid = $this->db->insert_id();

        // Since these options are created before the user saves anything they are
        // marked for trash until the first save.
        $addalbumoption = $this->team_model->add_option( $id, 'photo_album', $aid, true );
        // }}}
        // {{{ Prepare an empty slide show.
        $inst = array(
            'title'         => $this->singular . ' slideshow ' . $id,
            'description'   => '~~~team|edit|' . $id . '~~~',
            'ref_id'        => $id,
            'date'          => time(),
            'tr'            => 1
        );
        $this->load->model( 'photos_model', 'photos' );
        // Create empty photo album.
        $addalbum = $this->photos->add( $inst );

        // Grab the album id and associate it with the entry.
        $sid = $this->db->insert_id();

        // Since these options are created before the user saves anything they are
        // marked for trash until the first save.
        $addalbumoption = $this->team_model->add_option( $id, 'slideshow', $sid, true );
        // }}} 
        // {{{ Prepare a new playlist.
        $playlist = array(
            'title'             => $this->singular . ' playlist ' . $id,
            'number_of_songs'   => 0,
            'description'       => '~~~team|edit|' . $id . '~~~',
            'status'            => 'unpublished',
            'tr'                => 1,
            // Chifix* This will have to be changed to accomadate different users.
            'owner_id'          => 1
        );
        $this->load->model( 'music_model', 'music' );
        $playlist = $this->music->add_playlist( $playlist );
        $pid = $this->db->insert_id();

        // Since these options are created before the user saves anything they are
        // marked for trash until the first save.
        $addplaylistoption = $this->team_model->add_option( $id, 'music_playlist', $pid, true );
        // }}}

        return $id;
    }
    // }}}
    // {{{ public function update()
    public function update()
    {   
        $this->is_logged_in();
        $this->load->helper('text');
        $this->load->model( 'team_model', 'team' );
        $this->load->model( 'operations_model', 'operate' );
        $this->load->library('form_validation');
        //Set validation rules...
        $this->form_validation->set_rules('title', 'Title', 'trim|required');            
        $this->form_validation->set_error_delimiters('<div class="notice error">', '</div>');

        if ( $this->form_validation->run() == TRUE ) 
        {
            // {{{ INSERT INTO DATABASE
            $id = $this->uri->segment(3);
            $title = $this->input->post('title');
            $name = url_title( $title, 'dash', true );
            $format_check = $this->input->post('format_check');
            $content = ($format_check == 'clear') ? strip_tags( $this->input->post('content'), '<br><p><strong><u>' ) : $this->input->post('content');
            $excerpt = word_limiter( $content, 50);
            $excerpt = strip_tags( $excerpt );
            // Try to extract the video code and put it in the database.
            $video_code = $this->operate->get_vid_code( $this->input->post('video'), $this->input->post('video_type') );
            // If we don't get a unique id for the video, then we don't store video type.
            //$video_type = $video_code == "" ? "" : $this->input->post('video_type');
            $update = array(
                'title'         => $this->input->post('title'),
                'subtitle'      => $this->input->post('subtitle'),
                'facebook'      => $this->input->post('facebook'),
                'twitter'       => $this->input->post('twitter'),
                'myspace'       => $this->input->post('myspace'),
                'name'          => $name,
                'content'       => $content,
                'excerpt'       => $excerpt,
                'status'        => $this->input->post('status'),
                //'video_type'    => $video_type,
                //'video'         => $video_code,
                'tr'            => 0
            );
            $change = $this->team->update( $id, $update );
            // }}}

            // {{{ Make sure options aren't marked for trash
            $this->load->model( 'photos_model', 'photos' );
            $this->load->model( 'music_model', 'music' );
            $options = $this->get_all_options( $id, 'team_options' ); 
            foreach( $options as $option )
            {
                $not_trash = array( 'tr' => 0 );
                $this->team->update_option( $option->id, $not_trash );
                $this->db->where( 'id', $option->type_id );
                switch( $option->type )
                {
                    case 'photo_album'      :
                    case 'slideshow'        :
                        $this->db->update( 'photo_albums', $not_trash );
                        break;
                    case 'music_playlist'   :
                        $this->db->update( 'music_playlists', $not_trash );
                        break;
                }
            }
            // }}}

            // {{{ Update XML
            $this->load->library( 'xml/RoyaltyXML', $this, 'royalx' );
            $this->royalx->config( array( 'con' => $this ) );
            $xml_update = $this->team->get_records();
            $this->royalx->update_team( $id, $xml_update );
            // }}}
            
            $success = $change;
            $this->edit( $success );
        } 
        else 
        {   
            $success = false;
            $this->edit( $success, false, true );
        }
    }
    // }}}
    // {{{ public function remove()
    public function remove()
    {
        $this->is_logged_in();
        $id = $this->uri->segment( 3 );
        $this->load->model( 'team_model' );
        $this->team_model->delete( $id );
        redirect( 'team/manage' );
    }
    // }}}
    // {{{ public function file_upload()
    public function file_upload()
    {
        $this->load->model( 'image_model', 'image' );
        $this->load->model( 'image_config' );
        $id = $this->uri->segment( 3 );
        if( count( $_FILES ) > 0 ) 
        {   
            $config = $this->image_config->team_bg_config( $id );
            $config['table']     = $this->db->dbprefix( $this->table );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $this->image->configure_class( $config );

            if( $this->image->put_image() )
            {   
                $this->image->clear_config();
                echo "great.";   
            } 
            else 
            {   
                echo "error";
            }
        }
    }
    // }}}
    // {{{ public function photos_upload()
    public function photos_upload()
    {
        $this->load->model( 'image_model', 'image' );
        $this->load->model( 'photos_model', 'photos' );
        $this->load->model( 'team_model', 'team' );
        $this->load->model( 'image_config' );

        // Get album id.
        $ent = $this->uri->segment( 3 );
        $id = $this->uri->segment( 4 );

        if( count( $_FILES ) > 0 ) 
        {   
            $pid = $this->photos->create_pic_row( $id );
            $config = $this->image_config->team_extra_config( $pid );
            $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
            $config['temp_name'] = $_FILES['Filedata']['name'];
            $this->image->configure_class( $config );

            if( $this->image->put_image() )
            {   
                $this->image->clear_config();
                $config = $this->image_config->small_photos_config( $pid );
                $config['temp_file'] = $_FILES['Filedata']['tmp_name'];
                $config['temp_name'] = $_FILES['Filedata']['name'];
                $this->image->configure_class( $config );

                if( $this->image->put_image() )
                {
                    $this->photos->set_order( $id, $pid );
                    $this->photos->update_album_size( $id );
                    echo "uploaded.";   
                }
            } 
            else 
            {   
                echo "error.";
            }
        }
    }
    // }}}
    // {{{ public function get_options( $id, $relationship_table, $option_table, $type )
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
    // {{{ public function get_all_options( $id, $option_table )
    public function get_all_options( $id, $relationship_table )
    {
        // Add the prefix if we have one
        $relationship_table = $this->db->dbprefix( $relationship_table );
        $sql  = 'SELECT *';
        $sql .= ' FROM `' . $relationship_table . '`';
        $sql .= ' WHERE ( `' . $relationship_table . '`.`record_id` = \'' . $id . '\')'; 
        $sql .= ' ORDER BY `' . $relationship_table . '`.`id` ASC;';
        $query = $this->db->query( $sql );
        return $query->result();
    }
    // }}}
    
}
