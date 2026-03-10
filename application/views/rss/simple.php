<?='<?xml version="1.0" encoding="UTF-8" ?>'?>  
<rss 
    version="2.0" 
    xmlns:dc="http://purl.org/dc/elements/1.1/" 
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" 
    xmlns:admin="http://webns.net/mvcb/" 
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" 
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
>  

    <channel>

        <title><?=option_value( 'site_name' )?></title>

        <link><?=base_url()?></link>

        <description><?=option_value( 'site_description' )?></description>

        <dc:language><?=option_value( 'site_language' )?></dc:language>

        <dc:creator><?=option_value( 'main_email' )?></dc:creator>

        <dc:rights>Copyright <?=gmdate("Y", time())?></dc:rights>

        <admin:generatorAgent rdf:resource="<?=base_url()?>" />

        <? if( there_are_entries() ) : while( there_are_entries() ) : get_next(); ?>

        <item>

            <title><?=title()?></title>

            <link><?=base_url() . 'blog/' . id() . '/' .  url_title( title(), 'dash', true )?></link>

            <guid><?=base_url() . 'blog/' . id() . '/' .  url_title( title(), 'dash', true )?></guid>

            <description><![CDATA[ <?=excerpt()?> ]]></description>

            <pubDate><?=date ('r', unix_time() )?></pubDate>

        </item>
        
        <? endwhile; endif; ?>
    
    </channel>

</rss> 

