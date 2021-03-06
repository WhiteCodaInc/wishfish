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
class Scrape extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
//        } else if (!$this->common->getPermission()->contacts) {
//            header('location:' . site_url() . 'admin/dashboard/error/500');
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
        $this->load->view('admin/scrape');
        $this->load->view('admin/admin_footer');
    }

    function linkedin() {
        $url = $this->input->post('url');
        $html = $this->curl_file_get_contents($url);
        echo $html;
    }

    function twitter() {
        $base_url = "https://twitter.com/";
        $userid = $this->input->post('userid');
        $html = $this->curl_file_get_contents($base_url . $userid);
        echo $html;
    }

    function facebook() {
        $src = "";
        $base_url = "https://www.facebook.com/";
        $uid = $this->input->post('userid');
        $html = $this->curl_file_get_contents($base_url . $uid);

        $page = str_replace(array('<!--', '-->'), '', $html);
        $dom = new DOMDocument();
        @$dom->loadHTML($page, 0);

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $image) {
            if ($image->getAttribute('class') == "profilePic img") {
                $src = $image->getAttribute('src');
            }
        }
        $nodes = $dom->getElementsByTagName('title');
        $name = explode('|', $nodes->item(0)->nodeValue);

        if (isset($name[0]) && trim($name[0]) == "Page Not Found") {
            echo '0';
        } else if (isset($name[0]) && trim($name[0]) == "Facebook") {
            echo '1';
        } else {
            $data['profile'] = $src;
            $data['name'] = $name[0];
            echo json_encode($data);
        }
    }

//    function facebook() {
//        $base_url = "http://graph.facebook.com/";
//        $userid = $this->input->post('userid');
//        $url = $base_url . $userid;
//        $res = json_decode($this->curl_file_get_contents($url));
//        if (!isset($res->error)) {
//            $img_path = FCPATH . "user.jpg";
//            if (file_exists($img_path)) {
//                unlink($img_path);
//            }
//            copy("{$url}/picture?width=215&height=215", $img_path);
//            $res->profile = base_url() . 'user.jpg';
//            echo json_encode($res);
//        } else {
//            echo 0;
//        }
//    }

    function addContact() {
        $post = $this->input->post();

        if (is_array($post) && count($post)) {
            $set = array(
                'fname' => $post['fname'],
                'lname' => $post['lname']
            );
            $this->db->insert('contact_detail', $set);
            $insertid = $this->db->insert_id();

            $img_url = FCPATH . "import/user.jpg";
            copy($post['url'], $img_url);

            $fname = 'contacts/contact_avatar_' . $insertid . '.jpg';
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            if ($this->s3->putObjectFile($img_url, $this->bucket, $fname, "public-read")) {
                $this->db->update('contact_detail', array('contact_avatar' => $fname), array('contact_id' => $insertid));
            }
            unlink($img_url);
            echo 1;
        } else {
            header('location:' . site_url() . 'admin/scrape');
        }
    }

    function curl_file_get_contents($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); //The number of seconds to wait while trying to connect.	
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE); //To stop cURL from verifying the peer's certificate.
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13');
        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }

}
