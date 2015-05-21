<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logout
 *
 * @author Laxmisoft
 */
class Logout extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        
    }

    function index() {
//        $this->session->unset_userdata('userid');
//        $this->session->unset_userdata('name');
//        $this->session->unset_userdata('email');
        $this->wi_authex->logout();
        //header('location:' . site_url() . 'home');
    }

}
