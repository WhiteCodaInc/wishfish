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
class M_email_list extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getEmailLists() {
        $this->db->select("E.name,count(E.list_id) as totalE,count(contact_id) as totalC");
        $this->db->from('email_list as E');
        $this->db->join('email_list_contacts as EC', 'E.list_id = EC.list_id');
        $query = $this->db->get();
        echo '<pre>';
        print_r($query->result());
        die();
        return $query->result();
    }

    function getEmailList($gid) {
        $query = $this->db->get_where('email_list', array('list_id' => $gid));
        return $query->row();
    }

    function createEmailList($set) {
        $this->db->insert('email_list', $set);
        return TRUE;
    }

    function updateEmailList($set) {
        $gid = $set['listid'];
        unset($set['listid']);

        $this->db->update('email_list', $set, array('list_id' => $gid));
        return TRUE;
    }

    function getListContacts($listid) {
        $query = $this->db->get_where('email_list_contacts', array('list_id' => $listid));
        return $query->result();
    }

}
