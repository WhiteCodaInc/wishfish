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
class Register extends CI_Controller {

    private $client;
    private $service;

    //put your code here
    function __construct() {
        parent::__construct();


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
        // }
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
        $data['isLogin_f'] = (isset($fid) && $fid != "") ? TRUE : FALSE;
        $data['url'] = $this->client->createAuthUrl();
        $this->load->view('signup', $data);
    }

    function signup() {

        if ($this->input->get('error')) {
            header('location:' . site_url() . 'register');
        }

        $isSignup = array(
            'name' => 'g_isSignup',
            'value' => 1,
            'expire' => time() + 86500,
            'domain' => '.wish-fish.com'
        );
        $this->input->set_cookie($isSignup);

        $code = $this->input->get('code');
        $token = $this->session->userdata('token');
		
		
		
       /* if (isset($token) && $token != "") {
            $this->client->setAccessToken($token);
        }*/

        if (isset($code) && $code != "") {
            $this->client->authenticate($code);
            $this->session->set_userdata('token', $this->client->getAccessToken());

            if ($this->client->getAccessToken()) {
                $data = $this->service->userinfo->get();

                $this->session->set_userdata('token', $this->client->getAccessToken());
                $user = $this->isUserExist($data);

                if (!$user) {
                    $this->objregister->registerWithSocial($data);
                }
                $googleid = array(
                    'name' => 'googleid',
                    'value' => $data['id'],
                    'expire' => time() + 86500,
                    'domain' => '.wish-fish.com'
                );
                $this->input->set_cookie($googleid);
                header('location:' . site_url() . 'app/dashboard');
            } else {
                header('Location: ' . filter_var($this->client->getRedirectUri(), FILTER_SANITIZE_URL));
            }
        }
    }

    function fbsignup() {
        $isSignup = array(
            'name' => 'f_isSignup',
            'value' => 1,
            'expire' => time() + 86500,
            'domain' => '.wish-fish.com'
        );
        $this->input->set_cookie($isSignup);

        $facebook = new Facebook(array(
            'appId' => $this->config->item('appID'),
            'secret' => $this->config->item('appSecret'),
        ));
        $user = $facebook->getUser();
        if ($user) {
            try {
                $user_profile = $facebook->api('/me');  //Get the facebook user profile data
                $is_user = $this->isUserExist($user_profile);
                if (!$is_user) {
                    $this->objregister->registerWithSocial($user_profile);
                }
                $facebookid = array(
                    'name' => 'facebookid',
                    'value' => $user_profile['id'],
                    'expire' => time() + 86500,
                    'domain' => '.wish-fish.com'
                );
                $this->input->set_cookie($facebookid);
                header('location:' . site_url() . 'app/dashboard');
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = NULL;
            }
        }
    }

    function logout() {
        $this->client->revokeToken();
        $this->session->sess_destroy();
        header('Location: ' . site_url() . 'login'); //redirect user back to page
    }

    function isUserExist($data) {
        return $this->objregister->isUserExist($data);
    }

    function create() {
        
    }

    function createAccount() {
        $post = $this->input->post();
        if ($this->authex->can_register($post['email'])) {
            $flag = $this->objregister->register($post);
            if ($flag) {
                header('location:' . site_url() . 'app/dashboard');
            } else {
                header('location:' . site_url() . 'register?msg=RF');
            }
        } else {
            header('location:' . site_url() . 'login?msg=R');
        }
    }

}
