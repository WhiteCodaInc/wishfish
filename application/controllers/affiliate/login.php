<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Wish-Fish
 *
 * @author Laxmisoft
 */
class Login extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('affiliate/m_affiliate', 'objaffiliate');
    }

    function index() {
        $this->load->view('affiliate/affiliate-login');
    }

}
