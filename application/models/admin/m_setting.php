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
class M_setting extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getTwilioNumbers() {
        $this->db->select('twilio_id,class_name,twilio_number');
        $this->db->from('twilio_number as T');
        $this->db->join('access_class as A', 'T.class_id = A.class_id');
        $query = $this->db->get();
        return $query->result();
    }

    function getTwilioNumber($twilioid) {
        $query = $this->db->get_where('twilio_number', array('twilio_id' => $twilioid));
        return $query->row();
    }

    function addTwilioNumber($set) {
        $set['twilio_number'] = str_replace(array('(', ')', ' ', '-'), '', $set['code'] . $set['twilio_number']);
        unset($set['code']);
        $query = $this->db->get_where('twilio_number', array('class_id' => $set['class_id']));
        if ($query->num_rows() > 0) {
            $this->db->update('twilio_number', $set, array('class_id' => $set['class_id']));
            $this->updateAdminProfile($set);
            $msg = "U";
        } else {
            $this->db->insert('twilio_number', $set);
            $this->updateAdminProfile($set);
            $msg = "I";
        }
        return $msg;
    }

    function updateAdminProfile($set) {
        $this->db->update('admin_profile', $set, array('class_id' => $set['class_id']));
    }

    function getCalenderSetting() {
        $query = $this->db->get('calender_setting');
        return $query->row();
    }

    function updateCalenderSetting($set) {
        $this->db->update('calender_setting', $set);
        return true;
    }

    function updatePaypal($set) {
        $this->db->update('wi_general_setting', $set, array('method_name' => "PAYPAL"));
        return TRUE;
    }

    function updateStripe($set) {
        $this->db->update('wi_general_setting', $set, array('method_name' => "STRIPE"));
        return TRUE;
    }
}
