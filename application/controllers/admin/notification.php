<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of notification
 *
 * @author Laxmisoft
 */
class Notification extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else {
            
        }
    }

    function index() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/notification');
        $this->load->view('admin/admin_footer');
    }

}
