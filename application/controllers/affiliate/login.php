<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author Laxmisoft
 */
class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header("cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        $this->load->library('authex');
        $this->load->helper('cookie');
        if ($this->authex->alogged_in()) {
            header('location:' . site_url() . 'affiliate/dashboard');
        } else {
            $this->load->model('affiliate/m_login', 'objlogin');
        }
    }

    function index() {
        $data['uname'] = $this->input->cookie('affid', TRUE);
        $data['passwd'] = $this->input->cookie('affpasswd', TRUE);
        $this->load->view('admin/affiliate-login', $data);
    }

    function checkLogin() {
        $post = $this->input->post();
        if (is_array($post) && count($post) > 0) {
            $is_login = $this->authex->alogin($post);
            if ($is_login == 1) {
                $this->storeCookie($post);
                header('location:' . site_url() . 'affiliate/dashboard');
            } else if ($is_login == 2) {
                header('location:' . site_url() . 'affiliate/login?msg=NA');
            } else {
                header('location:' . site_url() . 'affiliate/login?msg=fail');
            }
        } else {
            header('location:' . site_url() . 'affiliate/login');
        }
    }

    function storeCookie($post) {
        if (isset($post['remember']) && $post['remember'] == "on") {
            $userid = array(
                'name' => 'affid',
                'value' => $post['affid'],
                'expire' => time() + (3600 * 24 * 7),
            );
            $this->input->set_cookie($userid);
            $password = array(
                'name' => 'affpasswd',
                'value' => $post['password'],
                'expire' => time() + (3600 * 24 * 7),
            );
            $this->input->set_cookie($password);
        }
        return TRUE;
    }

    function register() {
        $this->load->view('affiliate/register');
    }

    function createProfile() {
        $post = $this->input->post();
        $this->objlogin->createProfile($post);
        header('location:' . site_url() . 'affiliate/login');
    }

}
