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
class M_admin_access extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getAdminAccessClass() {
        $query = $this->db->get_where('privilage');
        return $query->result();
    }

    function addClass($post) {
        if ($this->db->insert('privilage', $post)) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    function getPermission($post) {
        $query = $this->db->get_where('privilage', array('class_id' => $post['class_id']));
        return $query->row();
    }

    function addPermission($post) {
        $set = array(
            'coni' => (isset($post['coni']) ? 1 : 0),
            'conu' => (isset($post['conu']) ? 1 : 0),
            'cond' => (isset($post['cond']) ? 1 : 0),
        );
        $this->session->set_userdata('classid', $post['class_id']);
        $where = array('class_id' => $post['class_id']);
        if ($this->db->update('privilage', $set, $where)) {
            return $post['class_id'];
        } else {
            return FALSE;
        }
    }

}
