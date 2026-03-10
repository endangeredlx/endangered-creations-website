   <!-- BEGIN MAIN CONTENT -->
   <div id="cntwrp">
      <!-- BEGIN FULL CONTENT -->
      <div id="flcnt" class="grid_12 blkBg">
         <div class="flwdhdr">
            <div class="hfcnt">
               <h2 class="largeTitle white">Don't Have an Account?</h2>
               <h3 class="mediumTitle purple">Sign-Up Here</h3>
               <? if( $success === false ) : ?>
                  <?=validation_errors()?>
               <? endif; ?>
               <? if( $success !== true ) : ?>
               <form action="<?=safe_url()?>user/register" enctype="multipart/form-data" name="signup" id="signup" method="post">
                  <label for="first_name">First Name</label>
                  <input type="text" id="first_name" value="" name="first_name" />
                  <label for="last_name">Last Name</label>
                  <input type="text" name="last_name" value="" id="last_name" />
                  <label for="username">Username</label>
                  <input type="text" name="username" value="" id="username" />
                  <label for="email">Email</label>
                  <input type="text" name="email" value="" id="email" />
                  <label for="email">Re-Enter Email</label>
                  <input type="text" name="emailconf" value="" id="emailconf" />
                  <label for="newpassword">New Password</label>
                  <input type="password" name="newpassword" value="" id="newpassword" />
                  <input type="submit" value="Sign Up" class="white prpBg" />
               </form>
               <? endif; ?>
               <? if( $success === true ) : ?>
               <div class="registerSuccess">
                  <h3 class="smallTitle">Success</h3>
                  <p>You&#39;ve successfully registered as a member on <strong class="light_purple">DominiqueDebeau.com!</strong><br /> Go to your email and click the verification link to finish registration.</p>
               </div>
               <? endif; ?>
            </div>
            <div class="hfcnt">
               <h2 class="largeTitle white">Already a Member?</h2>
               <h3 class="mediumTitle purple">Login</h3>
               <form action="<?=safe_url()?>user/login" enctype="multipart/form-data" method="post" name="signin" id="signin" >
                  <label for="login">Email or Username</label>
                  <input type="text" name="login" value="" id="login" />
                  <label for="password">Password</label>
                  <input type="password" name="password" value="" id="password" />
                  <input type="submit" value="Login" class="white prpBg" />
               </form>
            </div>
         </div>
      </div>
      <!-- END FULL CONTENT -->
   </div>
   <!-- END MAIN CONTENT -->
</div>
<!-- END 960 CONTAINER -->
