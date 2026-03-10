   <div id="cntwrp">
      <!-- BEGIN FULL CONTENT -->
      <div id="flcnt" class="grid_12 whtBg">
         <div class="flwdhdr"><img src="<?=theme_path()?>images/store_title.jpg" /></div>
         <div class="flwdhdr">
            <div class="fullWidthBtmBdr blkBg"></div>
         </div>
         <div class="uiMenuContain">
            <div class="leftControls">
               <a href="<?=safe_url()?>store" class="controlButton">store home</a>
               <a href="" class="controlButton">categories</a>
            </div>
            <div class="rightControls">
               <a href="" class="controlButton">search</a>
               <a href="" class="controlButton">total : &#163; 0</a>
               <a href="" class="controlButton">items in cart : 0</a>
            </div>
         </div>
         <div class="storeWelcomeMessage">
            <div class="left">Hello. <a href="">Sign In</a>&nbsp;&nbsp;&nbsp;New Customer. <a href="">Start here.</a></div> 
            <div class="right">Showing 1 item</div>
         </div>
         <div class="oneGrid">
            <?  if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
               <a href="<?=base_url()?>store/single/<?=id()?>/<?=name()?>">
                  <img src="<?=pic()?>" alt="" />
               </a>
               <div class="storeInfo">
                  <form action="<?=safe_url()?>store/add_to_cart/<?=id()?>/" method="post" enctype="multipart/form-data">
                     <div class="midTitle"><?=title()?></div>
                     <div class="itemPrice">&#163; <?=price()?></div>
                     <p><?=content()?></p>
                     <label for="qty">Qty</label>
                     <input type="hidden" name="id" value="<?=id()?>" />
                     <input type="text" name="qty" value="1" />
                     <? if( there_are_item_options() ) : while( there_are_item_options() ) : get_item_options()  ?>
                        <label for="<?=option_name()?>" ><?=option_label()?></label>
                        <? if( there_are_option_values() ) : ?>
                        <select name="<?=option_name()?>">
                        <? while( there_are_option_values() ) : get_option_values(); ?>
                           <option value="<?=option_value_value()?>"><?=option_value_name()?></option>
                        <? endwhile; ?>
                        </select>
                        <? endif; ?>
                     <? endwhile; endif; ?>
                     <? if( $this->session->userdata( 'is_logged_in' ) == true ) : ?>
                     <input type="submit" class="controlButton" value="Add to Cart" />
                     <? else : ?>
                     <a href="<?=safe_url()?>user/signin" class="controlButton">Must Login To Buy</a>
                     <? endif; ?>
                  </form>
               </div>
            <? endwhile; endif; ?>
         </div>
      </div>
      <!-- END FULL CONTENT -->
   </div>
   <!-- END MAIN CONTENT -->
</div>
<!-- END 960 CONTAINER -->
