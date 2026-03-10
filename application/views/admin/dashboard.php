<div id="main_content" class="clearfix">

    <h3>Welcome Back, <?=$this->session->userdata('alias')?>!</h3>

    <? if( isset ( $notifications ) ) :  ?>
    <div id="bignt">
        <div id="bignt_areatitle">Admin Messages</div>
        <div class="bignt_contentarea">
            <? foreach( $notifications->result() as $notice ) : ?>
            <div class="bignt_title"><?=$notice->title?></div>
            <div class="bignt_date"><?=date('F j, Y h:i:sa', $notice->date)?></div>
            <div class="bignt_body"><?=$notice->message?></div>
            <div class="bignt_author"><?=$notice->author?></div>
            <? endforeach; ?>
        </div>
    </div>
    <?  endif; ?>      

    <a class="button_link_blue right" href="<?=base_url()?>entries/manage">Manage <strong>Blog</strong></a>
    <!--<a class="button_link_blue right" href="<?=base_url()?>comments/manage">Approve/Manage <strong>Comments</strong><?if( $num_unapproved != 0 ){?><span class="list_count"><?=$num_unapproved?></span><?}?></a>
    <a class="button_link right" href="<?=base_url()?>photos/manage">Manage <strong>Photos</strong></a>
    <a class="button_link right" href="<?=base_url()?>mailinglist/manage">Manage <strong>Mailing List</strong></a>-->
</div>
