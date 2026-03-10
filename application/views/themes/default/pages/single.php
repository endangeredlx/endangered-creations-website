        <!--{{{ BEGIN_MAIN -->
        <div id="main">
            <!--{{{ PRIMARY_AREA -->
            <div class="primary_area <?=( $page_type != 'home' ) ? 'wide' : ''?>">
                <div id="entries">
                    <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
                    <div class="entry">
                        <h1><?=title()?></h1>
                        <div class="entry_media">
                            <? if( has_pic() ) :?>
                            <img src="<?=pic()?>" />
                            <? endif; ?>
                        </div>
                        <div class="entry_content long">
                            <?=nl2br( content() )?>
                        </div>
                    </div>
                    <? endwhile; endif; ?>
                </div>
            </div>
            <!-- END_PRIMARY_AREA }}} -->
            <? $this->load->view( theme_relative_path() . 'general/sidebar' ) ?>
        </div>
        <!--}}}-->
