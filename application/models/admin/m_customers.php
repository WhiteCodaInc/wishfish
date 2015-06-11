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
        $this->db->select('U.user_id,profile_pic,U.register_date,name,email,P.plan_name,join_via,status');
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
        ($from != "") ? $where['DATE(U.register_date) >='] = date('Y-m-d', strtotime($from)) : '';
        ($to != "") ? $where['DATE(U.register_date) <='] = date('Y-m-d', strtotime($to)) : '';
        ($join != "" && $join != "-1") ? $where['join_via'] = $join : '';
        ($status != "" && $status != "-1") ? $where['U.status'] = $status : '';
        ($plan != "" && $plan != "-1") ? $where['P.plan_id'] = $plan : '';

        $this->db->select('U.user_id,profile_pic,U.register_date,name,email,P.plan_name,join_via,status');
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
            $fname = 'wish-fish/admin/customers/customer_avatar_' . $cid . '.' . $ext[1];
            if ($this->s3->putObjectFile($file['customer_avatar']['tmp_name'], $this->bucket, $fname, "public-read")) {
                return $fname;
            } else {
                return "UF";
            }
        } else {
            return "IF";
        }
    }

}
