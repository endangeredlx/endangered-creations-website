    <!-- BEGIN MAIN CONTENT -->
    <div id="main_content" class="clearfix">

        <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>

            <?
                $ttl_data = array( 'name' => 'title', 'id' => 'title', 'value' => title() );
                $desc_data = array( 'name' => 'description', 'id' => 'content', 'class' => 'wysiwyg', 'value' => description() );
                $clear_format = array( 'noclear' => 'nope, I\'m fine.', 'clear'	=> 'clear formatting.' );
            ?>

            <? $attributes = array('name' => 'edit', 'id' => 'edit'); ?>

            <?=form_open( base_url() . $class . '/update/' . row_value('id'), $attributes )?>

            <div class="tabbed_links">

                <a href="<?=base_url() . $this->class . '/edit_photos/' . album_id()?>" >Captions/Album Cover</a> 

                <a href="<?=base_url() . $this->class . '/edit_order/' . album_id()?>">Photo Order</a>

                <a href="<?=base_url() . $this->class . '/edit/' . album_id()?>" class="active">Edit Album Info</a> 

            </div>

            <div class="tabbed">
            <!-- BEGIN MAIN EDIT CONTENT -->
            <div id="edit_content" class="clearfix left">

                <? if( !is_relative() ) : ?>

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


                <label>Title :</label>

                <?=form_input( $ttl_data, '' )?>

                <label>Description :</label>

                <?=form_textarea( $desc_data )?>

                <label>Clear Formatting?</label>
                <?=form_dropdown( 'format_check', $clear_format, 'noclear' )?>

                <?=form_submit( 'submit', 'Update' )?>

                <? else : ?>

                <div class="grey_edit_block">

                This album is associated with another record. The Description and title cannont be edited.

                </div>

                <? endif; ?>

            </div>
            <!-- END MAIN EDIT CONTENT -->

            <!-- BEGIN SIDE CONTENT -->
            <div id="side_content" class="right">

                <? $st_options = array( 'published' => 'published', 'unpublished' => 'unpublished' ); ?>

                <label>Status:</label>
                <?=form_dropdown('status',$st_options, row_value('status') )?>

                <div class="divider"></div>

                <label>Album Cover :</label>

                <? if( has_album_cover() ) : ?> 

                <div id="photo_info_holder" class="photo_info_holder"> 

                    <img src="<?=base_url() . 'images/photos/' . small_photo()?>" class="edit_image"  width="240"/>

                </div> 

                <? elseif( row_value('size') == 0 ) : ?>

                <span class="left faded small">No photos uploaded yet.</span>

                <? else : ?>

                <span class="left faded small">You can choose an album cover by clicking the button below.</span>

                <? endif; ?>

                <div class="divider"></div>

                <a href="<?=base_url() . $class . '/add_photos/' . id()?>" id="photo_edit_button" class="button_link">

                    <strong>Add Photos</strong>

                </a>

                <a href="<?=base_url() . $class . '/edit_photos/' . id()?>" class="button_link">
                    <strong> Re-Order, Add Captions, or Delete </strong>
                </a>

            </div>

        </div>
        <!-- END EDIT CONTENT -->
        </div>

        <?  endwhile; endif; ?>

        <?=form_close()?>

</div>
