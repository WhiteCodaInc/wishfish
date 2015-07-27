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
class M_plans extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getPlans() {
        $query = $this->db->get('wi_payment_plan');
        return $query->result();
    }

    function getPlan($pid) {
        $query = $this->db->get_where('wi_payment_plan', array('payment_plan_id' => $pid));
        return $query->row();
    }

    function createPlan($set) {
        $this->db->insert('wi_payment_plan', $set);
        return TRUE;
    }

    function updatePlan($set) {
        $pid = $set['planid'];
        unset($set['planid']);
        $this->db->update('wi_payment_plan', $set, array('payment_plan_id' => $pid));
        return TRUE;
    }

    function setAction() {
        $ids = $this->input->post('plan');
        foreach ($ids as $value) {
            $this->db->delete('wi_payment_plan', array('payment_plan_id' => $value));
        }
    }

}
