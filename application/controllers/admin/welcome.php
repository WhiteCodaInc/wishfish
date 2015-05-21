<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
        $this->load->library('cpanel_api');
    }

    public function index() {
        ini_set("max_execution_time", 360);
        $mail = $this->cpanel_api->mail()->list_mail();
        echo '<pre>';
        print_r($mail);
        //$this->load->view('admin/welcome_message');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */