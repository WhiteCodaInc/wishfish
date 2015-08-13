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
class M_csv extends CI_Model {

    private $userid;

    function __construct() {
        parent::__construct();
        $this->userid = $this->session->userdata('u_userid');
    }
}
