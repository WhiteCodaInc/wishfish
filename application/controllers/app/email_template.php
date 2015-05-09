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
            header('location:' . site_url() . 'home');
        } elseif (!$this->authex->isActivePlan()) {
            header('location:' . site_url() . 'app/upgrade');
        } else {
            $this->load->model('dashboard/m_email_template', 'objtemplate');
        }
    }

    function index() {
        $data['template'] = $this->objtemplate->getTemplates();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');

        $this->load->view('dashboard/email-template', $data);
        $this->load->view('dashboard/footer');
    }

    function addTemplate() {
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');

        $this->load->view('dashboard/add-email-template');
        $this->load->view('dashboard/footer');
    }

    function createTemplate() {
        $post = $this->input->post();
        $this->objtemplate->createTemplate($post);
        header('location:' . site_url() . 'app/email_template?msg=I');
    }

    function editTemplate($pid) {
        $data['template'] = $this->objtemplate->getTemplate($pid);
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');

        $this->load->view('dashboard/add-email-template', $data);
        $this->load->view('dashboard/footer');
    }

    function updateTemplate() {
        $post = $this->input->post();
        $this->objtemplate->updateTemplate($post);
        header('location:' . site_url() . 'app/email_template?msg=U');
    }

    function action() {
        $type = $this->input->post('actionType');
        $ids = $this->input->post('template');
        if ($type == "Delete") {
            $this->objtemplate->setAction($ids);
        }
        header('location:' . site_url() . 'app/email_template?msg=D');
    }

}
