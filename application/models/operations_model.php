<? if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operations_model extends CI_Model 
{
   public function create_youtube( $vid_code, $width, $height, $color = "" ) 
   {
		$template = '<object width="'.$width.'" height="'.$height.'">
			<param name="movie" value="http://www.youtube.com/v/'.$vid_code.'&color1=0xb1b1b1&color2=0xcfcfcf&hl=en_US&feature=player_detailpage&fs=1"></param>
			<param name="allowFullScreen" value="true"></param>
			<param name="allowScriptAccess" value="always"></param>
			<embed 
				src="http://www.youtube.com/v/'.$vid_code.'&color1=0xb1b1b1&color2=0xcfcfcf&hl=en_US&feature=player_detailpage&fs=1" 
				type="application/x-shockwave-flash" 
				allowfullscreen="true" 
				allowScriptAccess="always" 
				width="'.$width.'" 
				height="'.$height.'"></embed>
		</object>';
		return $template;
	}
	
   public function create_worldstar($vid_code,$width,$height) 
   {
		$template = '<OBJECT width="'.$width.'" height="'.$height.'">
			<EMBED height="'.$height.'" type="application/x-shockwave-flash" width="'.$width.'" src="http://www.worldstarhiphop.com/videos/e/16711680/'.$vid_code.'" allowFullscreen="true"></EMBED>
			</OBJECT>';
		return $template;
	}
	
   public function create_vimeo( $vid_code, $width, $height, $color = '' ) 
   {
		$template = '<iframe src="http://player.vimeo.com/video/' . $vid_code . '?color=' . $color . '" width="' . $width . '" height="' . $height . '" frameborder="0"></iframe>';	
		return $template;
	}
	
	function get_vid_code($string, $type) 
	{
	   if( $string != "" && strstr( $string, "http://") ) {	
		   if($type == "youtube") {
		   
		   	$pattern = "http://www.youtube.com/watch?v=";
		   	
		   	$a1 = explode($pattern,$string);
		   
		   	if( count($a1) >= 2 ) {	
		   	
		   		$a2 = explode("&",$a1[1]);
		   		return $a2[0];
		   		
		   	} else {
		   		
		   		return "";
		   		
		   	}
		   
		   } else if ( $type == "vimeo") {
		   	
		   	$pattern = "vimeo.com/";
		   	
		   	$a1 = explode( $pattern, $string );
		   
		   	return $a1[1];
		   	
		   	
		   } else if ($type == "worldstarhiphop") {
		   	$pattern = "http://www.worldstarhiphop.com/videos/video.php?v=";
		   	$a1 = explode($pattern,$string);
		   	if( count($a1) > 1 ) {	
		   		return $a1[1];
		   	} else {
		   		return "";
		   	}
		   }
      }
      else
      {
         return "";
      }
	}
	
	function if_clear_make($string, $replace) {
		
		$result = ($string == "")?$replace:$string;
		
		return $result;
		
	}
	
	function get_notice() 
	{	
		$this->db->where("active","yes");
		$query = $this->db->get('notifications');
		
		$notice = $query->row();
		
		return $notice;
	}
	
	function search_for( $terms )
	{
		$data = array();
		$this->db->like( 'title', $terms );
		$this->db->or_like( 'content', $terms ); 
		$this->db->order_by( 'date desc, views desc' ); 
		$query = $this->db->get( 'entries' );
		
		if( $query->num_rows() > 0 )
		{
			foreach( $query->result() as $row )
			{
				$data[] = $row;
			}
		}
		
		return $data;
	}
	
}

?>
