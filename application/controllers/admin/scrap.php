<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin_profile
 *
 * @author Laxmisoft
 */
class Scrap extends CI_Controller {

    function __construct() {
        parent::__construct();
//        if (!$this->wi_authex->logged_in()) {
//            header('location:' . site_url() . 'home');
//        } elseif (!$this->wi_authex->isActivePlan()) {
//            header('location:' . site_url() . 'app/upgrade');
//        } else {
//            $this->load->model('dashboard/m_contact_groups', 'objgroup');
//        }
    }

    function index() {
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        $this->load->view('dashboard/scrap');
        $this->load->view('dashboard/footer');
    }

    function linkedin() {
        $url = $this->input->get('query');
        $html = $this->curl_file_get_contents($url);
        echo $html;
    }

    function facebook() {
        $url = "http://graph.facebook.com/" . $this->input->get('query');
        $res = json_decode($this->curl_file_get_contents($url));
        echo '<pre>';
        print_r($res);
        $profile_url = "https://graph.facebook.com/{$res->id}/picture?width=215&height=215";
        $profile = $this->curl_file_get_contents($profile_url);
        echo $profile;
    }

    function curl_file_get_contents($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); //The number of seconds to wait while trying to connect.	
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //To stop cURL from verifying the peer's certificate.
        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }

}
