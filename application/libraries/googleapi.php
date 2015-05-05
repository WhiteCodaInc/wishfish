<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Googleapi {

    private $_CI;

    function __construct() {

        $this->_CI = & get_instance();
        $this->_CI->config->load('googleplus');

        require APPPATH . 'third_party/google-api/Google_Client.php';
        require APPPATH . 'third_party/google-api/contrib/Google_Oauth2Service.php';

        $cache_path = $this->_CI->config->item('cache_path');
        $GLOBALS['apiConfig']['ioFileCache_directory'] = ($cache_path == '') ? APPPATH . 'cache/' : $cache_path;

        $this->client = new Google_Client();
        $this->client->setApplicationName($this->_CI->config->item('application_name', 'googleplus'));
        $this->client->setClientId($this->_CI->config->item('client_id', 'googleplus'));
        $this->client->setClientSecret($this->_CI->config->item('client_secret', 'googleplus'));
        $this->client->setRedirectUri($this->_CI->config->item('redirect_uri', 'googleplus'));
        $this->client->setDeveloperKey($this->_CI->config->item('api_key', 'googleplus'));

        $this->plus = new Google_Oauth2Service($this->client);
    }

    function logout() {
        $this->_CI->session->unset_userdata('token');
        //unset($_SESSION['token']);
        $this->client->revokeToken();
        header('Location: ' . filter_var($this->client->setRedirectUri, FILTER_SANITIZE_URL)); //redirect user back to page
    }

    function is_login() {
        $code = $this->_CI->input->get('code');
        $token = $this->_CI->session->userdata('token');
        if (isset($code) && $code != "") {
            //print_r($_GET);
            $this->client->authenticate($code);
            $this->_CI->session->set_userdata('token', $this->client->getAccessToken());
            header('Location: ' . filter_var($this->client->setRedirectUri, FILTER_SANITIZE_URL));
            return;
        }


        if (isset($token) && $token != "") {
            $this->client->setAccessToken($token);
        }
        $data = array();
        if ($this->client->getAccessToken()) {
            //For logged in user, get details from google using access token
            $data = $this->plus->userinfo->get();
            //$data['user_id'] = $user['id'];
            //$data['user_name'] = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            //$data['email'] = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            //$data['profile_url'] = filter_var($user['link'], FILTER_VALIDATE_URL);
            //$data['profile_image_url'] = filter_var($user['picture'], FILTER_VALIDATE_URL);
            //$data['personMarkup'] = "$email<div><img src='$profile_image_url?sz=50'></div>";
            $this->_CI->session->set_userdata('token', $this->client->getAccessToken());
            return $data;
        } else {
            //For Guest user, get google login url
            $authUrl = $this->client->createAuthUrl();
            return $authUrl;
        }
    }

    /* public function __call($name, $arguments) {

      if(method_exists($this->plus, $name)) {
      return call_user_func(array($this->plus, $name), $arguments);
      }
      return false;

      } */
}
