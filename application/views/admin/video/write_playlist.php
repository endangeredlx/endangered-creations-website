<div id="main_content" class="clearfix">
    <div class="continue_playlist" style="display:none;">
    
        <h2>Enter Name For Playlist</h2>     

        <input type="text" name="title" id="title" />

        <div id="save_playlist" class="button_link">
            <strong>Save Playlist</strong>
        </div>

    </div>
    <div class="list_drag">
        <div class="resources">
            <h1>Available Songs</h1>
            <span>Drag songs over to the playlist area</span>
            <div class="resource_list">
                <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
                    <div rid="<?=id()?>" class="resource"><?=title()?> - <?=filename( 40 )?></div>
                <? endwhile; endif; ?>
            </div>
        </div>
        <div class="newlist">
            <h1>New Playlist</h1>
            <span>Double click songs to remove them</span>
            <div class="listarea">
            </div>
        </div>
    </div>
    <div id="continue" class="button_link">
        <strong>Continue</strong>
    </div>
</div>
