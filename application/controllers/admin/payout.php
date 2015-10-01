<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin_profile
 *
 * @author Laxmisoft
 */
class Payout extends CI_Controller {

    private $p;

    function __construct() {
        parent::__construct();

        $this->p = $this->common->getPermission();

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->affs) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_payout', 'objpayout');
        }
    }

    function index() {
        if ($this->p->affs) {
            $data['setting'] = $this->objpayout->getPayoutSetting();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/payout-setting', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
