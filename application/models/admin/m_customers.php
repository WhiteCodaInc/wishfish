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
        $this->db->select('U.user_id,profile_pic,U.register_date,name,email,phone,phone_verification,P.plan_name,status');
        $this->db->from('wi_user_mst as U');
        $this->db->join('wi_plan_detail as PD', 'U.user_id = PD.user_id', 'left outer');
        $this->db->join('wi_plans as P', 'PD.plan_id = P.plan_id');
        $this->db->where('PD.plan_status', 1);
        $this->db->order_by('name', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function searchResult() {
        $post = $this->input->post();
        $name = $post['name_search'];
        $email = $post['email_search'];
        $from = $post['from_search'];
        $to = $post['to_search'];
        $plan = $post['plan_search'];
        $join = $post['join_search'];
        $status = $post['status_search'];

        ($name != "") ? $this->db->like('name', $name) : '';
        ($email != "") ? $this->db->like('email', $email) : '';
        ($from != "") ? $where['DATE(U.register_date) >='] = $this->common->getMySqlDate($from, "mm-dd-yyyy") : '';
        ($to != "") ? $where['DATE(U.register_date) <='] = $this->common->getMySqlDate($to, "mm-dd-yyyy") : '';
        ($join != "" && $join != "-1") ? $where['join_via'] = $join : '';
        ($status != "" && $status != "-1") ? $where['U.status'] = $status : '';
        ($plan != "" && $plan != "-1") ? $where['P.plan_id'] = $plan : '';

        $this->db->select('U.user_id,profile_pic,U.register_date,name,email,phone,phone_verification,P.plan_name,status');
        $this->db->from('wi_user_mst as U');
        $this->db->join('wi_plan_detail as PD', 'U.user_id = PD.user_id', 'left outer');
        $this->db->join('wi_plans as P', 'PD.plan_id = P.plan_id');
        $this->db->where('PD.plan_status', 1);
        (isset($where) && is_array($where)) ? $this->db->where($where) : '';
        $query = $this->db->get();
        return $query->result();
    }

    function getCustomerInfo($cid) {
        $this->db->select('*,U.user_id,U.register_date');
        $this->db->from('wi_user_mst as U');
        $this->db->join('wi_plan_detail as PD', 'U.user_id = PD.user_id', 'left outer');
        $this->db->join('wi_plans as P', 'PD.plan_id = P.plan_id');
        $this->db->where('PD.plan_status', 1);
        $this->db->where('U.user_id', $cid);
        $query = $this->db->get();
        return $query->row();
    }

    function setAction($type) {
        $ids = $this->input->post('customer');
        $msg = "";
        $where = 'user_id in (' . implode(',', $ids) . ')';
        $this->db->where($where);
        switch ($type) {
            case "Active":
                $this->db->update('wi_user_mst', array('status' => 1));
                $msg = "A";
                break;
            case "Deactive":
                $this->db->update('wi_user_mst', array('status' => 0));
                $msg = "DA";
                break;
            case "Delete":
                $this->db->delete('wi_user_mst');
                $msg = "D";
                break;
        }
        return $msg;
    }

    function updateCustomer($set) {
        $m = "";
        $cid = $set['customerid'];
        $customerInfo = $this->getCustomerInfo($cid);
        $set['phone'] = (preg_match('/^\(?\d{3}\)?[- ]?\d{3}[- ]?\d{4}$/', $set['phone'])) ?
                str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['phone']) :
                NULL;
        $set['birthday'] = ($set['birthday'] != "") ?
                $this->wi_common->getMySqlDate($set['birthday'], $customerInfo->date_format) :
                NULL;

        unset($set['customerid']);
        unset($set['code']);

        $data = array();

        if (isset($_FILES['profile_pic'])) {
            if ($_FILES['profile_pic']['error'] == 0) {
                $msg = $this->uploadImage($_FILES, $cid);
                switch ($msg) {
                    case "UF":
                        $m = "UF";
                        break;
                    case "IF":
                        $m = "IF";
                        break;
                    default:
                        $set['profile_pic'] = $msg;
                        $m = "U";
                        break;
                }
            }
        } else {
            $m = "U";
        }
        echo "MSG : {$m}";
        die();
        //$this->db->update('wi_user_mst', $set, array('user_id' => $cid));
        return $m;
    }

    function uploadImage($file, $cid) {
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        $ext = explode('/', $file['profile_pic']['type']);
        if (in_array($ext[1], $valid_formats)) {
            $this->s3->setAuth($this->accessKey, $this->secretKey);
            $fname = 'wish-fish/users/profile_' . $cid . '.' . $ext[1];
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
