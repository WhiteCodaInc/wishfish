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
class Plans extends CI_Controller {

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->paypi && !$this->p->paypu && !$this->p->paypd) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_plans', 'objplan');
        }
    }

    function index() {
        if ($this->p->paypi || $this->p->paypu || $this->p->paypd) {
            $data['plans'] = $this->objplan->getPlans();
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/plans', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addPlan() {
        if ($this->p->paypi) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-payment-plan');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createPlan() {
        if ($this->p->paypi) {
            $post = $this->input->post();
            $this->objplan->createPlan($post);
            header('location:' . site_url() . 'admin/plans?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editPlan($pid) {
        if ($this->p->paypu) {
            $data['plans'] = $this->objplan->getPlan($pid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-payment-plan', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updatePlan() {
        if ($this->p->paypu) {
            $post = $this->input->post();
            $this->objplan->updatePlan($post);
            header('location:' . site_url() . 'admin/plans?msg=U');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->paypd) {
            $type = $this->input->post('actionType');
            if ($type == "Delete") {
                $this->objplan->setAction();
                header('location:' . site_url() . 'admin/plans?msg=D');
            } else {
                header('location:' . site_url() . 'admin/plans');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
