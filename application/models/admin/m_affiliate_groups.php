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
class M_affiliate_groups extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getAffiliateGroups() {
        $query = $this->db->get('affiliate_groups');
        return $query->result();
    }

    function getAffiliateGroup($gid) {
        $query = $this->db->get_where('affiliate_groups', array('group_id' => $gid));
        return $query->row();
    }

    function createAffiliateGroup($set) {
        $this->db->insert('affiliate_groups', $set);
        return TRUE;
    }

    function updateAffiliateGroup($set) {
        $gid = $set['groupid'];
        unset($set['groupid']);

        $this->db->update('affiliate_groups', $set, array('group_id' => $gid));
        return TRUE;
    }

    function setAction() {

        $ids = $this->input->post('group');
        foreach ($ids as $value) {
            $this->db->delete('affiliate_groups', array('group_id' => $value));
        }
    }

}
