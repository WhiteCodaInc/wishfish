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
        $this->userid = $this->session->userdata('userid');
        $this->bucket = "mikhailkuznetsov";
        $this->accessKey = "AKIAJWQAEAXONVCWQZKQ";
        $this->secretKey = "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";
    }

    function uploadProfilePic() {
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
            }
        }
        $m = "U";
        $this->db->update('user_mst', $set, array('user_id' => $this->userid));
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

    function updatePassword() {
        $post = $this->input->post();
        $where['user_id'] = $post['userid'];
        $set['password'] = $post['password'];

        if ($this->db->update('user_mst', $set, $where)) {
            $this->session->unset_userdata('d-userid');
            $this->session->unset_userdata('d-name');
            $query = $this->db->get_where('user_mst', $where);
            $login['email'] = $query->row()->email;
            $login['password'] = $query->row()->password;
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

    function sendMail($userid, $type) {
        $userInfo = $this->common->getUserInfo($userid);
        $templateInfo = $this->common->getAutomailTemplate($type);

        $tag = array(
            'NAME' => $userInfo->name,
            'THISDOMAIN' => "Wish-Fish"
        );
        $subject = $this->parser->parse_string($templateInfo['mail_subject'], $tag, TRUE);
        $this->load->view('email_format', $templateInfo, TRUE);
        $body = $this->parser->parse('email_format', $tag, TRUE);

        $from = ($templateInfo['from'] != "") ? $templateInfo['from'] : NULL;
        $name = ($templateInfo['name'] != "") ? $templateInfo['name'] : NULL;

        return $this->common->sendAutoMail($userInfo->email, $subject, $body, $from, $name);
    }

}
