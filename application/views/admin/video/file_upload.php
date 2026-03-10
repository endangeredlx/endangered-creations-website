<div id="main_content" class="clearfix">
   <h2>Add <?=$human_name?></h2>
 	<? if( isset( $record ) ) : ?>
   <div class="notice information">Upload <?=$what?> to "<?=anchor( $class . "/edit/$record->id", $record->title )?>"</div>
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
            swfobject.embedSWF("<?=base_url()?>flashUploaders/<?=$uploader?>Uploader.swf?upload_class=<?=$class?>&human_name=<?=$human_name?>&base_url=<?=base_url()?>&primary_id=<?=$primary_id?>&upload_function=<?=$upload_function?>&file_type=<?=$file_type?>", "flashPanel", "550", "400", "10.0.0", "expressInstall.swf", flashvars, params, attributes);
        </script>
        <div id="flashPanel"></div>
    <? endif; ?>
</div>
