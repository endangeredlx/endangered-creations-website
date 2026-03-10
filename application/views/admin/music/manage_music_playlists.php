<div id="main_content" class="clearfix">

    <a href="<?=base_url()."music/write/"?>" class="button_link">

        Create <strong>New <?=ucwords($singular)?></strong>

    </a>

    <div style="height:1px; border-bottom:1px solid #ccc; margin-top:10px; margin-bottom:10px;"></div>

    <div class="tabbed_links">

        <a href="<?=base_url() . $this->class . '/manage/songs'?>" class="">Upload/Manage Songs</a>

        <a href="<?=base_url() . $this->class . '/manage/playlists'?>" class="active">Manage/Create Playlists</a>

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
                    Songs
                </div>

                <div class="edit_mid left">
                    Status
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

                    <strong><?=anchor('music/edit_playlist/' . id(), title())?></strong>

                </div>

                <div class="edit_short left">

                    &nbsp;<span class="faded"><?=number_of_songs()?></span>

                </div>

                <div class="edit_mid left">

                    &nbsp;<span class="faded"><?=status()?></span>
                    &nbsp;<span class="toggle_status">change</span>

                </div>

                <a href="<?=base_url()?>music/edit/1">

                    <div class="edit_button left"></div>

                </a>

                <div class="delete_button d_music left"></div>

                <? if( option_value( 'main_music_playlist' ) != id() ) : ?>

                <div class="edit_short left main_playlist">

                    &nbsp;<span class="faded">make main playlist</span>

                </div>

                <? else : ?>

                <div class="edit_short left is_main_playlist">

                    &nbsp;<span class="faded">main playlist</span>

                </div>

                <? endif; ?>

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

                    Songs

                </div>

                <div class="edit_mid left">

                    Status  

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
