<div id="main_content" class="clearfix">

	<? $attributes = array('name' => 'edit_photo_album', 'id' => 'edit_photo_album'); ?>
            
    <?=form_open(base_url().'index.php?admin/update_photo_album/'.$id,$attributes)?>
    
	<div id="edit_content" class="clearfix left">
    
		<? if($success) : ?>
        
        <div class="success notice clearfix">The album was successfully edited.</div>
        
        <? elseif($error) : ?>
        
        <?=validation_errors()?>
        
        <? elseif($warning) : ?>
        
        <div class="warning notice clearfix"></div>
        
        <? endif; ?>
        
        <h2>Edit Photo Album</h2>
        
        <? if(isset($record)) : foreach ($record->result() as $row) : ?>
            
             <?
				$name_data = array(
				  'name'        => 'title',
				  'id'          => 'title',
				  'value'       => $row->title
				);
				
				$description_data = array(
				  'name'        => 'description',
				  'id'          => 'content',
				  'class'   	=> 'wysiwyg',
				  'value'       => $row->description
				);
				
				$year_options = array();
				
				$today = getdate();
				
				for($i = 0; $i < 11; $i++)
				{
					$year = getdate( mktime( 0, 0, 0, 1, 3, ( $today['year'] - $i ) ) );
					
					$year_options[$year[0]] = $year['year'];
				}
				
				$js = 'onClick="clear_me(this)"';
				
				$submit_js = 'onClick="submit_form(this); return false;"';
			?>
            
            <label>Album Name</label>
        
			<?=form_input($name_data,'',$js);?>
            
            <label>Year:</label>
            
			<?=form_dropdown('date' , $year_options, mktime(0,0,0,1,3,date("Y", $row->date)) )?>
            
            <label>Description:</label>
            
            <?=form_textarea($description_data);?>
            
            <?=form_submit('submit', 'Update Album',$submit_js);?>
        
    </div>
    
    <div id="side_content" class="right">
    
    	<?
		
			$st_options = array(
			  'published'  		=> 'published',
			  'unpublished'    	=> 'unpublished'
			);
		
		?>
        
        <? if( $this->session->userdata('privilege') != "writer" ) : ?>
        
        <label>Status:</label>
            
		<?=form_dropdown('status',$st_options, $row->status)?>
        
        <? endif; ?>
        
        <label>Album Cover:</label>
        
        <? if($row->small != "") : ?>
        
        <img src="<?=base_url()."images/".$row->small?>" class="edit_image"  />
        
        <? else : ?>
        
        You can choose an album cover by clicking the button below.
        
        <? endif; ?>
        
        <label>Edit Photos:</label>
        
        <a href="<?=base_url()."index.php?admin/edit_album_photos/".$id?>" class="button_link">
        	Re-Order, Add Captions, or Delete
        </a>
    
    	<label>Upload:</label>
        
        <a href="<?=base_url()."index.php?admin/add_pics_album/".$id?>" class="button_link">
        	Add New Photos
        </a>
    
    </div>

	<?=form_close()?>
    
    <? endforeach; endif; ?>
    
</div>