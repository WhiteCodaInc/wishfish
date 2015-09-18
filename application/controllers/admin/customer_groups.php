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
class Customer_groups extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
//        } else if (!$this->common->getPermission()->customers) {
//            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_customer_groups', 'objgroup');
        }
    }

    function index() {
        $data['groups'] = $this->objgroup->getCustomerGroups();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/customer-group', $data);
        $this->load->view('admin/admin_footer');
    }

    function addCustomerGroup() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-customer-group');
        $this->load->view('admin/admin_footer');
    }

    function createCustomerGroup() {
        $post = $this->input->post();
        $this->objgroup->createCustomerGroup($post);
        header('location:' . site_url() . 'admin/customer_groups?msg=I');
    }

    function editCustomerGroup($gid) {
        $data['groups'] = $this->objgroup->getCustomerGroup($gid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-customer-group', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateCustomerGroup() {
        $post = $this->input->post();
        $this->objgroup->updateCustomerGroup($post);
        header('location:' . site_url() . 'admin/customer_groups?msg=U');
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objgroup->setAction();
            header('location:' . site_url() . 'admin/customer_groups?msg=D');
        } else {
            header('location:' . site_url() . 'admin/customer_groups');
        }
    }

}
