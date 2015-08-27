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
            $joinVia = array(
                'name' => 'JoinVia',
                'value' => 'home',
                'expire' => 3600,
                'domain' => '.wish-fish.com'
            );
            $this->input->set_cookie($joinVia);
            header('location:' . $this->client->createAuthUrl());
        } else {
            $joinVia = array(
                'name' => 'JoinVia',
                'value' => 'register',
                'expire' => 3600,
                'domain' => '.wish-fish.com'
            );
            $this->input->set_cookie($joinVia);
            $data['isLogin_f'] = (isset($fid) && $fid != "") ? TRUE : FALSE;
            $data['url'] = $this->client->createAuthUrl();
            $this->load->view('signup', $data);
        }
    }

    function signup() {
        if ($this->input->get('error')) {
            header('location:' . site_url() . 'register');
        }
        $code = $this->input->get('code');

        if (isset($code) && $code != "") {
            $this->client->authenticate($code);
            if ($this->client->getAccessToken()) {
                $data = $this->service->userinfo->get();
                $user = $this->objregister->isUserExist($data);
                if (!$user) {
                    if ($this->objregister->registerWithSocial($data, "google")) {
                        $googleid = array(
                            'name' => 'googleid',
                            'value' => $data['id'],
                            'expire' => time() + 86500,
                            'domain' => '.wish-fish.com'
                        );
                        $this->input->set_cookie($googleid);
                        header('location:' . site_url() . 'app/dashboard');
                    } else {
                        header('Location: ' . site_url() . 'register?msg=RF');
                    }
                } else {
//                    header('Location: ' . site_url() . 'login?signin=google&msg=R');
                    header('Location: ' . site_url() . 'login?msg=' . $user);
                }
            } else {
                header('Location: ' . site_url() . 'register?msg=RF');
            }
        }
    }

    function fbsignup() {
        $from = $this->input->get('from');
        if ($from != "" && $from == "home") {
            $joinVia = array(
                'name' => 'JoinVia',
                'value' => 'home',
                'expire' => 3600,
                'domain' => '.wish-fish.com'
            );
            $this->input->set_cookie($joinVia);
        } else {
            $joinVia = array(
                'name' => 'JoinVia',
                'value' => 'register',
                'expire' => 3600,
                'domain' => '.wish-fish.com'
            );
            $this->input->set_cookie($joinVia);
        }

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
                    if ($this->objregister->registerWithSocial($user_profile, "facebook")) {
                        $facebookid = array(
                            'name' => 'facebookid',
                            'value' => $user_profile['id'],
                            'expire' => time() + 86500,
                            'domain' => '.wish-fish.com'
                        );
                        $this->input->set_cookie($facebookid);
                        header('location:' . site_url() . 'app/dashboard');
                    } else {
                        header('location: ' . site_url() . 'register?msg=RF');
                    }
                } else {
//                    header('Location: ' . site_url() . 'login?signin=fb&msg=R');
                    header('Location: ' . site_url() . 'login?msg=' . $is_user);
                }
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

    function createAccount() {
        $post = $this->input->post();
        $res = $this->wi_authex->can_register($post['email']);
        if (!$res) {
            $flag = $this->objregister->register($post);
            if ($flag) {
                header('location:' . site_url() . 'app/dashboard');
            } else {
                header('location:' . site_url() . 'register?msg=RF');
            }
        } else {
            header('location:' . site_url() . 'login?msg=' . $res);
        }
    }

    function getAppRequest() {
        $app_id = '1685645121664692';
        $app_secret = 'efd44cb34c6d6330dbc9f5c4bc7a69c3';
        $friend_id = '100001185072454';

        $token_url = "https://graph.facebook.com/oauth/access_token?" .
                "client_id=" . $app_id .
                "&client_secret=" . $app_secret .
                "&grant_type=client_credentials";

//your app access token
        $app_access_token = file_get_contents($token_url);

        $apprequest_url = "https://graph.facebook.com/" .
                $friend_id .
                "/apprequests?message='some message'&" .
                $app_access_token . "&method=post";

//        $result = file_get_contents($apprequest_url);
//        echo $result;


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apprequest_url); //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); //The number of seconds to wait while trying to connect.	
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //To stop cURL from verifying the peer's certificate.
        /* Tell Facebook that we are using a valid browser */
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13');
        $contents = curl_exec($curl);
        curl_close($curl);
        echo $contents;
    }

}
