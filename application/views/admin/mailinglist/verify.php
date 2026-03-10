<div style="width:100%;">
    <div class="chi_logo" style="background-image:url(<?=base_url()?>application/views/admin/images/chi_logo.jpg);width:120px;height:120px;margin:20px auto;"></div>
</div>
<? if( $email_found && $success ) : ?>
<div style="width:100%;">
<div style="height:50px;margin:20px auto; text-align:center;width:100%;font-size:12px;font-family:Helvetica;">Your email has been confirmed. <a href="<?=base_url()?>">Click here to go back to <?=option_value( 'site_name' )?></a></div>
</div>
<? elseif( $email_found && !$success ) : ?>
<div style="width:100%;">
<div style="height:50px;margin:20px auto; text-align:center;width:100%;font-size:12px;font-family:Helvetica;">Your conifmation link is wrong. <a href="<?=base_url()?>">Click here to go back to <?=option_value( 'site_name' )?></a></div>
</div>
<? else : ?>
<div style="width:100%;">
<div style="height:50px;margin:20px auto; text-align:center;width:100%;font-size:12px;font-family:Helvetica;">This confimation link doesn't match anything in our records. <a href="<?=base_url()?>">Click here to go back to <?=option_value( 'site_name' )?></a></div>
</div>
<? endif; ?>
