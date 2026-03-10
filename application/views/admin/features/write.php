<div id="main_content" class="clearfix">
    
    <? if($success) : ?>
    
    <? elseif($error) : ?>
    
    <?=validation_errors()?>
    
    <? elseif($warning) : ?>
    
    <div class="warning notice clearfix"></div>
    
    <? endif; ?>
    
   	<? if(!$success) : ?>
    
         <h2>Add <?=ucwords( $singular )?></h2>
        
         <? $attributes = array('name' => 'write', 'id' => 'write'); ?>

         <?=form_open( base_url(). $class . '/create', $attributes )?>

         <?
            $ttl_data = array( 'name' => 'title', 'id' => 'title', 'value' => '' );
            $link_data = array( 'name' => 'link', 'id' => 'link', 'value' => '' );
            $desc_data = array( 'name' => 'content', 'id' => 'content', 'value' => '' );
			
            $js = 'onClick="clear_me(this)"';
            
            $submit_js = 'onClick="submit_form(this); return false;"';
        ?>
        
        <label>Title</label>
        <?=form_input( $ttl_data, '', $js );?>

        <label>Link To</label>
        <?=form_input( $link_data, '', $js )?>

        <label>Description</label>
        <?=form_input( $desc_data, '', $js )?>

        <?=form_submit( 'submit', 'Continue', $submit_js )?>
        
        <?=form_close()?>
    
    <? endif; ?>

</div>
