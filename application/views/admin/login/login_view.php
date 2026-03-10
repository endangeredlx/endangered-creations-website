<div id="main_content" class="clearfix">

    <div id="chi_logo" style="background-image:url(<?=base_url()?>application/views/admin/images/chi_logo.jpg);"></div>
   
    <div id="login_container">
    
        <div id="login_inner">
        
            <div class="login_logo"></div>
            
            <? if($error) : ?>
            
            <?=validation_errors()?>
            
            <? elseif($warning) : ?>
            
            <div class="warning notice"></div>
            
            <? endif; ?>
            
            <div class="information notice">Login in to manage your site.</div>
            
            <? $attributes = array('name' => 'login_to_admin', 'id' => 'login_to_admin'); ?>
            
            <?=form_open(base_url().'index.php?admin/login_check',$attributes)?>
            
            <?
			
                $lgn_data = array(
                  'name'        => 'login',
                  'id'          => 'login'
                );
                
                $pwd_data = array(
                  'name'        => 'password',
                  'id'          => 'password'
                );
                
                //$submit_js = 'onClick="submit_login(this); return false;"';
            
            ?>
            
            <label>Login Name:</label>
            
            <?=form_input($lgn_data,'')?>
            
            <label>Password:</label>
            
            <?=form_password($pwd_data,'')?>
            
            <?=form_submit('submit', 'Login');?>
            
            <?=form_close()?>
            
        </div>
        
    </div>

</div>
<script>
    $('#login').focus();
</script>
