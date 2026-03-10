<div id="main_content" class="clearfix">

    <a href="<?=base_url() . $class . '/settings/' ?>" class="button_link">
        Change <strong>Comment Settings</strong>
    </a>
    
    <div style="height:1px; border-bottom:1px solid #ccc; margin-top:10px; margin-bottom:10px;"></div>

    <h2>Manage <?=ucwords( $plural )?></h2>
    
    <!-- BEGIN EDIT CONTAINER -->
    <div id="edit_container">
    
        <!-- BEGIN HEAD ROW -->
    	<div class="head_row clearfix grey_bg">
        
            <div class="edit_short left"> Author </div>
            
            <div class="edit_long left">
                Body
            </div>

            <div class="edit_short left">
                Approval
            </div>
            
            <div class="left">delete</div>
            
            <div class="left">&nbsp;/&nbsp;approve</div>
        
        </div>
        <!-- END HEAD ROW -->

    	<? $style_toggle = 0; ?>
        <? start_comments(); ?>
    
        <? if( there_are_comments() ) : while( there_are_comments() ) : get_next_comment(); ?>

        <div id="<?=comment_id()?>" class="edit_row left <?=approval()?>">
        
            <div class="edit_short left">
                <?=comment_author()?>
                <span><?=comment_date('m/d/Y h:ia')?></span>
                <span class="comment_email"><?=comment_email()?></span>
                <span class="comment_website"><?=comment_website()?></span>
            </div>
            
            <div class="edit_long left">
            <span> in response to <a href="<?=base_url()?>entries/single/<?=comment_id()?>/<?=url_title( comment_title(), 'dash', true)?>"><?=comment_title()?></a></span>
                <?=comment_content()?>
            </div>


            <div class="edit_short approval_state left">
                <?=approval()?>
            </div>
            
            <div class="left d_<?=$class?>" title="delete this comment"></div>

            <?if( approval() == 'unapproved' ) : ?>
            <div class="left make_approval" title="approve this comment"></div>
            <? else : ?>
            <div class="left make_unapproved" title="unapprove this comment"></div>
            <? endif; ?>

        </div>
        
        <? endwhile; else : ?>

        <? $current_style = ($style_toggle % 2 == 0)?'white_bg':'grey_bg'; ?>

        <div id="0000" class="edit_row clearfix <?=$current_style?>">

            There are no <?=$plural?> to show.

        </div>

        <? endif; ?>
        
        <? $current_style = ($style_toggle % 2 == 0)?"white_bg":"grey_bg"; ?>
        
        <!-- BEGIN FOOTER ROW -->
        <div class="footer_row clearfix">
        
            <div class="edit_short left">
                Author
            </div>
            
            <div class="edit_long left">
                Body
            </div>

            <div class="edit_short left">
                Approval
            </div>
            
            <div class="left">delete</div>
            
            <div class="left">&nbsp;/&nbsp;approve</div>
        
        </div>
        <!-- END FOOTER ROW -->
        
	</div>
    <!-- END EDIT CONTAINER -->
    
    <?=$this->pagination->create_links()?>

</div>
