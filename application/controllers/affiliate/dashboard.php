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
class Dashboard extends CI_Controller {

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

        $this->load->model('affiliate/m_dashboard', 'objdashboard');
        $this->load->model('affiliate/m_affiliate', 'objaffiliate');
    }

    function index() {

        if (!$this->directLogin && $this->wi_authex->alogged_in()) {

            $aid = $this->session->userdata('a_affid');
            $data['affInfo'] = $this->common->getAffInfo($aid);
            $this->load->view('admin/admin_header');
            $this->load->view('affiliate/affiliate_top');
            $this->load->view('affiliate/affiliate_navbar');
            $this->load->view('affiliate/affiliate-dashboard', $data);
            $this->load->view('admin/admin_footer');
        } else {
            $affInfo = $this->common->getAffInfo($this->aid);
            if ($this->aid != "" && count($affInfo) == 1) {

                if ($this->directLogin) {
                    $login = array(
                        'email' => $affInfo->email
                    );
                    if ($this->wi_authex->alogin($login)) {
                        header('location:' . site_url() . 'affiliate/dashboard');
                    } else {
                        header('location:' . site_url() . 'affiliate/login');
                    }
                } else {
                    $data['flag'] = TRUE;
                    $data['affInfo'] = $affInfo;
                    $data['isForgot'] = ($this->type != "" && $this->type == "forgot") ? TRUE : FALSE;
                    $this->load->view('affiliate/dummy-dashboard', $data);
                }
            } else if ($this->daid != "") {
                $data['flag'] = FALSE;
                $data['affInfo'] = FALSE;
                $this->load->view('affiliate/dummy-dashboard', $data);
            } else if ($this->daid != "") {
                $data['flag'] = TRUE;
                $data['isForgot'] = FALSE;
                $data['affInfo'] = FALSE;
                $data['affId'] = $this->daid;
                $this->load->view('affiliate/dummy-dashboard', $data);
            } else {
                header('location:' . site_url() . 'home');
            }
        }
    }

    function updatePassword() {
        $post = $this->input->post();
        if (isset($post) && is_array($post)) {
            $login = $this->objdashboard->updatePassword($post);
            if ($login && $this->wi_authex->alogin($login)) {
                header('location:' . site_url() . 'affiliate/dashboard');
            } else {
                header('location:' . site_url() . 'affiliate/dashboard?aid=' . $this->aid);
            }
        } else if ($this->wi_authex->alogged_in()) {
            header('location:' . site_url() . 'affiliate/dashboard');
        } else {
            header('location:' . site_url() . 'home');
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
