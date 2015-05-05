<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author Laxmisoft
 */
class Beta extends CI_Controller {

    function __construct() {
        parent::__construct();
        require APPPATH . 'third_party/Mailgun/Mailgun.php';
        require APPPATH . 'third_party/google-api/contrib/Google_Oauth2Service.php';
        require APPPATH . 'third_party/facebook/facebook.php';
        $this->load->library('authex');
        $this->load->helper('cookie');
        $this->config->load('googleplus');
        $this->config->load('facebook');
        $this->load->model('m_register', 'objregister');
        //-------------Google---------------------------------//
        $this->client = new Google_Client();
        $this->client->setApplicationName($this->config->item('application_name', 'googleplus'));
        $this->client->setClientId($this->config->item('client_id', 'googleplus'));
        $this->client->setClientSecret($this->config->item('client_secret', 'googleplus'));
        $this->client->setRedirectUri($this->config->item('redirect_uri', 'googleplus'));
        $this->client->setDeveloperKey($this->config->item('api_key', 'googleplus'));

        $this->service = new Google_Oauth2Service($this->client);

        //-----------------Mail Gun--------------------------//
        $this->mgClient = new Mailgun('key-acfdb718a88968c616bcea83e1020909');
        $this->listAddress = 'wish-fish@mg.wish-fish.com';
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
        $data['pdetail'] = $this->common->getPlans();
        $data['gatewayInfo'] = $this->common->getPaymentGatewayInfo("STRIPE");
        $this->load->view('header');
        $this->load->view('slider', $data);
        $this->load->view('home', $data);
        $this->load->view('footer');
    }

    function createMailList() {
        $result = $this->mgClient->post("lists", array(
            'address' => 'wish-fish@mg.wish-fish.com',
            'description' => 'Mailgun Dev List'
        ));
        print_r($result);
    }

    function subscribe() {
        # Issue the call to the client.
        $result = $this->mgClient->post("lists/$this->listAddress/members", array(
            'address' => 'bar@example.com',
            'name' => 'Bob Bar',
            'description' => 'Developer',
            'subscribed' => true,
            'vars' => '{"age": 26}'
        ));
    }

}
