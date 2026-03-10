<!DOCTYPE html>
<html lang="en">
<head>
    <title>chi | content handling interface</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/views/admin/library/css/reset.css"></link>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/views/admin/library/css/admin.css"></link>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/views/admin/library/css/jquery.wysiwyg.css"></link>

    <!--[if IE]>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/views/general/css/admin-ie.css"></link>
    <![endif]-->

    <script type="text/javascript">
        // We create the global var ChiBaseURL to easily refer to the base url.
        var ChiBaseURL = "<?=base_url()?>";
        // Don't change the last two lines.
        // They are there because the js is made to deal with url WITHOUT a trailing slash.
        var len = ChiBaseURL.length;
        ChiBaseURL = ChiBaseURL.substring( 0, len-1 );
    </script>

    <script src="<?=base_url()?>js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <? 
        //This loop cycles through all the javascript files we'll need.
        if( isset( $javascript ) ) : foreach( $javascript as $script ) : 
    ?>
    <script type="text/javascript" src="<?=base_url()?>application/views/admin/library/js/<?=$script?>.js"></script>
    <? endforeach; endif; ?>

</head>
<body class="<?=( isset( $class ) ) ? $class : 'general'?>">
<div id="dialog_wrapper" class="popup_container" style="display:none;">
    <div class="popup_outter">
        <div class="popup_inner" id="popup_dialog">
            <h1 class="popup_title"><span id="dialog_title">Alert Name</span></h1>
            <div class="popup_content" id="dialog_content"></div>
            <div class="popup_controls" id="popup_controls"></div>
        </div>
    </div>
</div>
    
