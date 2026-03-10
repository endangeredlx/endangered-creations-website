<?

class Image_model extends CI_Model 
{
	/*
	 *  Image Resizing/Uploading/Croping Class 
	 *	This class allows you to upload/resize/crop photos and update them into the database
	 */
	var $config = array();
    // {{{ public function put_image() 
    /*
     * For moving, resizing, renaming photos and putting them into a database.
     */
    public function put_image() 
    {
        //get some info about this thing
        list( $width, $height, $type ) = getimagesize( $this->config['temp_file'] );
        $temp_type = image_type_to_mime_type( $type );

        if( $temp_type == "image/pjpeg" || $temp_type == "image/jpeg" || $temp_type == "image/gif" || $temp_type == "image/png" )
        {
            //get new dimensions if needed
            if( $this->config['resize_by'] != "" && $this->config['resize_to'] != "" )
            {
                switch( $this->config['resize_by'] )
                {
                    case "height":
                        if ($height > $this->config['resize_to'] || $this->config['stretch'] ) { $new_height = intval($this->config['resize_to']);$new_width = intval(( $width/$height )*$this->config['resize_to']);} else { $new_width = intval($width);$new_height = intval($height); }
                        break;
                    case "width":
                        if ( $width > $this->config['resize_to'] || $this->config['stretch'] ) { $new_width = intval($this->config['resize_to']); $new_height = intval(( $height/$width )*$this->config['resize_to']); } else { $new_width = intval($width); $new_height = intval($height); }
                        break;
                    case "container" :
                        if( $width > $height && $width > intval( $this->config['resize_to'] ) ) { $new_width = intval( $this->config['resize_to']); $new_height = intval( ($height/$width) * $this->config['resize_to'] ); } else if( $height > $width && $height > intval( $this->config['resize_to'] ) ) { $new_height = intval( $this->config['resize_to'] ); $new_width = intval( ( $width/$height ) * $this->config['resize_to'] ); } else { $new_height = $height; $new_width = $width; }
                        break;
                }
            }
            //echo "new height - $new_height, new width $new_width";
            //rename if needed
            if( $this->config['new_name'] == "" )
            {
                $this->config['new_name'] = $this->config['temp_name'];
            }

            //create the image resource
            switch( $temp_type )
            {
                case ( "image/jpeg" || "image/pjpeg" ):
                    $temp_src = imagecreatefromjpeg($this->config['temp_file']);
                    break;
                case "image/gif":
                    $temp_src = imagecreatefromgif($this->config['temp_file']);
                    break;
                case "image/png":
                    $temp_src = imagecreatefrompng($this->config['temp_file']);
                    break;
            }

            $new_file = imagecreatetruecolor($new_width,$new_height);

            //this is the actual resizing right here
            $imagecopy = imagecopyresampled( $new_file, $temp_src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

            switch($temp_type)
            {
                case ( 'image/jpeg' || 'image/pjpeg' ) :
                    $new_location = $this->config['path'] . $this->config['new_name'] . '.jpg';
                    $new_path = $this->config['new_name'] . '.jpg';
                    $file_moved = imagejpeg( $new_file, $new_location, 100 );
                    break;
                case 'image/gif':
                    $new_location = $this->config['path'] . $this->config['new_name'] . '.gif';
                    $new_path = $this->config['new_name'] . '.gif';
                    $file_moved = imagegif( $new_file, $new_location, 100 );
                    break;
                case 'image/png':
                    $new_location = $this->config['path'] . $this->config['new_name'] . '.png';
                    $new_path = $this->config['new_name'] . '.png';
                    $file_moved = imagepng( $new_file, $new_location, 100 );
                    break;
            }

            //clean up the mess...
            imagedestroy( $temp_src );
            imagedestroy( $new_file );

            if( $this->config['table'] != "" && $this->config['where_id'] != "" & $this->config['column'] != "" ) 
            {
                if( $this->config['into_photo_table'] ) 
                { 
                    $mysql = mysql_query("Update `".$this->config['table']."` set `".$this->config['column']."` = '$new_path', `".$this->config['column']."_width` = '$new_width', `".$this->config['column']."_height` = '$new_height' where `id` = '".$this->config['where_id']."';");
                } 
                else 
                { 
                    $mysql = mysql_query("Update `".$this->config['table']."` set `".$this->config['column']."` = '$new_path' where `id` = '".$this->config['where_id']."';");
                }
            }

            if( $mysql && $file_moved ) 
            {
                return true;
            }
        } 
        else 
        {
            return false;
        }
    }
    // }}}
    // {{{ public function put_image_crop() 
    /*
     * For moving, resizing, renaming, and CROPPING photos and putting them into a database.
     */
    public function put_image_crop() 
    {
        //get some information about this thing...
        list($width,$height,$type) = getimagesize($this->config['temp_file']);
        $temp_type = image_type_to_mime_type($type);

        if( $temp_type == "image/pjpeg" || $temp_type == "image/jpeg" || $temp_type == "image/gif" || $temp_type == "image/png")
        {
            if( $this->config['resize_by'] == "width" )
            {
                if( $this->config['resize_to'] < $this->config['crop_w'] || $this->config['stretch'] )
                {
                    $new_height = intval(($this->config['crop_h']/$this->config['crop_w'])*$this->config['resize_to']);
                    $new_width = intval($this->config['resize_to']);
                } 
                else 
                {
                    $new_height = intval($this->config['crop_h']);
                    $new_width = intval($this->config['crop_w']);
                }
            } 
            else if ( $this->config['resize_by'] == "height" )
            {
                if( $this->config['resize_to'] < $this->config['crop_h'] || $this->config['stretch'] )
                {
                    $new_width = intval(($this->config['crop_w']/$this->config['crop_h'])*$this->config['resize_to']);
                    $new_height = intval($this->config['resize_to']);
                } 
                else 
                {
                    $new_height = intval($this->config['crop_h']);
                    $new_width = intval($this->config['crop_w']);
                }
            }
            //echo "c height - $this->config['crop_h'], c width $this->config['crop_w']";
            //rename if needed
            if( $this->config['new_name'] == "" )
            {
                $this->config['new_name'] = $this->config['temp_name'];
            }

            //create the image resource
            switch( $temp_type )
            {
                case "image/jpeg":
                    $temp_src = imagecreatefromjpeg($this->config['temp_file']);
                    break;
                case "image/gif":
                    $temp_src = imagecreatefromgif($this->config['temp_file']);
                    break;
                case "image/png":
                    $temp_src = imagecreatefrompng($this->config['temp_file']);
                    break;
            }

            $new_file = imagecreatetruecolor($new_width,$new_height);

            //this is the actual resizing right here
            imagecopyresampled($new_file,$temp_src,0,0,$this->config['crop_x'],$this->config['crop_y'],$new_width,$new_height,$this->config['crop_w'],$this->config['crop_h']);

            switch( $temp_type )
            {
                case ( "image/jpeg" || "image/pjpeg" ):
                    $new_location = $this->config['path'].$this->config['new_name'].".jpg";
                    $new_path = $this->config['new_name'].".jpg";
                    $file_moved = imagejpeg($new_file,$new_location,100);
                    break;
                case "image/gif":
                    $new_location = $this->config['path'].$this->config['new_name'].".gif";
                    $new_path = $this->config['new_name'].".gif";
                    $file_moved = imagegif($new_file,$new_location,100);
                    break;
                case "image/png":
                    $new_location = $this->config['path'].$this->config['new_name'].".png";
                    $new_path = $this->config['new_name'].".png";
                    $file_moved = imagepng($new_file,$new_location,100);
                    break;
            }

            //clean up the mess...
            imagedestroy($temp_src);
            imagedestroy($new_file);

            if( $this->config['table'] != "" && $this->config['where_id'] != "" && $this->config['column'] != "" && $this->config['column'] != "square" )
            {
                if ( $this->config['into_photo_table']) 
                {
                    $mysql = mysql_query("Update `".$this->config['table']."` set `".$this->config['column']."` = '$new_path', `".$this->config['column']."_width` = '$new_width', `".$this->config['column']."_height` = '$new_height' where `id` = '".$this->config['where_id']."';");
                } 
                else 
                { 
                    echo 'swag';
                    $mysql = mysql_query("Update `".$this->config['table']."` set `".$this->config['column']."` = '$new_path' where `id` = '".$this->config['where_id']."';");
                }
            } 
            else if ( $this->config['column'] == "square" ) 
            {
                if ($this->config['into_photo_table']) 
                {
                    $mysql = mysql_query("Update `".$this->config['table']."` set `".$this->config['column']."` = '$new_path', `".$this->config['column']."_width` = '$new_width' where `id` = '".$this->config['where_id']."';");
                } 
                else 
                { 
                    $mysql = mysql_query("Update `".$this->config['table']."` set `".$this->config['column']."` = '$new_path' where `id` = '".$this->config['where_id']."';");
                }
            }
            if($mysql && $file_moved) 
            {
                return true;
            }
        } 
        else 
        {
            return false;
        }
    }
    // }}}
    // {{{ public function configure_class( $data ) 
    public function configure_class( $data ) 
    { 	
        // If $data isn't an array then we don't have much to do.
        if ( ! is_array( $data ) ) return FALSE;

        $this->temp = $this->default_config();
        foreach ( array('temp_file', 'temp_name', 'resize_by', 'resize_to', 'where_id', 'table', 'column', 'path', 'into_photo_table', 'stretch', 'new_name', 'crop_x', 'crop_y', 'crop_w', 'crop_h') as $val ) 
        {
            if( ! isset ( $data[$val] ) ) 
            {
                $data[$val] = $this->temp[$val];
            }
        }
        $this->config = $data;	
    }
    // }}}
    // {{{ public function default_config() 
    public function default_config() 
    {
        return array (
            'resize_by' 		=> 'width',
            'resize_to' 		=> 620,
            'path' 				=> 'images/',
            'into_photo_table' 	=> false,
            'stretch'			=> false,
            'crop_x'			=> 0,
            'crop_y' 			=> 0,
            'crop_w'			=> 0,
            'crop_h'			=> 0
        );
    }
    // }}}
    // {{{ public function clear_config() 
    public function clear_config() 
    {
        $this->config = array();
    }
    // }}}
	
}
	
?>
