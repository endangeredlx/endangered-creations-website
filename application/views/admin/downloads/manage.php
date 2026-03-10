<div id="main_content" class="clearfix">

	<a href="<?=base_url() . $class . '/add_file/'?>" class="button_link">
      Add <strong>New <?=ucwords( $singular )?></strong>
    </a>

	<a href="<?=base_url() . $class . '/write/'?>" class="button_link">
      I've Added My <strong><?=ucwords( $singular )?> Manually</strong>
    </a>
    
    <div style="height:1px; border-bottom:1px solid #ccc; margin-top:10px; margin-bottom:10px;"></div>

    <h2>Manage <?=ucwords($singular)?></h2>
    
    <div id="edit_container" class="clearfix">
    
    	<div class="head_row clearfix grey_bg">
        
            <div class="edit_long left">
                Title
            </div>

            <div class="edit_mid left">
                Status
            </div>
            
            <div class="left">edit&nbsp;/&nbsp;</div>
            
            <div class="left">delete</div>
        
        </div>
    
    	<? $style_toggle = 0; ?>
    
        <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
        
        <? $current_style = ( $style_toggle % 2 == 0 ) ? 'white_bg' : 'grey_bg'; ?>
        
        <div id="<?=id()?>" class="edit_row clearfix <?=$current_style?>">
        
           <div class="edit_long left">
                <strong><?=anchor( $class . '/edit/' . id(), title() )?></strong>
            </div>

            <div class="edit_mid left">
                &nbsp;<span class="faded"><?=row_value('status')?></span>
            </div>
            
            <a href="<?=base_url() . $class ?>/edit/<?=id()?>">
            
            	<div class="edit_button left"></div>
                
            </a>
            
            <div class="delete_button d_<?=$class?> left"></div>
        
        </div>
        
        <? $style_toggle++; ?>
        
        <? endwhile; endif; ?>
        
        <? $current_style = ($style_toggle % 2 == 0)?"white_bg":"grey_bg"; ?>
        
        <div class="footer_row clearfix <?=$current_style?>">
        
            <div class="edit_long left">
                Title
            </div>
            
            <div class="edit_mid left">
                Status  
            </div>
            
            <div class="left">edit&nbsp;/&nbsp;</div>
            
            <div class="left">delete</div>
        
        </div>
        
	</div>
    
    <?=$this->pagination->create_links()?>

</div>
