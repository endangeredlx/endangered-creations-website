<div id="main_content" class="clearfix">
    
    <? if($success) : ?>
    
    <div class="success notice clearfix">This song was successfully created. Now go to the <b><?=anchor(base_url()."index.php?admin/edit_photo_album/".$this->db->insert_id(),"Edit Page");?></b> to add pictures or change details.</div>
    
    <div class="information notice clearfix">You can also <b><?=anchor(base_url()."index.php?admin/manage_photo_albums","manage other albums")?></b>.</div>
    
    <? elseif($error) : ?>
    
    <?=validation_errors()?>
    
    <? elseif($warning) : ?>
    
    <div class="warning notice clearfix"></div>
    
    <? endif; ?>
    
   	<? if(!$success) : ?>
    
        <h2>Photo Album Name</h2>
        
        <? $attributes = array('name' => 'write_photo_album', 'id' => 'write_photo_album'); ?>
        
        <?=form_open(base_url().'index.php?admin/create_photo_album',$attributes)?>
        
        <?
            $name_data = array(
              'name'        => 'title',
              'id'          => 'title',
              'value'       => ''
            );
		   
		    $content_data = array(
              'name'        => 'description',
              'id'          => 'content',
              'class'   	=> 'wysiwyg',
              'value'       => 'description'
            );
		   	
            $js = 'onClick="clear_me(this)"';
            
            $submit_js = 'onClick="submit_form(this); return false;"';
        ?>
        
        <label>Name of Album</label>
        
        <?=form_input($name_data,'',$js);?>
        
        <label>Content</label>
        
        <?=form_textarea($content_data);?>
        
        <?=form_submit('submit', 'Create Album',$submit_js);?>
        
        <?=form_close()?>
    
    <? endif; ?>

</div>