<div id="main_content" class="clearfix">

    <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
    
    <? $attributes = array('name' => 'edit', 'id' => 'edit'); ?>

    <?=form_open(base_url(). $class . '/update/' . id(), $attributes )?>

    <div id="edit_content" class="clearfix left">

        <? if($success) : ?>

        <div class="success notice clearfix">The Item was successfully edited.</div>

        <? elseif($error) : ?>

        <?=validation_errors()?>

        <? elseif($warning) : ?>

        <div class="warning notice clearfix"></div>

        <? endif; ?>

        <h2>Edit <?=ucwords( $singular )?></h2>

        <? 
            //Set up input configurations
            $ttl_data = array( 'name' => 'title', 'id' => 'title', 'value' => title() );
            $link_data = array( 'name' => 'url', 'id' => 'url', 'value' => row_value('url') );
            $content_data = array( 'name' => 'description', 'id' => 'content', 'value' => description() );
        ?>

        <label>Title</label>
        <?=form_input( $ttl_data, '' )?>

        <label>Link To</label>
        <?=form_input( $link_data, '' )?>

        <label>Description</label>
        <?=form_input( $content_data, '' );?>

        <?=form_submit('submit', 'Update');?>

    </div>

    <div id="side_content" class="right">

        <input type="hidden" name="status_was" value="<?=row_value('status')?>" />
        <input type="hidden" name="order_was" value="<?=row_value('order')?>" />

        <?
            $st_options = array(
                'published'  		=> 'published',
                'unpublished'    	=> 'unpublished'
            );
        ?>

        <label>Status:</label>
        <?=form_dropdown('status',$st_options, row_value('status'))?>

        <!--

        <label>Main Image:</label>

        <? if( has_pic() ) : ?>

        <div id="photo_info_holder" class="photo_info_holder"> 

            <img src="<?=pic()?>" class="edit_image"  width="240"/>

        </div> 

        <a href="<?=base_url() . $class . "/add_photo/" . id()?>" id="photo_edit_button" class="button_link">
            <strong>Change Main Photo</strong>
        </a>

        <? else : ?>

        <div id="photo_info_holder" class="photo_info_holder"> 
            <i>No Image.</i>
        </div>  

        <a href="<?=base_url() . $class . '/add_photo/' . id()?>" class="button_link">
            <strong>Add Photo</strong>
        </a>

        <? endif; ?>

        <div class="divider"></div>

        -->

    </div>

    <?=form_close()?>

    <?  endwhile; endif; ?>

</div>
