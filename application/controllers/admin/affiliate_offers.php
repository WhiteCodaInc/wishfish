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
class affiliate_Offers extends CI_Controller {

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->affoi && !$this->p->affou && !$this->p->affod) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_affiliate_offers', 'objoffer');
            $this->load->model('admin/m_plans', 'objplan');
            $this->load->model('admin/m_products', 'objproduct');
        }
    }

    function index() {
        if ($this->p->affoi || $this->p->affou || $this->p->affod) {
            $data['offers'] = $this->objoffer->getOffers();
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/affiliate-offers', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addOffer() {
        if ($this->p->affoi) {
            $data['plans'] = $this->objplan->getPlans();
            $data['products'] = $this->objproduct->getProducts();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-affiliate-offer', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createOffer() {
        if ($this->p->affoi) {
            $post = $this->input->post();
            $this->objoffer->createOffer($post);
            header('location:' . site_url() . 'admin/affiliate_offers?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editOffer($oid) {
        if ($this->p->affou) {
            $data['offer'] = $this->objoffer->getOffer($oid);
            $data['plans'] = $this->objplan->getPlans();
            $data['products'] = $this->objproduct->getProducts();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-affiliate-offer', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateOffer() {
        if ($this->p->affou) {
            $post = $this->input->post();
            $msg = $this->objoffer->updateOffer($post);
            header('location:' . site_url() . 'admin/affiliate_offers?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->affou || $this->p->affod) {
            $type = $this->input->post('actionType');
            if ($type == "Delete" || $type == "Active" || $type == "Deactive") {
                $ids = $this->input->post('offers');
                $msg = $this->objoffer->setAction($type, $ids);
                header('location:' . site_url() . 'admin/affiliate_offers?msg=' . $msg);
            } else {
                header('location:' . site_url() . 'admin/affiliate_offers');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
