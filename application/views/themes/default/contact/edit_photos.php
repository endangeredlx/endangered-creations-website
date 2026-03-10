<div id="main_content" class="clearfix">

	<? if($success) : ?>
    
    <div class="notice success">The photos have been successfully edited.</div>
    
    <? endif; ?>
    
    <div class="notice information">You can set the album cover by clicking the <b>green plus sign</b> to the right of each picture.</div>

	<h2>Edit Photos</h2>
    
    <div class="mini_menu"><a href="<?=base_url().'index.php?admin/edit_album_photos_order/'.$id?>">CHANGE PHOTO ORDER</a><a href="<?=base_url().'index.php?admin/edit_photo_album/'.$id?>">BACK TO ALBUM EDIT</a> <b><?=$records->num_rows()?> PHOTOS</b></div>
    
    <div id="photo_area">
    
		<? $attributes = array('name' => 'edit_album_photos', 'id' => 'edit_album_photos'); ?>
                
        <?=form_open(base_url().'index.php?admin/update_album_photos/'.$id,$attributes)?>
        
        <? $style_toggle = 0; $pos=1;?>
        
        <? if(isset($records)) : foreach ($records->result() as $row) : ?>
        
        	<? 
				$current_style = ($style_toggle % 2 == 0)?"white_bg":"grey_bg"; 
            
            	$description_data = array(
				  'name'        => 'description_'.$row->id,
				  'class'   	=> 'wysiwyg photo_edit_ta',
				  'value'       => $row->description
				);
				
				$album_cover_style = ( $row->small == $album->small ) ? "album_cover" : "";
				
			?>
        
        	<div id="<?=$pos?>" pid="<?=$row->id?>" aid="<?=$id?>" class="photo_edit_row <?=$album_cover_style?> <?=$current_style?> clearfix is_image" style="width:770px; padding-right:30px;">
        
        		<img src="../images/<?=$row->small?>" class="pop_up_full">
                
                <div id="<?=$id?>" class="photo_edit_edit clearfix right">
                
                	<label>edit</label>
                    
                    <div class="delete_photo" title="delete photo"></div>
                    
                    <div class="make_album_cover" title="make album cover"></div>
                
                </div>
                
                <div class="right" style="margin-right:10px;">
                
                	<label>caption</label>
                    
                	<?=form_textarea($description_data)?>
                    
                </div>
                
            </div>
        
        <? $style_toggle++; $pos++; ?>
        
        <? endforeach;?>
        
        <?=form_submit('submit', 'Update Photos');?>
        
        <? endif;?>
        
        <?=form_close()?>
    
    </div>

</div>