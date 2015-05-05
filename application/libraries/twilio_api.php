<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Twilip Api
 *
 * @author Laxmisoft
 */
class Twilio_api {

//put your code here
    protected $_ci;
    protected $_twilio;
    protected $mode;
    protected $account_sid;
    protected $auth_token;
    protected $api_version;
    protected $number;

    public function __construct() {
        require_once APPPATH . 'third_party/twilio/Services/services_Twilio.php';
        $CI = & get_instance();
        $CI->load->config('twilio', TRUE);

        //get settings from config
        $this->mode = $CI->config->item('mode', 'twilio');
        $this->account_sid = $CI->config->item('account_sid', 'twilio');
        $this->auth_token = $CI->config->item('auth_token', 'twilio');
        $this->api_version = $CI->config->item('api_version', 'twilio');
        $this->number = $CI->config->item('number', 'twilio');

        $client = new Services_Twilio($this->account_sid, $this->auth_token);
        $CI->twilio = $client;
    }

}
