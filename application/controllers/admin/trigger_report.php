<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of trigger
 *
 * @author Laxmisoft
 */
class Trigger_report extends CI_Controller {

    private $timezone = "";
    private $date = "";
    private $hour = "";
    private $minute = "";
    private $second = "";

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->library('parser');
        $this->load->library('common');

        $this->load->model("admin/m_analytics", 'objanalytics');
        $this->load->model('admin/m_trigger', 'objtrigger');
    }

    function index() {
        // UM =  - to UTC 
        // UP = UTC to + 
        $this->timezone = "UM8";
        $datetime = date('Y-m-d H:i:s', gmt_to_local(time(), $this->timezone, TRUE));
        echo "<pre>";
        echo "FULL TIME : {$datetime}<br>";
        $this->date = date('Y-m-d', strtotime($datetime));
        $this->hour = date('H', strtotime($datetime));
        if ($this->hour == -1)
            $this->hour = 23;
        $this->minute = date('i', strtotime($datetime));
        $this->second = date('s', strtotime($datetime));

        $profiles = $this->objtrigger->getProfiles();
        $res = $this->objanalytics->getTotalUser($this->date);



        echo "DATE : " . $this->date . '<br>';
        echo "HOUR : " . $this->hour . '<br>';
        echo "MINUTE : " . $this->minute . '<br>';
        echo "SECOND : " . $this->second . '<br>';

//        print_r($profiles);
//        print_r($res);
//        die();

        foreach ($profiles as $value) {
            if ($this->hour == "11" && $this->minute == "59") {
                if ($value->sms_report) {
                    $body = $this->makeSMSBody($res);
                    if ($value->phone != NULL && $this->common->sendSMS($value->phone, $body)) {
                        echo '<br>-------------SMS SENT SUCCESSFULLY---------------<br>';
                    } else {
                        echo '<br>-------------SMS NOT SUCCESSFULLY SENT---------------<br>';
                    }
                }
                if ($value->email_report) {
                    $subject = "Wish-Fish Daily Report";
                    $body = $this->makeSMSBody($res);
                    if ($value->email != NULL && $this->common->sendMail($value->email, $subject, $body)) {
                        echo '<br>-------------EMAIL SENT SUCCESSFULLY---------------<br>';
                    } else {
                        echo '<br>-------------EMAIL NOT SUCCESSFULLY SENT---------------<br>';
                    }
                }
            }
        }
    }

    function makeEmailBody($res) {
        $body = "<b>New Users :</b> {$res->totalU}<br>";
        $body .= "<b>Today's Free-Trial Users :</b> " . $res->expired + $res->non_expired . "<br>";
        $body .= "<b>Today's Premium Users :</b> " . $res->totalP + $res->totalE . "<br>";
        $body .= "<b>Today's Revenue :</b> $" . $res->personal + $res->enterprise . "<br>";
        return $body;
    }

    function makeSMSBody($res) {
        $body = "New Users : {$res->totalU} ";
        $body .= "Today's Free-Trial Users : " . $res->expired + $res->non_expired . " ";
        $body .= "Today's Premium Users :</b> " . $res->totalP + $res->totalE . " ";
        $body .= "Today's Revenue : $" . $res->personal + $res->enterprise . " ";
        return $body;
    }

}
