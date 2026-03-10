<div id="main_content" class="clearfix">

	<a href="<?=base_url()."index.php?admin/write_photo_album/"?>" class="button_link">
        Create <strong>New Photo Album</strong>
    </a>
    
    <div style="height:1px; border-bottom:1px solid #ccc; margin-top:10px; margin-bottom:10px;"></div>

	<h2>Manage Photo Albums</h2>
    
    <div id="edit_container" class="clearfix">
    
    	<div class="artist_row head_row clearfix grey_bg">
        
            <div class="edit_mid left">
                Name
            </div>
            
            <div class="edit_short left">
              
            </div>
            
            <div class="edit_short left">
                  Date
            </div>
            
            <div class="edit_short left">
                
            </div>
            
            <div class="left">edit&nbsp;/&nbsp;</div>
            
            <div class="left">delete</div>
        
        </div>
    
    	<? $style_toggle = 0; ?>
    
		<? if(isset($records)) : foreach($records as $row) : ?>
        
        <? $current_style = ($style_toggle % 2 == 0)?"white_bg":"grey_bg"; ?>
        
        <div id="<?=$row->id?>" class="edit_row artist_row clearfix <?=$current_style?>">
        
            <div class="edit_mid left">
                <?=anchor("admin/edit_photo_album/$row->id",$row->title)?>
            </div>
            
            <div class="edit_short left">
               
            </div>
            
            <div class="edit_short left">
                <?=mdate("%Y",$row->date)?>
                <span class="faded"></span>
            </div>
            
            <div class="edit_short left">
                
            </div>
            
            <a href="index.php?admin/edit_photo_album/<?=$row->id?>">
            
            	<div class="edit_button left"></div>
                
            </a>
            
            <div class="delete_button d_palbum left"></div>
        
        </div>
        
        <? $style_toggle++; ?>
        
        <? endforeach; if( count($records) == 0 ) : ?>
        
        <? $style_toggle++; ?>
        
        <div id="" class="edit_row artist_row clearfix white_bg">
        
        	<i>No Photo Albums</i>
            
        </div>
        
        <? endif; endif; ?>
        
        <? $current_style = ($style_toggle % 2 == 0)?"white_bg":"grey_bg"; ?>
        
        <div class="artist_row footer_row clearfix <?=$current_style?>">
        
            <div class="edit_mid left">
                Title
            </div>
            
            <div class="edit_short left">
               
            </div>
            
            <div class="edit_short left">
               Date
            </div>
            
            <div class="edit_short left">
               
            </div>
            
            <div class="left">edit&nbsp;/&nbsp;</div>
            
            <div class="left">delete</div>
        
        </div>
        
	</div>
    
    <?=$this->pagination->create_links()?>

</div>