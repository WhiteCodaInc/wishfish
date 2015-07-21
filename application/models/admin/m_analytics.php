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
        echo '<pre>';
        print_r($post);
        die();
        $where = array(
            'DATE(payment_date) >=' => $this->common->getMySqlDate($post['from'], "mm-dd-yyyy"),
            'DATE(payment_date) <=' => $this->common->getMySqlDate($post['to'], "mm-dd-yyyy"),
            'testmode' => 0,
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

}
