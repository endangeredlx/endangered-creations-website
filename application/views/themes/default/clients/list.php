        <!--{{{ BEGIN_MAIN -->
        <div id="main">
           <!--{{{ PRIMARY_AREA -->
            <div class="primary_area wide">
                <div id="entries">
                    <div class="entry">
                    <h1>CLIENTS</h1>
                    <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
                        <a href="<?=row_value( 'website' )?>" title="<?=htmlspecialchars( description() )?>">
                            <div class="client_item" <?if( has_pic() ) : ?>style="background-image:url(<?=pic()?>);"<? endif; ?>>
                                <?if( !has_pic() ) : ?><?=title()?><? endif;?>
                            </div>
                        </a>
                    <? endwhile; endif; ?>
                    </div>
                </div>
            </div>
            <!-- END_PRIMARY_AREA }}} -->
            <? $this->load->view( theme_relative_path() . 'general/sidebar' ) ?>
        </div>
        <!--}}}-->
