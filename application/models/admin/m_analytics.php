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
class M_analytics extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getPayments($post) {

        $where = array(
            'DATE(payment_date) >=' => $this->common->getMySqlDate($post['from'], "mm-dd-yyyy"),
            'DATE(payment_date) <=' => $this->common->getMySqlDate($post['to'], "mm-dd-yyyy"),
            'testmode' => 0,
            'P.status' => 1
        );

        $this->db->select('DATE(payment_date) as pdate,count(*) as totalP,sum(mc_gross) as totalA', FALSE);
        $this->db->from('wi_payment_mst as P');
        $this->db->join('wi_plan_detail as PD', 'P.id = PD.id');
        $this->db->join('wi_user_mst as U', 'PD.user_id = U.user_id');
        $this->db->group_by('DATE(payment_date)');
        $this->db->order_by('DATE(payment_date)', 'desc');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    function getPaymentDetail($post) {
        $where = array(
            'DATE(payment_date) =' => $post['pdate'],
            'testmode' => 0,
            'P.status' => 1
        );
        $this->db->select('U.user_id,name,email,plan_name,P.gateway,mc_gross');
        $this->db->from('wi_payment_mst as P');
        $this->db->join('wi_plan_detail as PD', 'P.id = PD.id');
        $this->db->join('wi_plans as PL', 'PD.plan_id = PL.plan_id');
        $this->db->join('wi_user_mst as U', 'PD.user_id = U.user_id');
        $this->db->order_by('payment_date', 'desc');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    function getTotalUser($post) {
        $where = array(
            'DATE(PD.register_date) >=' => $this->common->getMySqlDate($post['from'], "mm-dd-yyyy"),
            'DATE(PD.register_date) <=' => $this->common->getMySqlDate($post['to'], "mm-dd-yyyy"),
            'testmode' => 0,
            'P.status' => 1
        );
        $this->db->select(' DATE(PD.register_date) as date,
                            count(DISTINCT U.user_id) totalU,
                            sum(case when plan_id = 2 then 1 else 0 end) totalP,
                            sum(case when plan_id = 3 then 1 else 0 end) totalE,
                            sum(case when plan_id = 1 and CURDATE() >= expiry_date then 1 else 0 end) expired,
                            sum(case when plan_id = 1 and CURDATE() < expiry_date then 1 else 0 end) non_expired,
                            sum(case when plan_id = 2 then mc_gross else 0 end) personal,
                            sum(case when plan_id = 3 then mc_gross else 0 end) enterprise', FALSE);
        $this->db->from('wi_plan_detail as PD');
        $this->db->join('wi_user_mst as U', 'PD.user_id = U.user_id');
        $this->db->join('wi_payment_mst as P', 'PD.id = P.id');
        $this->db->where($where);
        $this->db->order_by('PD.register_date', 'desc');
        $this->db->group_by('DATE(PD.register_date)');
        $query = $this->db->get();
        return $query->result();
    }

    function getUserDetail($post) {
        $where = array(
            'DATE(PD.register_date) =' => $post['pdate'],
            'testmode' => 0,
            'P.status' => 1
        );
        $this->db->select('U.user_id,name,email,plan_name,P.gateway,mc_gross');
        $this->db->from('wi_payment_mst as P');
        $this->db->join('wi_plan_detail as PD', 'P.id = PD.id');
        $this->db->join('wi_plans as PL', 'PD.plan_id = PL.plan_id');
        $this->db->join('wi_user_mst as U', 'PD.user_id = U.user_id');
        $this->db->order_by('PD.register_date', 'desc');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    function getTotalNewUser($post) {

        $where = array(
            'DATE(register_date) >=' => $this->common->getMySqlDate($post['from'], "mm-dd-yyyy"),
            'DATE(register_date) <=' => $this->common->getMySqlDate($post['to'], "mm-dd-yyyy")
        );

        $this->db->select('DATE(register_date) as date,count(*) as totalU');
        $this->db->order_by('register_date', 'desc');
        $query = $this->db->get_where('wi_user_mst', $where);
        return $query->result();
    }

    function getNewUserDetail($post) {
        $this->db->select('*');
        $this->db->where('DATE(register_date)', $post['pdate']);
        $this->db->order_by('register_date', 'desc');
        $query = $this->db->get('wi_user_mst');
        return $query->result();
    }

}
