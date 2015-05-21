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
class M_affiliates extends CI_Model {

    private $profileid;
    private $bucket;
    private $accessKey;
    private $secretKey;

    function __construct() {
        parent::__construct();
        $this->load->library('amazons3');
        $this->profileid = $this->session->userdata('profile_id');
        $this->config->load('aws');
        $this->bucket = $this->encryption->decode($this->config->item('bucket', 'aws'));
        $this->accessKey = $this->encryption->decode($this->config->item('accessKey', 'aws'));
        $this->secretKey = $this->encryption->decode($this->config->item('secretKey', 'aws'));
    }

    function getAffiliateDetail() {
        $this->db->order_by('fname', 'asc');
        $query = $this->db->get('affiliate_detail');
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
        $group = $post['group_search'];
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
        ($group != "" && $group != "-1") ? $where['group_id'] = $group : '';

        $this->db->select('*');
        $this->db->from('affiliate_detail as A');
        $this->db->join('multiple_affiliate_group as M', 'A.affiliate_Id = M.affiliate_id', 'left outer');
        $this->db->group_by('A.affiliate_id');
        (isset($where) && is_array($where)) ? $this->db->where($where) : '';

        $query = $this->db->get();
        return $query->result();
    }

    function getAffiliateInfo($aid) {
        $query = $this->db->get_where('affiliate_detail', array('affiliate_id' => $aid));
        return $query->row();
    }

    function getAffiliate($aid) {
        $res = array();
        $query = $this->db->get_where('affiliate_detail', array('affiliate_id' => $aid));
        $res[] = $query->row();

        $this->db->select('A.group_id');
        $this->db->from('affiliate_groups as A');
        $this->db->join('multiple_affiliate_group as MC', 'A.group_id = MC.group_id');
        $this->db->where('affiliate_id', $aid);
        $query = $this->db->get();
        $cgroup = array();
        foreach ($query->result() as $value) {
            $cgroup[] = $value->group_id;
        }
        $res[] = $cgroup;
        return $res;
    }

    function createAffiliate($set) {

        $set['birthday'] = ($set['birthday'] != "") ? date('Y-m-d', strtotime($set['birthday'])) : NULL;
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        unset($set['code']);
        $this->db->insert('affiliate_detail', $set);
        $insertid = $this->db->insert_id();
        $m = "I";
        if (isset($_FILES['affiliate_avatar'])) {
            if ($_FILES['affiliate_avatar']['error'] == 0) {
                $msg = $this->uploadImage($_FILES, $insertid);
                switch ($msg) {
                    case "UF":
                        $m = "UF";
                        break;
                    case "IF":
                        $m = "IF";
                        break;
                    default:
                        $set['affiliate_avatar'] = $msg;
                        $this->db->update('affiliate_detail', $set, array('affiliate_id' => $insertid));
                        $m = "I";
                        break;
                }
            }
        }
        return $m;
    }

    function updateAffiliate($set) {
        $m = "";
        $aid = $set['affiliateid'];
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        $set['birthday'] = ($set['birthday'] != "") ? date('Y-m-d', strtotime($set['birthday'])) : NULL;

        if (isset($set['group_id'])) {
            $group = $set['group_id'];
            unset($set['group_id']);
        }
        unset($set['affiliateid']);
        unset($set['code']);

        $data = array();
        if (isset($group)) {
            foreach ($group as $value) {
                $data[] = array(
                    'affiliate_id' => $aid,
                    'group_id' => $value
                );
            }
        }

        if (isset($_FILES['affiliate_avatar'])) {
            if ($_FILES['affiliate_avatar']['error'] == 0) {
                $msg = $this->uploadImage($_FILES, $aid);
                switch ($msg) {
                    case "UF":
                        $m = "UF";
                        break;
                    case "IF":
                        $m = "IF";
                        break;
                    default:
                        $set['affiliate_avatar'] = $msg;
                        $m = "U";
                        break;
                }
            }
        }

        $this->db->trans_start();
        $m = "U";
        $this->db->update('affiliate_detail', $set, array('affiliate_id' => $aid));
        //--------------Delete Existing Group---------------------------------//
        $this->db->select('M.id');
        $this->db->from('multiple_affiliate_group as M');
        $this->db->join('affiliate_groups as CG', 'M.group_id = CG.group_id');
        $this->db->join('affiliate_detail as C', 'M.affiliate_id = C.affiliate_id');
        $this->db->where('M.affiliate_id', $aid);
        $query = $this->db->get();
        $res = $query->result();
        $ids = array();
        foreach ($res as $value) {
            $ids[] = $value->id;
        }
        if (count($ids) > 0) {
            $this->db->where_in('id', $ids, TRUE);
            $this->db->delete('multiple_affiliate_group');
        }
        //-------------------------Insert New Assign Group--------------------//
        (count($data) > 0) ? $this->db->insert_batch('multiple_affiliate_group', $data) : '';
        $this->db->trans_complete();
        return $m;
    }

    function uploadImage($file, $aid) {
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        $ext = explode('/', $file['affiliate_avatar']['type']);
        if (in_array($ext[1], $valid_formats)) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            $fname = 'affiliates/affiliate_avatar_' . $aid . '.' . $ext[1];
            if ($this->s3->putObjectFile($file['affiliate_avatar']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return "UF";
            }
        } else {
            return "IF";
        }
    }

    function setAction() {

        $ids = $this->input->post('affiliate');
        foreach ($ids as $value) {
            $this->db->delete('affiliate_detail', array('affiliate_id' => $value));
        }
    }

}
