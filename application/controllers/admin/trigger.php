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
class Trigger extends CI_Controller {

    private $timezone = "";
    private $date = "";
    private $hour = "";
    private $minute = "";

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->library('parser');
        $this->load->library('common');

        $this->load->model("admin/m_admin_contacts", 'objcon');
        $this->load->model('admin/m_trigger', 'objtrigger');
        $this->load->model('admin/m_list_builder', 'objbuilder');
        $this->load->model("admin/m_analytics", 'objanalytics');
    }

    function index($dt = NULL) {
        // UM =  - to UTC 
        // UP = UTC to + 
        $this->timezone = "UM8";
        $datetime = date('Y-m-d H:i:s', gmt_to_local(time(), $this->timezone, TRUE));
        echo "{$this->session->userdata('email')}<br>";
        echo "<pre>";
        echo "FULL TIME : {$datetime}<br>";
        $this->date = date('Y-m-d', strtotime($datetime));
        $this->hour = date('H', strtotime($datetime));
        if ($this->hour == -1)
            $this->hour = 23;
        $this->minute = date('i', strtotime($datetime));

        $blackList = $this->objcon->getBlackList();
        $res = $this->objtrigger->getEvents($this->date);

        $profiles = $this->objtrigger->getProfiles();
//        $res = $this->objanalytics->getTotalUser($this->date);
        $users = $this->objanalytics->getTotalUser($dt);


        echo "DATE : " . $this->date . '<br>';
        echo "HOUR : " . $this->hour . '<br>';
        echo "MINUTE : " . $this->minute . '<br>';
//        echo "SECOND : " . $this->second . '<br>';

        print_r($profiles);
        print_r($users);

        foreach ($profiles as $value) {
            if ($this->hour == "11" && $this->minute == "59") {
                if ($value->sms_report) {
                    $body = $this->makeSMSBody($users);
                    if ($value->phone != NULL && $this->common->sendSMS($value->phone, $body)) {
                        echo $body . '<br>';
                        echo '<br>-------------SMS SENT SUCCESSFULLY---------------<br>';
                    } else {
                        echo '<br>-------------SMS NOT SUCCESSFULLY SENT---------------<br>';
                    }
                }
                if ($value->email_report) {
                    $subject = "Wish-Fish Daily Report";
                    $body = $this->makeEmailBody($users);
                    if ($value->email != NULL && $this->common->sendMail($value->email, $subject, $body)) {
                        echo '<br>-------------EMAIL SENT SUCCESSFULLY---------------<br>';
                        echo $body . '<br>';
                    } else {
                        echo '<br>-------------EMAIL NOT SUCCESSFULLY SENT---------------<br>';
                    }
                }
            }
        }

        foreach ($res as $value) {
            if ($this->hour == $value->h && $this->minute == $value->m) {
                echo "<br>-------------Event ID : {$value->event_id} ...! ----------------<br>";
                echo "HOUR : " . $value->h . '<br>';
                echo "MINUTE : " . $value->m . '<br>';
                switch ($value->group_type) {
                    case 'individual':
                        if (!in_array($value->user_id, $blackList)) {
                            $contact = $this->objcon->getContactInfo($value->user_id);
                            $tag = $this->common->setToken($contact);
                            if ($value->event_type == "sms") {
                                $body = $this->parser->parse_string($value->body, $tag, TRUE);
                                if ($this->sendSMS($contact->phone, $body, $value->notify)) {
                                    if ($value->is_repeat && $value->end_type == "never")
                                        $this->objtrigger->addNextEvent($value->event_id);
                                    $this->objtrigger->updateStatus($value->event_id);
                                } else {
                                    echo "<br>-------------Event ID : {$value->event_id} Failed...! ----------------<br>";
                                }
                            } else if ($value->event_type == "email") {
                                if ($this->sendMail($contact, $tag, $value, $value->notify)) {
                                    if ($value->is_repeat && $value->end_type == "never")
                                        $this->objtrigger->addNextEvent($value->event_id);
                                    $this->objtrigger->updateStatus($value->event_id);
                                } else {
                                    echo "<br>-------------Event ID : {$value->event_id} Failed...! ----------------<br>";
                                }
                            }
                        }
                        break;
                    case 'simple':
                        $res = $this->objbuilder->getGroupContact($value->group_id);
                        $cids = $res[1];
                        foreach ($cids as $cid) {
                            if (!in_array($cid, $blackList)) {
                                $contact = $this->objcon->getContactInfo($cid);
                                $tag = $this->common->setToken($contact);
                                if ($value->event_type == "sms") {
                                    $body = $this->parser->parse_string($value->body, $tag, TRUE);
                                    if ($this->sendSMS($contact->phone, $body, $value->notify)) {
                                        if ($value->is_repeat && $value->end_type == "never")
                                            $this->objtrigger->addNextEvent($value->event_id);
                                        $this->objtrigger->updateStatus($value->event_id);
                                    } else {
                                        echo "<br>-------------Event ID : {$value->event_id} Failed...! ----------------<br>";
                                    }
                                } else if ($value->event_type == "email") {
                                    if ($this->sendMail($contact, $tag, $value, $value->notify)) {
                                        if ($value->is_repeat && $value->end_type == "never")
                                            $this->objtrigger->addNextEvent($value->event_id);
                                        $this->objtrigger->updateStatus($value->event_id);
                                    } else {
                                        echo "<br>-------------Event ID : {$value->event_id} Failed...! ----------------<br>";
                                    }
                                }
                            }
                        }
                        break;
                    case 'sms':
                        $cids = $this->objbuilder->getSubGroupContact($value->group_id);
                        foreach ($cids as $cid) {
                            if (!in_array($cid, $blackList)) {
                                $contact = $this->objcon->getContactInfo($cid);
                                $tag = $this->common->setToken($contact);
                                if ($value->event_type == "sms") {
                                    $body = $this->parser->parse_string($value->body, $tag, TRUE);
                                    if ($this->sendSMS($contact->phone, $body, $value->notify)) {
                                        if ($value->is_repeat && $value->end_type == "never")
                                            $this->objtrigger->addNextEvent($value->event_id);
                                        $this->objtrigger->updateStatus($value->event_id);
                                    } else {
                                        echo "<br>-------------Event ID : {$value->event_id} Failed...! ----------------<br>";
                                    }
                                } else if ($value->event_type == "email") {
                                    if ($this->sendMail($contact, $tag, $value, $value->notify)) {
                                        if ($value->is_repeat && $value->end_type == "never")
                                            $this->objtrigger->addNextEvent($value->event_id);
                                        $this->objtrigger->updateStatus($value->event_id);
                                    } else {
                                        echo "<br>-------------Event ID : {$value->event_id} Failed...! ----------------<br>";
                                    }
                                }
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }

    function sendSMS($to, $body, $notify) {
        if ($notify == "me") {
            echo "NOTIFY ME<br>";
            $adminInfo = $this->common->getAdminInfo(2);
            $to = $adminInfo->phone;
            echo "SESSION : " . $to . '<br>';
        } else {
            echo "NOTIFY THEM<br>";
        }
        if ($to != "") {
            echo "TO : " . $to . '<br>';
            echo "BODY : " . $body . '<br>';
            echo "<br>-------------Event Sucssfully Sent...! ----------------<br>";
            return $this->common->sendSMS($to, $body);
        } else {
            return FALSE;
        }
    }

    function sendMail($contact, $tag, $post, $notify) {
        if ($notify == "me") {
            $adminInfo = $this->common->getAdminInfo(2);
            $email = $adminInfo->email;
        } else {
            $email = $contact->email;
        }
        if ($email != "") {
            $subject = $this->parser->parse_string($post->subject, $tag, TRUE);
            $body = $this->parser->parse_string($post->body, $tag, TRUE);
            return $this->common->sendMail($email, $subject, $body);
        } else {
            return FALSE;
        }
    }

    function makeEmailBody($res) {
        $totalU = $res->expired + $res->non_expired;
        $totalPA = number_format($res->personal, 2);
        $totalEA = number_format($res->enterprise, 2);
        $totalR = $totalPA + $totalEA;
        $body = "<h1>Today's Report</h1><br>"
                . "<b>New Users :</b> {$res->totalU}<br>"
                . "<b>Free-Trial Users :</b> {$totalU}<br>"
                . "<b>Personal Plan Users :</b> {$res->totalP}<br>"
                . "<b>Enterprise Plan Users :</b> {$res->totalE}<br>"
                . "<b>Personal Plan Amount :</b> {$totalPA} <br>"
                . "<b>Enterprise Plan Amount :</b> {$totalEA} <br>"
                . "<b>Total Revenue :</b> $ {$totalR}<br>";
        return $body;
    }

    function makeSMSBody($res) {
        $totalU = $res->expired + $res->non_expired;
        $totalPA = number_format($res->personal, 2);
        $totalEA = number_format($res->enterprise, 2);
        $totalR = $totalPA + $totalEA;
        $body = "Today's Report%0a"
                . "Free Plan : {$totalU} Users%0a"
                . "Personal Plan : {$res->totalP} Users%0a"
                . "Enterprise Plan : {$res->totalE} Users%0a"
                . "Total Revenue : $ {$totalR}";
        return $body;
    }

}
