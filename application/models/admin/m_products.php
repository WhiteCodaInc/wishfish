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
class M_products extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getProducts() {
        $query = $this->db->get('wi_plans');
        return $query->result();
    }

    function getProduct($pid) {
        $query = $this->db->get_where('wi_plans', array('template_id' => $pid));
        return $query->row();
    }

    function updateProduct($set) {
        $pid = $set['planid'];
        unset($set['planid']);
        $this->db->update('wi_plans', $set, array('plan_id' => $pid));
        return TRUE;
    }

}
