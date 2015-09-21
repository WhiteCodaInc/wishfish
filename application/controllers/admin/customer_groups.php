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

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->cusgi && !$this->p->cusgu && !$this->p->cusgd) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_customer_groups', 'objgroup');
        }
    }

    function index() {
        if ($this->p->cusgi || $this->p->cusgu || $this->p->cusgd) {
            $data['groups'] = $this->objgroup->getCustomerGroups();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/customer-group', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addCustomerGroup() {
        if ($this->p->cusgi) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-customer-group');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createCustomerGroup() {
        if ($this->p->cusgi) {
            $post = $this->input->post();
            $this->objgroup->createCustomerGroup($post);
            header('location:' . site_url() . 'admin/customer_groups?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editCustomerGroup($gid) {
        if ($this->p->cusgu) {
            $data['groups'] = $this->objgroup->getCustomerGroup($gid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-customer-group', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateCustomerGroup() {
        if ($this->p->cusgu) {
            $post = $this->input->post();
            $this->objgroup->updateCustomerGroup($post);
            header('location:' . site_url() . 'admin/customer_groups?msg=U');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->cusgd) {
            $type = $this->input->post('actionType');
            if ($type == "Delete") {
                $this->objgroup->setAction();
                header('location:' . site_url() . 'admin/customer_groups?msg=D');
            } else {
                header('location:' . site_url() . 'admin/customer_groups');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
