        <!--{{{ BEGIN_MAIN -->
        <div id="main">
           <!--{{{ PRIMARY_AREA -->
            <div class="primary_area wide">
                <div id="entries">
                    <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
                    <? $url = base_url() . 'blog/single/' . id() . '/' . url_title( title(), 'dash', true ); ?>
                    <div class="entry">
                        <a href="<?=$url?>">
                            <h1><?=title()?></h1>
                        </a>
                        <span class="meta"><?=human_date()?></span>
                        <? if( has_video() ) : ?>
                        <div class="entry_media">
                            <? if( has_video() ) :?>
                            <?=video( 359, 246, 'ffffff' )?>
                            <? endif; ?>
                        </div>
                        <div class="entry_content">
                            <?=excerpt()?>
                        </div>
                        <? else : ?>
                        <div class="entry_content long">
                            <?=excerpt()?>
                        </div>
                        <? endif; ?>
                    </div>
                    <? endwhile; endif; ?>
                </div>
            </div>
            <!-- END_PRIMARY_AREA }}} -->
            <? $this->load->view( theme_relative_path() . 'general/sidebar' ) ?>
        </div>
        <!--}}}-->
