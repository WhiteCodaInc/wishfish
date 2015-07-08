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
class M_feedback extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getFeedbackDetail() {
        $this->db->order_by('name', 'desc');
        $query = $this->db->get('feedback');
        return $query->result();
    }

    function setAction() {
        $ids = $this->input->post('feedback');
        if (is_array($ids) && count($ids) > 0) {
            foreach ($ids as $value) {
                $this->db->delete('feedback', array('feedback_id' => $value));
            }
            $msg = "D";
        } else {
            $msg = FALSE;
        }
        return $msg;
    }

}
