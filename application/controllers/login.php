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
        require APPPATH . 'third_party/google-api/Google_Client.php';
        require APPPATH . 'third_party/google-api/contrib/Google_Oauth2Service.php';
        require_once APPPATH . 'third_party/facebook/facebook.php';
        $this->config->load('googlelogin');
        $this->config->load('facebook');
        $this->load->model('m_register', 'objregister');

        $this->client = new Google_Client();
        $this->client->setApplicationName($this->config->item('application_name', 'googlelogin'));
        $this->client->setClientId($this->config->item('client_id', 'googlelogin'));
        $this->client->setClientSecret($this->config->item('client_secret', 'googlelogin'));
        $this->client->setRedirectUri($this->config->item('redirect_uri', 'googlelogin'));
        $this->client->setDeveloperKey($this->config->item('api_key', 'googlelogin'));

        $this->service = new Google_Oauth2Service($this->client);
    }

    function index() {
        if ($this->wi_authex->logged_in()) {
            header('location:' . site_url() . 'app/dashboard');
        } else {
            $from = $this->input->get('from');
            $gid = $this->input->cookie('googleid');
            $fid = $this->input->cookie('facebookid');
            if (isset($gid) && $gid != "") {
                $data['isLogin_g'] = TRUE;
                $this->client->setApprovalPrompt('auto');
            } else {
                $data['isLogin_g'] = FALSE;
                $this->client->setApprovalPrompt('force');
            }

            if ($from != "" && $from == "home") {
                header('location:' . $this->client->createAuthUrl());
            } else {
                $data['word'] = $this->wi_common->getRandomDigit(5);
                $this->session->set_userdata('captchaWord', $data['word']);
                $data['isLogin_f'] = (isset($fid) && $fid != "") ? TRUE : FALSE;
                $data['url'] = $this->client->createAuthUrl();

                $data['uname'] = $this->input->cookie('useremail', TRUE);
                $data['passwd'] = $this->input->cookie('password', TRUE);
                $this->load->view('login', $data);
            }
        }
    }

    function signin() {
        $post = $this->input->post();

        if (isset($post['remember'])) {
            $remember = $post['remember'];
            unset($post['remember']);
        }
        if (is_array($post) && count($post) > 0) {
            $is_login = $this->wi_authex->login($post);
            if ($is_login) {
                $this->objregister->linkWithProfile($post['email']);
                if (isset($remember) && $remember == "on")
                    $this->storeCookie($post);
                if ($this->wi_authex->isActivePlan()) {
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

    function gsignin() {
        if ($this->input->get('error')) {
            header('location:' . site_url() . 'login');
        }
        $code = $this->input->get('code');
        if (isset($code) && $code != "") {
            $this->client->authenticate($code);
            $this->session->set_userdata('token', $this->client->getAccessToken());
            if ($this->client->getAccessToken()) {
                $data = $this->service->userinfo->get();
                $this->session->set_userdata('token', $this->client->getAccessToken());
                $user = $this->objregister->isUserExist($data);

                if (!$user) {
                    header('location: ' . site_url() . 'login?msg=NR');
                } else {
                    $this->objregister->linkWithProfile($data['email']);
                    $is_login = array(
                        'name' => 'isLogin',
                        'value' => $data['id'],
                        'expire' => time() + 86500,
                        'domain' => '.wish-fish.com'
                    );
                    $this->input->set_cookie($is_login);
                    header('location:' . site_url() . 'app/dashboard');
                }
            } else {
                header('Location: ' . site_url() . 'login');
            }
        }
    }

    function fbsignin() {
        $facebook = new Facebook(array(
            'appId' => $this->config->item('appID'),
            'secret' => $this->config->item('appSecret'),
        ));
        $user = $facebook->getUser();
        if ($user) {
            try {
                $user_profile = $facebook->api('/me');  //Get the facebook user profile data
                $is_user = $this->objregister->isUserExist($user_profile);
                if (!$is_user) {
                    header('location: ' . site_url() . 'login?msg=NR');
                } else {
                    $is_login = array(
                        'name' => 'isLogin',
                        'value' => $user_profile['id'],
                        'expire' => time() + 86500,
                        'domain' => '.wish-fish.com'
                    );
                    $this->input->set_cookie($is_login);
                    header('location:' . site_url() . 'app/dashboard');
                }
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = NULL;
                header('Location: ' . site_url() . 'login');
            }
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
