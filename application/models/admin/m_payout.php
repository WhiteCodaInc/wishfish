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
class M_payout extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getPayoutSetting() {
        $query = $this->db->get('payout_setting');
        return $query->result();
    }

    function updateSetting($post) {
        $pid = $post['payoutid'];
        unset($post['payoutid']);
        $this->db->update('payout_setting', $post, array('group_id' => $pid));
        return TRUE;
    }

}
