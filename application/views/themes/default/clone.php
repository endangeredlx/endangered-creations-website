<?
   // This 'Clone' sets up the general structure of pages.
   $this->load->view( theme_relative_path() . 'parts/head' );
   $this->load->view( theme_relative_path() . 'parts/top' ); 
   $this->load->view( $main_content );
   $this->load->view( theme_relative_path() . 'parts/footer' );
?>
