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
class Affiliate extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('m_affiliate', 'objaffiliate');
    }

    function join() {
        $this->load->view('affiliate-join');
    }

    function login() {
        $this->load->view('affiliate-login');
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
