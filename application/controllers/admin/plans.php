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
class Plans extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
//        } else if (!$this->common->getPermission()->contacts) {
//            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_products', 'objproduct');
            $this->load->model('admin/m_plans', 'objplan');
        }
    }

    function index() {
        $data['plans'] = $this->objplan->getPlans();
        $data['products'] = $this->objproduct->getProducts();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/plans', $data);
        $this->load->view('admin/admin_footer');
    }

    function addPlan() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-payment-plan');
        $this->load->view('admin/admin_footer');
    }

    function createPlan() {
        $post = $this->input->post();
        $this->objplan->createPlan($post);
        header('location:' . site_url() . 'admin/plans?msg=I');
    }

    function editPlan($pid) {
        $data['plans'] = $this->objplan->getPlan($pid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-payment-plan', $data);
        $this->load->view('admin/admin_footer');
    }

    function updatePlan() {
        $post = $this->input->post();
        $this->objplan->updatePlan($post);
        header('location:' . site_url() . 'admin/plans?msg=U');
    }

    function assignPlan() {
        $post = $this->input->post();
        $this->objplan->assignPlan($post);
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objplan->setAction();
            header('location:' . site_url() . 'admin/plans?msg=D');
        } else {
            header('location:' . site_url() . 'admin/plans');
        }
    }

}
