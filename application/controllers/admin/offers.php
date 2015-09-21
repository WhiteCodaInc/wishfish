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
class Offers extends CI_Controller {

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->offi && !$this->p->offu && !$this->p->offd) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_offers', 'objoffer');
            $this->load->model('admin/m_plans', 'objplan');
            $this->load->model('admin/m_products', 'objproduct');
        }
    }

    function index() {
        if ($this->p->offi || $this->p->offu || $this->p->offd) {
            $data['offers'] = $this->objoffer->getOffers();
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/offers', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addOffer() {
        if ($this->p->offi) {
            $data['plans'] = $this->objplan->getPlans();
            $data['products'] = $this->objproduct->getProducts();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-offer', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createOffer() {
        if ($this->p->offi) {
            $post = $this->input->post();
            $this->objoffer->createOffer($post);
            header('location:' . site_url() . 'admin/offers?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editOffer($oid) {
        if ($this->p->offu) {
            $data['offer'] = $this->objoffer->getOffer($oid);
            $data['plans'] = $this->objplan->getPlans();
            $data['products'] = $this->objproduct->getProducts();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-offer', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateOffer() {
        if ($this->p->offu) {
            $post = $this->input->post();
            $msg = $this->objoffer->updateOffer($post);
            header('location:' . site_url() . 'admin/offers?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->offu || $this->p->offd) {
            $type = $this->input->post('actionType');
            if ($type == "Delete" || $type == "Active" || $type == "Deactive") {
                $ids = $this->input->post('offers');
                $msg = $this->objoffer->setAction($type, $ids);
                header('location:' . site_url() . 'admin/offers?msg=' . $msg);
            } else {
                header('location:' . site_url() . 'admin/offers');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
