<div id="pgftr">
   <div id="pgftrttl">PHOTOS<span> + <?=$album->title?></span></div>
</div>
<div id="cntwrp">
   <div id="cntnt" class="abmpg">
      <div id="flpgcnt">
         <div class="ptodata"><?=$album->size?> photos&nbsp;&nbsp;&nbsp; | <a href="<?=base_url()?>photos">Photos Page</a></div>
         <? if( isset( $photos ) ) : foreach( $photos->result() as $photo ) : ?>
            <div class="ptoitm pto"> 
               <a href="<?=base_url()?>photos/photo/<?=$photo->id?>">
                  <div class="ptothm" style="background-image:url(<?=base_url()?>images/photos/<?=$photo->small?>);"></div>
               </a>
            </div>
         <? endforeach; endif; ?>
         <div class="ptodsc" style="">
            <div class="indnt">&nbsp;</div>
            <div class="cptn"><span>Description</span><?=$album->description?></div>
         </div>
      </div>
   </div>
</div>


