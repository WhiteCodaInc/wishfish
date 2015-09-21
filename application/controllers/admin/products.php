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

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->probi && !$this->p->probu && !$this->p->probd) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_products', 'objproduct');
        }
    }

    function index() {
        if ($this->p->probi || $this->p->probu || $this->p->probd) {
            $data['product'] = $this->objproduct->getProducts();
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/products', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addProduct() {
        if ($this->p->probi) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-product');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createProduct() {
        if ($this->p->probi) {
            $post = $this->input->post();
            $this->objproduct->createProduct($post);
            header('location:' . site_url() . 'admin/products?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editProduct($pid) {
        if ($this->p->probu) {
            $data['product'] = $this->objproduct->getProduct($pid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-product', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateProduct() {
        if ($this->p->probu) {
            $post = $this->input->post();
            $this->objproduct->updateProduct($post);
            header('location:' . site_url() . 'admin/products?msg=U');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->probd) {
            $type = $this->input->post('actionType');
            if ($type == "Delete") {
                $this->objproduct->setAction();
            }
            header('location:' . site_url() . 'admin/products?msg=D');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
