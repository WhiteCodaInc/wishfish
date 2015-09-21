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
class Sms_template extends CI_Controller {

    private $p;

    function __construct() {
        parent::__construct();

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->smsti && !$this->p->smstu && !$this->p->smstd) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_admin_sms_template', 'objtmplt');
        }
    }

    function index() {
        if ($this->p->smsti || $this->p->smstu || $this->p->smstd) {
            $data['template'] = $this->objtmplt->getTemplates();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/sms-template', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addTemplate() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-sms-template');
        $this->load->view('admin/admin_footer');
    }

    function createTemplate() {
        if ($this->p->smsti) {
            $post = $this->input->post();
            $this->objtmplt->createTemplate($post);
            header('location:' . site_url() . 'admin/sms_template?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editTemplate($pid) {
        if ($this->p->smstu) {
            $data['template'] = $this->objtmplt->getTemplate($pid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-sms-template', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateTemplate() {
        if ($this->p->smstu) {
            $post = $this->input->post();
            $this->objtmplt->updateTemplate($post);
            header('location:' . site_url() . 'admin/sms_template?msg=U');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->smstd) {
            $type = $this->input->post('actionType');
            if ($type == "Delete") {
                $this->objtmplt->setAction();
            }
            header('location:' . site_url() . 'admin/sms_template?msg=D');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
