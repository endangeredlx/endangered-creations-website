<div id="news_content" class="left">

	<? if(isset($records)) : foreach($records as $row) : ?>
    
	<div class="news_story left">
    
    	<a href="<?="http://www.talkofdetroit.com/photo_album/$row->id/".url_title($row->title,'dash',true)?>" >
    
    	<? if($row->small != "" ) : ?>
        
        <img src="<?=base_url()?>images/<?=$row->small?>" class="story_image venue_image left" alt="<?=$row->title?>" />
        
        <? else: ?>
        
        <img src="<?=base_url()?>images/general/mid_default.jpg" class="story_image venue_image left" alt="<?=$row->title?>" />
        
        <? endif; ?>
        
        </a>
        
        <div class="v_info_wrap right clearfix">
        
            <h3 class="venue_name left"><?=anchor("http://www.talkofdetroit.com/photo_album/$row->id/".url_title($row->title,'dash',true), $row->title)?></h3>
            
            <div class="venue_info left"></div>
            
            <? 
		
				$breaks = array("<br>","<br />");
				$spaces = array("&nbsp;","&nbsp;	");
			
			?>
            
            <p class="venue_p left"><?=word_limiter(str_replace($breaks,$spaces,strip_tags($row->description,'<br>')), 18)?></p>
            
            <p class="more left"><?=anchor("http://www.talkofdetroit.com/photo_album/$row->id/".url_title($row->title,'dash',true), "view album")?> >></p>
        
        </div>	
        	
	</div>
    
    <div class="entry_divide left"></div>
    
	<? endforeach; ?>

	<? else : ?>	
    
    <div class="news_story">
    
		<h2 class="news_title left">No entries submitted yet.</h2>
        
    </div>
    
	<? endif; ?>
    
</div>
<?=$this->load->view("extensions/side_bar")?>
