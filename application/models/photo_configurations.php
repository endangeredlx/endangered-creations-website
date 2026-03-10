<?

class Photo_configurations extends CI_Model 
{
	
	//PHOTO CONFIGURATIONS
	
	var $crop_w = 0;
	var $crop_h = 0;
	var $spec_url = ".example.com/beta/";
	
	function sq_event_config( $id, $width, $height ) {
		
		$this->crop_w = ($width > $height) ? $height : $width;
		$this->crop_h = ($width > $height) ? $height : $width;
		
		return array (
			"resize_by" 		=> "width",
			"resize_to" 		=> 75,
			"table" 			=> "events",
			"column" 			=> "square",
			"where_id"			=> $id,
			"new_name"			=> "event_square_".$id,
			"path" 				=> "images/",
			"spec_url"			=> $this->spec_url,
			"into_photo_table" 	=> false,
			"stretch"			=> false,
			"crop_x"			=> 0,
			"crop_y" 			=> 0,
			"crop_w"			=> $this->crop_w,
			"crop_h"			=> $this->crop_h
		);
		
	}
	
	function mid_event_config( $id ) {
		
		return array (
			"resize_by" 		=> "width",
			"resize_to" 		=> 225,
			"where_id" 			=> $id,
			"table" 			=> "events",
			"column" 			=> "mid",
			"path" 				=> "images/",
			"spec_url"			=> $this->spec_url,
			"into_photo_table" 	=> false,
			"stretch"			=> false,
			"new_name"			=> "event_mid_".$id
		);
		
	}
	
	function feature_config( $id ) {
		
		return array (
			"resize_by" 		=> "width",
			"resize_to" 		=> 550,
			"where_id" 			=> $id,
			"table" 			=> "features",
			"column" 			=> "image",
			"path" 				=> "images/",
			"spec_url"			=> $this->spec_url,
			"into_photo_table" 	=> false,
			"stretch"			=> false,
			"new_name"			=> "feat_".$id
		);
		
	}
	
	function mid_entry_config( $id ) 
	{	
		return array (
			"resize_by" 		=> "width",
			"resize_to" 		=> 590,
			"where_id" 			=> $id,
			"table" 			=> "eb_entries",
			"column" 			=> "image",
			"path" 				=> "images/entries/",
			"spec_url"			=> $this->spec_url,
			"into_photo_table" 	=> false,
			"stretch"			=> false,
			"new_name"			=> "entry_mid_".$id
		);
	}
	
	function mid_port_config( $id ) 
	{	
		return array (
			"resize_by" 		=> "width",
			"resize_to" 		=> 960,
			"where_id" 			=> $id,
			"table" 			=> "eb_port",
			"column" 			=> "large",
			"path" 				=> "images/ports/",
			"spec_url"			=> $this->spec_url,
			"into_photo_table" 	=> false,
			"stretch"			=> false,
			"new_name"			=> "entry_port_" . $id
		);
	}
	
	function mid_artist_config( $id ) {
		
		return array (
			"resize_by" 		=> "width",
			"resize_to" 		=> 320,
			"where_id" 			=> $id,
			"table" 			=> "artists",
			"column" 			=> "image",
			"path" 				=> "images/",
			"spec_url"			=> $this->spec_url,
			"into_photo_table" 	=> false,
			"stretch"			=> false,
			"new_name"			=> "artist_mid_".$id
		);
		
	}
	
	function mid_venue_config( $id ) {
		
		return array (
			"resize_by" 		=> "width",
			"resize_to" 		=> 225,
			"where_id" 			=> $id,
			"table" 			=> "venues",
			"column" 			=> "image",
			"path" 				=> "images/",
			"spec_url"			=> $this->spec_url,
			"into_photo_table" 	=> false,
			"stretch"			=> false,
			"new_name"			=> "venue_mid_".$id
		);
		
	}
	
	function large_album_config( $id ) 
	{	
		return array (
			"resize_by" 		=> "width",
			"resize_to" 		=> 960,
			"where_id" 			=> $id,
			"table" 			=> "eb_photos",
			"column" 			=> "large",
			"path" 				=> "../images/",
			"spec_url"			=> $this->spec_url,
			"into_photo_table" 	=> true,
			"stretch"			=> false,
			"new_name"			=> "album_large_".$id
		);
	}
	
	function small_album_config( $id ) 
	{	
		return array (
			"resize_by" 		=> "width",
			"resize_to" 		=> 225,
			"where_id" 			=> $id,
			"table" 			=> "eb_photos",
			"column" 			=> "small",
			"path" 				=> "../images/",
			"spec_url"			=> $this->spec_url,
			"into_photo_table" 	=> true,
			"stretch"			=> false,
			"new_name"			=> "album_small_".$id
		);
	}
	
	function square_album_config( $id, $width, $height ) 
	{	
		$this->crop_w = ($width > $height) ? $height : $width;
		$this->crop_h = ($width > $height) ? $height : $width;
		
		return array (
			"resize_by" 		=> "width",
			"resize_to" 		=> 85,
			"where_id" 			=> $id,
			"table" 			=> "eb_photos",
			"column" 			=> "square",
			"path" 				=> "../images/",
			"spec_url"			=> $this->spec_url,
			"into_photo_table" 	=> true,
			"stretch"			=> false,
			"new_name"			=> "album_square_".$id,
			"crop_x"			=> 0,
			"crop_y" 			=> 0,
			"crop_w"			=> $this->crop_w,
			"crop_h"			=> $this->crop_h
		);
	}
}
	
?>
