<div id="pgftr">
   <div id="pgftrttl">PHOTOS</div>
</div>
<div id="cntwrp">
   <div id="cntnt" class="abmpg">
      <div id="flpgcnt">
         <? if( isset( $records ) ) : foreach( $records as $record ) : ?>
            <div class="ptoitm abm"> 
               <a href="<?=base_url()?>photos/album/<?=$record->id?>">
                  <div class="ptothm" style="background-image:url(<?=base_url()?>images/photos/<?=$record->small?>);"></div>
               </a>
               <div class="ptoinf">
                  <span class="ptottl"><a href=""><?=$record->title?></a></span>
                  <span class="ptomt"><?=$record->size?> photos</span>
               </div>
            </div>
         <? endforeach; endif; ?>
      </div>
   </div>
</div>
