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

//    private $userid;
//    private $bucket;
//    private $accessKey;
//    private $secretKey;

    function __construct() {
        parent::__construct();
//        $this->load->library('amazons3');
//        $this->userid = $this->session->userdata('a_affid');
//        $this->config->load('aws');
//        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
//        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
//        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));
    }

//    function uploadProfilePic() {
//        $flag = FALSE;
//        if (isset($_FILES['profile'])) {
//            if ($_FILES['profile']['error'] == 0) {
//                $msg = $this->uploadImage($_FILES);
//                switch ($msg) {
//                    case "UF":
//                        $m = "UF";
//                        break;
//                    case "IF":
//                        $m = "IF";
//                        break;
//                    default:
//                        $set['profile_pic'] = $msg;
//                        $this->session->set_userdata('profile_pic', $msg);
//                        $m = "U";
//                        break;
//                }
//                $this->db->update('wi_user_mst', $set, array('user_id' => $this->userid));
//            }
//        }
//        $m = "U";
//
//        return $m;
//    }
//
//    function uploadImage($file) {
//        $valid_formats = array("jpg", "png", "gif", "jpeg", "PNG", "JPG", "JPEG", "GIF");
//        $ext = explode('/', $file['profile']['type']);
//        if (in_array($ext[1], $valid_formats)) {
//            $this->s3->setAuth($this->accessKey, $this->secretKey);
//            $fname = 'wish-fish/users/profile_' . $this->userid . '.' . $ext[1];
//            if ($this->s3->putObjectFile($file['profile']['tmp_name'], $this->bucket, $fname, "public-read")) {
//                return $fname;
//            } else {
//                return "UF";
//            }
//        } else {
//            return "IF";
//        }
//    }

    function updatePassword($post) {
        $where['affiliate_id'] = $post['affid'];
        $set['password'] = sha1($post['password']);
        if ($this->db->update('affiliate_detail', $set, $where)) {
            $this->session->unset_userdata('d-affid');
            $this->session->unset_userdata('d-name');
            $query = $this->db->get_where('affiliate_detail', $where);
            $login['email'] = $query->row()->email;
            if ($post['type'] == "welcome") {
                $this->sendMail($post['affid'], "WELCOME E-MAIL");
            } else {
                $this->sendMail($post['affid'], "FORGOT PASSWORD SUCCESS");
            }
            return $login;
        } else {
            return FALSE;
        }
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

}
