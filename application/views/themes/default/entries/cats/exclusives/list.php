        <!--{{{ MAIN -->
        <div id="main" class="main safe_float_left">
            <!--{{{ PRIMARY_AREA -->
            <div class="primary_area safe_float_left">
                <!--{{{ ENTRIES_AREA -->
                <div id="entries">
                    <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
                    <? $url = base_url() . 'blog/single/' . id() . '/' . url_title( title() ); ?>
                    <div class="entry safe_float_left" eid="<?=id()?>">
                        <a href="<?=$url?>">
                            <h1><?=title()?></h1>
                        </a>
                        <span class="entry_date"><?=human_date()?></span>
                        <? if( has_video() ) : ?>
                        <div class="entry_image">
                            <?=video( 530, 360, '990000' )?>
                        </div>
                        <div class="entry_share">
                            <span>SHARE</span>
                            <a href="http://facebook.com/sharer.php?u=<?=urlencode( $url )?>&t=<?=rawurlencode( title() )?>" target="_blank" >
                                <div class="facebook"></div>
                            </a>
                            <a href="http://twitter.com/?status=<?=rawurlencode( 'Blog : ' . title() . ' ' . row_value( 'small_url' ) . ' via @hiphopspaceship' )?>" target="_blank">
                                <div class="twitter"></div>
                            </a>
                            <div class="like_dislike">
                                <div class="like"></div>
                                <div class="dislike"></div>
                            </div>
                            <span class="count_like" style="display:none;">POSTED!</span>
                        </div>
                        <p>
                            <?=excerpt()?>
                        </p>
                        <a class="read_more" href="<?=$url?>">read more</a>
                        <? else : ?>
                        <p>
                            <?=excerpt()?>
                            <a class="read_more intext" href="<?=$url?>">read more</a>
                        </p>
                        <div class="entry_share">
                            <span>SHARE</span>
                            <a href="http://facebook.com/sharer.php?u=<?=urlencode( $url )?>&t=<?=rawurlencode( title() )?>" target="_blank" >
                                <div class="facebook"></div>
                            </a>
                            <a href="http://twitter.com/?status=<?=rawurlencode( 'Blog : ' . title() . ' ' . row_value( 'small_url' ) . ' via @hiphopspaceship' )?>" target="_blank">
                                <div class="twitter"></div>
                            </a>
                            <div class="like_dislike">
                                <div class="like"></div>
                                <div class="dislike"></div>
                            </div>
                            <span class="count_like" style="display:none;">POSTED!</span>
                        </div>
                        <? endif; ?>
                    </div>
                    <? endwhile; endif; ?>
                </div>
                <!--}}}-->
                <?=$this->pagination->create_links()?>
            </div>
            <!--}}}-->
            <? $this->load->view( theme_relative_path() . 'general/sidebar' ) ?>
        </div>
        <!--}}}-->
