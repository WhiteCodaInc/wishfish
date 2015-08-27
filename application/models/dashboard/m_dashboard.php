<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_admin_login
 *
 * @author Laxmisoft
 */
class M_dashboard extends CI_Model {

    private $userid;
    private $bucket;
    private $accessKey;
    private $secretKey;

    function __construct() {
        parent::__construct();
        $this->load->library('amazons3');
        $this->userid = $this->session->userdata('u_userid');
        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));

        $this->load->model('dashboard/m_contacts', 'objcontact');
        $this->load->model('dashboard/m_calender', 'objcalender');
    }

    function uploadProfilePic() {
        $flag = FALSE;
        if (isset($_FILES['profile'])) {
            if ($_FILES['profile']['error'] == 0) {
                $msg = $this->uploadImage($_FILES);
                switch ($msg) {
                    case "UF":
                        $m = "UF";
                        break;
                    case "IF":
                        $m = "IF";
                        break;
                    default:
                        $set['profile_pic'] = $msg;
                        $this->session->set_userdata('profile_pic', $msg);
                        $m = "U";
                        break;
                }
                $this->db->update('wi_user_mst', $set, array('user_id' => $this->userid));
            }
        }
        $m = "U";

        return $m;
    }

    function uploadImage($file) {
        $valid_formats = array("jpg", "png", "gif", "jpeg", "PNG", "JPG", "JPEG", "GIF");
        $ext = explode('/', $file['profile']['type']);
        if (in_array($ext[1], $valid_formats)) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            $fname = 'wish-fish/users/profile_' . $this->userid . '.' . $ext[1];
            if ($this->s3->putObjectFile($file['profile']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return "UF";
            }
        } else {
            return "IF";
        }
    }

    function updatePassword($post) {
        $where['user_id'] = $post['userid'];
        $set['password'] = sha1($post['password']);
        if ($this->db->update('wi_user_mst', $set, $where)) {
            $this->session->unset_userdata('d-userid');
            $this->session->unset_userdata('d-name');
            $query = $this->db->get_where('wi_user_mst', $where);
            $login['email'] = $query->row()->email;
            if ($post['type'] == "welcome") {
                $this->sendMail($post['userid'], "WELCOME E-MAIL");
            } else {
                $this->sendMail($post['userid'], "FORGOT PASSWORD SUCCESS");
            }
            return $login;
        } else {
            return FALSE;
        }
    }

    function getProfileSetup() {
        $per = 20;
        $userInfo = $this->wi_common->getUserInfo($this->userid);
        $setup['upload'] = ($userInfo->profile_pic != "") ? 1 : 0;
        $setup['profile'] = ($userInfo->phone != "" && $userInfo->birthday != "") ? 1 : 0;
        $contacts = $this->objcontact->getContactDetail();
        $setup['contact'] = (count($contacts) > 0) ? 1 : 0;
        $events = $this->objcalender->getNormalEvent();
        $setup['event'] = (count($events) > 0) ? 1 : 0;
        foreach ($setup as $value) {
            $per += ($value) ? 20 : 0;
        }
        $setup['per'] = $per;
        return $setup;
    }

    function setReminder($post) {
        echo '<pre>';
        print_r($post);
        die();
        $event_data = array(
            'user_id' => $this->userid,
            'event' => 'Reminder',
            'event_type' => "sms",
            'group_type' => "individual",
            'contact_id' => $this->userid,
            'color' => "#00a65a",
            'notification' => "1",
            'notify' => "me",
            'body' => $post['text'],
            'time' => $post['time'],
            'date' => $this->wi_common->getMySqlDate($this->wi_common->getUTCDate(), $this->session->userdata('u_date_format'))
        );
        $this->db->insert('wi_schedule', $event_data);
        return TRUE;
    }

    function sendMail($userid, $type) {
        $userInfo = $this->wi_common->getUserInfo($userid);
        $templateInfo = $this->wi_common->getAutomailTemplate($type);

        $tag = array(
            'NAME' => $userInfo->name,
            'THISDOMAIN' => "Wish-Fish"
        );

        $subject = $this->parser->parse_string($templateInfo['mail_subject'], $tag, TRUE);
        $this->load->view('email_format', $templateInfo, TRUE);
        $body = $this->parser->parse('email_format', $tag, TRUE);

        $from = ($templateInfo['from'] != "") ? $templateInfo['from'] : NULL;
        $name = ($templateInfo['name'] != "") ? $templateInfo['name'] : NULL;

        return $this->wi_common->sendAutoMail($userInfo->email, $subject, $body, $from, $name);
    }

    function addFeedback($post) {
        $uid = $this->userid;
        $name = $this->session->userdata('u_name');
        $email = $this->session->userdata('u_email');
        $set = array(
            'user_id' => $uid,
            'name' => $name,
            'email' => $email,
            'query' => $post['query']
        );
        (isset($post['country']) && $post['country'] != "" && $post['country'] != "-1") ?
                        $set['country'] = $post['country'] : "";
        $this->db->insert('feedback', $set);
        return true;
    }

    function verifyEmail($uid) {
        $this->db->update('wi_user_mst', array('email_verification' => 1), array('user_id' => $uid));
    }

}
