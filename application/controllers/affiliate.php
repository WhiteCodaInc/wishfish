<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mikhaill
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
        $this->load->view('header');
        $this->load->view('affiliate-join');
        $this->load->view('footer');
    }

    function login() {
        $this->load->view('header');
        $this->load->view('affiliate-login');
        $this->load->view('footer');
    }

    function signup() {
        $post = $this->input->post();
        $msg = $this->objaffiliate->register($post);
        header('location:' . site_url() . 'homepage?msg=' . $msg);
    }

    function signin() {
        $post = $this->input->post();
        if ($this->objaffiliate->login($post)) {
            header('location:' . site_url() . 'homepage');
        } else {
            header('location:' . site_url() . 'login?msg=fail');
        }
    }

}
