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
            $email_data = array( 'name' => 'email', 'id' => 'email', 'value' => row_value( 'email' ) );
        ?>

        <label>Email</label>
        <?=form_input( $email_data, '' )?>

        <?=form_submit('submit', 'Update');?>

    </div>

    <div id="side_content" class="right">
    </div>

    <?=form_close()?>

    <?  endwhile; endif; ?>

</div>
