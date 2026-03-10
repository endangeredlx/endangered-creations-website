<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* RoyaltyXML
*
* The Content Handling Interface XML Editing Decorator Class (Decorator)
*
* Package Chi - Content Handling Interface
**/
require( APPPATH . 'libraries/ChiXML' . EXT );
class RoyaltyXML 
{
    // {{{ VARIABLES
    private $chix;
    private $con;
    private $CI;
    private $x;
    private $main;
    private $music_playlist;
    private $photo_album;
    private $slideshow;
    private $bu = "http://royaltyrecordsinc.com/";
    private $xml = array(
        'home-page'         => 'application/views/themes/default/library/swf/site_configuration/pages/layout1.xml',
        'royalty-records'   => 'application/views/themes/default/library/swf/site_configuration/pages/about.xml',
        'news'              => 'application/views/themes/default/library/swf/site_configuration/pages/news.xml',
        'photos'            => 'application/views/themes/default/library/swf/site_configuration/pages/photos.xml',
        'events'            => 'application/views/themes/default/library/swf/site_configuration/pages/events.xml'
    );
    private $config_folder = 'application/views/themes/default/library/swf/site_configuration/';
    private $site_folder = 'application/views/themes/default/library/swf/';
    // }}}

    // {{{ public function __construct(  )
    public function __construct(  )
    {
        $this->x = new ChiXML();
    }
    // }}}
    // {{{ public function config( $params )
    public function config( $params )
    {
        if( isset( $params['con'] ) ) $this->con =& $params['con'];
        $this->CI =& get_instance();
    }
    // }}}
    // {{{ public function update_page( $page, $data )
    public function update_page( $page, $data )
    {
        // Construct new node.
        $xml  = tab(2) . "<articleText>" . newline(); 
        $xml .= tab(2) . "<![CDATA[" . newline();
        $xml .= tab(3) . "<h1>" . $data['title'] . "</h1>" . newline();
        $xml .= tab(3) . "<p>". nl2br( $data['content'] ) . "</p>" . newline();
        $xml .= tab(2) . "]]>" . newline();
        $xml .= tab(2) . "</articleText>" . newline(); 

        // Get current file.
        $orig = file_get_contents( $this->xml[$page] );
        // Manipulate the string.
        $orig = $this->x->update_xml( $orig, 'ARTICLE', $xml );
        $fo = fopen( $this->xml[$page], 'w+' );
        $write = fwrite( $fo, $orig );
        fclose( $fo );
        return $write;
    }
    // }}}
    // {{{ public function update_events( $update )
    public function update_events( $update )
    {
        $xml = '';
        // Construct new nodes.
        $cnt = 0;
        foreach( $update as $event )
        {
            $start_y = ( 160 + ( 95 * $cnt ) );
            $xml .= newline();
            $xml .= tab(1) . "<!-- EVENT -->" . newline();
            $xml .= tab(2) . "<image>" . newline() . tab(3) . "<x>40</x>" . newline(); 
            $xml .= tab(3) . "<y>" . $start_y . "</y>" . newline();
            $xml .= tab(3) . "<addSuperSizedImagePopUp>true</addSuperSizedImagePopUp>" . newline();
            $xml .= tab(3) . "<superSizedImageUrl>" . $this->bu . "images/events/" . $event->pic . "</superSizedImageUrl>" . newline();
            $xml .= tab(3) . "<imageURL>" . $this->bu . "images/events/" . $event->small_pic . "</imageURL>" . newline();
            $xml .= tab(2) . "</image>" . newline();
            $xml .= tab(2) . "<article>" . newline();
            $xml .= tab(3) . "<x>130</x>" . newline();
            $xml .= tab(3) . "<y>" . $start_y . "</y>" . newline();
            $xml .= tab(3) . "<width>590</width>" . newline();
            $xml .= tab(3) . "<articleText>" . newline();
            $xml .= tab(4) . "<![CDATA[<h1>" . $event->title . "</h1><p>At " . $event->venue . " - " . $event->address . " on " . date( "F j, Y, g:i a", $event->date ) . ".]]>" . newline();
            $xml .= tab(3) . "</articleText>" . newline();
            $xml .= tab(2) . "</article>" . newline();
            $xml .= tab(2) . "<image>" . newline() . tab(3) . "<x>40</x>" . newline(); 
            $xml .= tab(3) . "<y>" . ( $start_y + 85 ) . "</y>" . newline();
            $xml .= tab(3) . "<imageURL>http://royaltyrecordsinc.com/application/views/themes/default/library/swf/site_images/line_3.jpg</imageURL>" . newline();
            $xml .= tab(2) . "</image>" . newline();
            $xml .= tab(1) . "<!-- END OF EVENT -->" . newline();
            $cnt++;
        }

        // Get current file.
        $orig = file_get_contents( $this->xml['events'] );
        // Manipulate the string.
        $orig = $this->x->update_xml( $orig, 'EVENTS_AREA', $xml );
        $fo = fopen( $this->xml['events'], 'w+' );
        $write = fwrite( $fo, $orig );
        fclose( $fo );
        return $write;
    }
    // }}}
    // --- TEAM FUNCTIONS --- //
    // {{{ public function update_team( $id, $update )
    public function update_team( $id, $update )
    {
        $team_table = 'team';
        $config_file = 'application/views/themes/default/library/swf/site_configuration/config.xml';
        // {{{ Update Menu.
        $artistm = '';
        foreach( $update as $artist )
        {
            // Grab individual artist info.
            if( $artist->id == $id ) $info = $artist;
            $bg = ( preg_match( '/[a-zA-Z0-9_]+\.(gif|jpg|png)$/i', $artist->pic ) ) ? "http://royaltyrecordsinc.com/images/team/" . $artist->pic : 0;
            $useImage = ( $bg === 0 ) ? 'false' : 'true';
            $artistm .= newline();
            $artistm .= tab(2) . "<subPage>" . newline();
            $artistm .= tab(3) . "<name>". $artist->title ."</name>" . newline();
            $artistm .= tab(3) . "<title>Royalty Records | " . $artist->title . "</title>" . newline();
            $artistm .= tab(3) . "<xmlPath>http://royaltyrecordsinc.com/application/views/themes/default/library/swf/site_configuration/pages/artists/" . $artist->id . ".xml</xmlPath>" . newline();
            $artistm .= tab(3) . "<cssPath>http://royaltyrecordsinc.com/application/views/themes/default/library/swf/site_stylesheets/content.css</cssPath>" . newline();
            $artistm .= tab(3) . "<utilityType>content</utilityType>" . newline();
            $artistm .= tab(3) . "<muteAudio>true</muteAudio>" . newline();
            $artistm .= tab(3) . "<backgroundOptions>" . newline();
            $artistm .= tab(4) . "<topMargin>0</topMargin>" . newline();
            $artistm .= tab(4) . "<bottomMargin>0</bottomMargin>" . newline();
            $artistm .= tab(4) . "<useImage>" . $useImage . "</useImage>" . newline();
            if( !( $bg === 0 ) ) {
                $artistm .= tab(4) . "<imageURL>" . $bg ."</imageURL>" . newline();
                $artistm .= tab(4) . "<staticImage>true</staticImage>" . newline();
                $artistm .= tab(4) . "<imageX>left</imageX>" . newline();
                $artistm .= tab(4) . "<imageY>top</imageY>" . newline();
            }
            $artistm .= tab(4) . "<!--bgColor is used if your image does not fill the entire width/height of the stage-->" . newline();
            $artistm .= tab(4) . "<bgColor>0x828282</bgColor>" . newline();
            $artistm .= tab(3) . "</backgroundOptions>" . newline();
            $artistm .= tab(2) . "</subPage>" . newline();
        }
        $this->main = $info; 
        // Get current file.
        $orig = file_get_contents( $config_file );
        // Save the CONFIG file.
        $orig = $this->x->update_xml( $orig, 'ARTIST_MENU', $artistm );
        $fo = fopen( $config_file, 'w+' );
        $write = fwrite( $fo, $orig );
        fclose( $fo );
        // }}}
        // {{{ Update Artist File.

        // Get relative information about the music playlist and photo album.
        $this->music_playlist = $this->get_team_music_playlist( $info->id );         
        $this->photo_album = $this->get_team_photo_album( $info->id );         
        $this->slideshow = $this->get_team_slideshow( $info->id );         

        // Check to see if this file has been created.
        // If not, this is the first save.
        $single_xml_file = $this->config_folder . 'pages/artists/' . $info->id . '.xml';
        $single_xml_text = @file_get_contents( $single_xml_file );
        $first_save = ( $single_xml_text === false ) ? true : false;

        if( $first_save )
        {
            // Clone ARTIST file.
            $clone_single = $this->config_folder . 'pages/artists/clone.xml';
            copy( $clone_single, $single_xml_file );
            $single_xml_text = @file_get_contents( $single_xml_file );
        }

        // Top Banner XML
        $banner_xml = newline();
        $banner_inner_xml = newline();
        $banner_inner_xml .= tab(3) . tag( 'x', 40 ) . newline();
        $banner_inner_xml .= tab(3) . tag( 'y', 40 ) . newline();
        $banner_inner_xml .= tab(3) . tag( 'swfUrl', $this->bu . $this->site_folder . 'newSlideShow.swf' ) . newline();
        $banner_inner_xml .= tab(3) . tag( 'swfXML', $this->bu . $this->config_folder . 'pages/artists/slideshows/' . $info->id . '.xml' ) . newline() . tab(2);
        $banner_xml .= tab(2) . tag( 'swf', $banner_inner_xml ) .newline() . tab(2);
        $single_xml_text = $this->x->update_xml( $single_xml_text, 'TOP_BANNER', $banner_xml );

        // Artist Title
        $name_xml = newline();
        $name_inner_xml = newline();
        $name_inner_xml .= tab(3) . tag( 'x', 40 ) . newline();
        $name_inner_xml .= tab(3) . tag( 'y', 276 ) . newline();
        $name_inner_xml .= tab(3) . tag( 'swfUrl', $this->bu . $this->site_folder . 'artistTitle.swf?q_title=' . $info->title ) . newline();
        $name_xml .= tab(2) . tag( 'swf', $name_inner_xml ) .newline() . tab(2);
        $single_xml_text = $this->x->update_xml( $single_xml_text, 'ARTIST_TITLE', $name_xml );

        // {{{ XML Nodes
        // Bio
        $bio = newline();
        $bio .= tab(2) . '<articleText>' . newline();
        $bio .= tab(2) . '<![CDATA[' . newline();
        $bio .= tab(3) . '<h1>' . $info->subtitle . '</h1><p>' . $info->content . '</p>' . newline();
        $bio .= tab(2) . ']]>' . newline();
        $bio .= tab(2) . '</articleText>' . newline() . tab(2);
        $single_xml_text = $this->x->update_xml( $single_xml_text, 'BIO', $bio );

        // Facebook Link 
        $fb_xml = newline();
        $fb_xml .= tab(2) . tag( 'linkUrl', $info->facebook ) . newline() .tab(2);
        $single_xml_text = $this->x->update_xml( $single_xml_text, 'FACEBOOK_LINK', $fb_xml );

        // Twitter Link
        $tw_xml = newline();
        $tw_xml .= tab(2) . tag( 'linkUrl', $info->twitter ) . newline() . tab(2);
        $single_xml_text = $this->x->update_xml( $single_xml_text, 'TWITTER_LINK', $tw_xml );

        // Prepare MySpace Link
        $ms_xml = newline();
        $ms_xml .= tab(2) . tag( 'linkUrl', $info->myspace ) . newline() . tab(2);
        $single_xml_text = $this->x->update_xml( $single_xml_text, 'MYSPACE_LINK', $ms_xml );

        // If the playlist has songs we prepare and populate the xml
        if( $this->music_playlist->number_of_songs > 1 )
        {
            $mp_cover_image = ( $this->music_playlist->pic != '' ) ? $this->bu . 'images/music/' . $this->music_playlist->pic : 'http://placehold.it/279x190/000/000/&text=%3F'; 

            $mp_cover_xml = newline();
            $mp_cover_inner = newline();
            $mp_cover_inner .= tab(2) . tag( 'x', 405 ) . newline();
            $mp_cover_inner .= tab(2) . tag( 'y', 436 ) . newline();
            $mp_cover_inner .= tab(2) . tag( 'imageURL',  $mp_cover_image ) . newline() . tab(1); 
            $mp_cover_xml .= tab(1) . tag( 'image', $mp_cover_inner ) . newline() . tab(1);
            $single_xml_text = $this->x->update_xml( $single_xml_text, 'PLAYLIST_IMAGE', $mp_cover_xml );

            // Prepare Music Playlist XML
            $mp_xml = newline();
            $mp_inner_xml = newline();
            $mp_inner_xml .= tab(3) . tag( 'x', 405 ) . newline();
            $mp_inner_xml .= tab(3) . tag( 'y', 632 ) . newline();
            $mp_inner_xml .= tab(3) . tag( 'swfUrl', $this->bu . $this->site_folder . 'mp3Module.swf' ) . newline();
            $mp_inner_xml .= tab(3) . tag( 'swfXML', $this->bu . $this->config_folder . 'pages/artists/music_playlists/' . $info->id . '.xml' ) . newline() . tab(2);
            $mp_xml .= tab(2) . tag( 'swf', $mp_inner_xml ) . newline() . tab(2);
            $single_xml_text = $this->x->update_xml( $single_xml_text, 'MUSIC_PLAYER', $mp_xml );
        }
        // If we don't have songs we clear the playlist area.
        else
        {
            $single_xml_text = $this->x->update_xml( $single_xml_text, 'MUSIC_PLAYER', '' );
            $single_xml_text = $this->x->update_xml( $single_xml_text, 'PLAYLIST_IMAGE', '' );
        }

        if( $this->photo_album->size > 1 )
        {
            // Get cover image.
            $pa_cover_image = ( $this->photo_album->small != '' ) ? $this->bu . 'images/photos/' . $this->photo_album->small : $this->bu . 'images/defaults/artist_music_playlist_cover.jpg';

            // Prepare Photo Album Cover
            $pa_xml = newline();
            $pa_xml .= tab(2) . tag( 'x', 405 ) . newline();
            $pa_xml .= tab(2) . tag( 'y', 756 ) . newline();
            $pa_xml .= tab(2) . tag( 'imageURL', $pa_cover_image ) . newline(); 
            $pa_xml .= tab(2) . tag( 'addExternalSwfPopUp', 'true' ) . newline();
            $pa_xml .= tab(2) . tag( 'swfUrl', $this->bu . $this->site_folder . 'photoModule.swf' ) . newline();
            $pa_xml .= tab(2) . tag( 'swfXML', $this->bu . $this->config_folder . 'pages/artists/photo_albums/' . $info->id . '.xml' ) . newline();
            $pa_xml .= tab(2) . tag( 'swfCSS', $this->bu . $this->site_folder . 'site_stylesheets/photo.css' ) . newline() . tab(1);
            $full_pa_xml = newline();
            $full_pa_xml .= tab(1) . tag( 'image', $pa_xml ) . newline() . tab(1);
            $single_xml_text = $this->x->update_xml( $single_xml_text, 'ALBUM_AREA', $full_pa_xml );
        }
        else
        {
            $single_xml_text = $this->x->update_xml( $single_xml_text, 'ALBUM_AREA', '' );
        }
        // }}}

        // Save Main Artist File
        $fo = fopen( $single_xml_file, 'w+' );
        $write = fwrite( $fo, $single_xml_text);
        fclose( $fo );

        // If this is a first save we create the other relative files
        if( $first_save )
        {
            // Clone PLAYLIST file.
            $clone_playlist = $this->config_folder . 'pages/artists/music_playlists/clone.xml';
            $playlist_xml_file = $this->config_folder . 'pages/artists/music_playlists/' . $info->id . '.xml';
            copy( $clone_playlist, $playlist_xml_file );

            // Clone PHOTO_ALBUM file.
            $clone_photo_album = $this->config_folder . 'pages/artists/photo_albums/clone.xml';
            $photo_album_xml_file = $this->config_folder . 'pages/artists/photo_albums/' . $info->id . '.xml';
            copy( $clone_photo_album, $photo_album_xml_file );

            // Clone SLIDESHOW file.
            $clone_slideshow = $this->config_folder . 'pages/artists/slideshows/clone.xml';
            $slideshow_xml_file = $this->config_folder . 'pages/artists/slideshows/' . $info->id . '.xml';
            copy( $clone_slideshow, $slideshow_xml_file );
        }
        else
        {
            // Repopulate Photo Album
            $this->rewrite_photo_album( $id );
            $this->rewrite_slideshow( $id );
            // Repopulate Music Playlist
            $this->rewrite_music_playlist( $id );
            // Allow for Playlist Picture
        }
        // }}}
    }
    // }}}
    // {{{ public function get_team_playlist( $id )
    public function get_team_music_playlist( $id )
    {
        $playlist = $this->get_options( $id, 'team_options', 'music_playlists', 'music_playlist' );
        return $playlist[0];
    }
    // }}}
    // {{{ public function get_team_photo_album( $id )
    public function get_team_photo_album( $id )
    {
        $photo_album = $this->get_options( $id, 'team_options', 'photo_albums', 'photo_album' );
        return $photo_album[0];
    }
    // }}}
    // {{{ public function get_team_slideshow( $id )
    public function get_team_slideshow( $id )
    {
        $slideshow = $this->get_options( $id, 'team_options', 'photo_albums', 'slideshow' );
        return $slideshow[0];
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
    // {{{ public function rewrite_photo_album( $id )
    public function rewrite_photo_album( $id )
    {
        // Prepare nodes. 
        $this->CI->load->model( 'photos_model', 'photos' );
        $photos = $this->CI->photos->get_photos( $this->photo_album->type_id );
        $photo_xml = newline();
        foreach( $photos as $photo )
        {
            // Prepare nodes.
            $photo_inner_xml = newline();
            $photo_inner_xml .= tab(2) . tag( 'ThumbUrl', $this->bu . 'images/photos/' . $photo->square ) . newline();
            $photo_inner_xml .= tab(2) . tag( 'ImageUrl', $this->bu . 'images/photos/' . $photo->large ) . newline();
            $photo_inner_xml .= tab(2) . tag( 'addImageInfo', 'false' ) . newline();
            $photo_inner_xml .= tab(2) . tag( 'thumbCaption', 'Click To View' ) . newline();
            $photo_inner_xml .= tab(2) . tag( 'addFullScreenButton', 'false' ) . newline();
            $photo_xml .= tab(1) . tag( 'image', $photo_inner_xml ) . newline();
        }

        $file_xml = file_get_contents( $this->config_folder . 'pages/artists/photo_albums/' . $this->photo_album->record_id . '.xml'  );
        // Save the CONFIG file.
        $file_xml = $this->x->update_xml( $file_xml, 'PHOTO_AREA', $photo_xml );
        $fo = fopen( $this->config_folder . 'pages/artists/photo_albums/' . $this->photo_album->record_id . '.xml', 'w+' );
        $write = fwrite( $fo, $file_xml );
        fclose( $fo );
    }
    // }}}
    // {{{ public function rewrite_slideshow( $id )
    public function rewrite_slideshow( $id )
    {
        // Prepare nodes. 
        $this->CI->load->model( 'photos_model', 'photos' );
        $photos = $this->CI->photos->get_photos( $this->slideshow->type_id );
        $photo_xml = newline();
        foreach( $photos as $photo )
        {
            // Prepare nodes.
            $photo_inner_xml = newline();
            $photo_inner_xml .= tab(2) . tag( 'interval', '4000' ) . newline();
            $photo_inner_xml .= tab(2) . tag( 'useImage', 'true' ) . newline();
            $photo_inner_xml .= tab(2) . tag( 'imageURL', $this->bu . 'images/photos/' . $photo->crop1 ) . newline();
            $photo_inner_xml .= tab(2) . tag( 'bgColor', '0x000000' ) . newline() . tab(1);
            $photo_xml .= tab(1) . tag( 'slide', $photo_inner_xml ) . newline();
        }
        $photo_xml .= tab(1);

        $file_xml = file_get_contents( $this->config_folder . 'pages/artists/slideshows/' . $this->slideshow->record_id . '.xml'  );
        // Save the CONFIG file.
        $file_xml = $this->x->update_xml( $file_xml, 'SLIDE_AREA', $photo_xml );
        $fo = fopen( $this->config_folder . 'pages/artists/slideshows/' . $this->slideshow->record_id . '.xml', 'w+' );
        $write = fwrite( $fo, $file_xml );
        fclose( $fo );
    }
    // }}}
    // {{{ public function rewrite_music_playlist( $id )
    public function rewrite_music_playlist( $id )
    {
        // Prepare nodes. 
        $this->CI->load->model( 'music_model', 'music' );
        $tracks = $this->get_music_playlist_records( $this->music_playlist->type_id );
        $track_xml = newline();
        foreach( $tracks as $track )
        {
            // Prepare nodes.
            $track_inner_xml = newline();
            $track_inner_xml .= tab(2) . tag( 'artist', $track->artist  ) . newline();
            $track_inner_xml .= tab(2) . tag( 'album', '' ) . newline();
            $track_inner_xml .= tab(2) . tag( 'title', $track->title  ) . newline();
            $track_inner_xml .= tab(2) . tag( 'url', $this->bu . 'music_files/' . $track->file  ) . newline();
            $track_xml .= tab(1) . tag( 'track', $track_inner_xml ) . newline();
        }

        $file_xml = file_get_contents( $this->config_folder . 'pages/artists/music_playlists/' . $this->music_playlist->record_id . '.xml'  );
        // Save the CONFIG file.
        $file_xml = $this->x->update_xml( $file_xml, 'TRACK_AREA', $track_xml );
        $fo = fopen( $this->config_folder . 'pages/artists/music_playlists/' . $this->music_playlist->record_id . '.xml', 'w+' );
        $write = fwrite( $fo, $file_xml );
        fclose( $fo );
    }
    // }}}
    // {{{ private function get_music_playlist_records()
    private function get_music_playlist_records( $pid )
    {
        $ci = $this->CI;
        $stab = $ci->db->dbprefix( 'music_songs' );
        $rtab = $ci->db->dbprefix( 'music_records' );
        // Grab songs from the records table
        $sql  = 'SELECT `' . $stab . '`.`id`, `' . $stab . '`.`title`, `' . $stab . '`.`file`, `' . $stab . '`.`artist`,';
        $sql .= ' `' . $rtab . '`.`song_id`, `' . $rtab . '`.`playlist_id`';
        $sql .= ' FROM ' . $stab . ', ' . $rtab;
        $sql .= ' WHERE (' . $rtab . '.playlist_id = \'' . $pid . '\')';
        $sql .= ' AND (' . $stab . '.id = ' . $rtab . '.song_id )';
        $sql .= ' ORDER BY `order` ASC;';
        $query = $ci->db->query( $sql );
        return $query->result(); 
    } 
    // }}}
    // --- NEWS FUNCTIONS --- //
    // {{{ public function update_entries( $update )
    public function update_entries( $update )
    {
        // Construct new nodes.
        $cnt = 0;
        $news_xml = newline();
        foreach( $update as $entry )
        {
            $news_xml .= tab(1) . "<!-- ENTRY -->" . newline();

            // Title and Date
            $td_xml = newline() ;
            $start_y = ( 171 + ( 619 * $cnt ) );
            // First Nodes Positioning and width
            $td_xml .= tab(2) . tag( 'x', 40 ) . newline();
            $td_xml .= tab(2) . tag( 'y', $start_y ) . newline();
            $td_xml .= tab(2) . tag( 'width', 655 ) . newline();
                // Entry Title and Date
                $title_date = newline();
                $title_date .= tab(3) . tag( 'h1', $entry->title ) . newline(); 
                $title_date .= tab(3) . tag( 'h2', date( "F j, Y, g:i a", $entry->date ) ) . newline() . tab(2); 
                $tdcdata = newline();
                $tdcdata .= tab(2) . tag( 'cdata', $title_date ) . tab(1) .newline() . tab(2);
                $td_art = newline() . tab(2) . tag( 'articleText', $tdcdata ) . newline() . tab(1);
            $td_full_xml = $td_xml . $td_art;
            // Put in the main xml file.
            $news_xml .= tab(1). tag( 'article', $td_full_xml ) . newline();

            // Main Image
            $img_xml = newline(); 
            $img_xml .= tab(2) . tag( 'x', 40 ) . newline();
            $img_xml .= tab(2) . tag( 'y', $start_y + 100 ) . newline();
            $entry_image = ( $entry->pic != '' ) ? $this->bu . 'images/entries/' . $entry->pic : $this->bu . 'images/defaults/entries_image.jpg';
            $img_xml .= tab(2) . tag( 'imageURL', $entry_image ) . newline() . tab(1);
            // Put in the main xml file.
            $news_xml .= tab(1) . tag( 'image', $img_xml ) . newline();
            
            // Article Text
            $text_xml = newline() ;
            // First Nodes Positioning and width
            $text_xml .= tab(2) . tag( 'x', 40 ) . newline();
            $text_xml .= tab(2) . tag( 'y', $start_y + 424 ) . newline();
            $text_xml .= tab(2) . tag( 'width', 550 ) . newline();
                // Entry Body
                $text_body = newline();
                $text_body .= tab(3) . $entry->content . newline() . tab(2); 
                $text_cdata = newline();
                $text_cdata .= tab(2) . tag( 'cdata', $text_body ) . tab(1) .newline() . tab(2);
                $text_art = newline() . tab(2) . tag( 'articleText', $text_cdata ) . newline() . tab(1);
            $text_full_xml = $text_xml . $text_art;
            // Put in the main xml file.
            $news_xml .= tab(1). tag( 'article', $text_full_xml ) . newline();
            $cnt++;
        }

        // Get current file.
        $orig = file_get_contents( $this->xml['news'] );
        // Manipulate the string.
        $orig = $this->x->update_xml( $orig, 'NEWS_AREA', $news_xml );
        $fo = fopen( $this->xml['news'], 'w+' );
        $write = fwrite( $fo, $orig );
        fclose( $fo );
        return $write;
    }
    // }}}
    // {{{ public function update_photos( $update )
    public function update_photos( $update, $id = 0 )
    {
        $photo_xml = newline();
        // Update master photos file.
        $cnt = 0;
        foreach( $update as $album )
        {
            if( $id != 0 && $album->id == $id ) $info = $album;
            $col = $cnt % 3;
            $row = floor( $cnt / 3 ); // The row value, with the first row being 0.
            $x = 40 + ( $col * 300 ); 
            $y =  140 + ( 240 * $row );
            $album_xml = newline();
            $album_inner_xml = newline();
            $album_inner_xml .= tab(2) . tag( 'x', $x ) . newline();
            $album_inner_xml .= tab(2) . tag( 'y', $y ) . newline();
            $image = ( $album->small != '' ) ? $this->bu . 'images/photos/' . $album->small : $this->bu . 'images/defaults/photo_cover.jpg';
            $album_inner_xml .= tab(2) . tag( 'imageURL', $image ) . newline();
            $album_inner_xml .= tab(2) . tag( 'includeImageOver', 'true' ) . newline();
            $album_inner_xml .= tab(2) . tag( 'imageOverURL', $this->bu . 'images/defaults/photo_over.png' ) . newline();
            $album_inner_xml .= tab(2) . tag( 'muteAudio', 'true') . newline();
            $album_inner_xml .= tab(2) . tag( 'addExternalSwfPopUp', 'true') . newline();
            $album_inner_xml .= tab(2) . tag( 'swfUrl', $this->bu . $this->site_folder . 'photoModule.swf' ) . newline();
            $album_inner_xml .= tab(2) . tag( 'swfXML', $this->bu . $this->config_folder . 'pages/photos/' . $album->id . '.xml' ) . newline();
            $album_inner_xml .= tab(2) . tag( 'swfCSS', $this->bu . $this->site_folder . 'site_stylesheets/photo.css' ) . newline() . tab(1);
            $photo_xml .= tab(1) . tag( 'image', $album_inner_xml ) . newline();
            $cnt++;
        }        

        // Get current file.
        $orig = file_get_contents( $this->xml['photos'] );
        // Manipulate the string.
        $orig = $this->x->update_xml( $orig, 'PHOTO_ALBUM_AREA', $photo_xml );
        $fo = fopen( $this->xml['photos'], 'w+' );
        $write = fwrite( $fo, $orig );
        fclose( $fo );

        // If we have an id, we update the individual xml file.
        if( $id != 0 )
        {
            $ind = @file_get_contents( $this->config_folder . 'pages/photos/' . $info->id . '.xml' );
            if( $ind === false )
            {
                // Copy the clone into a new file.
                $clone_photo_album = $this->config_folder . 'pages/photos/clone.xml';
                $photo_album_xml_file = $this->config_folder . 'pages/photos/' . $info->id . '.xml';
                copy( $clone_photo_album, $photo_album_xml_file );
            }
            else
            {
                $this->CI->load->model( 'photos_model', 'photos' );
                $photos = $this->CI->photos->get_photos( $info->id );
                $individual_xml = newline();

                // Create our new nodes.
                foreach( $photos as $photo )
                {
                    $inner_ind_xml = newline();
                    $image = $this->bu . 'images/photos/' . $photo->large;
                    $small = $this->bu . 'images/photos/' . $photo->small;

                    $inner_ind_xml .= tab(2) . tag( 'ThumbUrl', $small ) . newline();
                    $inner_ind_xml .= tab(2) . tag( 'ImageUrl', $image ) . newline();
                    $inner_ind_xml .= tab(2) . tag( 'addImageInfo', 'false' ) . newline();
                    $inner_ind_xml .= tab(2) . tag( 'thumbCaption', 'Click to view.' ) . newline();
                    $inner_ind_xml .= tab(2) . tag( 'addFullScreenButton', 'false' ) . newline() . tab(1);
                    $individual_xml .= tab(1) . tag( 'image', $inner_ind_xml ) . newline();
                }

                $ind = $this->x->update_xml( $ind, 'IMAGES_AREA', $individual_xml );
                $fo = fopen( $this->config_folder . 'pages/photos/' . $info->id . '.xml', 'w+' );
                $write = fwrite( $fo, $ind );
                fclose( $fo );
            }
        }
        else
        {
            return $write;
        }
    }
    // }}}
}
