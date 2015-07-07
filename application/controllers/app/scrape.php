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
        if (!$this->wi_authex->logged_in()) {
            header('location:' . site_url() . 'home');
        } else {
            $this->load->library('amazons3');
            $this->config->load('aws');
            $this->userid = $this->session->userdata('u_userid');
            $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
            $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
            $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));
        }
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

    function facebook($userid = NULL) {
        $base_url = "https://www.facebook.com/";
        $uid = ($userid != NULL) ? $userid : $this->input->post('userid');
        $html = $this->curl_file_get_contents($base_url . $uid);
//        echo $html;

        $dom = new DOMDocument();
        @$dom->loadHTML($html, 0);
        $nodes = $dom->getElementsByTagName('title');
        $data['name'] = $nodes->item(0)->nodeValue;

//        $res = $this->curl_file_get_contents($url);
//        if (!isset($res->error)) {
        $img_path = FCPATH . "user.jpg";
        if (file_exists($img_path)) {
            unlink($img_path);
        }
//        $img_path = file_get_contents($img_path);
        copy("http://graph.facebook.com/{$userid}/picture?width=215&height=215", $img_path);
        $data['profile'] = base_url() . 'user.jpg';

        echo "<img src='{$img_path}' alt=''>";

//        } else {
//            echo 0;
//        }
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
                'user_id' => $this->userid,
                'fname' => $post['fname'],
                'lname' => $post['lname']
            );
            $this->db->insert('wi_contact_detail', $set);
            $insertid = $this->db->insert_id();

            if ($post['type'] != "facebook") {
                $img_url = FCPATH . "user.jpg";
                copy($post['url'], $img_url);
            } else {
                $img_url = FCPATH . "user.jpg";
            }

            $fname = 'wish-fish/contacts/contact_avatar_' . $insertid . '.jpg';
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            if ($this->s3->putObjectFile($img_url, $this->bucket, $fname, "public-read")) {
                $this->db->update('wi_contact_detail', array('contact_avatar' => $fname), array('contact_id' => $insertid));
            }
            unlink($img_url);
            echo 1;
        } else {
            header('location:' . site_url() . 'app/dashboard');
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
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //To stop cURL from verifying the peer's certificate.
        /* Tell Facebook that we are using a valid browser */
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13');
        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }

    function fb() {
        /* Email to Search By */
        $eml = 'sanjayvekariya18@gmail.com';

        /* This is where we are going to search.. */
        $url = 'http://www.facebook.com/search.php?q=' . urlencode($eml);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); //The number of seconds to wait while trying to connect.	
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //To stop cURL from verifying the peer's certificate.
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13');
        $response = curl_exec($curl);
        echo $response . '<br>';
        $response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        echo $response_code . '<br>';
        curl_close($curl);
        if ($response_code == 200) {

            /* Parse HTML Response */
            $dom = new DOMDocument();
            @$dom->loadHTML($response);

            /* What we are looking for */
            $match = 'http://www.facebook.com/profile.php?id=';

            /* Facebook UIDs */
            $uids = array();

            /* Find all Anchors */
            $anchors = $dom->getElementsByTagName('a');

            foreach ($anchors as $anchor) {
                echo $anchor . '<br>';
                $href = $anchor->getAttribute('href');
                if (stristr($href, $match) !== false) {
                    $uids[] = str_replace($match, '', $href);
                }
            }

            /* Found Facebook Users */
            if (!empty($uids)) {

                /* Return Unique UIDs */
                $uids = array_unique($uids);

                /* Show Results */
                foreach ($uids as $uid) {

                    /* Profile Picture */
                    echo '<img src="http://graph.facebook.com/' . $uid . '/picture" alt="' . $uid . '" />';
                }
            }
        }
        //return $contents;
    }

}
