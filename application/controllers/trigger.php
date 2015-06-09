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
    private $second = "";

    function __construct() {
        parent::__construct();
        $this->load->model("dashboard/m_contacts", 'objcontact');
        $this->load->model('m_trigger', 'objtrigger');
    }

    function index() {
        //$blackList = $this->objcontact->getBlackList();
        $res = $this->objtrigger->getEvents();

        // echo '<pre>';

        foreach ($res as $value) {

            $userInfo = $this->wi_common->getUserInfo($value->user_id);
            $time = date('Y-m-d H:i:s', gmt_to_local(time(), $userInfo->timezones, TRUE));
            //echo "<pre>";
            //echo "FULL TIME : {$time}<br>";

            $this->date = date('Y-m-d', strtotime($time));
            $this->hour = date('H', strtotime($time)) - 1;
            $this->minute = date('i', strtotime($time));
            $this->second = date('s', strtotime($time));


            /* print_r($userInfo);
              echo "Event TIME : {$value->time}<br>";
              echo "DATE : " . $this->date . '<br>';
              echo "HOUR : " . $this->hour . '<br>';
              echo "MINUTE : " . $this->minute . '<br>';
              echo "SECOND : " . $this->second . '<br>'; */


            if ($this->hour == $value->h && $this->minute == $value->m) {
                //echo "<br>-------------Event ID : {$value->event_id} Sucssfully Sent...! ----------------<br>";
                switch ($value->group_type) {
                    case 'individual':
                        // if (!in_array($value->contact_id, $blackList)) {
                        $contact = $this->wi_common->getContactInfo($value->contact_id);
                        print_r($contact);
                        $tag = $this->wi_common->setToken($contact);
                        print_r($tag);
                        if ($value->event_type == "sms") {
                            $body = $this->parser->parse_string($value->body, $tag, TRUE);
                            if ($this->sendSMS($contact->phone, $body, $value->notify)) {
                                $this->objtrigger->updateStatus($value->event_id);
                            }
                        } else if ($value->event_type == "email") {
                            if ($this->sendMail($contact, $tag, $value, $value->notify)) {
                                $this->objtrigger->updateStatus($value->event_id);
                            }
                        }
                        //  }
                        break;
                    case 'simple':
                        $res = $this->objtrigger->getGroupContact($value->group_id);
                        $cids = $res[1];
                        foreach ($cids as $cid) {
                            // if (!in_array($cid, $blackList)) {
                            $contact = $this->wi_common->getContactInfo($cid);
                            print_r($contact);
                            $tag = $this->wi_common->setToken($contact);
                            print_r($tag);
                            if ($value->event_type == "sms") {
                                $body = $this->parser->parse_string($value->body, $tag, TRUE);
                                if ($this->sendSMS($contact->phone, $body, $value->notify)) {
                                    $this->objtrigger->updateStatus($value->event_id);
                                }
                            } else if ($value->event_type == "email") {
                                if ($this->sendMail($contact, $tag, $value, $value->notify)) {
                                    $this->objtrigger->updateStatus($value->event_id);
                                }
                            }
                            // }
                        }
                        break;
                    default:
                        break;
                }
            }

            //echo "<br><br>";
        }
    }

    function sendSMS($to, $body, $notify) {
        if ($notify == "me") {
            $to = $this->session->userdata('phone');
        }
        return $this->wi_common->sendSMS($to, $body);
    }

    function sendMail($contact, $tag, $post, $notify) {
        if ($notify == "me") {
            $email = $this->session->userdata('email');
        } else {
            $email = $contact->email;
        }
        $subject = $this->parser->parse_string($post->subject, $tag, TRUE);
        $body = $this->parser->parse_string($post->body, $tag, TRUE);
        return $this->wi_common->sendMail($email, $subject, $body);
    }

}
