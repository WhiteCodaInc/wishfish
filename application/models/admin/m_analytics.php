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
        $from = $this->common->getMySqlDate($post['from'], "mm-dd-yyyy");
        $to = $this->common->getMySqlDate($post['to'], "mm-dd-yyyy");
        $d1 = date_create($from);
        $d2 = date_create($to);
        echo date_diff($d2, $d1)->format('%a');


//        $where = array(
//            'DATE(P.register_date) >=' => $this->common->getMySqlDate($post['from'], "mm-dd-yyyy"),
//            'DATE(P.register_date) <=' => $this->common->getMySqlDate($post['to'], "mm-dd-yyyy"),
//            'testmode' => 0,
//        );
//        $this->db->select('id,P.user_id,plan_id,plan_status,is_lifetime,expiry_date,P.register_date');
//        $this->db->from('wi_plan_detail');
//        $this->db->join('wi_user_mst as U', 'P.iser_id = U.user_id');
//        $this->db->order_by('DATE(P.register_date)', 'desc');
//        $this->db->where($where);
//        $query = $this->db->get();
//        $res = $query->result();
//        $customer = array();
//        $expired = $non_expired = 0;
//        foreach ($res as $key => $val) {
//            //---------------Free Trial (non-expired)--------------//
//            $currPlan = $this->wi_common->getCurrentPlan($val->user_id);
//            if (count($currPlan) && $currPlan->plan_id == 1 && $currPlan->is_lifetime != 1 && $cur) {
//                $trialD = $this->common->getDateDiff($val, $currPlan);
//                ($trialD) ? $non_expired++ : $expired++;
//            }
//        }
    }

}
