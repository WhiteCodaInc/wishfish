<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author Laxmisoft
 */
class Email_notification extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->email) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_email_notification', 'obnotification');
        }
    }

    function index() {
        $data['automail'] = $this->obnotification->getAutomails();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/email-notification', $data);
        $this->load->view('admin/admin_footer');
    }

    function edit($aid) {
        $data['template'] = $this->obnotification->getAutomail($aid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/edit-email-notification', $data);
        $this->load->view('admin/admin_footer');
    }

    function update() {
        $post = $this->input->post();
        $this->obnotification->update($post);
        header('location:' . site_url() . 'admin/email_notification?msg=U');
    }

}
