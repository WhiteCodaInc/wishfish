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
class Products extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
//        } else if (!$this->common->getPermission()->sms) {
//            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_products', 'objproduct');
        }
    }

    function index() {
        $data['product'] = $this->objproduct->getProducts();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/products', $data);
        $this->load->view('admin/admin_footer');
    }

    function addProduct() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-product');
        $this->load->view('admin/admin_footer');
    }

    function createProduct() {
        $post = $this->input->post();
        $this->objproduct->createProduct($post);
        header('location:' . site_url() . 'admin/products?msg=I');
    }

    function editProduct($pid) {
        $data['products'] = $this->objproduct->getProduct($pid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-product', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateProduct() {
        $post = $this->input->post();
        $this->objproduct->updateProduct($post);
        header('location:' . site_url() . 'admin/products?msg=U');
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objproduct->setAction();
        }
        header('location:' . site_url() . 'admin/products?msg=D');
    }

}
