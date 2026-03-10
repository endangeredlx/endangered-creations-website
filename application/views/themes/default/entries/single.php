        <!--{{{ BEGIN_MAIN -->
        <div id="main">
           <!--{{{ PRIMARY_AREA -->
            <div class="primary_area wide">
                <div id="entries">
                    <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
                    <? $url = base_url() . 'blog/single/' . id() . '/' . url_title( title(), 'dash', true ); ?>
                    <div class="entry">
                        <h1><?=title()?></h1>
                        <span class="meta"><?=human_date()?></span>
                        <? $cat = entry_category();?>
                        <? if( has_pic() && $cat['name'] != 'Videos' ) :?>
                        <div class="entry_media">
                            <img src="<?=pic()?>" />
                        </div>
                        <? endif; ?>
                        <? if( has_video() ) :?>
                        <div class="entry_media">
                            <?=video( 540, 359, 'ffffff' )?>
                        </div>
                        <? endif; ?>
                        <div class="entry_content long">
                            <?=content()?>
                        </div>
                    </div>
                    <? endwhile; endif; ?>
                </div>
            </div>
            <!-- END_PRIMARY_AREA }}} -->
            <? $this->load->view( theme_relative_path() . 'general/sidebar' ) ?>
        </div>
        <!--}}}-->
