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
class Join extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('affiliate/m_affiliate', 'objaffiliate');
    }

    function index() {
        $this->load->view('affiliate/affiliate-join');
    }

    function signup() {
        $post = $this->input->post();
        $res = $this->wi_authex->aff_can_register($post['email']);
        if ($res) {
            $flag = $this->objaffiliate->register($post);
            if ($flag) {
                header('location:' . site_url() . 'affiliate/dashboard');
            } else {
                header('location:' . site_url() . 'affiliate/join?msg=RF');
            }
        } else {
            header('location:' . site_url() . 'affiliate/login?msg=E');
        }
    }

}
