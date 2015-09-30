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
        $this->load->view('header');
        $this->load->view('affiliate-join');
    }

    function login() {
        $this->load->view('header');
        $this->load->view('affiliate-login');
        $this->load->view('footer');
    }

    function signup() {
        header('location:' . site_url() . 'affiliate/join');
        $post = $this->input->post();
        if ($this->objaffiliate->isAffiliateExist($post)) {
            header('location:' . site_url() . 'affiliate/join?msg=R');
        } else {
            $msg = $this->objaffiliate->register($post);
            header('location:' . site_url() . 'affiliate/login');
        }
    }

    function signin() {
        header('location:' . site_url() . 'affiliate/login');
        $post = $this->input->post();
        if ($this->objaffiliate->login($post)) {
            header('location:' . site_url() . 'homepage');
        } else {
            header('location:' . site_url() . 'login?msg=fail');
        }
    }

}
