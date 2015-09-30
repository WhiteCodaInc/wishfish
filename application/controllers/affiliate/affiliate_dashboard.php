<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author Laxmisoft
 */
class Affiliate_dashboard extends CI_Controller {

    private $aid, $daid, $directLogin;

    //put your code here
    function __construct() {
        parent::__construct();
        $this->output->set_header('cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header("cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

        $affid = $this->input->get('aid');
        $this->type = $this->input->get('type');
        $this->directLogin = $this->input->get('d');
        $this->aid = ($affid != "") ? $this->encryption->decode($affid) : '';

        if ($this->session->userdata('d-affid')) {
            $this->daid = $this->session->userdata('d-affid');
        }

//        $this->load->model('affiliate/m_dashboard', 'objdashboard');
        $this->load->model('affiliate/m_affiliate', 'objaffiliate');
    }

    function index() {
        if (!$this->directLogin && $this->wi_authex->alogged_in()) {
            $aid = $this->session->userdata('a_affid');
            $data['affInfo'] = $this->common->getAffInfo($aid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/admin-dashboard', $data);
            $this->load->view('admin/admin_footer');
        } else {
            $affInfo = $this->common->getAffInfo($this->aid);
            if ($this->aid != "" && count($affInfo) == 1) {

                if ($this->directLogin) {
                    $login = array(
                        'email' => $affInfo->email
                    );
                    if ($this->wi_authex->login($login)) {
                        header('location:' . site_url() . 'affiliate/affiliate_dashboard');
                    } else {
                        header('location:' . site_url() . 'affiliate/login');
                    }
                } else {
                    $data['flag'] = TRUE;
                    $data['userInfo'] = $affInfo;
                    $data['isForgot'] = ($this->type != "" && $this->type == "forgot") ? TRUE : FALSE;
                    $this->load->view('affiliate/dummy-dashboard', $data);
                }
            } else if ($this->duid != "") {
                $data['flag'] = FALSE;
                $data['userInfo'] = FALSE;
                $this->load->view('dashboard/dummy-dashboard', $data);
            } else if ($this->daid != "") {
                $data['isForgot'] = FALSE;
                $data['userInfo'] = FALSE;
                $data['userId'] = $this->daid;
                $this->load->view('dashboard/dummy-dashboard', $data);
            } else {
                header('location:' . site_url() . 'home');
            }
        }
    }

    function error($error) {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/' . $error);
        $this->load->view('admin/admin_footer');
    }

}
