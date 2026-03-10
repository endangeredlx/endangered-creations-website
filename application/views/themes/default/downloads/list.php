        <!--{{{ MAIN -->
        <div id="main" class="main safe_float_left">
            <!--{{{ PRIMARY_AREA -->
            <div class="primary_area safe_float_left">
                <h1 class="cufon">DOWNLOADS</h1>
                  <? if( there_are_entries() ) : while( there_are_entries() ) : get_next();?>
                     <a href="<?=base_url()?>downloads/get_file/<?=filename()?>">
                         <div class="dl_item" style="background-image:url(<?=pic()?>);"></div>
                     </a>
                  <? endwhile; endif; ?>
            </div>
            <!--}}}-->
            <? $this->load->view( theme_relative_path() . 'general/sidebar' ) ?>
        </div>
        <!--}}}-->
