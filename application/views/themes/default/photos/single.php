<div id="pgftr">
<div id="pgftrttl">PHOTOS<span> + <?=$album->title?></span></div>
</div>
<div id="cntwrp">
   <div id="cntnt" class="abmpg">
      <div id="bgrgtcnt">
         <div class="ptodata">
            Photo <?=( $album->size - $photo->order + 1 )?> out of <?=$album->size?> - <a href="<?=base_url()?>photos/album/<?=$album->id?>">Back to Album</a> | <a href="<?=base_url()?>media">Media Page</a>
            <div class="ptonav"><a href="<?=base_url()?>photos/photo/<?=$prev?>">Previous</a> <a href="<?=base_url()?>photos/photo/<?=$next?>">Next</a></div>
         </div>
         <? if( isset( $photo ) ) : ?>
         <div class="ptoholder"> 
            <a href="<?=base_url()?>photos/photo/<?=$next?>">
               <img src="<?=base_url()?>images/photos/<?=$photo->large?>">
            </a>
         </div>
         <? endif; ?>
         <div class="ptodsc" style="">
            <div class="indnt">&nbsp;</div>
            <div class="cptn"><span>Description</span><? if( $photo->description == "" || $photo->description == "<br>" ) : ?><i>none</i><? else : ?><?=$photo->description?><? endif; ?></div>
         </div>
      </div>
   </div>
</div>
