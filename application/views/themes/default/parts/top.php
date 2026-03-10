    <div id="wrapper">
        <!--{{{ HEADER -->
        <div id="header">
            <div id="logo"></div>
            <div id="top_banner">
                <ul id="tiger_banner" class="tiger_slider">
                    <li  class="current" >
                        <a href="">
                            <img src="<?=theme_path()?>images/tiger.jpg" alt="" />
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="<?=theme_path()?>images/tiger_color.jpg" alt="" />
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END HEADER }}}-->
        <!--{{{ MENU -->
        <div id="menu">
            <ul>
                <li>
                    <a <?if( isset( $active_page ) && $active_page == 'home' ) { ?>class="active"<? } ?> href="<?=base_url()?>">home</a>
                </li>
                <li>
                    <a <?if( isset( $active_page ) && $active_page == 'bio' ) { ?>class="active"<? } ?> href="<?=base_url()?>pages/bio">bio</a>
                </li>
                <li>
                    <a <?if( isset( $active_page ) && $active_page == 'blog' ) { ?>class="active"<? } ?> href="<?=base_url()?>blog">blog</a>
                </li>
                <li>
                    <a <?if( isset( $active_page ) && $active_page == 'clients' ) { ?>class="active"<? } ?> href="<?=base_url()?>clients">clients</a>
                </li>
                <li>
                    <a <?if( isset( $active_page ) && $active_page == 'videos' ) { ?>class="active"<? } ?> href="<?=base_url()?>videos">videos</a>
                </li>
                <li>
                    <a <?if( isset( $active_page ) && $active_page == 'contact' ) { ?>class="active"<? } ?> href="<?=base_url()?>contact">contact</a>
                </li>
            </ul>
        </div>
        <!-- END HEADER }}}-->
