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
                    $content_data = array( 'name' => 'content', 'id' => 'content', 'class' => 'wysiwyg small', 'value' => content() );
                    $clear_format = array( 'noclear' => 'nope, I\'m fine.', 'clear'	=> 'clear formatting.' );
                ?>

                <label>Title :</label>

                <?=form_input( $ttl_data );?>

                <label>Description :</label>

                <?=form_textarea($content_data);?>

                <label>Clear Formatting?</label>
                <?=form_dropdown('format_check',$clear_format, 'noclear', 'id="format_check"')?>

                <div class="divider"></div>

                <label>Options :</label>
                
                <div class="add_option_container">
                    
                    <span class="option_caption">Add options this item to the right.</span>
                    
                    <div class="add_plus_blue" id="add_new_option"></div>

                    <input type="text" name="new_option" id="new_option" class="new_option" value="Add New Option..."/>

                </div>

                <!-- {{{ NEW OPTION CLONE -->                
                <div class="item_option_container" id="option_clone" style="display:none;">
                    <div class="remove_option">
                        <div class="remove_button closex" title="delete this option"></div>
                    </div>
                    <div class="item_option_editors">
                        <label></label>
                        <input type="text" name="option_0" id="0" class="item_option" value="{option_name}"/>
                        <label>choices : <a class="add_more_choices">add more choices</a></label>
                    </div>
                </div>
                <!-- END NEW OPTION CLONE }}} -->                

                <? if( there_are_item_options() ) : while( there_are_item_options() ) : get_item_options()  ?>

                <div class="item_option_container" id="option_<?=option_position()?>">

                    <div class="remove_option">
                        <div class="remove_button closex" title="delete this option"></div>
                    </div>

                    <div class="item_option_editors">

                        <label><?=ordinal( option_position() )?> Option : </label>

                        <input type="text" name="option_<?=option_id()?>" id="<?=option_id()?>" class="item_option" value="<?=option_label()?>"/>
                        
                        <label>choices : <a class="add_more_choices">add more choices</a></label>
                        
                        <? while( there_are_option_values() ) : get_option_values(); ?>
                        <div class="item_option_value" >
                            <span><?=option_value_name()?></span>
                            <div class="remove_item closex" title="delete choice"></div>
                        </div>
                        <? endwhile; ?>

                    </div>

                </div>
                
                <? endwhile; endif; ?>

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

                <?  $price_data = array( 'name' => 'price', 'id' => 'price', 'value' => price() ); ?>

                <label>Price :</label>

                <?=form_input( $price_data );?>

                <label>Media :</label>

                <? if( has_pic() ) : ?> 


                <div id="photo_info_holder" class="photo_info_holder"> 

                    <img src="<?=pic()?>" class="edit_image"  width="240"/>

                </div> 

                <a href="<?=base_url() . $class . '/add_photo/' . id()?>" id="photo_edit_button" class="button_link_blue">

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

            </div>

        </div>
        <!-- END MAIN CONTENT -->

        <?  endwhile; endif; ?>

        <?=form_close()?>

</div>
