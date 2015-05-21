<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Twilio extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('twilio_api');
    }

    function send_sms() {
        try {
            $message = $this->twilio->account->messages->create(
                    array(
                        'To' => "+12016033014",
                        'From' => "+17606422366",
                        'Body' => "Hello",
                    )
            );
            echo $message;
        } catch (Services_Twilio_RestException $e) {
            echo $e->getMessage();
        }
    }

    function get_number() {
        try {
            $numbers = $this->twilio->account->available_phone_numbers->getList(
                    'GB', 'Mobile', array()
            );
            foreach ($numbers as $number) {
                echo $number->phone_number;
            }
        } catch (Services_Twilio_RestException $e) {
            echo $e->getMessage();
        }
    }

    function getSMS() {
        try {
            foreach ($this->twilio->account->sms_messages as $sms) {
                echo $sms->to;
            }
        } catch (Services_Twilio_RestException $e) {
            echo $e->getMessage();
        }
    }

}

/* End of file twilio_demo.php */