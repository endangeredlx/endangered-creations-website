<?php  if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailinglist extends CI_Controller 
{
    // {{{ VARIABLES 
    var $class          = 'mailinglist';
    var $singular       = 'contact';
    var $plural         = 'contacts';
    var $table          = 'contacts';
    // }}}
    // {{{ public function __construct()
    public function __construct()
    {
        parent::__construct();
    }
    // }}}
    // {{{ public function subscribe()
    public function subscribe()
    {
        $this->load->library('form_validation');
        //Set validation rules...
        $this->form_validation->set_rules( 'hhss_email', 'Email', 'trim|required|valid_email' );            
        // Check that we have a real email.
        if( $this->form_validation->run() == TRUE )
        {
            $email = $this->input->post( 'hhss_email' );
            $this->load->model( 'mailinglist_model', 'mailinglist' );
            // Check that the email isn't already on the list.
            if( ! $this->mailinglist->is_duplicate( $email ) )
            {
                $id = $this->mailinglist->add_to_list( array( 'email' => $email ) ); 
                if( is_numeric( $id ) )
                {
                    $this->send_confirm( $id, $email );
                    $message = 'You\'ve been successfully added to the mailing list.';
                }
            } 
            else 
            {
                $message = 'This email is already on the list.';
            }
        }
        else
        {
            $message = 'Please use a valid email.';
        }

        if( $this->input->post( 'ajax' ) == '1' || $this->input->post( 'flash' ) == '1' )
        {
            echo $message;
        }
        else 
        {
            // What to do if this is not an ajax transaction.
            $this->session->set_flashdata( 'subscribed_message', $message );
            redirect( 'run/index' );
        }
    }
    // }}}
    // {{{ public function send_confirm( $id, $email )
    public function send_confirm( $id, $email )
    {
        $option_params = array( 'user_id' => 1 );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        $options =& $this->ChiOptions;
        $this->load->library('email');
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = true;
        $config['mailtype'] = 'html';
        $this->email->initialize( $config );
        $this->email->from( 'info@' . $options->option_value( 'domain_name' ), $options->option_value( 'site_name' ) );
        $this->email->to( $email );
        $this->email->subject( 'Email Confirmation | ' . $options->option_value( 'site_name' ) . ' Mailing List');
        $confirm_link = base_url() . "mailinglist/verify/" . $id . "/" . md5( $id . $email );
        $htmlemail = "
        <html>
            <head>
            </head>
            <body>
                <font face=\"Helvetica\" style=\"font-size:13px;\"><b>Confirm Your Email</b></font><br>
                <font face=\"Helvetica\" style=\"font-size:11px;\">Click the link below to confirm your email :</font><br><br>
                <a style=\"font-family:Helvetica;font-size:11px;\" href=\"" . $confirm_link . "\">" . $confirm_link . "</a><br><br><br>
                <font face=\"Helvetica\" style=\"font-size:11px;\">If link isn't clickable, copy and paste it into your address bar.</font><br><br>
            </body>
        </html>";
        $this->email->message( $htmlemail );

        if( $this->email->send() )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    // }}}
    // --- BASIC ADMIN FUNCTIONS --- //
    // {{{ public function login_check()
    public function login_check()
    {
        $this->load->model('login_model');
        $query = $this->login_model->validate();
        if($query['valid']) // if the user's credentials validated...
        {
            $data = array(
                'mid'            => $query['id'],
                'login'         => $this->input->post('login'),
                'alias'         => $query['alias'],
                'privilege'    => $query['privilege'],
                'is_logged_in' => true
            );
            //$this->session->set_userdata($data);
            redirect('admin/home');
        }
        else // incorrect username or password
        {
        redirect('admin/index');
        }
    }
    // }}}
    // {{{ public function logout()
    public function logout()
    {
        $this->session->sess_destroy();
        $this->index();
    }
    // }}}
    // {{{ public function is_logged_in()
    public function is_logged_in()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if(!isset($is_logged_in) || $is_logged_in != true) 
        {
        redirect('admin/index');
        }   
    }
    // }}}
    // --- BASIC VIEW FUNCTIONS --- //
    // {{{ public function manage()
    public function manage()
    {
        $this->is_logged_in();
        // Set up a few parameters
        $offset = ( $this->uri->segment( 3 ) == "" ) ? 0 : $this->uri->segment( 3 );
        $offset = ( is_numeric( $offset ) ) ? $offset : 0;
        // Load Records
        $params = array( 
            'type'                  => $this->class, 
            'class'                 => $this->class,
            'how_many'              => 20, 
            'offset'                => $offset, 
            'tumblr'                => 'false', 
            'include_unpublished'   => true, 
            'pages'                 => true 
        );
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $ChiQL =& $this->ChiRecords;
        // Load Options
        $option_params = array( 'user_id' => 1 );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        $Options =& $this->ChiOptions;
        // Load Helpers
        $this->load->helper('date');

        // Main page configuration.
        // Main data array.
        $data = array(
            'records'               => $ChiQL,
            'options'               => $Options, 
            'total'                 => $this->db->get( $this->table )->num_rows(),
            'type'                  => $this->class, 
            'class'                 => $this->class,
            'singular'              => $this->singular,
            'plural'                => $this->plural,
            'javascript'            => array( 'general/admin.basic', $this->class . '/manage' ),
            'main_content'          => 'admin/' . $this->class . '/manage'
        );

        // Pagination Configuration ______
        // Fix for generating the right url based on whether or not we're using an .htaccess file.
        $htfix = ( $Options->htaccess() ) ? '' : 'index.php?';

        $config = array(
            'base_url'           => base_url() . $htfix . $this->class . '/manage/',
            'total_rows'         => $data['total'],
            'per_page'           => $params['how_many'],
            'num_links'          => 8,
            'uri_segment'        => 3,
            'full_tag_open'      => '<div id="pgntn" class="clearfix">',
            'full_tag_close'     => '</div>'
        );
        $this->pagination->initialize( $config );

        // Load view.
        $this->load->view( 'admin/clone', $data ); 
    }
    // }}}
    // {{{ public function edit( $success = false, $warning = false, $error = false )
    public function edit( $success = false, $warning = false, $error = false )
    { 
        $data = array();
        $id = $this->uri->segment( 3 );
        // Set up a few parameters
        $params = array( 
            'type'      => $this->class, 
            'class'     => $this->class,
            'how_many'  => 1, 
            'id'        => $id, 
            'pages'     => true 
        );
        $option_params = array( 'user_id' => 1 );

        // Ensure that any update notifications are true booleans
        $success = ( $success === true || $success === false ) ? $success : false;
        $warning = ( $warning === true || $warning === false ) ? $warning : false;
        $error = ( $error === true || $error === false ) ? $error : false;

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;

        // Main data array.
        $data = array(
            'records'           => $ChiQL,
            'options'           => $Options, 
            'success'           => $success,
            'warning'           => $warning,
            'error'             => $error,
            'class'             => $this->class,
            'main_content'      => 'admin/' . $this->class . '/edit',
            'javascript'        => array( 'general/admin.basic', $this->class . '/edit' ),
            'singular'          => $this->singular
        );

        // Load view.
        $this->load->view( 'admin/clone', $data );
    }
    // }}}
    // {{{ public function plain_text()
    public function plain_text()
    {
        $this->is_logged_in();
        // Set up a few parameters
        $offset = 0;
        $params = array( 
            'type'                  => $this->class, 
            'class'                 => $this->class,
            'how_many'              => 'all', 
            'offset'                => $offset, 
            'tumblr'                => 'false', 
            'include_unpublished'   => false, 
            'pages'                 => true 
        );
        $option_params = array( 'user_id' => 1 );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Options =& $this->ChiOptions;
        // Main data array.
        $data = array(
            'records'               => $ChiQL,
            'options'               => $Options, 
            'type'                  => $this->class, 
            'class'                 => $this->class,
            'singular'              => $this->singular,
            'plural'                => $this->plural,
        );

        // Load view.
        $this->load->view( 'admin/' . $this->class . '/plain', $data ); 
    }
    // }}}
    // {{{ public function verify()
    public function verify()
    {
        $id = $this->uri->segment( 3 );
        $confirm = $this->uri->segment( 4 );
        $this->load->model( 'mailinglist_model', 'mailinglist' ); 
        $contact = $this->mailinglist->get_record( $id );
        if( count( $contact ) == 1 )
        {
            $email_found = true;
            $success = $this->mailinglist->verify( $confirm, $id, $contact[0]->email );
        }
        else
        {
            $email_found = false;
            $success = false;
        }
        $option_params = array( 'user_id' => 1 );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
        $Options =& $this->ChiOptions;
        // Main Data
        $data = array(
            'success'               => $success,
            'email_found'           => $email_found,
            'options'               => $Options
        );
        $this->load->view( 'admin/mailinglist/verify', $data ); 
        
    }
    // }}}
    // --- CRUD FUNCTIONS --- //
    // {{{ public function update()
    public function update()
    {   
        $this->is_logged_in();
        $this->load->helper('text');
        $this->load->model( 'mailinglist_model', 'mailinglist' );
        $this->load->library('form_validation');
        //Set validation rules...
        $this->form_validation->set_rules('email', 'Email', 'trim|required');            
        $this->form_validation->set_error_delimiters('<div class="notice error">', '</div>');

        if( $this->form_validation->run() == TRUE ) 
        {
            $id = $this->uri->segment(3);

            $update = array(
                'email'         => $this->input->post('email'),
            );

            $change = $this->mailinglist->update( $id, $update );
            $success = $change;
            $this->edit( $success );
        } 
        else 
        {   
            $success = false;
            $this->edit( $success, false, true );
        }
    }
    // }}}
    // {{{ public function remove()
    public function remove()
    {
        $this->is_logged_in();
        $id = $this->uri->segment(3);
        $this->load->model( 'mailinglist_model', 'mailinglist');
        $this->mailinglist->delete( $id );
        //$this->links->rewrite_xml();
    }
    // }}}
}
