<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin_access
 *
 * @author Laxmisoft
 */
class Analytics extends CI_Controller {

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->totalp && !$this->p->totalu && !$this->p->totalnu && !$this->p->admr) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_analytics', 'objanalytics');
        }
    }

    function index() {
        if ($this->p->totalp) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/analytics-payment');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function getPayments() {
        if ($this->p->totalp) {
            $post = $this->input->post();
            $data['phistory'] = $this->objanalytics->getPayments($post);
            $this->load->view('admin/analytics-datewise-payment', $data);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function getPaymentDetail() {
        if ($this->p->totalp) {
            $post = $this->input->post();
            $data['pdetail'] = $this->objanalytics->getPaymentDetail($post);
            $this->load->view('admin/analytics-payment-detail', $data);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function totalUser() {
        if ($this->p->totalu) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/analytics-total-users');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function getTotalUser() {
        if ($this->p->totalu) {
            $post = $this->input->post();
            $data['users'] = $this->objanalytics->getTotalUser($post);
            $this->load->view('admin/analytics-datewise-user', $data);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function getUserDetail() {
        if ($this->p->totalu) {
            $post = $this->input->post();
            $data['udetail'] = $this->objanalytics->getUserDetail($post);
            $this->load->view('admin/analytics-user-detail', $data);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function totalNewUser() {
        if ($this->p->totalnu) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/analytics-total-new-users');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function getTotalNewUser() {
        if ($this->p->totalnu) {
            $post = $this->input->post();
            $data['users'] = $this->objanalytics->getTotalNewUser($post);
            $this->load->view('admin/analytics-datewise-new-user', $data);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function getNewUserDetail() {
        if ($this->p->totalnu) {
            $post = $this->input->post();
            $data['udetail'] = $this->objanalytics->getNewUserDetail($post);
            $this->load->view('admin/analytics-new-user-detail', $data);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function adminReport() {
        if ($this->p->admr) {
            $data['profiles'] = $this->objanalytics->getProfiles();
            $data['class'] = $this->objanalytics->getAdminAccessClass();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/analytics-admin', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->admr) {
            $post = $this->input->post();
            $act = array("ee", "es", "de", "ds", "da", "ea");
            if (in_array($post['actionType'], $act) && isset($post['profile']) && count($post['profile']) > 0) {
                $msg = $this->objanalytics->setAction($post);
                header('location:' . site_url() . 'admin/analytics/adminReport?msg=' . $msg);
            } else {
                header('location:' . site_url() . 'admin/analytics/adminReport');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
