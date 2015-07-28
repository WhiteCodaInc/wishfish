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

    function __construct() {
        parent::__construct();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
//        } else if (!$this->common->getPermission()->customers) {
//            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_offers', 'objoffer');
            $this->load->model('admin/m_plans', 'objplan');
            $this->load->model('admin/m_products', 'objproduct');
        }
    }

    function index() {
        $data['offers'] = $this->objoffer->getOffers();
//        echo '<pre>';
//        print_r($data);
//        die();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/offers', $data);
        $this->load->view('admin/admin_footer');
    }

    function addOffer() {
        $data['plans'] = $this->objplan->getPlans();
        $data['products'] = $this->objproduct->getProducts();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-offer', $data);
        $this->load->view('admin/admin_footer');
    }

    function createOffer() {
        $post = $this->input->post();
        $this->objoffer->createOffer($post);
        header('location:' . site_url() . 'admin/offers?msg=I');
    }

    function editOffer($oid) {
        $data['offer'] = $this->objoffer->getOffer($oid);
        $data['plans'] = $this->objplan->getOffers();
        $data['products'] = $this->objproduct->getOffers();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-offer', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateOffer() {
        $post = $this->input->post();
        $msg = $this->objoffer->updateOffer($post);
        header('location:' . site_url() . 'admin/offers?msg=' . $msg);
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete" || $type == "Active" || $type == "Deactive") {
            $ids = $this->input->post('offers');
            $msg = $this->objoffer->setAction($type, $ids);
            header('location:' . site_url() . 'admin/offers?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/offers');
        }
    }

}
