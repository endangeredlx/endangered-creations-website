<div class="photo_content clearfix left">

    <div class="photo_header clearfix">    
        
        <div class="photo_album_title"><?=$album->title?></div>
        
        <div class="tweetmeme">
        
            <!-- For Tweet Count add data-count="horizontal" -->
                                                    
            <a href="http://twitter.com/share" 
                class="twitter-share-button" 
                data-count="none" 
                data-via="talkofdetroit" 
                data-url="http://www.talkofdetroit.com/photo_album/<?=$album->id?>/<?=url_title($album->title,'dash',true)?>"
                data-text="Check out <?=$album->title?> on talkofdetroit.com!"
             >Tweet</a>
             
        </div>
        
        <div class="photo_album_info"><a href="http://www.talkofdetroit.com/photos">Back to Albums</a> | <?=$records->num_rows()?> photos</div>
        
    </div>
    
    <div id="photo_album_photos" class="left clearfix">
    
        <? if(isset($records)) : foreach($records->result() as $row) : ?>
        
            <div class="photo_holder clearfix left">
            	
                <a href="http://www.talkofdetroit.com/photo_single/<?=$row->id?>">
                
                	<img src="<?=base_url()?>images/<?=$row->square?>" title="<?=$row->description?>">
                    
                </a>
            
            </div>
        
        <? endforeach; endif; ?>
    
    </div>
    
    <div class="photo_album_desc clearfix left">
    
    	<?=$this->time_model->setTime($album->date)?>
    
    	<div class="photo_album_date">posted <?=$this->time_model->timeSince("minute","hour","week")?></div>
        
        <?=$album->description?>
    
    </div>

</div>

<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>

<? $this->load->view('general/small_sidebar'); ?>