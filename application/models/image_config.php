<?

class Image_config extends CI_Model 
{
    // --- MUSIC CONFIGURATIONS --- //
    // {{{ public function music_config( $id, $width, $height ) 
    public function music_config( $id, $width, $height ) 
    {
        $crop_w = ( $width > $height ) ? $height : $width;
        $crop_h = ( $width > $height ) ? $height : $width;

        return array (
            'resize_by'             => 'width',
            'resize_to' 		    => 80,
            'column' 			    => 'pic',
            'where_id'			    => $id,
            'new_name'			    => 'chimu_' . $id . '_' . time(),
            'path' 				    => 'music_files/images/',
            'into_photo_table' 	    => false,
            'stretch'			    => false,
            'crop_x'			    => 0,
            'crop_y' 			    => 0,
            'crop_w'			    => $crop_w,
            'crop_h'			    => $crop_h
        );
    }
    // }}}
    // {{{ public function song_image_config( $id ) 
    public function song_image_config( $id, $width, $height ) 
    {	
		$crop_w = ( $width > $height ) ? $height : $width;
		$crop_h = ( $width > $height ) ? $height : $width;

        return array (
            'resize_by' 		    => 'width',
            'resize_to' 		    => 80,
            'where_id' 			    => $id,
            'column' 			    => 'pic',
            'path' 				    => 'images/music/',
            'into_photo_table'      => false,
            'stretch'			    => false,
			'crop_x'			    => 0,
			'crop_y' 			    => 0,
			'crop_w'			    => $crop_w,
			'crop_h'			    => $crop_h,
            'new_name'			    => 'chi_sq_' . $id . '_' . time()
        );
    }
    // }}}
    // {{{ public function playlist_image_config( $id ) 
    public function playlist_image_config( $id ) 
    {	
        return array (
            'resize_by' 		    => 'width',
            'resize_to' 		    => 279,
            'where_id' 			    => $id,
            'column' 			    => 'pic',
            'path' 				    => 'images/music/',
            'into_photo_table'      => false,
            'stretch'			    => false,
            'new_name'			    => 'chip_sq_' . $id . '_' . time()
        );
    }
    // }}}
    // --- DOWNLOADS CONFIGURATIONS --- //
    // {{{ public function downloads_config( $id ) 
    public function downloads_config( $id ) 
    {
        return array (
            'resize_by'             => 'width',
            'resize_to' 		    => 150,
            'where_id' 			    => $id,
            'column' 			    => 'pic',
            'path' 				    => 'images/downloads/',
            'into_photo_table'      => false,
            'stretch'			    => false,
            'new_name'			    => 'dl_' . $id . '_' . time()
        );
    }
    // }}}
    // --- FEATURES CONFIGURATIONS --- //
    // {{{ public function features_config( $id ) 
    public function features_config( $id ) 
    {
        return array (
            'resize_by'             => 'width',
            'resize_to' 		    => 560,
            'where_id' 			    => $id,
            'column' 			    => 'pic',
            'path' 				    => 'images/features/',
            'into_photo_table'      => false,
            'stretch'			    => false,
            'new_name'			    => 'feat_' . $id . '_' . time()
        );
    }
    // }}}
    // --- EVENTS CONFIGURATIONS --- //
   // {{{ public function events_mid_config( $id ) 
    public function events_mid_config( $id ) 
    {
        return array (
            'resize_by'             => 'width',
            'resize_to' 		    => 480,
            'where_id' 			    => $id,
            'column' 			    => 'pic',
            'path' 				    => 'images/events/',
            'into_photo_table'      => false,
            'stretch'			    => false,
            'new_name'			    => 'chievt_' . $id . '_mid_' . time()
        );
    }
    // }}}
     // {{{ public function events_square_config( $id, $width, $height ) 
    public function events_square_config( $id, $width, $height ) 
    {	
		$crop_w = ( $width > $height ) ? $height : $width;
		$crop_h = ( $width > $height ) ? $height : $width;

        return array (
            'resize_by' 		    => 'width',
            'resize_to' 		    => 75,
            'where_id' 			    => $id,
            'column' 			    => 'small_pic',
            'path' 				    => 'images/events/',
            'into_photo_table'      => false,
            'stretch'			    => false,
			'crop_x'			    => 0,
			'crop_y' 			    => 0,
			'crop_w'			    => $crop_w,
			'crop_h'			    => $crop_h,
            'new_name'			    => 'chievt_' . $id . '_sq_' . time()
        );
    }
    // }}}
    // --- RECORDS CONFIGURATIONS --- //
    // {{{ public function pages_config( $id ) 
    public function pages_config( $id ) 
    {	
        return array (
            'resize_by'             => 'width',
            'resize_to' 		    => 560,
            'where_id' 			    => $id,
            'column' 			    => 'pic',
            'path' 				    => 'images/entries/',
            'into_photo_table'	    => false,
            'stretch'			    => false,
            'new_name'			    => 'chient_' . $id . '_mid_' . time()
        );
    }
    // }}}
    // {{{ public function entries_extra_config( $id ) 
    public function entries_extra_config( $id ) 
    {	
        return array (
            'resize_by' 		    => 'width',
            'resize_to' 		    => 630,
            'where_id' 			    => $id,
            'column' 			    => 'large',
            'path' 				    => 'images/entries/',
            'into_photo_table'      => true,
            'stretch'			    => false,
            'new_name'			    => 'chient_' . $id . '_l_' . time()
        );
    }
    // }}}
    // {{{ public function entries_mid_config( $id ) 
    public function entries_mid_config( $id ) 
    {	
        return array (
            'resize_by' 		    => 'width',
            'resize_to' 		    => 560,
            'where_id' 			    => $id,
            'column' 			    => 'pic',
            'path' 				    => 'images/entries/',
            'into_photo_table'	    => false,
            'stretch'			    => false,
            'new_name'			    => 'chient_' . $id . '_m_' . time()
        );
    }
    // }}}
    // {{{ public function entries_small_config( $id ) 
    public function entries_small_config( $id ) 
    {	
        return array (
            'resize_by'             => 'width',
            'resize_to' 		    => 361,
            'where_id' 			    => $id,
            'column' 			    => 'pic',
            'path' 				    => 'images/entries/',
            'into_photo_table'      => false,
            'stretch'			    => false,
            'new_name'			    => 'chient_' . $id . '_s_' . time()
        );
    }
    // }}}
    // --- TEAM CONFIGURATIONS --- //
    // {{{ public function team_bg_config( $id ) 
    public function team_bg_config( $id ) 
    {	
        return array (
            'resize_by' 		    => 'width',
            'resize_to' 		    => 1500,
            'where_id' 			    => $id,
            'column' 			    => 'pic',
            'path' 				    => 'images/team/',
            'spec_url'			    => $this->spec_url,
            'into_photo_table'	    => false,
            'stretch'			    => false,
            'new_name'			    => 'chitm_l_' . $id . '_' . time()
        );
    }
    // }}}
    // --- CLIENTS CONFIGURATIONS --- //
    // {{{ public function clients_config( $id, $width, $height ) 
    public function clients_config( $id, $width, $height ) 
    {	
		$crop_w = ( $width > $height ) ? $height : $width;
		$crop_h = ( $width > $height ) ? $height : $width;

        return array (
            'resize_by' 		    => 'width',
            'resize_to' 		    => 150,
            'where_id' 			    => $id,
            'column' 			    => 'pic',
            'path' 				    => 'images/clients/',
            'into_photo_table'      => false,
            'stretch'			    => false,
			'crop_x'			    => 0,
			'crop_y' 			    => 0,
			'crop_w'			    => $crop_w,
			'crop_h'			    => $crop_h,
            'new_name'			    => 'chicli_' . $id . '_sq_' . time()
        );
    }
    // }}}
    // --- STORE CONFIGURATIONS --- //
    // {{{ public function store_big_config( $id ) 
    public function store_big_config( $id ) 
    {	
        return array (
            'resize_by' 		    => 'container',
            'resize_to' 		    => 360,
            'where_id' 			    => $id,
            'column' 			    => 'big_pic',
            'path' 				    => 'images/store/',
            'into_photo_table'      => false,
            'stretch'			    => false,
            'new_name'			    => 'chistore_l_' . $id . '_' . time()
        );
    }
    // }}}
    // {{{ public function store_small_config( $id ) 
    public function store_small_config( $id ) 
    {	
        return array (
            'resize_by' 		    => 'container',
            'resize_to' 		    => 360,
            'where_id' 			    => $id,
            'column' 			    => 'small_pic',
            'path' 				    => 'images/store/',
            'into_photo_table'      => false,
            'stretch'			    => false,
            'new_name'			    => 'chistore_s_' . $id . '_' . time()
        );
    }
    // }}}
    // --- PHOTOS CONFIGURATIONS --- //
    // {{{ public function large_photos_config( $id ) 
    public function large_photos_config( $id ) 
    {	
        return array (
            'resize_by' 		    => 'container',
            'resize_to' 		    => 720,
            'where_id' 			    => $id,
            'column' 			    => 'large',
            'path' 				    => 'images/photos/',
            'into_photo_table'      => true,
            'stretch'			    => false,
            'new_name'			    => 'chi_l_' . $id . '_' . time()
        );
    }
    // }}}
    // {{{ public function small_photos_config( $id ) 
    public function small_photos_config( $id ) 
    {	
        return array (
            'resize_by' 		    => 'width',
            'resize_to' 		    => 279,
            'where_id' 			    => $id,
            'column' 			    => 'small',
            'path' 				    => 'images/photos/',
            'into_photo_table'      => true,
            'stretch'			    => false,
            'new_name'			    => 'chi_s_' . $id . '_' . time()
        );
    }
    // }}}
    // {{{ public function square_photos_config( $id, $width, $height ) 
    public function square_photos_config( $id, $width, $height ) 
    {	
		$crop_w = ( $width > $height ) ? $height : $width;
		$crop_h = ( $width > $height ) ? $height : $width;

        return array (
            'resize_by' 		    => 'width',
            'resize_to' 		    => 75,
            'where_id' 			    => $id,
            'column' 			    => 'square',
            'path' 				    => 'images/photos/',
            'into_photo_table'      => true,
            'stretch'			    => false,
			'crop_x'			    => 0,
			'crop_y' 			    => 0,
			'crop_w'			    => $crop_w,
			'crop_h'			    => $crop_h,
            'new_name'			    => 'chi_sq_' . $id . '_' . time()
        );
    }
    // }}}
    // {{{ public function landscape_photos_config( $id ) 
    public function landscape_photos_config( $id ) 
    {	
        return array (
            'resize_by' 		    => 'container',
            'resize_to' 		    => 755,
            'where_id' 			    => $id,
            'column' 			    => 'crop1',
            'path' 				    => 'images/photos/',
            'into_photo_table'      => true,
            'stretch'			    => false,
            'new_name'			    => 'chi_ls_' . $id . '_' . time()
        );
    }
    // }}}
}

?>
