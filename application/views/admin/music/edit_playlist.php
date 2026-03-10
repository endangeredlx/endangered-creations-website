<div id="main_content" class="clearfix">
    <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
    <div class="list_drag" id="list_drag">
        <div class="resources">
            <h1>Available Songs</h1>
            <span>Drag songs over to the playlist area</span>
            <div class="resource_list">
                <? if( there_are_songs() ) : while( there_are_songs() ) : get_next_song(); ?>
                <div rid="<?=song_value( 'id' )?>" class="resource"><?=song_value( 'title' )?> - <?=song_value( 'file' )?></div>
                <? endwhile; endif; ?>
            </div>
        </div>
        <div class="newlist">
            <h1>New Playlist</h1>
            <span>Double click songs to remove them</span>
            <div class="listarea">
                <? if( there_are_playlist_records() ) : while( there_are_playlist_records() ) : get_next_playlist_record(); ?>
                <div rid="<?=playlist_record_value( 'id' )?>" class="resource"><?=playlist_record_value( 'title' )?> - <?=playlist_record_value( 'file' )?></div>
                <? endwhile; endif; ?>
            </div>
        </div>
    </div>
    <div class="edit_playlist short_edit" >
    
        <div class="right_side">
            <span>Other Options</span>
            <? if( option_value( 'playlist_covers' ) == '1' ) : ?>
            <a id="add_cover_playlist" href="<?=base_url() . $this->class . '/add_photo_playlist/' . id()?>" class="button_link">
                <strong>Change/Add Cover</strong>
            </a>
            <? endif; ?>
        </div>
        <h2>Playlist Name</h2>     

        <input type="text" name="title" id="title" value="<?=playlist_name()?>" />
        <input type="hidden" name="playlist_id" id="playlist_id" value="<?=id()?>" />
        
        <div id="save_playlist" class="button_link_blue">
            <strong>Save Playlist</strong>
        </div>
    </div>
    <? endwhile; endif; ?>
</div>
