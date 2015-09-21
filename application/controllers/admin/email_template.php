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

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->emailti && !$this->p->emailtu && !$this->p->emailtd) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_admin_email_template', 'objtmplt');
        }
    }

    function index() {
        if ($this->p->emailti || $this->p->emailtu || $this->p->emailtd) {
            $data['template'] = $this->objtmplt->getTemplates();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/email-template', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addTemplate() {
        if ($this->p->emailti) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-email-template');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createTemplate() {
        $post = $this->input->post();
        $this->objtmplt->createTemplate($post);
        header('location:' . site_url() . 'admin/email_template?msg=I');
    }

    function editTemplate($pid) {
        if ($this->p->emailti) {
            $data['template'] = $this->objtmplt->getTemplate($pid);
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-email-template', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateTemplate() {
        if ($this->p->emailtu) {
            $post = $this->input->post();
            $this->objtmplt->updateTemplate($post);
            header('location:' . site_url() . 'admin/email_template?msg=U');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->emailtd) {
            $type = $this->input->post('actionType');
            if ($type == "Delete") {
                $this->objtmplt->setAction();
            }
            header('location:' . site_url() . 'admin/email_template?msg=D');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
