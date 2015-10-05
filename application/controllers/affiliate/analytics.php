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

    function __construct() {
        parent::__construct();
        if (!$this->wi_authex->alogged_in()) {
            header('location:' . site_url() . 'affiliate/login');
        } else {
            $this->load->model('affiliate/m_analytics', 'objanalytics');
        }
    }

    function index() {
        $this->load->view('admin/admin_header');
        $this->load->view('affiliate/affiliate_top');
        $this->load->view('affiliate/affiliate_navbar');
        $this->load->view('affiliate/analytics-payment');
        $this->load->view('admin/admin_footer');
    }

    function getPayments() {
        $post = $this->input->post();
        $data['phistory'] = $this->objanalytics->getPayments($post);
        $this->load->view('affiliate/analytics-datewise-payment', $data);
    }

    function getPaymentDetail() {
        $post = $this->input->post();
        $data['pdetail'] = $this->objanalytics->getPaymentDetail($post);
        $this->load->view('admin/analytics-payment-detail', $data);
    }

    function totalUser() {
        $this->load->view('admin/admin_header');
        $this->load->view('affiliate/affiliate_top');
        $this->load->view('affiliate/affiliate_navbar');
        $this->load->view('affiliate/analytics-total-users');
        $this->load->view('admin/admin_footer');
    }

    function getTotalUser() {
        $post = $this->input->post();
        $data['users'] = $this->objanalytics->getTotalUser($post);
        $this->load->view('affiliate/analytics-datewise-user', $data);
    }

    function getUserDetail() {
        $post = $this->input->post();
        $data['udetail'] = $this->objanalytics->getUserDetail($post);
        $this->load->view('affiliate/analytics-user-detail', $data);
    }

    function totalNewUser() {
        $this->load->view('admin/admin_header');
        $this->load->view('affiliate/affiliate_top');
        $this->load->view('affiliate/affiliate_navbar');
        $this->load->view('affiliate/analytics-total-new-users');
        $this->load->view('admin/admin_footer');
    }

    function getTotalNewUser() {
        $post = $this->input->post();
        $data['users'] = $this->objanalytics->getTotalNewUser($post);
        $this->load->view('affiliate/analytics-datewise-new-user', $data);
    }

    function getNewUserDetail() {
        $post = $this->input->post();
        $data['udetail'] = $this->objanalytics->getNewUserDetail($post);
        $this->load->view('affiliate/analytics-new-user-detail', $data);
    }

}
