<div id="main_content" class="clearfix">

 	<h2>Add Photo</h2>
 
 	<? if( isset( $entry ) ) :  ?>
  
 	<div class="notice information">Add photo to "<?=anchor( base_url() . $class . "/edit/" . $entry->id, $entry->title )?>"</div>
    
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
            swfobject.embedSWF("<?=base_url()?>flashUploaders/fileUploader.swf?upload_class=<?=$class?>&base_url=<?=base_url()?>&primary_id=<?=$primary_id?>&upload_function=<?=$upload_function?>&file_type=<?=$file_type?>", "flashPanel", "550", "200", "10.0.0", "expressInstall.swf", flashvars, params, attributes);
        </script>
        
        <div id="flashPanel"></div>

    <? endif; ?>

</div>
