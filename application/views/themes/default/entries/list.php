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
                        <? if( has_pic() ) : ?>
                        <div class="entry_media">
                            <? if( has_pic() ) :?>
                            <img src="<?=pic()?>" />
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
                        <a class="read_more" href="<?=$url?>">read more</a>
                    </div>
                    <? endwhile; endif; ?>
                    <?=$this->pagination->create_links()?>
                </div>
            </div>
            <!-- END_PRIMARY_AREA }}} -->
            <? $this->load->view( theme_relative_path() . 'general/sidebar' ) ?>
        </div>
        <!--}}}-->
