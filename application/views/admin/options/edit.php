    <!-- BEGIN MAIN CONTENT -->
    <div id="main_content" class="clearfix">

            <? $attributes = array('name' => 'edit', 'id' => 'edit'); ?>

            <?=form_open( base_url(). $class . '/update/', $attributes )?>

            <!-- BEGIN MAIN EDIT CONTENT -->
            <div id="edit_content" class="clearfix left">

                <? 
                    // Begin update messages.
                    if( $success ) : 
                ?>

                <div class="success notice clearfix">The site options were successfully was successfully edited.</div>
     
                <? elseif( $error ) : ?>
                 
                <?=validation_errors()?>
         
                <? elseif( $warning ) : ?>

                <div class="warning notice clearfix"></div>

                <? 
                    // End update messages.
                    endif; 

                    // Populate options.
                    $site_name              = array( 'name' => 'site_name', 'id' => 'site_name', 'value' => option_value( 'site_name' ) );
                    $main_email             = array( 'name' => 'main_email', 'id' => 'main_email', 'value' => option_value( 'main_email' ) );
                    $facebook_link          = array( 'name' => 'facebook_link', 'id' => 'facebook_link', 'value' => option_value( 'facebook_link' ) );
                    $twitter_link           = array( 'name' => 'twitter_link', 'id' => 'twitter_link', 'value' => option_value( 'twitter_link' ) );
                    $vimeo_link             = array( 'name' => 'vimeo_link', 'id' => 'vimeo_link', 'value' => option_value( 'vimeo_link' ) );
                    $site_description       = array( 'name' => 'site_description', 'id' => 'content', 'class' => 'small', 'value' => option_value( 'site_description' ) );
                    $google_ad_300x250      = array( 'name' => 'google_ad_300x250', 'id' => 'content', 'class' => 'small', 'value' => option_value( 'google_ad_300x250' ) );
                    $google_ad_728x90       = array( 'name' => 'google_ad_728x90', 'id' => 'content', 'class' => 'small', 'value' => option_value( 'google_ad_728x90' ) );
                    // Featured videos
                    $fv = get_featured_videos();
                    $main_feature_video             = array( 'name' => 'main_feature_video', 'id' => 'main_feature_video', 'value' => $fv->main_feature_video->video );
                    $main_feature_video_title       = array( 'name' => 'main_feature_video_title', 'id' => 'main_feature_video_title', 'value' => $fv->main_feature_video->title );
                    $second_feature_video           = array( 'name' => 'second_feature_video', 'id' => 'second_feature_video', 'value' => $fv->second_feature_video->video );
                    $second_feature_video_title     = array( 'name' => 'second_feature_video_title', 'id' => 'second_feature_video_title', 'value' => $fv->second_feature_video->title );
                    $third_feature_video            = array( 'name' => 'third_feature_video', 'id' => 'third_feature_video', 'value' => $fv->third_feature_video->video );
                    $third_feature_video_title      = array( 'name' => 'third_feature_video_title', 'id' => 'third_feature_video_title', 'value' => $fv->third_feature_video->title );
                        

                ?>

                <h2>Edit Options</h2>

                <label class="longer">Site Name :<span>Title of the site</span></label>

                <?=form_input( $site_name, '' )?>

                <label class="longer">Main Email :<span>Where to send contact emails.</span></label>

                <?=form_input( $main_email, '' )?>
                
                <label class="longer">Facebook Link:</label>

                <?=form_input( $facebook_link, '' )?>

                <label class="longer">Twitter Link:</label>

                <?=form_input( $twitter_link, '' )?>

                <label class="longer">Vimeo Link:</label>

                <?=form_input( $vimeo_link, '' )?>

                <fieldset>

                <label class="longer">Featured Title:</label>

                <?=form_input( $main_feature_video_title, '' )?>

                <label class="longer">Featured Video:<span>youtube, vimeo, or worldstar</span></label>

                <?=form_input( $main_feature_video, '' )?>

                <label class="longer">Second Title:</label>

                <?=form_input( $second_feature_video_title, '' )?>

                <label class="longer">Second Video:<span>youtube, vimeo, or worldstar</span></label>

                <?=form_input( $second_feature_video, '' )?>

                <label class="longer">Third Title:</label>

                <?=form_input( $third_feature_video_title, '' )?>

                <label class="longer">Third Video:<span>youtube, vimeo, or worldstar</span></label>

                <?=form_input( $third_feature_video, '' )?>


                </fieldset>

                <label class="longer">Site Description :<span>For metadata and the RSS feed.</span></label>

                <?=form_textarea( $site_description );?>

                <!--
                <label class="longer">Google Ad 300x250:</label>

                <?=form_textarea( $google_ad_300x250 );?>

                <label class="longer">Google Ad 728x90:</label>

                <?=form_textarea( $google_ad_728x90 );?>
                -->

                <?=form_submit( 'submit', 'Update' )?>

            </div>
            <!-- END MAIN EDIT CONTENT -->

            <!-- BEGIN SIDE CONTENT -->
            <div id="side_content" class="right">

            </div>
            <!-- END SIDE CONTENT -->

        </div>
        <!-- END MAIN CONTENT -->


        <?=form_close()?>

</div>
