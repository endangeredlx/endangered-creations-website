<div id="main_content" class="clearfix">
    
    <? if($success) : ?>
    
    <div class="success notice clearfix">Your item was successfully created. Now go to the <b><?=anchor(base_url(). $class . "/edit/" . $this->db->insert_id(),"Edit Page");?></b> to add pictures, videos, etc</div>
    
    <div class="information notice clearfix">You can also <b><?=anchor(base_url(). $class . "/manage","manage other entries")?></b>.</div>
    
    <? elseif($error) : ?>
    
    <?=validation_errors()?>
    
    <? elseif($warning) : ?>
    
    <div class="warning notice clearfix"></div>
    
    <? endif; ?>
    
   	<? if(!$success) : ?>
    
        <h2>Add New Entry</h2>
        
        <? $attributes = array('name' => 'write', 'id' => 'write'); ?>
        
        <?=form_open( base_url(). $class . '/create', $attributes )?>
        
        <?
            $ttl_data = array(
              'name'        => 'title',
              'id'          => 'title',
              'value'       => 'Title'
            );
			
            $js = 'onClick="clear_me(this)"';
            
            $submit_js = 'onClick="submit_form(this); return false;"';
        ?>
        
        <label>Song Title</label>
        
        <?=form_input($ttl_data,'',$js);?>

        <?=form_submit( 'submit', 'Continue', $submit_js );?>
        
        <?=form_close()?>
    
    <? endif; ?>

</div>
