<div id="main_content" class="clearfix">


    <div class="tabbed_links">

        <a href="<?=base_url() . $this->class . '/edit_photos/' . album_id()?>" >Captions/Album Cover</a> 

        <a href="<?=base_url() . $this->class . '/edit_order/' . album_id()?>" class="active">Photo Order</a>

        <a href="<?=base_url() . $this->class . '/edit/' . album_id()?>">Edit Album Info</a> 

        <div id="results" style="">
            <div style="display:none;" class="saving">Saving photo order. Please wait...</div>
            <div style="display:none;" class="saved">Photo order saved!</div>
        </div>

    </div>

    <div class="tabbed">

        <div id="photo_area">

            <? $pos=1;?>

            <? if( there_are_photos() ) : while( there_are_photos() ) : get_photo(); ?>

            <div id="<?=$pos?>" pid="<?=id()?>" aid="<?=album_id()?>" class="photo_edit_row_order grey_bg clearfix">

                <div style="background-image:url(<?=base_url()?>images/photos/<?=small_photo()?>);"><img src="<?=base_url()?>application/views/admin/images/drag.png" /></div>
                
            </div>

            <? $pos++; ?>

            <? endwhile;  endif; ?>

        </div>

    </div>

</div>
