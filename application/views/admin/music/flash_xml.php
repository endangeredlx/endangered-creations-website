<?
    $xml = '<?xml version="1.0" encoding="utf-8" standalone="yes"?>';
    $xml .= '<content>';
    if( there_are_entries() ) : while( there_are_entries() ) : get_next(); 
        if( there_are_playlist_records() ) : while( there_are_playlist_records() ) : get_next_playlist_record(); 
        $pic = ( playlist_record_value( 'pic' ) != '' ) ? base_url() . 'images/music/' . playlist_record_value( 'pic' ) : base_url() . 'images/defaults/flash_music.jpg';  
        $xml .= '<mp3 Thumb="' . $pic . '" Title="' . playlist_record_value( 'artist' ) . ' - '. playlist_record_value( 'title' ) . '" Path="' . base_url() . 'music_files/' . playlist_record_value( 'file' ) . '" />';
        endwhile; endif;
    endwhile; endif;
    $xml .= '</content>';
    echo $xml;
?>
