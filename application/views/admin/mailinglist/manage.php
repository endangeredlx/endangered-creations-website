<div id="main_content" class="clearfix">

	<a href="<?=base_url(). $class . '/plain_text/'?>" class="button_link">
      View All Emails as <strong>Plain Text</strong>
    </a>
    
    <div style="height:1px; border-bottom:1px solid #ccc; margin-top:10px; margin-bottom:10px;"></div>

    <h2>Manage <?=ucwords( $plural )?></h2>
    <div class="small faded"><?=$total?> emails.</div>
    
    <div id="edit_container" class="clearfix">
    
    	<div class="head_row clearfix grey_bg">
        
            <div class="edit_long left">
                Email
            </div>

            <div class="edit_long left">
                Status
            </div>
            
            <div class="left">edit&nbsp;/&nbsp;</div>
            
            <div class="left">delete</div>
        
        </div>
    
    	<? $style_toggle = 0; ?>
    
        <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?> 

        <? $current_style = ($style_toggle % 2 == 0)?"white_bg":"grey_bg"; ?>
        
        <div id="<?=id()?>" class="edit_row clearfix <?=$current_style?>">
        
           <div class="edit_long left">
                <strong><?=anchor( $class . '/edit/' . id(), row_value( 'email' ) )?></strong>
            </div>

            <div class="edit_long left">
                &nbsp;<span class="faded"><?=( row_value('status') == 's' ) ? 'subscribed' : 'unverified'?></span>
            </div>
            
            <a href="<?=base_url() . $class ?>/edit/<?=id()?>">
            
            	<div class="edit_button left"></div>
                
            </a>
            
            <div class="delete_button d_<?=$class?> left"></div>
        
        </div>
        
        <? $style_toggle++; ?>
        
        <? endwhile; endif; ?>
        
        <? $current_style = ($style_toggle % 2 == 0)?'white_bg':'grey_bg'; ?>
        
        <div class="footer_row clearfix white_bg">
        
            <div class="edit_long left">
                Email
            </div>

            <div class="edit_long left">
                Status
            </div>
            
            <div class="left">edit&nbsp;/&nbsp;</div>
            
            <div class="left">delete</div>
        
        </div>
        
	</div>
    
    <?=$this->pagination->create_links()?>

</div>
