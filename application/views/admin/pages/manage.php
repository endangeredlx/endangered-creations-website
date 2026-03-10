<div id="main_content" class="clearfix">

    <a href="<?=base_url()."pages/write/"?>" class="button_link">
        Add <strong>New Pages</strong>
    </a>

    <div style="height:1px; border-bottom:1px solid #ccc; margin-top:10px; margin-bottom:10px;"></div>

    <h2>Manage Pages</h2>

    <!-- BEGIN EDIT CONTAINER -->
    <div id="edit_container">

        <!-- BEGIN HEAD ROW -->
        <div class="head_row clearfix grey_bg">

            <div class="edit_mid left">
                Title
            </div>

            <div class="edit_short left">
                Date
            </div>

            <div class="edit_short left">
                Author
            </div>

            <div class="edit_short left">
                Status
            </div>

            <div class="left">edit&nbsp;/&nbsp;</div>

            <div class="left">delete</div>

        </div>
        <!-- END HEAD ROW -->

        <? $style_toggle = 0; ?>

        <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
    
        <? $current_style = ($style_toggle % 2 == 0)?"white_bg":"grey_bg"; ?>
        
        <div id="<?=id()?>" class="edit_row clearfix <?=$current_style?>">
        
            <div class="edit_mid left">

                 <?=anchor( "pages/edit/" . id(), title() )?> 

            </div>

            <div class="edit_short left">

                <?=mdate( "%m/%d/%Y", unix_time() )?>
                <span class="faded"><?=mdate( "%h:%i%a", unix_time() )?></span>

            </div>

            <div class="edit_short left">
               <?=author()?>
            </div>

            <div class="edit_short left">
               <?=row_value('status')?>
            </div>
            
            <a href="<?=base_url()?>pages/edit/<?=id()?>">
            
            	<div class="edit_button left"></div>
                
            </a>
            
            <a href="<?=base_url()?>pages/remove/<?=id()?>" class="delete_button d_pages left"></a>
        
        </div>
        
        <? $style_toggle++; ?>

        <? endwhile; endif; ?>

        <? $current_style = ($style_toggle % 2 == 0)?"white_bg":"grey_bg"; ?>

        <!-- BEGIN FOOTER ROW -->
        <div class="footer_row clearfix <?=$current_style?>">

            <div class="edit_mid left">
                Title
            </div>

            <div class="edit_short left">
                Date
            </div>

            <div class="edit_short left">
                Author
            </div>

            <div class="edit_short left">
                Status 
            </div>

            <div class="left">edit&nbsp;/&nbsp;</div>

            <div class="left">delete</div>

        </div>
        <!-- END FOOTER ROW -->

    </div>
    <!-- END EDIT CONTAINER -->

    <?=$this->pagination->create_links()?>

</div>
