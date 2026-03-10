    <!-- BEGIN MAIN CONTENT -->
    <div id="main_content" class="clearfix">

        <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>

            <? $attributes = array('name' => 'edit', 'id' => 'edit'); ?>

            <?=form_open( base_url(). $class . '/update/' . row_value('id') . '/' . row_value('name'), $attributes )?>

            <!-- BEGIN MAIN EDIT CONTENT -->
            <div id="edit_content" class="clearfix left">

                <? 
                    // Begin update messages.
                    if( $success ) : 
                ?>

                <div class="success notice clearfix">The <?=$singular?> was successfully edited.</div>
     
                <? elseif( $error ) : ?>
                 
                <?=validation_errors()?>
         
                <? elseif( $warning ) : ?>

                <div class="warning notice clearfix"></div>

                <? 
                    // End update messages.
                    endif; 
                ?>

                <h2><?=ucwords( $action )?> <?=ucwords( $singular )?></h2>

                <?=form_hidden( 'form_submitted', 'false', 'id="form_submitted"' )?>

                <?
                    $ttl_data = array( 'name' => 'title', 'id' => 'title', 'value' => title() );
                    $subttl_data = array( 'name' => 'subtitle', 'id' => 'subtitle', 'value' => subtitle() );
                    $facebook_data = array( 'name' => 'facebook', 'id' => 'facebook', 'value' => facebook() );
                    $twitter_data = array( 'name' => 'twitter', 'id' => 'twitter', 'value' => twitter() );
                    $myspace_data = array( 'name' => 'myspace', 'id' => 'myspace', 'value' => myspace() );
                    $content_data = array( 'name' => 'content', 'id' => 'content', 'class' => 'wysiwyg', 'value' => content() );
                    $clear_format = array( 'noclear' => 'nope, I\'m fine.', 'clear'	=> 'clear formatting.' );
                ?>

                <label>Name:</label>

                <?=form_input( $ttl_data );?>

                <label>Subtitle :</label>

                <?=form_input($subttl_data,'');?>

                <label>Facebook Link:</label>

                <?=form_input($facebook_data,'');?>

                <label>Twitter Link :</label>

                <?=form_input($twitter_data,'');?>

                <label>Myspace Link :</label>

                <?=form_input($myspace_data,'');?>

                <label>Body :</label>

                <?=form_textarea($content_data);?>

                <label>Clear Formatting?</label>
                <?=form_dropdown('format_check',$clear_format, 'noclear')?>

                <?=form_submit('submit', 'Save', 'id="form_submit"');?>

            </div>
            <!-- END MAIN EDIT CONTENT -->

            <!-- BEGIN SIDE CONTENT -->
            <div id="side_content" class="right">

                <? if( cookiedata('privilege') == 'superuser' ) :?>

                <? $st_options = array( 'published' => 'published', 'unpublished' => 'unpublished' ); ?>

                <label>Status:</label>
                <?=form_dropdown('status',$st_options, row_value('status') )?>

                <? endif; ?>

                <label>Media :</label>

                <? if( has_pic() ) : ?> 


                <div id="photo_info_holder" class="photo_info_holder"> 

                    <img src="<?=pic()?>" class="edit_image"  width="240"/>

                </div> 

                <a href="<?=base_url() . $class . '/add_photo/' . id()?>" id="photo_edit_button" class="button_link <?=( $action == 'create' ) ? 'create' : '' ?>">

                    <strong>Change Background Image</strong>

                </a>

                <a href="" onclick="return false;" id="delete_entry_photo" e_id="<?=id()?>" class="button_link <?=( $action == 'create' ) ? 'create' : '' ?>">

                    <strong>Delete Background Image</strong>

                </a>

                <? 
                    // If a picture is available for this page
                    else : 
                ?>

                <a href="<?=base_url() . $class . '/add_photo/' . id()?>" class="button_link <?=( $action == 'create' ) ? 'create' : '' ?>">

                    <strong>Add Background Image</strong>

                </a>

                <? endif; ?>

                <div class="divider"></div>

                <!-- BEGIN VIDEO AREA -->
                <!--
                <label>Video:</label>
                <span class="left block faded btm_marg clearfix">Paste the video link (not the embed code) and specify what type of video</span>
                -->
                <?
                    $vid_pre = array(
                        'vimeo'				=> 'http://www.vimeo.com/',
                        'youtube'			=> 'http://www.youtube.com/',
                        'worldstarhiphop'   => 'http://www.worldstarhiphop.com/videos/video.php?v=',
                        ''					=> 'Paste a video link.'
                    );
                ?>

                <? if( !has_video() ) : ?>
                
                <? elseif ( has_video() ) : ?>
                
                <?=video( 250, 200, 'ffffff' )?>

                <? endif; ?>

                <!-- VIDEO INPUT IS HIDDEN -->
                <?=form_hidden( array( 'name' => 'video', 'class' => 'small_input', 'id' => 'video_link' ), $vid_pre[ row_value('video_type') ] . row_value('video') );?>

                <? $vid_options = array( 'vimeo' => 'Vimeo', 'youtube' => 'YouTube', 'worldstarhiphop' => 'WorldStar' ); ?>

                <!--<?=form_dropdown('video_type', $vid_options, row_value('video_type') )?>-->

                <!-- END VIDEO AREA -->

                <? if( has_relative_music_playlist() ) : ?>

                <a href="<?=base_url() . 'music/edit_playlist/' . relative_music_playlist_id()?>" class="button_link <?=( $action == 'create' ) ? 'create' : '' ?>">

                    <strong>Edit Music Playlist</strong>

                </a>
                
                <? endif; ?>

                <? if( has_relative_photo_album() ) : ?>

                <a href="<?=base_url() . 'photos/edit_photos/' . relative_photo_album_id()?>" class="button_link <?=( $action == 'create' ) ? 'create' : '' ?>">

                    <strong>Edit Photo Album</strong>

                </a>
                
                <? endif; ?>

                <? if( has_relative_slideshow() ) : ?>

                <a href="<?=base_url() . 'photos/edit_photos/' . relative_slideshow_id()?>" class="button_link <?=( $action == 'create' ) ? 'create' : '' ?>">

                    <strong>Edit Top Banner</strong>

                </a>
                
                <? endif; ?>

            </div>

        </div>
        <!-- END MAIN CONTENT -->

        <?  endwhile; endif; ?>

        <?=form_close()?>

</div>
