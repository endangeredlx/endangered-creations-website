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
            <div class="right">Showing 8 out of 16 items</div>
         </div>
         <div class="fourGrid">
            <?  if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
               <div class="fourGridItem">
                  <a href="<?=safe_url()?>store/single/<?=id()?>/<?=name()?>">
                     <img src="<?=pic()?>" alt="" />
                  </a>
                  <a href="<?=safe_url()?>store/single/<?=id()?>/<?=name()?>" class="itemTitle"><?=title()?></a>
                  <div class="itemPrice">&#163; <?=price()?></div>
               </div>
            <? endwhile; endif; ?>
            <div class="clearfix" id="pgntn">&nbsp;
               <strong>1</strong>&nbsp;
               <a class="page" href="">2</a>&nbsp;
               <a class="page" href="">&gt;</a>&nbsp;
            </div>
         </div>
      </div>
      <!-- END FULL CONTENT -->
   </div>
   <!-- END MAIN CONTENT -->
</div>
<!-- END 960 CONTAINER -->
