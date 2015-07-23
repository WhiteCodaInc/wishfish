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

    function index($dt) {
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
//        $res = $this->objanalytics->getTotalUser($this->date);
        $res = $this->objanalytics->getTotalUser($dt);



        echo "DATE : " . $this->date . '<br>';
        echo "HOUR : " . $this->hour . '<br>';
        echo "MINUTE : " . $this->minute . '<br>';
        echo "SECOND : " . $this->second . '<br>';

        print_r($profiles);
        print_r($res);

        foreach ($profiles as $value) {
//            if ($this->hour == "11" && $this->minute == "59") {
            if ($value->sms_report) {
                $body = $this->makeSMSBody($res);

                echo $body;

                if ($value->phone != NULL && $this->common->sendSMS($value->phone, $body)) {
                    echo '<br>-------------SMS SENT SUCCESSFULLY---------------<br>';
                } else {
                    echo '<br>-------------SMS NOT SUCCESSFULLY SENT---------------<br>';
                }
            }
            if ($value->email_report) {
                $subject = "Wish-Fish Daily Report";
                $body = $this->makeEmailBody($res);

                echo $body;

                if ($value->email != NULL && $this->common->sendMail($value->email, $subject, $body)) {
                    echo '<br>-------------EMAIL SENT SUCCESSFULLY---------------<br>';
                } else {
                    echo '<br>-------------EMAIL NOT SUCCESSFULLY SENT---------------<br>';
                }
            }
//            }
        }
    }

    function makeEmailBody($res) {
        $totalU = $res->expired + $res->non_expired;
        $totalP = $res->totalP + $res->totalE;
        $totalR = number_format($res->personal + $res->enterprise, 2);
        $body = "New Users : {$res->totalU}<br>"
                . "Today's Free-Trial Users : ${$totalU}<br>"
                . "Today's Premium Users : ${$totalP}<br>"
                . "Today's Revenue : ${$totalR}<br>";
        return $body;
    }

    function makeSMSBody($res) {
        $body = "New Users : {$res->totalU} "
                . "Today's Free-Trial Users : " . $res->expired + $res->non_expired . " "
                . "Today's Premium Users :</b> " . $res->totalP + $res->totalE . " "
                . "Today's Revenue : $" . $res->personal + $res->enterprise . " ";
        return $body;
    }

}
