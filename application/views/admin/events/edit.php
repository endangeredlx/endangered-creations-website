    <!-- BEGIN MAIN CONTENT -->
    <div id="main_content" class="clearfix">

    <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>

        <? $attributes = array('name' => 'edit', 'id' => 'edit'); ?>

        <?=form_open( base_url(). $class . '/update/' . row_value('id') . '/' . row_value('name'), $attributes )?>

        <!-- {{{ MAIN EDIT CONTENT -->
        <div id="edit_content" class="clearfix left">

            <!-- {{{ FEEDBACK AREA -->

            <?  if( $success ) : ?>

            <div class="success notice clearfix">The <?=$singular?> was successfully edited.</div>
 
            <? elseif( $error ) : ?>
             
            <?=validation_errors()?>
     
            <? elseif( $warning ) : ?>

            <div class="warning notice clearfix"></div>

            <?  endif; ?> 

            <!-- END FEEDBACK AREA }}} -->
            <?  
                // {{{ DATA SETUP
                $ttl_data = array( 'name' => 'title', 'id' => 'title', 'value' => title() );
                $venue_data = array( 'name' => 'venue', 'id' => 'venue', 'value' => row_value('venue') );
                $address_data = array( 'name' => 'address', 'id' => 'address', 'value' => row_value('address') );
                $time_dropdown = array();
                for( $i = 0; $i < 1420; $i = $i + 30)
                {
                    $time_dropdown[ $i ] = date( 'g:i a', ( ( $i * 60 ) + 25200 ) );
                }
                $date = date('m/d/Y', unix_time() );
                $time = ( ( unix_time() % 86400 ) / 60 ) - 420;
                // }}}
            ?>
            <!-- {{{ MAIN INPUTS -->
            <h2>Edit <?=ucwords( $singular )?></h2>

            <label>Title</label>
            <?=form_input( $ttl_data, '' )?>

            <label>Venue</label>
            <?=form_input( $venue_data, '' )?>

            <label>Address</label>
            <?=form_input( $address_data, '' )?>

            <label>Date</label>

            <input type="text" class="small_input" name="date" value="<?=$date?>" />

            <?=form_dropdown( 'time', $time_dropdown, $time )?>

            <?=form_submit('submit', 'Update');?>
            <!-- END MAIN INPUTS }}} -->

        </div>
        <!-- END MAIN EDIT CONTENT }}} -->

        <!-- {{{ SIDE CONTENT -->
        <div id="side_content" class="right">

            <? if( cookiedata('privilege') == 'superuser' ) :?>

            <? $st_options = array( 'published' => 'published', 'unpublished' => 'unpublished' ); ?>

            <label>Status:</label>
            <?=form_dropdown('status',$st_options, row_value('status') )?>

            <? endif; ?>

            <!-- {{{ PHOTO AREA -->

            <label>Media :</label>

            <? if( has_pic() ) : ?> 


            <div id="photo_info_holder" class="photo_info_holder"> 

                <img src="<?=pic()?>" class="edit_image"  width="240"/>

            </div> 

            <a href="<?=base_url() . $class . '/add_photo/' . id()?>" id="photo_edit_button" class="button_link">

                <strong>Change Main Photo</strong>

            </a>

            <a href="" onclick="return false;" id="delete_entry_photo" e_id="<?=id()?>" class="button_link">

                <strong>Delete Main Photo</strong>

            </a>

            <? 
                // If a picture is available for this page
                else : 
            ?>

            <a href="<?=base_url() . $class . '/add_photo/' . id()?>" class="button_link">

                <strong>Add Photo</strong>

            </a>

            <? endif; ?>

            <!-- END PHOTO AREA }}} -->

            <div class="divider"></div>

            <!-- {{{ VIDEO AREA -->

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

            <? if( !has_video() ) : ?>
            
            <? elseif ( has_video() ) : ?>
            
            <?=video( 250, 200, 'ffffff' )?>

            <? endif; ?>

            <?=form_input( array( 'name' => 'video', 'class' => 'small_input', 'id' => 'video_link' ), $vid_pre[ row_value('video_type') ] . row_value('video') );?>

            <? $vid_options = array( 'vimeo' => 'Vimeo', 'youtube' => 'YouTube', 'worldstarhiphop' => 'WorldStar' ); ?>

            <?=form_dropdown('video_type', $vid_options, row_value('video_type') )?>

            <!-- END VIDEO AREA }}} -->

        </div>

        <!-- END SIDE CONTENT }}} -->

    <?=form_close()?>

    <?  endwhile; endif; ?>

    </div>
    <!-- END MAIN CONTENT -->

