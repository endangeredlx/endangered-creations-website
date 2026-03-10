<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<!--{{{ HEAD -->
<head>

    <title><?=( isset( $page_title ) ) ? $page_title . ' | ' . option_value( 'site_name' ) : 'New Website'?></title>
    <meta charset="UTF-8" />

    <!-- START STYLES -->

    <!-- DEFAULT -->
    <link rel="stylesheet" href="<?=theme_path()?>library/css/reset.css" type="text/css" media="all" charset="utf-8">

    <? if( there_are_stylesheets() ) : while( there_are_stylesheets() ) : get_stylesheet() ?>
    <link rel="stylesheet" href="<?=theme_path()?>library/css/<?=stylesheet()?>" type="text/css" media="all" charset="utf-8">
    <? endwhile; endif; ?>
    <!-- END STYLES -->

    <!-- START JAVASCRIPT -->
    <script type="text/javascript">
        // We create the global var ChiBaseURL to easily refer to the base url.
        var ChiBaseURL = "<?=base_url()?>";
        // Don't change the last two lines.
        // They are there because the js is made to deal with url WITHOUT a trailing slash.
        var len = ChiBaseURL.length;
        ChiBaseURL = ChiBaseURL.substring( 0, len-1 );
    </script>
    <? if( there_are_scripts() ) : while( there_are_scripts() ) : get_script() ?>
    <script src="<?=theme_path()?>library/js/<?=script()?>" type="text/javascript"></script>
    <? endwhile; endif; ?>
    <script type="text/javascript">
    </script>
    <!-- END JAVASCRIPT -->

    <!-- GOOGLE ANALYTICS -->
    <script type="text/javascript">
    // Not set
    </script>
    <!-- END GOOGLE ANALYTICS -->

</head>
<!--}}}-->
<body class="<?=$page_type?>">
