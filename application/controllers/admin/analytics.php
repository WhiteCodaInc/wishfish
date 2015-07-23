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

//put your code here
    function __construct() {
        parent::__construct();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
//        } else if (!$this->common->getPermission()->admin) {
//            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_analytics', 'objanalytics');
        }
    }

    function index() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/analytics-payment');
        $this->load->view('admin/admin_footer');
    }

    function getPayments() {
        $post = $this->input->post();
        $data['phistory'] = $this->objanalytics->getPayments($post);
        $this->load->view('admin/analytics-datewise-payment', $data);
    }

    function getPaymentDetail() {
        $post = $this->input->post();
        $data['pdetail'] = $this->objanalytics->getPaymentDetail($post);
        $this->load->view('admin/analytics-payment-detail', $data);
    }

    function totalUser() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/analytics-total-users');
        $this->load->view('admin/admin_footer');
    }

    function getTotalUser() {
        $post = $this->input->post();
        $data['users'] = $this->objanalytics->getTotalUser($post);
        $this->load->view('admin/analytics-datewise-user', $data);
    }

    function getUserDetail() {
        $post = $this->input->post();
        $data['udetail'] = $this->objanalytics->getUserDetail($post);
        $this->load->view('admin/analytics-user-detail', $data);
    }

    function totalNewUser() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/analytics-total-new-users');
        $this->load->view('admin/admin_footer');
    }

    function getTotalNewUser() {
        $post = $this->input->post();
        $data['users'] = $this->objanalytics->getTotalNewUser($post);
        $this->load->view('admin/analytics-datewise-new-user', $data);
    }

    function getNewUserDetail() {
        $post = $this->input->post();
        $data['udetail'] = $this->objanalytics->getNewUserDetail($post);
        $this->load->view('admin/analytics-new-user-detail', $data);
    }

    function adminReport() {
        $data['profiles'] = $this->objanalytics->getProfiles();
        $data['class'] = $this->objanalytics->getAdminAccessClass();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/analytics-admin', $data);
        $this->load->view('admin/admin_footer');
    }

    function action() {
        $post = $this->input->post();
        $act = array("ee", "es", "de", "ds");
        if (in_array($post['actionType'], $act) && count($post['profile']) > 0) {
            $msg = $this->objprofile->setAction($post);
            header('location:' . site_url() . 'admin/analytics/admin_report?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/analytics/admin_report');
        }
    }

}
