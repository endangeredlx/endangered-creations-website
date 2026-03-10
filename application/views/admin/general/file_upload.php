<div id="main_content" class="clearfix">
    <h2>Add <?=ucwords( $human_name )?></h2>
    <?
        // If the id is set to 0 then the page behaves as if the upload is not going to any particular record
        if( $primary_id != 0 ) :
    ?>
    <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>

    <div class="notice information">Upload <?=$human_name?> to "<?=anchor( $class . '/edit/' . id(), title() )?>"</div>

    <? endwhile; endif; ?>
    <?  elseif( $primary_id == 0 ) : ?>

    <div class="notice information">Upload <?=ucwords($human_name)?> </div>

    <? endif; ?> 
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
        swfobject.embedSWF("<?=base_url()?>flashUploaders/<?=$uploader?>Uploader.swf?upload_class=<?=$class?>&human_name=<?=ucwords($human_name)?>&base_url=<?=base_url()?>&primary_id=<?=$primary_id?>&secondary_id=<?=$secondary_id?>&upload_function=<?=$upload_function?>&file_type=<?=$file_type?>", "flashPanel", "550", "400", "10.0.0", "expressInstall.swf", flashvars, params, attributes);
    </script>
    <div id="flashPanel"></div>
</div>
