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
class M_customer_groups extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profile_id');
    }

    function getCustomerGroups() {
        $query = $this->db->get('customer_groups');
        return $query->result();
    }

    function getCustomerGroup($gid) {
        $query = $this->db->get_where('customer_groups', array('group_id' => $gid));
        return $query->row();
    }

    function createCustomerGroup($set) {
        $this->db->insert('customer_groups', $set);
        return TRUE;
    }

    function updateCustomerGroup($set) {
        $gid = $set['groupid'];
        unset($set['groupid']);

        $this->db->update('customer_groups', $set, array('group_id' => $gid));
        return TRUE;
    }

    function setAction() {

        $ids = $this->input->post('group');
        foreach ($ids as $value) {
            $this->db->delete('customer_groups', array('group_id' => $value));
        }
    }

}
