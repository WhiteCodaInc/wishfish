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
            $this->load->library('parser');
            $this->load->model('admin/m_customers', 'objcustomer');
            $this->load->model('admin/m_customer_groups', 'objgroup');
            $this->load->model('admin/m_sms_template', 'objsmstemplate');
            $this->load->model('admin/m_email_template', 'objemailtemplate');
        }
    }

    function index() {
        $data['customers'] = $this->objcustomer->getCustomerDetail();
        echo '<pre>';
        print_r($data);
        die();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/customer-detail', $data);
        $this->load->view('admin/admin_footer');
    }

    function search() {
        $data['searchResult'] = $this->objcustomer->searchResult();
        $data['groups'] = $this->objgroup->getCustomerGroups();
        $data['zodiac'] = $this->common->getZodiacs();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/customer-detail', $data);
        $this->load->view('admin/admin_footer');
    }

    function profile($cid) {
        $res = $this->objcustomer->getCustomer($cid);
        $data['customer'] = $res[0];
        $data['cgroup'] = $res[1];

        $data['groups'] = $this->objgroup->getCustomerGroups();
        $data['sms_template'] = $this->objsmstemplate->getTemplates();
        $data['email_template'] = $this->objemailtemplate->getTemplates();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/customer-profile-view', $data);
        $this->load->view('admin/admin_footer');
    }

    function addCustomer() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-customer');
        $this->load->view('admin/admin_footer');
    }

    function createCustomer() {
        $post = $this->input->post();
        $this->objcustomer->createCustomer($post);
        header('location:' . site_url() . 'admin/customers?msg=I');
    }

    function editCustomer($aid) {
        $res = $this->objcustomer->getCustomer($aid);
        $data['customers'] = $res[0];
        $data['cgroup'] = $res[1];
        $data['groups'] = $this->objgroup->getCustomerGroups();
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
        if ($type == "Delete") {
            $this->objcustomer->setAction();
        }
        header('location:' . site_url() . 'admin/customers?msg=D');
    }

    function getZodiac($dt) {
        $zodiac = $this->common->getZodiac($dt);
        echo $zodiac;
    }

    //----------------Customer Profile Functionality--------------------------//

    function send_message() {
        $post = $this->input->post();
        $customer = $this->objcustomer->getCustomerInfo($post['cid']);
        $tag = $this->common->setToken($customer);
        $body = $this->parser->parse_string($post['body'], $tag, TRUE);
        $this->sendSMS($customer->phone, $body);
        header('location:' . site_url() . 'admin/customers/profile/' . $post['cid']);
    }

    function send_email() {
        $post = $this->input->post();
        $customer = $this->objcustomer->getCustomerInfo($post['cid']);
        $tag = $this->common->setToken($customer);
        $this->sendMail($customer, $tag, $post);
        header('location:' . site_url() . 'admin/customers/profile/' . $post['cid']);
    }

    function sendSMS($to, $body) {
        return $this->common->sendSMS($to, $body);
    }

    function sendMail($customer, $tag, $post) {
        $subject = $this->parser->parse_string($post['subject'], $tag, TRUE);
        $body = $this->parser->parse_string($post['body'], $tag, TRUE);
        return $this->common->sendMail($customer->email, $subject, $body);
    }

}
