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
class M_cpanel extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profile_id');
    }

    function getAccounts() {
        $query = $this->db->get('cpanel_email_account');
        return $query->result();
    }

    function getNotificationAccount() {
        $query = $this->db->get_where('cpanel_email_account', array('notification' => 1));
        return $query->result();
    }

    function getProfileAccount() {

        $adminInfo = $this->common->getAdminInfo();
        $acc = explode(',', $adminInfo->account_id);

        $this->db->where_in('account_id', $acc);
        $query = $this->db->get('cpanel_email_account');
        return $query->result();
    }

    function getAccount($accountid) {
        $query = $this->db->get_where('cpanel_email_account', array('account_id' => $accountid));
        return $query->row();
    }

    function createAccount($set) {
        $this->db->insert('cpanel_email_account', $set);
        return TRUE;
    }

    function updateAccount($accountid, $set) {
        $this->db->update('cpanel_email_account', $set, array('account_id' => $accountid));
        return TRUE;
    }

    function setAction($type, $ids) {
        if (is_array($ids))
            $this->db->where('account_id in(' . implode(',', $ids) . ')');
        switch ($type) {
            case "Add":
                $this->db->update('cpanel_email_account', array('notification' => 1));
                break;
            case "Remove":
                $this->db->update('cpanel_email_account', array('notification' => 0));
                break;
            case "Delete":
                $this->db->delete('cpanel_email_account', array('account_id' => $ids));
                break;
        }
        return TRUE;
    }

}
