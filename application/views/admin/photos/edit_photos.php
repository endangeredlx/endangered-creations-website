<div id="main_content" class="clearfix">

	<? if( $success ) : ?>
    
    <div class="notice success">The photos have been successfully edited.</div>
    
    <? endif; ?>

    <div class="tabbed_links">

        <a href="<?=base_url() . $this->class . '/edit_photos/' . album_id()?>" class="active">Captions/Album Cover</a> 

        <a href="<?=base_url() . $this->class . '/edit_order/' . album_id()?>">Photo Order</a>

        <a href="<?=base_url() . $this->class . '/edit/' . album_id()?>">Edit Album Info</a> 

    </div>
    
    <div class="tabbed">

        <!-- PHOTO AREA -->
        <div id="photo_area">
        
            <? $attributes = array( 'name' => 'edit_album_photos', 'id' => 'edit_album_photos' ); ?>
                    
            <?=form_open( base_url() . $this->class . '/update_photos/' . album_id(), $attributes )?>
            
            <? $style_toggle = 0; $pos=0;?>
            <!-- {{{ PHOTO LOOP --> 
            <? if( there_are_photos() ) : while( there_are_photos() ) : get_photo(); ?>
            
            <? 
                $style_toggle++; $pos++; $current_style = ( $style_toggle % 2 == 0 ) ? 'white_bg' : 'grey_bg'; 
            
                $description_data = array(
                    'name'      => 'description_' . id(),
                    'class'     => 'photo_edit_ta',
                    'value'     => description()
                );

                $album_cover_style = ( small_photo() == album_small_photo() ) ? 'album_cover' : '';
                
            ?>
            
                <div id="<?=$pos?>" pid="<?=id()?>" aid="<?=album_id()?>" class="photo_edit_row <?=$album_cover_style?> <?=$current_style?> clearfix is_image" style="width:770px; padding-right:30px;">
            
                    <img src="<?=base_url()?>images/photos/<?=small_photo()?>" class="pop_up_full">
                    
                    <div id="<?=id()?>" class="photo_edit_edit clearfix right">
                    
                        <label>edit</label>
                        
                        <div class="delete_photo left" title="delete photo"></div>
                        
                        <div class="make_album_cover left" title="make album cover"></div>
                    
                    </div>
                    
                    <div class="photo_single_info left" style="margin-right:10px;">
                    
                        <label>caption</label>
                        
                        <?=form_textarea($description_data)?>
                        
                    </div>
                    
                </div>
            
            <? endwhile;?>
            <!-- }}} --> 
            <?=form_submit('submit', 'Update Photos')?>

            <? else : ?>

            <div class="no_records">There are no photos. <a href="<?=base_url() . $this->class . '/add_photos/' . album_id()?>">Add some.</a></div>
            
            <? endif;?>
            
            <?=form_close()?>
        
        </div>
        <!-- END PHOTO AREA -->
    </div>

</div>
