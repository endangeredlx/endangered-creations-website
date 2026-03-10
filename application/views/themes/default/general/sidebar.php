            <!--{{{ SECONDARY_AREA -->
            <div class="secondary_area <?=( $page_type != 'home' ) ? 'short' : '' ?>">
            <? if( $page_type == 'home' ) : ?> 
                <!--{{{ RECENT_VIDEOS -->
                <div class="secondary_title">
                    <div class="video_area_title">
                        <div class="video_area_text">Recent Videos</div>
                    </div>
                </div>
                <div id="recent_videos">
                    <ul>
                        <?=get_recent_cats( 'videos' )?>
                    </ul>
                </div>
                <!-- END_RECENT_VIDEOS }}}-->
                <!--{{{ VIDEO_AREA -->
                <div class="video_area">
                    <div class="video_area_title">
                        <div class="video_area_text"><?=$featured_videos->second_feature_video->title?></div>
                    </div>
                    <div class="video_area_media">
                        <?=create_video( $featured_videos->second_feature_video->video, 350, 246, 'ffffff' )?>
                    </div>
                </div>
                <!-- END_VIDEO_AREA }}}-->
                <!--{{{ VIDEO_AREA -->
                <div class="video_area">
                    <div class="video_area_title">
                        <div class="video_area_text"><?=$featured_videos->third_feature_video->title?></div>
                    </div>
                    <div class="video_area_media">
                        <?=create_video( $featured_videos->third_feature_video->video, 350, 246, 'ffffff' )?>
                    </div>
                </div>
                <!-- END_VIDEO_AREA }}}-->
                <? endif; ?>
                <!--{{{ ARCHIVES -->
                <div style="float:left;" class="secondary_title">
                    <div class="video_area_title">
                        <div class="video_area_text">Archives</div>
                    </div>
                </div>
                <div class="archives">
                    <ul>
                        <?=archives()?>
                    </ul>
                </div>
                <!-- END ARCHIVES }}}-->
            </div>
            <!-- END_SECONDARY_AREA }}} -->
