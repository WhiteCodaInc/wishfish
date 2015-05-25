<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author Laxmisoft
 */
class Import extends CI_Controller {

    var $sess_data = array(), $userid;

    //put your code here
    function __construct() {
        parent::__construct();
        require APPPATH . 'third_party/google-api/Google_Client.php';
        $this->config->load('googlecontact');

        $this->client = new Google_Client();
        $this->client->setApplicationName($this->config->item('application_name', 'googlecontact'));
        $this->client->setClientId($this->config->item('client_id', 'googlecontact'));
        $this->client->setClientSecret($this->config->item('client_secret', 'googlecontact'));
        $this->client->setRedirectUri($this->config->item('redirect_uri', 'googlecontact'));
        $this->client->setDeveloperKey($this->config->item('api_key', 'googlecontact'));
        $this->client->setScopes("http://www.google.com/m8/feeds/");

        $this->userid = $this->session->userdata('userid');
    }

    function index() {
        header('location:' . $this->client->createAuthUrl());
    }

    public function contacts() {
        if ($this->input->get('error') == "access_denied") {
            header('location:' . site_url() . 'app/dashboard');
        }
        $authcode = $this->input->get('code');
        $clientid = $this->client->getClientId();
        $clientsecret = $this->client->getClientSecret();
        $redirecturi = $this->client->getRedirectUri();
        $max_result = 100;
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        $fields = array(
            'code' => urlencode($authcode),
            'client_id' => urlencode($clientid),
            'client_secret' => urlencode($clientsecret),
            'redirect_uri' => urlencode($redirecturi),
            'grant_type' => urlencode('authorization_code')
        );


        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        $fields_string = rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
        curl_setopt($ch, CURLOPT_POST, 5);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        // Set so curl_exec returns the result instead of outputting it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //to trust any ssl certificates
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);

        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);

        //extracting access_token from response string
        $responseToken = json_decode($result);
        if (isset($responseToken->access_token)) {
            $accesstoken = $responseToken->access_token;
            $this->session->set_userdata('token', $accesstoken);

            //passing accesstoken to obtain contact details
            $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=' . $max_result . '&alt=json&v=3.0&oauth_token=' . $this->session->userdata('token');

            $response = $this->curl_file_get_contents($url);
            $contacts = json_decode($response, true);
            $gc = array();
            foreach ($contacts['feed']['entry'] as $cnt) {
                $name = $cnt['title']['$t'];
                $email = (isset($cnt['gd$email'])) ? $cnt['gd$email']['0']['address'] : '';
                $phone = (isset($cnt['gd$phoneNumber'])) ? $cnt['gd$phoneNumber']['0']['$t'] : '';
                $gc[] = array('name' => $name, 'email' => $email, 'phone' => $phone);
            }
            $data['gc'] = $gc;
            $data['url'] = $this->client->createAuthUrl();

            $this->load->view('dashboard/header');
            $this->load->view('dashboard/import', $data);
            $this->load->view('dashboard/footer');
        } else {
//            header('location:' . site_url() . 'app/dashboard');
        }
    }

    function addContacts() {
        $post = $this->input->post();
        foreach ($post['contact'] as $value) {
            $name = explode(' ', $post['name'][$value]);
            $set = array(
                'user_id' => $this->userid,
                'fname' => $name[0],
                'lname' => $name[1]
            );
            ($post['email'][$value]) ? $set['email'] = $post['email'][$value] : '';
            ($post['phone'][$value]) ? $set['phone'] = $post['phone'][$value] : '';

            $this->db->insert('wi_contact_detail', $set);
        }
        header('location:' . site_url() . 'app/contacts');
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
