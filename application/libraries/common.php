<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use Mailgun\Mailgun;

class Common {

    //private $profileid;
    private $_CI, $user_id, $mgClient, $listAddress, $domain;

    function __construct() {
        $this->_CI = & get_instance();
        $this->_CI->load->library('authex');
        $this->_CI->load->library('twilio_api');
        $this->_CI->load->helper('date');
        $this->_CI->load->helper('captcha');
        $this->_CI->load->helper('file');
        $this->user_id = $this->_CI->session->userdata('userid');

        require_once APPPATH . 'third_party/mailgun-php/vendor/autoload.php';
        $this->mgClient = new Mailgun('key-acfdb718a88968c616bcea83e1020909');
        $this->listAddress = 'wish-fish@mg.mikhailkuznetsov.com';
        $this->domain = 'mg.wish-fish.com';
    }

    function getUserInfo($userid) {
        $query = $this->_CI->db->get_where('user_mst', array('user_id' => $userid));
        return $query->row();
    }

    function getContactInfo($contactid) {
        $query = $this->_CI->db->get_where('contact_detail', array('contact_id' => $contactid));
        return $query->row();
    }

//    function getPlanInfo() {
//        $query = $this->_CI->db->get_where('plan_detail', array('user_id' => $this->user_id, 'plan_status' => 2));
//        return $query->row();
//    }

    function getCurrentPlan($userid = NULL) {
        $uid = ($userid == NULL) ? $this->user_id : $userid;
        $query = $this->_CI->db->get_where('plan_detail', array('user_id' => $uid, 'plan_status' => 1));
        return $query->row();
    }

    function getPlan($planid) {
        $query = $this->_CI->db->get_where('plans', array('plan_id' => $planid));
        return $query->row();
    }

    function getPlans() {
//        $this->_CI->db->where_in('plan_id', array('2', '3'));
        $query = $this->_CI->db->get('plans');
        return $query->result();
    }

    function getLatestPlan($userid = NULL) {
        $uid = ($userid == NULL) ? $this->user_id : $userid;
        $this->_CI->db->limit(1);
        $this->_CI->db->order_by('register_date', 'desc');
        $query = $this->_CI->db->get_where('plan_detail', array('user_id' => $uid));
        return $query->row();
    }

    function getPaymentGatewayInfo($mname) {
        $query = $this->_CI->db->get_where('general_setting', array('method_name' => $mname));
        return $query->row();
    }

    function getZodiacs() {
        $query = $this->_CI->db->get('zodiac');
        return $query->result();
    }

    function getZodiac($dt) {
        $m = date('m', strtotime($dt));

        if (($m == date('m', strtotime('22-12-2000')) &&
                date('m-d', strtotime("22-12-2000")) <= date('m-d', strtotime($dt))) ||
                $m == date('m', strtotime('19-01-2000')) &&
                date('m-d', strtotime("19-01-2000")) >= date('m-d', strtotime($dt))
        ) {
            echo "Capricorn";
        } else {
            $dt = date('m-d', strtotime($dt));
            $this->_CI->db->select("*", FALSE);
            $this->_CI->db->where("DATE_FORMAT(start_date,'%m-%d') <=", $dt);
            $this->_CI->db->where("DATE_FORMAT(end_date,'%m-%d') >=", $dt);
            $query = $this->_CI->db->get('zodiac');
            echo $query->row()->zodiac_name;
        }
    }

    function sendMail($to = NULL, $subject, $body, $bcc = NULL) {
        $set = array(
            'from' => 'Wish-Fish <welcome@wish-fish.com>',
            'subject' => $subject,
            'html' => $body
        );
        ($to == NULL) ? $set['bcc'] = $bcc : $set['to'] = $to;
        $result = $this->mgClient->sendMessage($this->domain, $set);
        if ($result->http_response_code == 200) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function sendSMS($to, $body) {
        try {
            $this->_CI->twilio->account->messages->create(
                    array(
                        'To' => $to,
                        'From' => "+13233304915",
                        'Body' => $body,
                    )
            );
            return TRUE;
        } catch (Services_Twilio_RestException $e) {
            return FALSE;
        }
    }

    function setToken($user) {

        $tag = array(
            'FIRST_NAME' => $user->fname,
            'LAST_NAME' => $user->lname,
            'EMAIL' => $user->email,
            'PHONE' => $user->phone,
            'BIRTHDAY' => $user->birthday,
            'ZODIAC' => $user->zodiac,
            'AGE' => $user->age,
            'BIRTHDAY_ALERT' => $user->birthday_alert,
            'SOCIAL' => $user->social_media,
            'CONTACT' => $user->contact,
            'COUNTRY' => $user->country,
            'CITY' => $user->city,
            'ADDRESS' => $user->address,
            'RATING' => ($user->rating == "-1") ? "Not Assign" : $user->rating
        );
        return $tag;
    }

    //----------------------     General Setting  --------------------------------//
    function getGeneralSetting($companyid = NULL) {
        $CI = & get_instance();
//        echo $this->compid;
//        die();
        $compid = ($companyid !== NULL) ? $companyid : $this->compid;
        $query = $CI->db->get_where('general_setting', array('comp_id' => $compid));
        $res = $query->result_array();
        return $res[0];
    }

    function getPreviousDate($dt, $interval) {
        $format = $this->_CI->session->userdata('date_format');
        if ($this->validateDate($dt, 'Y-m-d')) {
            $date = new DateTime($dt);
        } else {
            $date = new DateTime($this->getMySqlDate($dt, $format));
        }
        date_sub($date, date_interval_create_from_date_string($interval));
        return date_format($date, 'Y-m-d');
    }

    function getMySqlDate($dt, $format) {
        if ($this->validateDate($dt, 'Y-m-d')) {
            return $dt;
        } else {
            $date = str_replace('mm', 'm', $format);
            $date = str_replace('dd', 'd', $date);
            $date = str_replace('yyyy', 'Y', $date);
            return DateTime::createFromFormat($date, $dt)->format('Y-m-d');
        }
    }

    function validateDate($dt, $format) {
        $d = DateTime::createFromFormat($format, $dt);
        return $d && $d->format($format) == $dt;
    }

    function getNextDate($dt, $interval) {
        $format = $this->_CI->session->userdata('date_format');
        if ($this->validateDate($dt, 'Y-m-d')) {
            $date = new DateTime($dt);
        } else {
            $date = new DateTime($this->getMySqlDate($dt, $format));
        }
        date_add($date, date_interval_create_from_date_string($interval));
        return date_format($date, 'Y-m-d');
    }

    function getUTCDate($mysqldate = NULL, $timezone = NULL, $format = NULL) {
        $format = ($format != NULL) ? $format : $this->_CI->session->userdata('date_format');
        $timezone = ($timezone != NULL) ? $timezone : $this->_CI->session->userdata('timezone');
        $date = str_replace('mm', 'm', $format);
        $date = str_replace('dd', 'd', $date);
        $date = str_replace('yyyy', 'Y', $date);
        if ($mysqldate != NULL) {
            return date($date, strtotime($mysqldate));
        } else {
            return date($date, gmt_to_local(time(), $timezone, TRUE));
        }
    }

    function getDateDiff($planInfo = NULL) {
        $format = $this->_CI->session->userdata('date_format');
        $pInfo = ($planInfo == NULL) ? $this->getCurrentPlan() : $planInfo;
        $d1 = date_create($this->getMySqlDate($this->getUTCDate(), $format));
        $d2 = date_create($pInfo->expiry_date);
        return date_diff($d2, $d1)->format('%a');
    }

    function getUTCDateWithTime($timezone) {
        return date('Y-m-d H:i:s', gmt_to_local(time(), $timezone, TRUE));
    }

//
//    //------------------------Header Function---------------------------------//
//
//    function getTotalUnreadMsg() {
//        $this->_CI->db->select('count(*) as total');
//        $query = $this->_CI->db->get_where('inbox', array('status' => 1));
//        return $query->row()->total;
//    }
//
//    function getUnreadMsg() {
//        $this->_CI->db->select('*');
//        $this->_CI->db->from('inbox as I');
//        $this->_CI->db->join('contact_detail as C', 'I.contact_id = C.contact_id');
//        $this->_CI->db->where('status', 1);
//        $query = $this->_CI->db->get();
//        return $query->result();
//    }
//
//    //-------------------Admin Access Class Permission------------------------//
//    function getPermission() {
//        $adminInfo = $this->getAdminInfo();
//        $permission = $this->_CI->db->get_where('access_class', array('class_id' => $adminInfo->class_id));
//        return $permission->row();
//    }

    function getTotal($userid, $tbl) {
        $where['user_id'] = $userid;
        $this->_CI->db->select('count(*)as total');
        $query = $this->_CI->db->get_where($tbl, $where);
        return $query->row()->total;
    }

    function getRandomDigit($length = 6) {
        return substr(str_shuffle("0123456789"), 0, $length);
    }

    function insertPlanDetail($userid, $planid, $customer) {
        $amount = $customer->subscriptions->data[0]->plan->amount / 100;
        $planInfo = $this->common->getPlan($planid);
        $plan_set = array(
            'user_id' => $userid,
            'plan_id' => $planid,
            'contacts' => $planInfo->contacts,
            'sms_events' => $planInfo->sms_events,
            'email_events' => $planInfo->email_events,
            'group_events' => $planInfo->group_events,
            'amount' => $amount,
            'plan_status' => 1,
            'start_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_start),
            'expiry_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_end)
        );
        $this->db->insert('plan_detail', $plan_set);
        return $this->db->insert_id();
    }

    function insertPaymentDetail($pid, $customer) {
        $amount = $customer->subscriptions->data[0]->plan->amount / 100;
        $insert_set = array(
            'id' => $pid,
            'transaction_id' => $customer->subscriptions->data[0]->id,
            'payer_id' => $customer->id,
            'payer_email' => $customer->email,
            'mc_gross' => $amount,
            'mc_fee' => ($amount * 0.029) + 0.30,
            'payment_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_start)
        );
        $this->db->insert('payment_mst', $insert_set);
    }

    //----------------------Admin Automail Template---------------------------//
    function getAutomailTemplate($type) {
        $query = $this->_CI->db->get_where('automail_template', array('mail_type' => $type));
        $res = $query->result_array();
        return $res[0];
    }

    function sendAutoMail($to, $subject, $body, $from = NULL, $name = NULL) {
        $set = array(
            'to' => $to,
            'subject' => $subject,
            'html' => $body
        );
        $nm = ($name == NULL) ? "Wish-Fish " : $name . ' ';
        $frm = ($from == NULL) ? "<welcome@wish-fish.com>" : $from;
        $set['from'] = $nm . $frm;
        $result = $this->mgClient->sendMessage($this->domain, $set);
        if ($result->http_response_code == 200) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
