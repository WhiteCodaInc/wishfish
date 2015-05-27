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
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else {
            $this->load->library('amazons3');
            $this->config->load('aws');
            $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
            $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
            $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));
        }
    }

    function index() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/scrap');
        $this->load->view('admin/admin_footer');
    }

    function linkedin() {
        $url = $this->input->post('url');
        $html = $this->curl_file_get_contents($url);
        echo $html;
    }

    function facebook() {
        $base_url = "http://graph.facebook.com/";
        $userid = $this->input->post('userid');
        $url = $base_url . $userid;
        $res = json_decode($this->curl_file_get_contents($url));
        if (!isset($res->error)) {
            $img_path = FCPATH . "user.jpg";
            copy("{$url}/picture?width=215&height=215", $img_path);
            $res->profile = base_url() . 'user.jpg';
            echo json_encode($res);
        } else {
            echo 0;
        }
    }

    function addContact() {
        $post = $this->input->post();
        if (is_array($post) && count($post)) {
            $set = array(
                'fname' => $post['fname'],
                'lname' => $post['lname']
            );
            $this->db->insert('contact_detail', $set);
            $insertid = $this->db->insert_id();

            $img_url = FCPATH . "user.jpg";
            $fname = 'wish-fish/admin/contacts/contact_avatar_' . $insertid . '.jpg';
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            if ($this->s3->putObjectFile($img_url, $this->bucket, $fname, "public-read")) {
                $this->db->update('contact_detail', array('contact_avatar' => $fname), array('contact_id' => $insertid));
            }
            unlink($img_url);
            echo 1;
        } else {
            header('location:' . site_url() . 'admin/scrap');
        }
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
