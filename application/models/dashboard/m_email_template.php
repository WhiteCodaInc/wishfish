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

    private $userid;

    function __construct() {
        parent::__construct();
        $this->userid = $this->session->userdata('u_userid');
    }

    function getTemplates() {
        $query = $this->db->get_where('wi_email_template', array('user_id' => $this->userid));
        return $query->result();
    }

    function getTemplate($tid) {
        $where = array(
            'template_id' => $tid,
            'user_id' => $this->userid
        );
        $query = $this->db->get_where('wi_email_template', $where);
        return $query->row();
    }

    function createTemplate($set) {
        $set['user_id'] = $this->userid;
        $this->db->insert('wi_email_template', $set);
        return TRUE;
    }

    function updateTemplate($set) {
        $tid = $set['templateid'];
        unset($set['templateid']);
        $where = array(
            'template_id' => $tid,
            'user_id' => $this->userid
        );
        $this->db->update('wi_email_template', $set, $where);
        return TRUE;
    }

    function setAction($ids) {
        foreach ($ids as $value) {
            $where = array(
                'template_id' => $value,
                'user_id' => $this->userid
            );
            $this->db->delete('wi_email_template', $where);
        }
    }

}
