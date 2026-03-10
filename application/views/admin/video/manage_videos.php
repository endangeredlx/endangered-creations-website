<div id="main_content" class="clearfix">

    <a href="<?=base_url() . 'music/upload_video/'?>" class="button_link">

        Upload <strong>New <?=ucwords($singular)?></strong>

    </a>

    <div style="height:1px; border-bottom:1px solid #ccc; margin-top:10px; margin-bottom:10px;"></div>

    <div class="tabbed_links">

    <a href="<?=base_url() . $this->class . '/manage/videos'?>" class="active">Upload/Manage Videos</a>

        <a href="<?=base_url() . $this->class . '/manage/playlists'?>" class="">Manage/Create Playlists</a>

    </div>

    <!-- {{{ BEGIN TABBED CONTAINER -->
    <div class="tabbed">
        <!-- {{{ BEGIN EDIT CONTAINER -->
        <div id="edit_container" >
            <!-- {{{ BEGIN HEAD ROW -->
            <div class="head_row clearfix grey_bg">

                <div class="edit_mid left">
                    Title
                </div>

                <div class="edit_short left">
                    File Name
                </div>

                <div class="edit_mid left">
                    Type
                </div>

                <div class="left">edit&nbsp;/&nbsp;</div>

                <div class="left">delete</div>

            </div>
            <!-- }}} -->

            <? $style_toggle = 0; ?>

            <!-- {{{ MAIN ROW LOOP -->
            <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>

            <? $current_style = ($style_toggle % 2 == 0)?'white_bg':'grey_bg'; ?>

            <div id="<?=id()?>" class="edit_row clearfix <?=$current_style?>">

                <div class="edit_mid left">

                    <strong><?=anchor('music/edit_video/' . id(), title())?></strong>

                </div>

                <div class="edit_short left">

                    <span class="faded"><?=video_file( 25 )?></span>

                </div>

                <div class="edit_mid left">

                    <span class="faded"><?=video_type()?></span>

                </div>

                <a href="<?=base_url()?>music/edit/1">

                    <div class="edit_button left"></div>

                </a>

                <div class="delete_button d_music left"></div>

            </div>
            <? endwhile; endif; ?>
            <!-- }}} -->

            <? $style_toggle++; ?>

            <? $current_style = ($style_toggle % 2 == 0)?"white_bg":"grey_bg"; ?>

            <!-- {{{ BEGIN FOOTER  ROW -->
            <div class="footer_row clearfix <?=$current_style?>">

                <div class="edit_mid left">

                    Title

                </div>

                <div class="edit_short left">

                    File Name

                </div>

                <div class="edit_mid left">

                    Type

                </div>

                <div class="left">edit&nbsp;/&nbsp;</div>

                <div class="left">delete</div>

            </div>
            <!-- }}} -->

        </div>
        <!-- }}} -->
    </div>
    <!-- }}} -->

<?=$this->pagination->create_links()?>

</div>
