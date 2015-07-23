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
class M_admin_profile extends CI_Model {

    private $profileid;
    private $bucket;
    private $accessKey;
    private $secretKey;

    function __construct() {
        parent::__construct();
        $this->load->library('amazons3');
        $this->profileid = $this->session->userdata('profileid');
        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));
    }

    function getProfiles() {
        $this->db->order_by('fname', 'asc');
        $query = $this->db->get_where('admin_profile');
        return $query->result();
    }

    function searchResult() {
        $post = $this->input->post();
        $fname = $post['fname_search'];
        $lname = $post['lname_search'];
        $email = $post['email_search'];
        $age = $post['age_search'];
        $from = $post['from_search'];
        $to = $post['to_search'];
        $zodiac = $post['zodiac_search'];
        $country = $post['country_search'];
        $city = $post['city_search'];
        $address = $post['address_search'];
        $rating = $post['rating_search'];

        ($fname != "") ? $this->db->like('fname', $fname) : '';
        ($lname != "") ? $this->db->like('lname', $lname) : '';
        ($email != "") ? $this->db->like('email', $email) : '';
        ($age != "") ? $where['age'] = $age : '';
        ($from != "") ? $where['birthday >='] = date('Y-m-d', strtotime($from)) : '';
        ($to != "") ? $where['birthday <='] = date('Y-m-d', strtotime($to)) : '';
        ($zodiac != "" && $zodiac != "-1") ? $where['zodiac'] = $zodiac : '';
        ($country != "") ? $this->db->like('country', $country) : '';
        ($city != "") ? $this->db->like('city', $city) : '';
        ($address != "") ? $this->db->like('address', $address) : '';
        ($rating != "" && $rating != "-1") ? $where['rating'] = $rating : '';

        $this->db->select('*');
        $this->db->from('admin_profile');
        (isset($where) && is_array($where)) ? $this->db->where($where) : '';
        $query = $this->db->get();
        return $query->result();
    }

    function getProfile($pid) {
        $query = $this->db->get_where('admin_profile', array('profile_id' => $pid));
        return $query->row();
    }

    function createProfile($set) {
        $this->db->insert('admin_profile', $set);
        return TRUE;
    }

    function updateProfile($set) {

        $m = "";
        $pid = $set['profileid'];
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        $set['twilio_number'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['twilio_number'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['twilio_number']) :
                NULL;
        $set['birthday'] = ($set['birthday'] != "") ? date('Y-m-d', strtotime($set['birthday'])) : NULL;
        $set['account_id'] = implode(',', $set['account_id']);

        unset($set['profileid']);
        unset($set['code']);
        if (isset($_FILES['admin_avatar'])) {
            if ($_FILES['admin_avatar']['error'] == 0) {
                $msg = $this->uploadImage($_FILES, $pid);
                switch ($msg) {
                    case "UF":
                        $m = "UF";
                        break;
                    case "IF":
                        $m = "IF";
                        break;
                    default:
                        $this->session->set_userdata('avatar', $msg);
                        $set['admin_avatar'] = $msg;
                        $m = "U";
                        break;
                }
            }
        }
        $m = "U";
        $this->db->update('admin_profile', $set, array('profile_id' => $pid));
        return $m;
    }

    function setAction() {
        $ids = $this->input->post('profile');
        foreach ($ids as $value) {
            $this->db->delete('admin_profile', array('profile_id' => $value));
        }
    }

    function uploadImage($file, $pid) {
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        $ext = explode('/', $file['admin_avatar']['type']);
        if (in_array($ext[1], $valid_formats)) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            $fname = 'wish-fish/admin/avatars/admin_avatar_' . $pid . '.' . $ext[1];
            if ($this->s3->putObjectFile($file['admin_avatar']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return "UF";
            }
        } else {
            return "IF";
        }
    }

}
