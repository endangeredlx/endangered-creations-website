<div id="main_content" class="clearfix">

<? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>

    <? $attributes = array('name' => 'edit', 'id' => 'edit'); ?>

    <?=form_open(base_url(). $class . '/update/' . id(), $attributes )?>

    <!-- {{{ BEGIN EDIT CONTENT -->
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
            $desc_data = array( 'name' => 'description', 'id' => 'description', 'value' => description() );
            $file_data = array( 'name' => 'file', 'id' => 'file', 'value' => filename() );
        ?>

        <label>Title</label>
        <?=form_input( $ttl_data, '' )?>

        <label>Description</label>
        <?=form_input( $desc_data, '' );?>

        <label>Filename </label>
        <?=form_input( $file_data, '' );?>

        <?=form_submit('submit', 'Update');?>

    </div>
    <!-- END EDIT CONTENT }}}-->
    <!-- {{{ BEGIN SIDE CONTENT -->
    <div id="side_content" class="right">

        <input type="hidden" name="status_was" value="<?=status()?>" />
        <input type="hidden" name="order_was" value="<?=order()?>" />

        <?
            $st_options = array(
                'published'  		=> 'published',
                'unpublished'    	=> 'unpublished'
            );
        ?>

        <label>Status:</label>
        <?=form_dropdown( 'status', $st_options, status() )?>

        <label>Main File:</label>

        <? if( filename() != "" ) : ?>

        <a href="<?=base_url() . 'dls/' . filename()?>" id="photo_edit_button" class="button_link">
            <strong>Download File</strong>
        </a>

        <? else : ?>

        <div id="photo_info_holder" class="photo_info_holder"> 
            <i>No File.</i>
        </div>  

        <? endif; ?>

        <div class="divider"></div>

        <? if( has_pic() ) : ?>

        <div id="photo_info_holder" class="photo_info_holder"> 
            <img src="<?=pic()?>"  />
        </div>

        <a href="<?=base_url() . $class . '/add_photo/' . id()?>" id="photo_edit_button" class="button_link">
            <strong>Change Image</strong>
        </a>

        <? else : ?>

        <div id="photo_info_holder" class="photo_info_holder"> 
            <i>No Image.</i>
        </div>  

        <a href="<?=base_url() . $class . '/add_photo/'. id() ?>" class="button_link">
            <strong>Add Image</strong>
        </a>

        <? endif; ?>

        <div class="divider"></div>

    </div>
    <!-- END SIDE CONTENT }}} -->

    <?=form_close()?>

    <? endwhile; endif; ?>

</div>
