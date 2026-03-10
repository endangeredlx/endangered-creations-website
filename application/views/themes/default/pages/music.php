   <div class="fullPage">
      <h1 class="pageTitle">Music</h1>
      <span class="superSubTitle">click the image to download the mixtape</span>
      <div class="downloadArea">
      <? if( isset( $records ) ) : foreach( $records as $record ) : ?>
         <a href="<?=base_url()?>dls/<?=$record->file?>">
            <div class="dl_item" style="background-image:url(<?=base_url()?>images/downloads/<?=$record->image?>);"></div>
         </a>
      <? endforeach; endif; ?>
      </div>
   </div>
