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
class Email_template extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->email) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_admin_email_template', 'objtmplt');
        }
    }

    function index() {
        $data['template'] = $this->objtmplt->getTemplates();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/email-template', $data);
        $this->load->view('admin/admin_footer');
    }

    function addTemplate() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-email-template');
        $this->load->view('admin/admin_footer');
    }

    function createTemplate() {
        $post = $this->input->post();
        $this->objtmplt->createTemplate($post);
        header('location:' . site_url() . 'admin/email_template?msg=I');
    }

    function editTemplate($pid) {
        $data['template'] = $this->objtmplt->getTemplate($pid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-email-template', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateTemplate() {
        $post = $this->input->post();
        $this->objtmplt->updateTemplate($post);
        header('location:' . site_url() . 'admin/email_template?msg=U');
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objtmplt->setAction();
        }
        header('location:' . site_url() . 'admin/email_template?msg=D');
    }

}
