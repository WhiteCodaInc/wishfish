<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_sms
 *
 * @author Laxmisoft
 */
class m_sms extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function getTemplate($tmpid) {
        $query = $this->db->get_where('sms_template', array('template_id' => $tmpid));
        $res = $query->result_array();
        echo json_encode($res[0]);
    }

    function getTemplates() {
        $query = $this->db->get('sms_template');
        return $query->result();
    }

    function getGroupContact($gid) {
        $this->db->select('*');
        $this->db->from('contact_detail as C');
        $this->db->join('contact_groups as CG', 'C.group_Id = CG.group_id');
        $this->db->where('C.group_id', $gid);
        $query = $this->db->get();
        return $query->result();
    }

    function getProfilePics($phone) {
//        $this->db->update('inbox', array('status' => 2), array('from' => $phone, 'status' => 1));
        $this->db->select('*');
        $query = $this->db->get_where('contact_detail', array('phone' => $phone));
        return $query->row();
    }

    function getInbox() {
        $this->db->select('*');
        $this->db->from('inbox as I');
        $this->db->join('contact_detail as C', 'I.contact_id = C.contact_id');
        $this->db->order_by('C.fname', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function updateInbox($to, $body) {
        $this->db->update('inbox', array('status' => 0, 'body' => $body), array('from' => $to));
    }

    function updateStatus($sid) {
        $this->db->update('inbox', array('status' => 2), array('sid' => $sid));
    }

}
