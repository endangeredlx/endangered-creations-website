    <!-- BEGIN MAIN CONTENT -->
    <div id="main_content" class="clearfix">

            <? $attributes = array('name' => 'edit', 'id' => 'edit'); ?>

            <?=form_open( base_url(). $class . '/update_settings/', $attributes )?>

            <!-- BEGIN MAIN EDIT CONTENT -->
            <div id="edit_content" class="clearfix left">

                <? 
                    // Begin update messages.
                    if( $success ) : 
                ?>

                <div class="success notice clearfix">The site options were successfully edited.</div>
     
                <? elseif( $error ) : ?>
                 
                <?=validation_errors()?>
         
                <? elseif( $warning ) : ?>

                <div class="warning notice clearfix"></div>

                <? 
                    // End update messages.
                    endif; 

                    // Populate options.
                    $comment_captcha = option_value( 'comment_captcha' );
                    $captcha = array( '1' => 'Require captcha on comments.', '0' => 'No captcha.' );
                    $comment_approval = option_value( 'comment_approval' );
                    $approval = array( '1' => 'Approve all comments.', '0' => 'Let comments immediately post.' );
                ?>

                <h2>Edit Options</h2>

                <label class="longer">Require Captcha?<span>Crazy letters that stop spam</span></label>

                <?=form_dropdown( 'comment_captcha', $captcha, $comment_captcha, 'class="longer"' )?>            

                <label class="longer">Approve All Comments? </label>

                <?=form_dropdown( 'comment_approval', $approval, $comment_approval, 'class="longer"' )?>            
                
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
