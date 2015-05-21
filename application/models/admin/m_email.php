<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_email
 *
 * @author Laxmisoft
 */
class m_email extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function getTemplate($tmpid) {
        $query = $this->db->get_where('email_template', array('template_id' => $tmpid));
        $res = $query->result_array();
        echo json_encode($res[0]);
    }

    function getTemplates() {
        $query = $this->db->get('email_template');
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

}
