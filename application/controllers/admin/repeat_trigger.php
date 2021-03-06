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
class Repeat_trigger extends CI_Controller {

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
    }

    function index() {
        $this->timezone = "UTC";
        $datetime = date('Y-m-d H:i:s', gmt_to_local(time(), $this->timezone, TRUE));
        $this->date = date('Y-m-d', strtotime($datetime));
        $this->hour = date('H', strtotime($datetime));
        $this->minute = date('i', strtotime($datetime));
        //$blackList = $this->objcon->getBlackList();
        //--------------------------------------------------------------------//
        $res = $this->objtrigger->getRepeatedEvent();
        echo '<pre>';
        print_r($res);
        foreach ($res as $value) {
            switch ($value->freq_type) {
                case "days":
                    $days = $value->freq_no * ($value->total_occurance - $value->occurance);
                    $dt = $this->common->getNextDate($value->date, $days . ' days');
                    break;
                case "weeks":
                    $days = $value->freq_no * ($value->total_occurance - $value->occurance);
                    $dt = $this->common->getNextDate($value->date, $days . ' weeks');
                    break;
                case "months":
                    $days = $value->freq_no * ($value->total_occurance - $value->occurance);
                    $dt = $this->common->getNextDate($value->date, $days . ' months');
                    break;
                case "years":
                    $days = $value->freq_no * ($value->total_occurance - $value->occurance);
                    $dt = $this->common->getNextDate($value->date, $days . ' years');
                    break;
            }
            echo $dt . '<br>';
            if ($this->date == $dt) {
                echo "match";
//                switch ($value->group_type) {
//                    case 'individual':
//                        if (!in_array($value->contact_id, $blackList)) {
//                            $contact = $this->objcon->getContactInfo($value->contact_id);
//                            $tag = $this->common->setToken($contact);
//                            if ($value->event_type == "sms") {
//                                $body = $this->parser->parse_string($value->body, $tag, TRUE);
//                                if ($this->sendSMS($contact->phone, $body)) {
//                                    $this->objtrigger->updateStatus($value->event_id);
//                                }
//                            } else if ($value->event_type == "email") {
//                                if ($this->sendMail($contact, $tag, $value)) {
//                                    $this->objtrigger->updateStatus($value->event_id);
//                                }
//                            }
//                        }
//                        break;
//                    case 'simple':
//                        $res = $this->objbuilder->getGroupContact($value->group_id);
//                        $cids = $res[1];
//                        foreach ($cids as $cid) {
//                            if (!in_array($cid, $blackList)) {
//                                $contact = $this->objcon->getContactInfo($cid);
//                                $tag = $this->common->setToken($contact);
//                                if ($value->event_type == "sms") {
//                                    $body = $this->parser->parse_string($value->body, $tag, TRUE);
//                                    if ($this->sendSMS($contact->phone, $body)) {
//                                        $this->objtrigger->updateStatus($value->event_id);
//                                    }
//                                } else if ($value->event_type == "email") {
//                                    if ($this->sendMail($contact, $tag, $value)) {
//                                        $this->objtrigger->updateStatus($value->event_id);
//                                    }
//                                }
//                            }
//                        }
//                        break;
//                    case 'sms':
//                        $cids = $this->objbuilder->getSubGroupContact($value->group_id);
//                        foreach ($cids as $cid) {
//                            if (!in_array($cid, $blackList)) {
//                                $contact = $this->objcon->getContactInfo($cid);
//                                $tag = $this->common->setToken($contact);
//                                if ($value->event_type == "sms") {
//                                    $body = $this->parser->parse_string($value->body, $tag, TRUE);
//                                    if ($this->sendSMS($contact->phone, $body)) {
//                                        $this->objtrigger->updateStatus($value->event_id);
//                                    }
//                                } else if ($value->event_type == "email") {
//                                    if ($this->sendMail($contact, $tag, $value)) {
//                                        $this->objtrigger->updateStatus($value->event_id);
//                                    }
//                                }
//                            }
//                        }
//                        break;
//                }
                $this->objtrigger->updateOccurance($value->event_id, $value->occurance);
            } else {
                echo "Not Match";
            }
        }
    }

    function sendSMS($to, $body) {
        return $this->common->sendSMS($to, $body);
    }

    function sendMail($contact, $tag, $post) {
        $subject = $this->parser->parse_string($post->subject, $tag, TRUE);
        $body = $this->parser->parse_string($post->body, $tag, TRUE);
        return $this->common->sendMail($contact->email, $subject, $body);
    }

}
