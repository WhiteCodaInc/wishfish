<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use Mailgun\Mailgun;

class Common {

    private $_CI, $userid, $profile_id, $mgClient, $listAddress, $domain;

    function __construct() {

        $this->_CI = & get_instance();

        require_once APPPATH . 'third_party/mailgun-php/vendor/autoload.php';
        $this->mgClient = new Mailgun('key-acfdb718a88968c616bcea83e1020909');
        $this->listAddress = 'mikhail@mg.mikhailkuznetsov.com';
        $this->domain = 'mg.mikhailkuznetsov.com';

        $this->_CI->load->library('authex');
        $this->_CI->load->library('twilio_api');

        $this->_CI->load->helper('date');
        $this->_CI->load->helper('file');
        $this->userid = $this->_CI->session->userdata('userid');
        $this->profile_id = $this->_CI->session->userdata('profileid');
    }

    function getCustomerInfo($customerid) {
        $query = $this->_CI->db->get_where('customer_detail', array('customer_id' => $customerid));
        return $query->row();
    }

    function sendMail($to = NULL, $subject, $body, $bcc = NULL) {
        $set = array(
            'from' => 'Wish-Fish <notification@wish-fish.com>',
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

    function AddMailMember($name, $email, $type) {
        $this->mgClient->post("lists/{$this->listAddress}/members", array(
            'address' => $email,
            'name' => $name,
            'description' => $type,
            'subscribed' => true,
        ));
    }

    function getRandomDigit($length = 6) {
        return substr(str_shuffle("0123456789"), 0, $length);
    }

//----------------------     General Setting  --------------------------------//

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
        if ($this->validateDate($dt, 'Y-m-d')) {
            $date = new DateTime($dt);
        } else {
            $date = new DateTime($this->getMySqlDate($dt, "dd-mm-yyyy"));
        }
        date_add($date, date_interval_create_from_date_string($interval));
        return date_format($date, 'Y-m-d');
    }

    function getUTCDate($timezone = NULL, $format = NULL, $mysqldate = NULL) {
        $timezone = ($timezone != NULL) ? $timezone : "UTC";
        $format = ($format != NULL) ? $format : "mm-dd-yyyy";
        $date = str_replace('mm', 'm', $format);
        $date = str_replace('dd', 'd', $date);
        $date = str_replace('yyyy', 'Y', $date);
        if ($mysqldate != NULL) {
            return date($date, strtotime($mysqldate));
        } else {
            return date($date, gmt_to_local(time(), $timezone, TRUE));
        }
    }

    function getDateDiff($userInfo, $planInfo) {
        $d1 = date_create($this->getMySqlDate($this->getUTCDate($userInfo->timezones, $userInfo->date_format), $userInfo->date_format));
        $d2 = date_create($planInfo->expiry_date);
        echo date_diff($d2, $d1)->format('%m');
        die();
//        return date_diff($d2, $d1)->format('%a');
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
        $frm = ($from == NULL) ? "<notification@wish-fish.com>" : $from;
        $set['from'] = $nm . $frm;
        $result = $this->mgClient->sendMessage($this->domain, $set);
        if ($result->http_response_code == 200) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------Admin Side Function--------------------------------//
    function getAdminInfo($adminid = NULL) {
        $aid = ($adminid != NULL) ? $adminid : $this->profile_id;
        $query = $this->_CI->db->get_where('admin_profile', array('profile_id' => $aid));
        return $query->row();
    }

    function getContactInfo($cid) {
        $query = $this->_CI->db->get_where('contact_detail', array('contact_id' => $cid));
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

    function sendSMS($to, $body) {
        if ($this->profile_id) {
            $adminInfo = $this->getAdminInfo();
        } else {
            $adminInfo = $this->getAdminInfo(2);
        }
        try {
            $msg = $this->_CI->twilio->account->messages->create(
                    array(
                        'To' => $to,
                        'From' => $adminInfo->twilio_number,
                        'Body' => $body,
                    )
            );
            return $msg->sid;
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
//            'GROUP' => $user->group_name,
            'BIRTHDAY' => $user->birthday,
            'ZODIAC' => $user->zodiac,
            'AGE' => $user->age,
            'SOCIAL' => $user->social_media,
            'COUNTRY' => $user->country,
            'CITY' => $user->city,
            'ADDRESS' => $user->address,
            'RATING' => ($user->rating == "-1") ? "Not Assign" : $user->rating
        );
        return $tag;
    }

    //------------------------Header Function---------------------------------//

    function getTotalUnreadMsg() {
        $where = array(
            'status' => 1
        );
        $this->_CI->db->select('count(*) as total');
        $this->_CI->db->where('contact_id !=', 'NULL');
        $query = $this->_CI->db->get_where('inbox', $where);
        return $query->row()->total;
    }

    function getUnreadMsg() {
        $this->_CI->db->select('*');
        $this->_CI->db->from('inbox as I');
        $this->_CI->db->join('contact_detail as C', 'I.contact_id = C.contact_id');
        $this->_CI->db->where('status', 1);
        $query = $this->_CI->db->get();
        return $query->result();
    }

    function getPermission() {
        $adminInfo = $this->getAdminInfo();
        $permission = $this->_CI->db->get_where('access_class', array('class_id' => $adminInfo->class_id));
        return $permission->row();
    }

}
