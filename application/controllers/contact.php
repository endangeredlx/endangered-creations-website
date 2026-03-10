<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Contact Controller Class
**/
class Contact extends CI_Controller
{
    // {{{ VARIABLES
    var $from_email = 'info@hiphopspaceship.com';
    var $from_name = 'Hip-Hop Spaceship';
    var $to_email = 'dennis@dennismars.com';
    var $bcc_email = 'dpzdpz@gmail.com';
    var $default_subject = 'Hip-Hop Spaceship';
    // }}}
    // {{{ public function Contact()
    public function Contact()
    {
        parent::__construct();
    }
    // }}}
    // --- BASIC VIEW FUNCTIONS --- //
    // {{{ public function index()
    public function index()
    {
        $data = array();
        //$params = array( 'type' => 'page', 'how_many' => 1, 'name' => 'clients' );
        $layout_params = array( 'user_id' => 1, 'page' => 'content' );
        $option_params = array( 'user_id' => 1 );
        $params = array( 
            'type'                  => 'post', 
            'how_many'              => 0, 
            'offset'                => 0, 
            'tumblr'                => 'false', 
            'include_unpublished'   => true, 
            'pages'                 => true 
        );

        // Load the necessary libraries. 
        $this->load->library( 'ChiRecords', $params, 'ChiRecords' );
        $this->load->library( 'ChiPresentation', $layout_params, 'ChiPresentation' );
        $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );

        // Main page configuration.
        $ChiQL =& $this->ChiRecords;
        $Presentation =& $this->ChiPresentation;
        $Options =& $this->ChiOptions;

        $this->load->helper('text');
        // Main data array.
        $data = array(
            'records'           => $ChiQL,
            'presentation'      => $Presentation,
            'options'           => $Options, 
            'page_title'        => 'Contact',
            'page_name'         => 'CONTACT',
            'secondary_name'    => $Options->option_value( 'site_name' ),
            'title'             => 'Contact',
            'type'              => 'contact', 
            'page_type'         => 'contact',
            'main_content'      => $Presentation->theme_relative_path() . 'contact/single'
        );

        $this->load->view( $Presentation->theme_relative_path() . 'clone', $data );
    }
    // }}}
    // --- BASIC ADMIN FUNCTIONS --- //
    // {{{ public function submit()
    public function submit()
    {
        $this->load->library('form_validation');
        //set validation rules...
        $this->form_validation->set_rules( 'input_name', 'name', 'trim|required' );            
        $this->form_validation->set_rules( 'input_email', 'email', 'trim|required|valid_email' );            
        $this->form_validation->set_rules( 'input_message', 'message', 'trim|required' );            
        $this->form_validation->set_error_delimiters( '<div class="err">' , '</div>' );
        if ( $this->form_validation->run() == true ) 
        {
            $message = $this->input->post( 'input_message' );
            $email = $this->input->post( 'input_email' );
            $name = $this->input->post( 'input_name' );
            $phone = $this->input->post( 'input_phone' );
            // Grab options
            $option_params = array( 'user_id' => 1 );
            $this->load->library( 'ChiOptions', $option_params, 'ChiOptions' );
            $op =& $this->ChiOptions;
            $this->load->library('email');
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = true;
            $config['mailtype']     = 'html';
            $this->email->initialize($config);
            $this->email->from( 'website@' . $op->option_value( 'domain_name' ), $op->option_value( 'site_name' ) );
            $this->email->to( $op->option_value( 'main_email' ) );
            $this->email->bcc( $this->bcc_email ); 
            $this->email->subject( 'Message from ' . $op->option_value( 'site_name' ) );
            $htmlemail = "
            <html>
            <head>
            </head>
            <body>
                <font face=\"helvetica\" style=\"font-size:13px;\"><b>message from site visitor</b></font><br>
                    <font face=\"helvetica\" style=\"font-size:10px;\"><b>name : ".$name."</b></font><br>
                    <font face=\"helvetica\" style=\"font-size:10px;\"><b>email : ".$email."</b></font><br><br>
                    <font face=\"helvetica\" style=\"font-size:10px;\"><b>phone : ".$phone."</b></font><br><br>
                    <font face=\"helvetica\" style=\"font-size:10px;\"><b>message :".$message." </b></font><br><br>
            </body>
            </html>";
            $this->email->message( $htmlemail );

            if( $this->email->send() )
            {
                if( $this->input->post( 'ajax' ) == '1' || $this->input->post( 'flash' ) == '1' )
                {
                    echo 'Your message has been sent.';
                }
                else
                {
                    $this->session->set_flashdata( 'status', 'sent' );  
                    redirect( 'contact' );
                }
            }
            else
            {
                if( $this->input->post( 'ajax' ) == '1' || $this->input->post( 'flash' ) == '1' )
                {
                    echo 'There was an error, please try again later.';
                }
                else
                {
                    $this->session->set_flashdata( 'status', 'notsent' );  
                    redirect( 'contact' );
                }
            }
        }
        else 
        {
            $this->session->set_flashdata( 'status', 'error' );  
            $this->index();
        }
    }
    // }}}
    // {{{ public function login_check()
    public function login_check()
    {
        $this->load->model('login_model');
        $query = $this->login_model->validate();
        if( $query['valid'] ) // if the user's credentials validated...
        {
            $data = array(
                'mid'               => $query['id'],
                'login'             => $this->input->post('login'),
                'alias'             => $query['alias'],
                'privilege'         => $query['privilege'],
                'is_logged_in'      => true
            );
            //$this->session->set_userdata($data);
            redirect( 'admin/home' );
        }
        else // incorrect username or password
        {
            redirect( 'admin/index' );
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
} // END CLASS //
?>
