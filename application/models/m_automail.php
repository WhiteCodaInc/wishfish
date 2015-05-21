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
class M_automail extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getAutomails() {
        $query = $this->db->get_where('wi_automail_template');
        return $query->result();
    }

    function getAutomail($mailid) {
        $query = $this->db->get_where('wi_automail_template', array('mail_id' => $mailid));
        return ($query->num_rows() == 1) ? $query->row() : FALSE;
    }

//    function create($set) {
//        $this->db->insert('wi_automail_template', $set);
//        return TRUE;
//    }

    function update($set) {
        $mailid = $set['mailid'];
        unset($set['mailid']);
        $this->db->update('wi_automail_template', $set, array('mail_id' => $mailid));
        return TRUE;
    }

//    function setAction() {
//        $ids = $this->input->post('mailid');
//        if (is_array($ids) && count($ids) > 0) {
//            foreach ($ids as $value) {
//                $this->db->delete('wi_automail_template', array('mail_id' => $value));
//            }
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
}
