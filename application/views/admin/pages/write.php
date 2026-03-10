<div id="main_content" class="clearfix">

    <? if( $success ) : ?>

    <? elseif( $error ) : ?>

    <?=validation_errors()?>

    <? elseif( $warning ) : ?>

    <div class="warning notice clearfix"></div>

    <? endif; ?>

    <? if( !$success ) : ?>

    <h2>Make New Page</h2>

    <? $attributes = array( 'name' => 'write', 'id' => 'write' ); ?>

    <?=form_open( base_url() . $class . '/create', $attributes )?>

    <?
        $name_data = array( 'name' => 'title', 'id' => 'title', 'value' => ''); 
        $content_data = array( 'name' => 'description', 'id' => 'content', 'class' => 'wysiwyg', 'value' => 'description');
        $js = 'onClick="clear_me(this)"';
        $submit_js = 'onClick="submit_form(this); return false;"';
    ?>

    <label>Page Name</label>

    <?=form_input( $name_data, '', $js );?>

    <label>Content</label>

    <?=form_textarea( $content_data );?>

    <?=form_submit( 'submit', 'Create Page', $submit_js )?>

    <?=form_close()?>

    <? endif; ?>

</div>
