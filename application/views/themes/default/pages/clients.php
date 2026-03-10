   <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>
   <div class="fullPage">
      <h1 class="pageTitle"><?=title()?></h1>
      <? if( has_pic() ) : ?>
      <div class="media">
         <img src="<?=pic()?>" alt="" />
      </div>
      <? endif; ?>
      <? if( has_video() ) : ?>
      <div class="media">
         <?=video( 620, 360, 'ffffff' )?>
      </div>
      <? endif; ?>
      <p><?=parse_content( content(), '<div class="listItem">', '</div>' )?></p>
   </div>
   <? endwhile; endif; ?>
