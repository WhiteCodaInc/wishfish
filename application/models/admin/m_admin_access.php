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
        $query = $this->db->get_where('access_class');
        return $query->result();
    }

    function addClass($post) {
        if ($this->db->insert('access_class', $post)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getPermission($post) {
        $query = $this->db->get_where('access_class', array('class_id' => $post['class_id']));
        return $query->row();
    }

    function addPermission($post) {
        echo '<pre>';
        print_r($post);
        die();

        $set = array(
            'admin' => (isset($post['admin']) ? 1 : 0),
            'contacts' => (isset($post['contacts']) ? 1 : 0),
            'affiliates' => (isset($post['affiliates']) ? 1 : 0),
            'customers' => (isset($post['customers']) ? 1 : 0),
            'sms' => (isset($post['sms']) ? 1 : 0),
            'email' => (isset($post['email']) ? 1 : 0),
            'calender' => (isset($post['calender']) ? 1 : 0),
            'setting' => (isset($post['setting']) ? 1 : 0),
        );
        $this->session->set_userdata('classid', $post['class_id']);
        $where = array('class_id' => $post['class_id']);
        if ($this->db->update('access_class', $set, $where)) {
            return $post['class_id'];
        } else {
            return FALSE;
        }
    }

}
