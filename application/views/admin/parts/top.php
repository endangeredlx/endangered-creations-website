<!-- {{{ MENU AREA -->
<div id="menu_wrapper" class="clearfix">

    <? if( $this->session->userdata('is_logged_in') ) : ?>

    <ul id="main_menu">  <!-- Drop Down Menu -->
        <li>
            <a href="<?=base_url() . 'admin/home' ?>" class="logo">
                <div id="logo"></div>
            </a>
        </li>
        <li>
            <a href="<?=base_url()."admin/home"?>" class="mm_item"> 
                Home
            </a>  
        </li>
        <li>
            <a href="<?=base_url()."features/manage"?>" class="mm_item"> 
            Features
            </a>  
        </li>
        <!--
        <li>
            <a href="<?=base_url()."links/manage"?>" class="mm_item"> 
            Links
            </a>  
        </li>
        -->
        <li>
            <a href="#" class="mm_item has_sub"> 
            Pages 
            </a>  
            <ul class="submenu" style="display:none;">
                <? if( there_are_pages() ) : while( there_are_pages() ) : next_page(); ?>
                <li>
                    <a href="<?=base_url()?>pages/edit/<?=page_id()?>/<?=page_name()?>" class="mm_item">
                        <?=page_title()?>
                    </a>
                </li>
                <? endwhile; endif; ?>
            </ul>
        </li>
        <li>
            <a href="<?=base_url()."entries/manage"?>" class="mm_item"> 
                Blog & Videos
            </a>  
        </li>
        <!--
        <li>
            <a href="<?=base_url()."events/manage"?>" class="mm_item"> 
                Events
            </a>  
        </li>
        -->
        <!--
        <li>
            <a href="<?=base_url() . 'team/manage'?>" class="mm_item"> 
                Artists
            </a>  
        </li>
        -->
        <!--
        <li>
            <a href="<?=base_url() . 'store/manage'?>" class="mm_item"> 
                Store
            </a>  
        </li>
        -->
        <!--
        <li>
            <a href="<?=base_url() . 'downloads/manage'?>" class="mm_item"> 
                Downloads
            </a>  
        </li>
        -->
        <li>
            <a href="<?=base_url() . 'clients/manage'?>" class="mm_item"> 
                Clients
            </a>  
        </li>
        <li>
        <!--
        <li>
            <a href="#" class="mm_item has_sub"> 
                Media 
            </a>  
            <ul class="submenu" style="display:none;">
                <li>
                    <a href="<?=base_url()."photos/manage"?>" class="mm_item"> 
                        Photos
                    </a>  
                </li>
                <li>
                    <a href="<?=base_url()."music/manage"?>" class="mm_item"> 
                        Music 
                    </a>  
                </li>
                <li>
                    <a href="<?=base_url()."video/manage"?>" class="mm_item"> 
                        Video
                    </a>  
                </li>
            </ul>
        </li>
        -->
        <? if( $this->session->userdata( 'privilege' ) == "superuser" ) : ?>
        <li>
            <a href="#" class="mm_item has_sub"> 
                More Options
            </a>  
            <ul class="submenu" style="display:none;">
                <!--
                <li>
                    <a href="<?=base_url()."pages/manage"?>" class="mm_item"> 
                        Manage Pages
                    </a>  
                </li>
                -->
                <li>
                    <a href="<?=base_url()."options/edit"?>" class="mm_item"> 
                        Site Options
                    </a>  
                </li>
            </ul>
        </li>
        <? endif; ?>
        <li>
            <a href="<?=base_url()."admin/logout"?>" class="mm_item"> 
                Logout
            </a>  
        </li>
    </ul>
<? endif; ?>
</div>
<!-- }}} -->
<!-- {{{ OPTION REFERENCE -->
<? if( $this->session->userdata('is_logged_in') ) : ?>
<? if( is_relative() ) : ?>
<div class="options_reference">
    <div class="center_wrap">
    <a class="button_link_blue" href="<?=base_url() . relative( 'class' ) . '/' . relative( 'function' ) . '/' . relative( 'id' )?>">
        <strong>Back To <?=relative( 'title' )?></strong>
        </a>
    </div>
</div>
<? endif; ?>
<!-- }}} -->
<? endif; ?>
<div id="wrapper">
