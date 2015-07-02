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
class M_contact_groups extends CI_Model {

    private $userid;

    function __construct() {
        parent::__construct();
        $this->userid = $this->session->userdata('u_userid');
    }

    function getContactGroups($type) {
        $where = array(
            'type' => $type,
            'user_id' => $this->userid
        );
        $query = $this->db->get_where('wi_contact_groups', $where);
        return $query->result();
    }

    function getContactGroup($gid) {
        $where = array(
            'group_id' => $gid,
            'user_id' => $this->userid
        );
        $query = $this->db->get_where('wi_contact_groups', $where);
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    function createContactGroup($set) {
        $set['user_id'] = $this->userid;
        $this->db->insert('wi_contact_groups', $set);
        return TRUE;
    }

    function updateContactGroup($set) {
        $gid = $set['groupid'];
        unset($set['groupid']);
        $where = array(
            'group_id' => $gid,
            'user_id' => $this->userid
        );
        return ($this->db->update('wi_contact_groups', $set, $where)) ? TRUE : FALSE;
    }

    function setAction() {

        $ids = $this->input->post('group');
        foreach ($ids as $value) {
            $this->db->delete('wi_contact_groups', array('group_id' => $value));
        }
    }

}
