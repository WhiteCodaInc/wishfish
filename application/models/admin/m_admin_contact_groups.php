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
class M_admin_contact_groups extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getContactGroups($type) {
        $this->db->where('type', $type);
        $query = $this->db->get('contact_groups');
        return $query->result();
    }

    function getContactGroup($gid) {
        $query = $this->db->get_where('contact_groups', array('group_id' => $gid));
        return $query->row();
    }

    function createContactGroup($set) {
        $this->db->insert('contact_groups', $set);
        return TRUE;
    }

    function updateContactGroup($set) {
        $gid = $set['groupid'];
        unset($set['groupid']);

        $this->db->update('contact_groups', $set, array('group_id' => $gid));
        return TRUE;
    }

    function setAction() {

        $ids = $this->input->post('group');
        foreach ($ids as $value) {
            $this->db->delete('contact_groups', array('group_id' => $value));
        }
    }

}
