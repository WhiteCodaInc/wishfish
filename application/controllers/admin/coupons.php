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
class Coupons extends CI_Controller {

    function __construct() {
        parent::__construct();
//        $rule = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
//        } else if (!$rule->affiliates) {
//            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_coupons', 'objcoupon');
        }
    }

    function index() {
        $data['coupons'] = $this->objcoupon->getCoupons();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/coupons', $data);
        $this->load->view('admin/admin_footer');
    }

    function addCoupon() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-coupon');
        $this->load->view('admin/admin_footer');
    }

    function createCoupon() {
        $post = $this->input->post();
        $this->objcoupon->createCoupon($post);
        header('location:' . site_url() . 'admin/coupons?msg=I');
    }

    function editCoupon($cid) {
        $data['coupon'] = $this->objcoupon->getCoupon($cid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-coupon', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateCoupon() {
        $post = $this->input->post();
        $this->objcoupon->updateCoupon($post);
        header('location:' . site_url() . 'admin/coupons?msg=U');
    }

    function action() {
        $type = $this->input->post('actionType');
        $ids = $this->input->post('coupon');
        if (($type == "Delete" || $type == "Active" || $type == "Deactive") && count($ids)) {
            $msg = $this->objcoupon->setAction($type, $ids);
            header('location:' . site_url() . 'admin/coupons?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/coupons');
        }
    }

}
