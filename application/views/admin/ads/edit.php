    <!-- BEGIN MAIN CONTENT -->
    <div id="main_content" class="clearfix">

            <? $attributes = array('name' => 'edit', 'id' => 'edit'); ?>

            <?=form_open( base_url(). $class . '/update/', $attributes )?>

            <!-- BEGIN MAIN EDIT CONTENT -->
            <div id="edit_content" class="clearfix left">

                <? 
                    // Begin update messages.
                    if( $success ) : 
                ?>

                <div class="success notice clearfix">The site options were successfully was successfully edited.</div>
     
                <? elseif( $error ) : ?>
                 
                <?=validation_errors()?>
         
                <? elseif( $warning ) : ?>

                <div class="warning notice clearfix"></div>

                <? 
                    // End update messages.
                    endif; 

                    // Populate options.
                    $site_name = array( 'name' => 'site_name', 'id' => 'site_name', 'value' => option_value( 'site_name' ) );
                    $main_email = array( 'name' => 'main_email', 'id' => 'main_email', 'value' => option_value( 'main_email' ) );
                    $facebook_link = array( 'name' => 'facebook_link', 'id' => 'facebook_link', 'value' => option_value( 'facebook_link' ) );
                    $twitter_link = array( 'name' => 'twitter_link', 'id' => 'twitter_link', 'value' => option_value( 'twitter_link' ) );
                    $vimeo_link = array( 'name' => 'vimeo_link', 'id' => 'vimeo_link', 'value' => option_value( 'vimeo_link' ) );
                    $site_description = array( 'name' => 'site_description', 'id' => 'content', 'class' => 'small', 'value' => option_value( 'site_description' ) );
                ?>

                <h2>Edit Options</h2>

                <label class="longer">Site Name :</label>

                <?=form_input( $site_name, '' )?>

                <label class="longer">Main Email :</label>

                <?=form_input( $main_email, '' )?>
                
                <label class="longer">Facebook Link:</label>

                <?=form_input( $facebook_link, '' )?>

                <label class="longer">Twitter Link:</label>

                <?=form_input( $twitter_link, '' )?>

                <label class="longer">Vimeo Link:</label>

                <?=form_input( $vimeo_link, '' )?>

                <label class="longer">Site Description :</label>

                <?=form_textarea( $site_description );?>

                <?=form_submit( 'submit', 'Update' )?>

            </div>
            <!-- END MAIN EDIT CONTENT -->

            <!-- BEGIN SIDE CONTENT -->
            <div id="side_content" class="right">

            </div>
            <!-- END SIDE CONTENT -->

        </div>
        <!-- END MAIN CONTENT -->


        <?=form_close()?>

</div>
