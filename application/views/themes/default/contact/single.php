        <!--{{{ MAIN -->
        <div id="main" class="main safe_float_left">
            <!--{{{ PRIMARY_AREA -->
            <div class="primary_area safe_float_left">
                <div id="entries">
                    <div class="entry">
                        <h1 class="cufon">CONTACT</h1>
                         <? if( $this->session->flashdata( 'status' ) != false ) : if( $this->session->flashdata( 'status' ) == "sent" ) : ?>
                         <div class="sccss">You message was successfully sent. You should recieve a response soon.</div>
                         <? elseif( $this->session->flashdata( 'status' ) == "notsent" ) : ?>
                         <div class="err">Something went wrong with the message. Please try again later.</div>
                         <? elseif( $this->session->flashdata( 'status' ) == "error" ) : ?>
                         <?=validation_errors()?>
                         <? endif; endif; ?>
                         <form action="<?=base_url()?>contact/submit" id="chicntct" method="post">
                            <label>
                               Name
                               <span class="">required</span>
                            </label>
                            <input type="text" name="input_name" value="" />
                            <label>
                               Email
                               <span class="">required</span>
                            </label>
                            <input type="text" name="input_email" value="" />
                            <label>
                               Phone  
                               <span class="">suggested</span>
                            </label>
                            <input type="text" name="input_phone" value="" />
                            <label>
                               Message
                               <span class="">required</span>
                            </label>
                            <textarea name="input_message"></textarea>
                            <input type="submit" value="Send" />
                         </form>
                    </div>
                </div>
            </div>
            <!--}}}-->
            <? $this->load->view( theme_relative_path() . 'general/sidebar' ) ?>
        </div>
        <!--}}}-->
