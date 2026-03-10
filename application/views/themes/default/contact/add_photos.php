<div id="main_content" class="clearfix">

 	<h2>Add Pictures To Album</h2>
 
 	<? if(isset($entry)) : foreach($entry as $row) : ?>
 
 	<div class="notice information">Add multiple pictures to "<?=anchor("admin/edit_photo_album/$row->id",$row->title)?>"</div>
    
		<script type="text/javascript">
            var flashvars = {};
            var params = {};
            params.play = "true";
            params.menu = "false";
            params.quality = "best";
            params.scale = "noscale";
            params.wmode = "opaque";
            params.allowfullscreen = "true";
            params.allowscriptaccess = "always";
            params.allownetworking = "all";
            var attributes = {};
            attributes.id = "flashPanel";
            swfobject.embedSWF("<?=base_url()?>flashUploaders/albumFileUploader.swf?upload_class=<?=$upload_class?>&base_url=<?=base_url()?>&primary_id=<?=$primary_id?>&upload_function=<?=$upload_function?>&file_type=<?=$file_type?>", "flashPanel", "550", "600", "10.0.0", "expressInstall.swf", flashvars, params, attributes);
        </script>
        
        <div id="flashPanel"></div>

	<? endforeach; ?>
    
    <? endif; ?>

</div>