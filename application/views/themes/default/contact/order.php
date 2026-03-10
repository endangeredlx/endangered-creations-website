<div id="main_content" class="clearfix">

	<h2>Edit Photo Order</h2>
    
    <div class="mini_menu"><a href="<?=base_url().'index.php?admin/edit_album_photos/'.$id?>">BACK TO PHOTO EDIT</a><a href="<?=base_url().'index.php?admin/edit_photo_album/'.$id?>">BACK TO ALBUM EDIT</a></div>
    
    <div id="photo_area">
    
		<? $attributes = array('name' => 'edit_artist', 'id' => 'edit_artist'); ?>
                
        <?=form_open(base_url().'index.php?admin/update_album_photos/'.$id,$attributes)?>
        
        <? $style_toggle = 0; $pos=1;?>
        
        <? if(isset($records)) : foreach ($records->result() as $row) : ?>
        
        	<? 
				$current_style = ($style_toggle % 2 == 0)?"white_bg":"grey_bg"; 
            
				
			?>
        
        	<div id="<?=$pos?>" pid="<?=$row->id?>" aid="<?=$id?>" class="photo_edit_row_order <?=$current_style?> clearfix">
        
        		<img src="../images/<?=$row->small?>">
                
                <div id="<?=$id?>" class="photo_edit_edit clearfix right" style="margin-top:0px;">
                
                	<label>edit</label>
                    
                    <div class="delete_photo"></div>
                    
                    <? if($row->order != ($records->num_rows)) : ?>
                    <div class="move_up"></div>
                    <? endif; ?>
                    
                    <? if($row->order != 1) : ?>
                    	<div class="move_down"></div>
                    <? endif; ?>
                
                </div>
                
            </div>
        
        <? $style_toggle++; $pos++; ?>
        
        <? endforeach;?>
        
        <? endif;?>
        
        <?=form_close()?>
    
    </div>

</div>