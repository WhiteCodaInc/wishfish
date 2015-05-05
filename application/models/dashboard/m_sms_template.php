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
class M_sms_template extends CI_Model {

    private $userid;

    function __construct() {
        parent::__construct();
        $this->userid = $this->session->userdata('userid');
    }

    function getTemplates() {
        $query = $this->db->get_where('sms_template', array('user_id' => $this->userid));
        return $query->result();
    }

    function getTemplate($tid) {
        $where = array(
            'template_id' => $tid,
            'user_id' => $this->userid
        );
        $query = $this->db->get_where('sms_template', $where);
        return $query->row();
    }

    function createTemplate($set) {
        $set['user_id'] = $this->userid;
        $this->db->insert('sms_template', $set);
        return TRUE;
    }

    function updateTemplate($set) {
        $tid = $set['templateid'];
        unset($set['templateid']);
        $where = array(
            'template_id' => $tid,
            'user_id' => $this->userid
        );
        $this->db->update('sms_template', $set, $where);
        return TRUE;
    }

    function setAction($ids) {
        foreach ($ids as $value) {
            $where = array(
                'template_id' => $value,
                'user_id' => $this->userid
            );
            $this->db->delete('sms_template', $where);
        }
    }

}
