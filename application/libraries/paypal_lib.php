<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**

 * */
class Paypal_lib extends CI_Controller {

    var $is_sandbox = FALSE;
    var $_errors = array();
    var $_endPoint = '';
    var $_version = '74.0';

    function __construct() {
        parent::__construct();
    }

    function set_acct_info($user_id, $password, $sign) {
        //Set 2Checkout account details
        $this->_credentials = array(
            'USER' => $this->is_sandbox ? $user_id : '',
            'PWD' => $this->is_sandbox ? $password : '',
            'SIGNATURE' => $this->is_sandbox ? $sign : '',
        );
        $this->_endPoint = $this->is_sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : '';
//        $this->_endPoint = $this->is_sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';
    }

    /**
     * Make API request
     *
     * @param string $method string API method to request
     * @param array $params Additional request parameters
     * @return array / boolean Response array / boolean false on failure
     */
    function request($method, $params = array()) {
        $this->_errors = array();
        if (empty($method)) { //Check if API method is not empty
            $this->_errors = array('API method is missing');
            return false;
        }

        //Our request parameters
        $requestParams = array(
            'METHOD' => $method,
            'VERSION' => $this->_version
                ) + $this->_credentials;

        //Building our NVP string
        $request = http_build_query($requestParams + $params);



        //cURL settings
        $curlOptions = array(
            CURLOPT_URL => $this->_endPoint,
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $request
        );

        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);

        //Sending our request - $response will hold the API response

        $response = curl_exec($ch);
        //print_r($response);
        //die();
        //Checking for cURL errors
        if (curl_errno($ch)) {
            $this->_errors = curl_error($ch);
            curl_close($ch);
            return false;
            //Handle errors
        } else {
            curl_close($ch);
            $responseArray = array();
            parse_str($response, $responseArray); // Break the NVP string to an array
            return $responseArray;
        }
    }

}
