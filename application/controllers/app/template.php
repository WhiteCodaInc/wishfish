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
class Template extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!$this->wi_authex->logged_in()) {
            header('location:' . site_url() . 'home');
        } elseif (!$this->wi_authex->isActivePlan()) {
            header('location:' . site_url() . 'app/upgrade');
        } else {
            $this->load->model('dashboard/m_email_template', 'objemailtemplate');
            $this->load->model('dashboard/m_sms_template', 'objsmstemplate');
        }
    }

    function index() {
        $emailT = $this->objemailtemplate->getTemplates();
        $smsT = $this->objsmstemplate->getTemplates();
        $data['template'] = array_merge_recursive($emailT, $smsT);
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        $this->load->view('dashboard/template', $data);
        $this->load->view('dashboard/footer');
    }

    function addTemplate($type) {
        $page = ($type == "email") ? "add-email-template" : "add-sms-template";
        $data['controller'] = "template";
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        $this->load->view("dashboard/{$page}", $data);
        $this->load->view('dashboard/footer');
    }

    function createTemplate($type) {
        $post = $this->input->post();
        ($type == "email") ?
                        $this->objemailtemplate->createTemplate($post) :
                        $this->objsmstemplate->createTemplate($post);
        header('location:' . site_url() . 'app/template?msg=I');
    }

    function editTemplate($type, $pid) {
        $page = ($type == "email") ? "add-email-template" : "add-sms-template";
        $data['template'] = ($type == "email") ?
                $this->objemailtemplate->getTemplate($pid) :
                $this->objsmstemplate->getTemplate($pid);
        $data['controller'] = "template";
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        $this->load->view("dashboard/{$page}", $data);
        $this->load->view('dashboard/footer');
    }

    function updateTemplate($type) {
        $post = $this->input->post();
        ($type == "email") ?
                        $this->objemailtemplate->updateTemplate($post) :
                        $this->objsmstemplate->updateTemplate($post);
        header('location:' . site_url() . 'app/template?msg=U');
    }

    function action() {
        $post = $this->input->post();
        $type = $post['actionType'];
        if ($type == "Delete") {
            (isset($post['emailT'])) ? $this->objemailtemplate->setAction($post['emailT']) : '';
            (isset($post['smsT'])) ? $this->objsmstemplate->setAction($post['smsT']) : '';
        }
        header('location:' . site_url() . 'app/template?msg=D');
    }

}
