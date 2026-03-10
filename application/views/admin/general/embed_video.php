    <div class="divider"></div>

    <!-- BEGIN VIDEO AREA -->

    <label>Video:</label>
    <span class="left block faded btm_marg clearfix">Paste the video link (not the embed code) and specify what type of video</span>

    <?
        $vid_pre = array(
            'vimeo'				=> 'http://www.vimeo.com/',
            'youtube'			=> 'http://www.youtube.com/',
            'worldstarhiphop'   => 'http://www.worldstarhiphop.com/videos/video.php?v=',
            ''					=> 'Paste a video link.'
        );
    ?>

    <?=video( 250, 200, 'ffffff' )?>

    <?=form_input( array( 'name' => 'video', 'class' => 'small_input', 'id' => 'video_link' ), $vid_pre[ row_value('video_type') ] . row_value('video') );?>

    <? $vid_options = array( 'vimeo' => 'Vimeo', 'youtube' => 'YouTube', 'worldstarhiphop' => 'WorldStar' ); ?>

    <?=form_dropdown('video_type', $vid_options, row_value('video_type') )?>

    <!-- END VIDEO AREA -->
