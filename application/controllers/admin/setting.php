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

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->smssi || !$this->p->smssu || !$this->p->cals || !$this->p->pays) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_setting', 'objsetting');
            $this->load->model('admin/m_admin_access', 'objclass');
        }
    }

    function sms() {
        if ($this->p->smssi || $this->p->smssu) {
            $data['twilio'] = $this->objsetting->getTwilioNumbers();
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/twilio-number', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function twilioNumber() {
        if ($this->p->smssi) {
            $data['class'] = $this->objclass->getAdminAccessClass();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-twilio-number', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addTwilioNumber() {
        if ($this->p->smssi) {
            $post = $this->input->post();
            $msg = $this->objsetting->addTwilioNumber($post);
            header('location:' . site_url() . 'admin/setting/sms?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editTwilioNumber($twilioid) {
        if ($this->p->smssu) {
            $data['twilio'] = $this->objsetting->getTwilioNumber($twilioid);
            $data['class'] = $this->objclass->getAdminAccessClass();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-twilio-number', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editNumber() {
        if ($this->p->smssu) {
            $post = $this->input->post();
            $msg = $this->objsetting->addTwilioNumber($post);
            header('location:' . site_url() . 'admin/setting/sms?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function calender() {
        if ($this->p->cals) {
            $data['calender'] = $this->objsetting->getCalenderSetting();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/calender-setting', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateCalenderSetting() {
        if ($this->p->cals) {
            $post = $this->input->post();
            if (is_array($post) && count($post) > 0) {
                $this->objsetting->updateCalenderSetting($post);
                header('location:' . site_url() . 'admin/setting/calender?msg=U');
            } else {
                header('location:' . site_url() . 'admin/setting/calender');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function payment() {
        if ($this->p->pays) {
            $data['paypal'] = $this->wi_common->getPaymentGatewayInfo("PAYPAL");
            $data['stripe'] = $this->wi_common->getPaymentGatewayInfo("STRIPE");
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/payment-setting', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updatePaypal() {
        if ($this->p->pays) {
            $post = $this->input->post();
            if (is_array($post) && count($post) > 0) {
                echo ($this->objsetting->updatePaypal($post)) ? 1 : 0;
            } else {
                header('location:' . site_url() . 'admin/setting/payment');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateStripe() {
        if ($this->p->pays) {
            $post = $this->input->post();
            if (is_array($post) && count($post) > 0) {
                echo ($this->objsetting->updateStripe($post)) ? 1 : 0;
            } else {
                header('location:' . site_url() . 'admin/setting/payment');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
