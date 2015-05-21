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
class M_email_template extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profile_id');
    }

    function getTemplates() {
        $query = $this->db->get('email_template');
        return $query->result();
    }

    function getTemplate($tid) {
        $query = $this->db->get_where('email_template', array('template_id' => $tid));
        return $query->row();
    }

    function createTemplate($set) {
        $this->db->insert('email_template', $set);
        return TRUE;
    }

    function updateTemplate($set) {
        $tid = $set['templateid'];
        unset($set['templateid']);
        $this->db->update('email_template', $set, array('template_id' => $tid));
        return TRUE;
    }

    function setAction() {

        $ids = $this->input->post('template');
        foreach ($ids as $value) {
            $this->db->delete('email_template', array('template_id' => $value));
        }
    }

}
