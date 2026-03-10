<div id="main_content" class="clearfix">

    <?  if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
    <? $attributes = array('name' => 'edit', 'id' => 'edit'); ?>

    <?=form_open(base_url(). $class . '/update_song/' . id(), $attributes )?>

    <div id="edit_content" class="clearfix left">

        <? if($success) : ?>

        <div class="success notice clearfix">The Item was successfully edited.</div>

        <? elseif($error) : ?>

        <?=validation_errors()?>

        <? elseif($warning) : ?>

        <div class="warning notice clearfix"></div>

        <? endif; ?>

        <h2>Edit <?=ucwords($singular)?><span><?=filename(100)?></h2>

        <? 
            //Set configure inputs 
            $ttl_data = array( 'name' => 'title', 'id' => 'title', 'value' => title() );
            $art_data = array( 'name' => 'artist', 'id' => 'artist', 'value' => artist() );
        ?>

        <label>Title</label>
        <?=form_input( $ttl_data, '' )?>

        <label>Artist</label>
        <?=form_input( $art_data, '' )?>

        <?=form_submit( 'submit', 'Update' )?>

    </div>
    <div id="side_content">


        <? if( filename() != "" ) : ?>

        <label>Preview Music:</label>

        <object type="application/x-shockwave-flash" data="<?=base_url()?>application/views/admin/library/js/audioplayer/player.swf" id="audioplayer1" height="24" width="240">
            <param name="movie" value="<?=base_url()?>js/audioplayer/player.swf">
            <param name="FlashVars" value="playerID=audioplayer1&soundFile=<?=base_url()?>music_files/<?=filename()?>&titles=<?=title()?>&artists=<?=artist()?>&left=0291c0&leftbg=0291c0&volslider=2d2f2d&bg=a5dcee&rightbg=0291c0&righticon=2f2d2f&lefticon=2f2d2f&rightbghover=01a8df&loader=086482">
            <param name="quality" value="high">
            <param name="menu" value="false">
            <param name="wmode" value="transparent">
        </object> 

        <? endif; ?>

        <? if( !has_pic() ) : ?>

        <label>Add Cover Art:</label> 
        <a href="<?=base_url() . $class ?>/add_photo/<?=id()?>" class="button_link">Add <strong>Cover Art</strong></a>

        <? else : ?>

        <div id="photo_info_holder" class="photo_info_holder"> 
        <img src="<?=pic()?>" class="edit_image"  />
        </div> 

        <label>Change Cover Art:</label> 
        <a href="<?=base_url() . $class ?>/add_photo/<?=id()?>" class="button_link">Change <strong>Cover Art</strong></a>

        <? endif; ?>
    </div>

    <?=form_close()?>

    <?  endwhile; endif; ?>

</div>
