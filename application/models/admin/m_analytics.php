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
        $this->db->order_by('DATE(payment_date)', 'desc');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    function getTotalUser($post) {

        $where = array(
            'DATE(register_date) >=' => $this->common->getMySqlDate($post['from'], "mm-dd-yyyy"),
            'DATE(register_date) <=' => $this->common->getMySqlDate($post['to'], "mm-dd-yyyy"),
            'testmode' => 0
        );
        $this->db->where($where);
        $query = $this->db->get_where('wi_user_mst');
        $res = $query->result();
        echo '<pre>';
        print_r($res);
        die();
    }

}
