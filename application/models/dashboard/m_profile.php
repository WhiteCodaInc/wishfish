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
class M_profile extends CI_Model {

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

    function getProfile() {
        $query = $this->db->get_where('user_mst', array('user_id' => $this->userid));
        return $query->row();
    }

    function updateProfile($set) {
        $m = "";
        echo '<pre>';
        print_r($set);
        die();
        if ($this->session->userdata('name') == "") {
            $this->session->set_userdata('name', $set['name']);
        }
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        $set['birthday'] = ($set['birthday'] != "") ?
                $this->common->getMySqlDate($set['birthday'], $this->session->userdata('date_format')) :
                NULL;
        unset($set['code']);
        if (isset($_FILES['profile_pic'])) {
            if ($_FILES['profile_pic']['error'] == 0) {
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
        $sess_array = array(
            'name' => $set['name'],
            'timezone' => $set['timezones'],
            'date_format' => $set['date_format']
        );
        $this->session->set_userdata($sess_array);
        $this->db->trans_start();
        $m = "U";
        $this->db->update('user_mst', $set, array('user_id' => $this->userid));
        $this->db->trans_complete();
        return $m;
    }

    function uploadImage($file) {
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        $ext = explode('/', $file['profile_pic']['type']);
        if (in_array($ext[1], $valid_formats)) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            $fname = 'wish-fish/users/profile_' . $this->userid . '.' . $ext[1];
            if ($this->s3->putObjectFile($file['profile_pic']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return "UF";
            }
        } else {
            return "IF";
        }
    }

}
