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
class Setting extends CI_Controller {

//put your code here
    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
//        } else if (!$this->common->getPermission()->setting) {
//            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_setting', 'objsetting');
            $this->load->model('admin/m_admin_access', 'objclass');
        }
    }

    function sms() {
        $data['twilio'] = $this->objsetting->getTwilioNumbers();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/twilio-number', $data);
        $this->load->view('admin/admin_footer');
    }

    function twilioNumber() {
        $data['class'] = $this->objclass->getAdminAccessClass();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-twilio-number', $data);
        $this->load->view('admin/admin_footer');
    }

    function addTwilioNumber() {
        $post = $this->input->post();
        $msg = $this->objsetting->addTwilioNumber($post);
        header('location:' . site_url() . 'admin/setting/sms?msg=' . $msg);
    }

    function editTwilioNumber($twilioid) {
        $data['twilio'] = $this->objsetting->getTwilioNumber($twilioid);
        $data['class'] = $this->objclass->getAdminAccessClass();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-twilio-number', $data);
        $this->load->view('admin/admin_footer');
    }

    function editNumber() {
        $post = $this->input->post();
        $msg = $this->objsetting->addTwilioNumber($post);
        header('location:' . site_url() . 'admin/setting/sms?msg=' . $msg);
    }

    function calender() {
        $data['calender'] = $this->objsetting->getCalenderSetting();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/calender-setting', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateCalenderSetting() {
        $post = $this->input->post();
        if (is_array($post) && count($post) > 0) {
            $this->objsetting->updateCalenderSetting($post);
            header('location:' . site_url() . 'admin/setting/calender?msg=U');
        } else {
            header('location:' . site_url() . 'admin/setting/calender');
        }
    }

    function payment() {
        $data['paypal'] = $this->wi_common->getPaymentGatewayInfo("PAYPAL");
        $data['stripe'] = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/payment-setting', $data);
        $this->load->view('admin/admin_footer');
    }

    function updatePaypal() {
        $post = $this->input->post();
        if (is_array($post) && count($post) > 0) {
            echo ($this->objsetting->updatePaypal($post)) ? 1 : 0;
        } else {
            header('location:' . site_url() . 'admin/setting/payment');
        }
    }

    function updateStripe() {
        $post = $this->input->post();
        if (is_array($post) && count($post) > 0) {
            echo ($this->objsetting->updateStripe($post)) ? 1 : 0;
        } else {
            header('location:' . site_url() . 'admin/setting/payment');
        }
    }

}
