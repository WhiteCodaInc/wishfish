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
        $query = $this->db->get('sms_template');
        return $query->result();
    }

    function getProduct($tid) {
        $query = $this->db->get_where('sms_template', array('template_id' => $tid));
        return $query->row();
    }

    function createProduct($set) {
        $this->db->insert('sms_template', $set);
        return TRUE;
    }

    function updateProduct($set) {
        $tid = $set['templateid'];
        unset($set['templateid']);
        $this->db->update('sms_template', $set, array('template_id' => $tid));
        return TRUE;
    }

    function setAction() {
        $ids = $this->input->post('template');
        foreach ($ids as $value) {
            $this->db->delete('sms_template', array('template_id' => $value));
        }
    }

}
