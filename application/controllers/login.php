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

    //put your code here
    function __construct() {
        parent::__construct();

        if ($this->authex->logged_in()) {
            header('location:' . site_url() . 'app/dashboard');
        } else {

            require APPPATH . 'third_party/google-api/Google_Client.php';
            require APPPATH . 'third_party/google-api/contrib/Google_Oauth2Service.php';
            require_once APPPATH . 'third_party/facebook/facebook.php';
            $this->load->library('authex');
            $this->load->helper('cookie');
            $this->config->load('googleplus');
            $this->config->load('facebook');
            $this->load->model('m_register', 'objregister');

            $this->client = new Google_Client();
            $this->client->setApplicationName($this->config->item('application_name', 'googleplus'));
            $this->client->setClientId($this->config->item('client_id', 'googleplus'));
            $this->client->setClientSecret($this->config->item('client_secret', 'googleplus'));
            $this->client->setRedirectUri($this->config->item('redirect_uri', 'googleplus'));
            $this->client->setDeveloperKey($this->config->item('api_key', 'googleplus'));

            $this->service = new Google_Oauth2Service($this->client);

            $this->load->library('authex');
            $this->load->helper('cookie');
        }
    }

    function index() {
        $gid = $this->input->cookie('googleid');
        $fid = $this->input->cookie('facebookid');
        if (isset($gid) && $gid != "") {
            $data['isLogin_g'] = TRUE;
            $this->client->setApprovalPrompt('auto');
        } else {
            $data['isLogin_g'] = FALSE;
            $this->client->setApprovalPrompt('force');
        }
        $data['word'] = $this->common->getRandomDigit(5);
        $this->session->set_userdata('captchaWord', $data['word']);
        $data['isLogin_f'] = (isset($fid) && $fid != "") ? TRUE : FALSE;
        $data['url'] = $this->client->createAuthUrl();

        $data['uname'] = $this->input->cookie('useremail', TRUE);
        $data['passwd'] = $this->input->cookie('password', TRUE);
        $this->load->view('login', $data);
    }

    function signin() {
        $post = $this->input->post();
        if (isset($post['remember'])) {
            $remember = $post['remember'];
            unset($post['remember']);
        }
        if (is_array($post) && count($post) > 0) {
            $is_login = $this->authex->login($post);
            if ($is_login) {
                if (isset($remember) && $remember == "on")
                    $this->storeCookie($post);
                if ($this->authex->isActivePlan()) {
                    header('location:' . site_url() . 'app/dashboard');
                } else {
                    header('location:' . site_url() . 'app/upgrade');
                }
            } else {
                header('location:' . site_url() . 'login?msg=F');
            }
        } else {
            header('location:' . site_url() . 'login');
        }
    }

    function storeCookie($post) {
        $userid = array(
            'name' => 'useremail',
            'value' => $post['email'],
            'expire' => time() + (3600 * 24 * 7),
        );
        $this->input->set_cookie($userid);
        $password = array(
            'name' => 'password',
            'value' => $post['password'],
            'expire' => time() + (3600 * 24 * 7),
        );
        $this->input->set_cookie($password);
        return TRUE;
    }

}
