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
class Customers extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->customers) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_customers', 'objcustomer');
        }
    }

    function index() {
        $data['customers'] = $this->objcustomer->getCustomerDetail();
        $data['plans'] = $this->wi_common->getPlans();
//        echo '<pre>';
//        print_r($data);
//        die();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/customer-detail', $data);
        $this->load->view('admin/admin_footer');
    }

    function search() {
        $data['searchResult'] = $this->objcustomer->searchResult();
        $data['plans'] = $this->wi_common->getPlans();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/customer-detail', $data);
        $this->load->view('admin/admin_footer');
    }

    function profile($cid) {
        $data['customer'] = $this->objcustomer->getCustomerInfo($cid);
        $data['phistory'] = $this->objcustomer->getPaymentHistory($cid);
        $data['card'] = $this->objcustomer->getCardDetail($cid);
        $data['gatewayInfo'] = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/customer-profile-view', $data);
        $this->load->view('admin/admin_footer');
    }

    function editCustomer($cid) {
        $data['customers'] = $this->objcustomer->getCustomerInfo($cid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/edit-customer', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateCustomer() {
        $post = $this->input->post();
        $msg = $this->objcustomer->updateCustomer($post);
        header('location:' . site_url() . 'admin/customers?msg=' . $msg);
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete" || $type == "Active" || $type == "Deactive") {
            $msg = $this->objcustomer->setAction($type);
            header('location:' . site_url() . 'admin/customers?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/customers');
        }
    }

    function loginAsUser($cid) {
        $customer = $this->objcustomer->getCustomerInfo($cid);
        if ($customer->status) {
            $uid = $this->encryption->encode($customer->user_id);
            $url = 'https://wish-fish.com/app/dashboard?uid=' . $uid;
            header('location:' . $url);
        } else {
            echo '<script>alert("Customer account currently was deactivated..!");close();</script>';
        }
    }

    function extendTrial() {
        $post = $this->input->post();
        if (is_array($post) && count($post) > 0) {
            $this->objcustomer->extendTrial($post);
            header('location:' . site_url() . 'admin/customers/profile/' . $post['userid']);
        } else {
            header('location:' . site_url() . 'admin/customers');
        }
    }

    function lifetimeAccess() {
        $post = $this->input->post();
        print_r($post);
        die();
        if (is_array($post) && count($post) > 0) {
            $this->objcustomer->extendTrial($post);
            header('location:' . site_url() . 'admin/customers/profile/' . $post['userid']);
        } else {
            header('location:' . site_url() . 'admin/customers');
        }
    }

    function updateCustomerNotification() {
        $this->objcustomer->updateCustomerNotification();
    }

    function updatePaymentNotification() {
        $this->objcustomer->updatePaymentNotification();
    }

    function updatePaymentDetail() {
        $post = $this->input->post();
        if ($post['stripeToken'] != "" && $post['userid'] != "") {
            (isset($post['isNew']) && $post['isNew']) ?
                            $this->objcustomer->createCard($post['userid'], $post['stripeToken']) :
                            $this->objcustomer->updateCard($post['userid'], $post['stripeToken']);
            header('location:' . site_url() . 'admin/customers/profile/' . $post['userid']);
        } else {
            header('location:' . site_url() . 'admin/customers');
        }
    }

}
