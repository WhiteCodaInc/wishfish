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
        $query = $this->db->get('wi_products');
        return $query->result();
    }

    function getProduct($pid) {
        $query = $this->db->get_where('wi_products', array('plan_id' => $pid));
        return $query->row();
    }

    function createProduct($set) {
        $this->db->insert('wi_products', $set);
        return TRUE;
    }

    function updateProduct($set) {
        $pid = $set['planid'];
        unset($set['planid']);
        $this->db->update('wi_products', $set, array('plan_id' => $pid));
        return TRUE;
    }

    function setAction() {
        $ids = $this->input->post('products');
        foreach ($ids as $value) {
            $this->db->delete('wi_products', array('plan_id' => $value));
        }
    }

}
