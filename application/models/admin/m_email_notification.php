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
class M_email_notification extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getAutomails() {
        $query = $this->db->get_where('automail_template');
        return $query->result();
    }

    function getAutomail($mailid) {
        $query = $this->db->get_where('automail_template', array('mail_id' => $mailid));
        return ($query->num_rows() == 1) ? $query->row() : FALSE;
    }

    function update($set) {
        $mailid = $set['mailid'];
        unset($set['mailid']);
        $this->db->update('automail_template', $set, array('mail_id' => $mailid));
        return TRUE;
    }

}
