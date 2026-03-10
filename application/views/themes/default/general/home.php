        <!--{{{ BEGIN_MAIN -->
        <div id="main">
            <!--{{{ SECONDARY_HEADER -->
            <div id="secondary_header">
                <!--{{{ SLIDER -->
                <div class="slider">
                    <ul id="slider" class="aviaslider">
                        <? if( there_are_features() ) : while( there_are_features() ) : next_feature(); ?> 
                        <li  class="current" >
                            <a href="<?=feature_link()?>">
                                <img src="<?=feature_pic()?>" alt="<?=feature_title()?>::" />
                            </a>
                        </li>
                        <? endwhile; endif; ?>
                    </ul>
                </div>
                <!-- END_SLIDER }}}-->
                <!--{{{ VIDEO_AREA -->
                <div id="video_area" class="video_area">
                    <div class="video_area_title">
                    <div class="video_area_text"><?=$featured_videos->main_feature_video->title?></div>
                    </div>
                    <div class="video_area_media">
                        <?=create_video( $featured_videos->main_feature_video->video, 370, 260, 'ffffff' )?>
                    </div>
                </div>
                <!-- END_VIDEO_AREA }}}-->
            </div>
            <!-- END_SECONDARY_HEADER }}}-->
            <!--{{{ PRIMARY_AREA -->
            <div class="primary_area">
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
                </div>
            </div>
            <!-- END_PRIMARY_AREA }}} -->
            <? $this->load->view( theme_relative_path() . 'general/sidebar' ) ?>
        </div>
        <!--}}}-->
