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
class Admin_login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header("cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        $this->load->library('authex');
        $this->load->helper('cookie');
        if ($this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/dashboard');
        } else {
            $this->load->model('admin/m_admin_login', 'objlogin');
        }
    }

    function index() {
        $data['uname'] = $this->input->cookie('userid', TRUE);
        $data['passwd'] = $this->input->cookie('password', TRUE);
        $this->load->view('admin/admin-login', $data);
    }

    function login() {
        $post = $this->input->post();
        if (is_array($post) && count($post) > 0) {
            $is_login = $this->authex->login($post);
            if ($is_login) {
                $this->storeCookie($post);
                header('location:' . site_url() . 'admin/dashboard');
            } else {
                header('location:' . site_url() . 'admin/admin_login?msg=fail');
            }
        } else {
            header('location:' . site_url() . 'admin/admin_login');
        }
    }

    function storeCookie($post) {
        if (isset($post['remember']) && $post['remember'] == "on") {
            $userid = array(
                'name' => 'userid',
                'value' => $post['userid'],
                'expire' => time() + (3600 * 24 * 7),
            );
            $this->input->set_cookie($userid);
            $password = array(
                'name' => 'password',
                'value' => $post['password'],
                'expire' => time() + (3600 * 24 * 7),
            );
            $this->input->set_cookie($password);
        }
        return TRUE;
    }

    function register() {
        $this->load->view('admin/register');
    }

    function createProfile() {
        $post = $this->input->post();
        $this->objlogin->createProfile($post);
        header('location:' . site_url() . 'admin/admin_login');
    }

}
