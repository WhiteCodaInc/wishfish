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
class M_admin_login extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function createProfile($set) {
        $this->db->insert('admin_profile', $set);
    }

}
