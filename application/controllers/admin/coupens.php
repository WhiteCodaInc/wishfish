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
class Coupens extends CI_Controller {

    function __construct() {
        parent::__construct();
//        $rule = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
//        } else if (!$rule->affiliates) {
//            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_coupens', 'objcoupen');
        }
    }

    function index() {
        $data['coupens'] = $this->objcoupen->getCoupens();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/coupens', $data);
        $this->load->view('admin/admin_footer');
    }

    function addCoupen() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-coupen');
        $this->load->view('admin/admin_footer');
    }

    function createCoupen() {
        $post = $this->input->post();
        $this->objcoupen->createCoupen($post);
        header('location:' . site_url() . 'admin/coupens?msg=I');
    }

    function editCoupen($cid) {
        $data['coupen'] = $this->objcoupen->getCoupen($cid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-coupen', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateCoupen() {
        $post = $this->input->post();
        $this->objcoupen->updateCoupen($post);
        header('location:' . site_url() . 'admin/coupens?msg=U');
    }

    function action() {
        $type = $this->input->post('actionType');
        $ids = $this->input->post('coupen');
        if (($type == "Delete" || $type == "Active" || $type == "Deactive") && count($ids)) {
            $msg = $this->objcoupen->setAction($type, $ids);
            header('location:' . site_url() . 'admin/coupens?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/coupens');
        }
    }

}
