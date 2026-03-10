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

                <h2>Edit <?=$singular?></h2>

                <?
                    $ttl_data = array( 'name' => 'title', 'id' => 'title', 'value' => title() );
                    $content_data = array( 'name' => 'content', 'id' => 'content', 'class' => 'wysiwyg', 'value' => content() );
                    $clear_format = array( 'noclear' => 'nope, I\'m fine.', 'clear'	=> 'clear formatting.' );
                ?>

                <label>Title</label>

                <?=form_input($ttl_data,'');?>

                <label>Content</label>

                <?=form_textarea($content_data);?>

                <label>Clear Formatting?</label>
                <?=form_dropdown('format_check',$clear_format, 'noclear')?>

                <?=form_submit('submit', 'Update');?>

            </div>
            <!-- END MAIN EDIT CONTENT -->

            <!-- BEGIN SIDE CONTENT -->
            <div id="side_content" class="right">

                <? if( cookiedata('privilege') == 'superuser' ) :?>

                <? $st_options = array( 'published' => 'published', 'unpublished' => 'unpublished' ); ?>
                <label>Status:</label>
                <?=form_dropdown('status',$st_options, row_value('status') )?>

                <? endif; ?>

                <? 
                    // If a picture is available.
                    if( has_pic() ) : 
                ?> 

                <label>Main Image:</label>

                <div id="photo_info_holder" class="photo_info_holder"> 

                    <img src="<?=pic()?>" class="edit_image"  width="240"/>

                </div> 

                <a href="<?=base_url(). $class . "/add_photo/" . id()?>" id="photo_edit_button" class="button_link">

                    <strong>Change Main Photo</strong>

                </a>

                <a href="" onclick="return false;" id="delete_entry_photo" e_id="<?=id()?>" class="button_link">

                    <strong>Delete Main Photo</strong>

                </a>

                <? 
                    // If a picture is available for this page
                    else : 
                ?>

                <div id="photo_info_holder" class="photo_info_holder"> 

                    <i>No Image.</i>

                </div>  

                <a href="<?=base_url(). $class . "/add_photo/".id()?>" class="button_link">

                    <strong>Add Photo</strong>

                </a>

                <? endif; ?>

                <div class="divider"></div>

                <!-- BEGIN VIDEO AREA -->

                <!--<label>Video:</label>
                <span class="left block faded btm_marg clearfix">Paste the video link (not the embed code) and specify what type of video</span>

                <?
                    $vid_pre = array(
                        'vimeo'				=> 'http://www.vimeo.com/',
                        ''					=> 'Paste a video link.'
                    );
                ?>

                <? if( !has_video() ) : ?>
                
                <? elseif ( has_video() ) : ?>
                
                <?=video( 250, 200, 'ffffff' )?>

                <? endif; ?>

                <?=form_input( array( "name" => "video", "class" => "small_input", "id" => "video_link" ), row_value('video_type') . row_value('video') );?>

                <? $vid_options = array( 'vimeo' => 'Vimeo'); ?>

                <?=form_dropdown('video_type', $vid_options, row_value('video_type') )?>-->

                <!-- END VIDEO AREA -->

            </div>

        </div>
        <!-- END MAIN CONTENT -->


        <?  endwhile; endif; ?>

        <?=form_close()?>

</div>
