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
class M_customers extends CI_Model {

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

    function getCustomerDetail() {
        $this->db->order_by('fname', 'asc');
        $query = $this->db->get('customer_detail');
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
        $this->db->from('customer_detail as C');
        $this->db->join('multiple_customer_group as M', 'C.customer_Id = M.customer_id', 'left outer');
        $this->db->group_by('C.customer_id');
        (isset($where) && is_array($where)) ? $this->db->where($where) : '';

        $query = $this->db->get();
        return $query->result();
    }

    function getCustomerInfo($cid) {
        $query = $this->db->get_where('customer_detail', array('customer_id' => $cid));
        return $query->row();
    }

    function getCustomer($cid) {
        $res = array();
        $query = $this->db->get_where('customer_detail', array('customer_id' => $cid));
        $res[] = $query->row();

        $this->db->select('C.group_id');
        $this->db->from('customer_groups as C');
        $this->db->join('multiple_customer_group as MC', 'C.group_id = MC.group_id');
        $this->db->where('customer_id', $cid);
        $query = $this->db->get();
        $cgroup = array();
        foreach ($query->result() as $value) {
            $cgroup[] = $value->group_id;
        }
        $res[] = $cgroup;
        return $res;
    }

    function createCustomer($set) {

        $set['birthday'] = ($set['birthday'] != "") ? date('Y-m-d', strtotime($set['birthday'])) : NULL;
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        unset($set['code']);
        $this->db->insert('customer_detail', $set);
        $insertid = $this->db->insert_id();
        $m = "I";
        if (isset($_FILES['customer_avatar'])) {
            if ($_FILES['customer_avatar']['error'] == 0) {
                $msg = $this->uploadImage($_FILES, $insertid);
                switch ($msg) {
                    case "UF":
                        $m = "UF";
                        break;
                    case "IF":
                        $m = "IF";
                        break;
                    default:
                        $set['customer_avatar'] = $msg;
                        $this->db->update('customer_detail', $set, array('customer_id' => $insertid));
                        $m = "I";
                        break;
                }
            }
        }
        return $m;
    }

    function updateCustomer($set) {
        $m = "";
        $cid = $set['customerid'];
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        $set['birthday'] = ($set['birthday'] != "") ? date('Y-m-d', strtotime($set['birthday'])) : NULL;

        if (isset($set['group_id'])) {
            $group = $set['group_id'];
            unset($set['group_id']);
        }
        unset($set['customerid']);
        unset($set['code']);

        $data = array();
        if (isset($group)) {
            foreach ($group as $value) {
                $data[] = array(
                    'customer_id' => $cid,
                    'group_id' => $value
                );
            }
        }

        if (isset($_FILES['customer_avatar'])) {
            if ($_FILES['customer_avatar']['error'] == 0) {
                $msg = $this->uploadImage($_FILES, $cid);
                switch ($msg) {
                    case "UF":
                        $m = "UF";
                        break;
                    case "IF":
                        $m = "IF";
                        break;
                    default:
                        $set['customer_avatar'] = $msg;
                        $m = "U";
                        break;
                }
            }
        }

        $this->db->trans_start();
        $m = "U";
        $this->db->update('customer_detail', $set, array('customer_id' => $cid));
        //--------------Delete Existing Group---------------------------------//
        $this->db->select('M.id');
        $this->db->from('multiple_customer_group as M');
        $this->db->join('customer_groups as CG', 'M.group_id = CG.group_id');
        $this->db->join('customer_detail as C', 'M.customer_id = C.customer_id');
        $this->db->where('M.customer_id', $cid);
        $query = $this->db->get();
        $res = $query->result();
        $ids = array();
        foreach ($res as $value) {
            $ids[] = $value->id;
        }
        if (count($ids) > 0) {
            $this->db->where_in('id', $ids, TRUE);
            $this->db->delete('multiple_customer_group');
        }
        //-------------------------Insert New Assign Group--------------------//
        (count($data) > 0) ? $this->db->insert_batch('multiple_customer_group', $data) : '';
        $this->db->trans_complete();
        return $m;
    }

    function uploadImage($file, $cid) {
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        $ext = explode('/', $file['customer_avatar']['type']);
        if (in_array($ext[1], $valid_formats)) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            $fname = 'customers/customer_avatar_' . $cid . '.' . $ext[1];
            if ($this->s3->putObjectFile($file['customer_avatar']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return "UF";
            }
        } else {
            return "IF";
        }
    }

    function setAction() {

        $ids = $this->input->post('customer');
        foreach ($ids as $value) {
            $this->db->delete('customer_detail', array('customer_id' => $value));
        }
    }

}
