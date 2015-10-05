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
        if (!$this->wi_authex->alogged_in()) {
            header('location:' . site_url() . 'affiliate/login');
        } else {
            $this->load->model('affiliate/m_offers', 'objoffer');
        }
    }

    function index() {
        $data['offers'] = $this->objoffer->getOffers();
        $this->load->view('admin/admin_header');
        $this->load->view('affiliate/affiliate_top');
        $this->load->view('affiliate/affiliate_navbar');
        $this->load->view('affiliate/offers', $data);
        $this->load->view('admin/admin_footer');
    }

    function addOffer() {
        $data['plans'] = $this->objplan->getPlans();
        $data['products'] = $this->objproduct->getProducts();
        $this->load->view('admin/admin_header');
        $this->load->view('affiliate/affiliate_top');
        $this->load->view('affiliate/affiliate_navbar');
        $this->load->view('affiliate/add-offer', $data);
        $this->load->view('admin/admin_footer');
    }

    function createOffer() {
        $post = $this->input->post();
        $this->objoffer->createOffer($post);
        header('location:' . site_url() . 'affiliate/offers?msg=I');
    }

    function editOffer($oid) {
        $data['offer'] = $this->objoffer->getOffer($oid);
        $data['plans'] = $this->objplan->getPlans();
        $data['products'] = $this->objproduct->getProducts();
        $this->load->view('admin/admin_header');
        $this->load->view('affiliate/affiliate_top');
        $this->load->view('affiliate/affiliate_navbar');
        $this->load->view('affiliate/add-offer', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateOffer() {
        $post = $this->input->post();
        $msg = $this->objoffer->updateOffer($post);
        header('location:' . site_url() . 'affiliate/offers?msg=' . $msg);
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete" || $type == "Active" || $type == "Deactive") {
            $ids = $this->input->post('offers');
            $msg = $this->objoffer->setAction($type, $ids);
            header('location:' . site_url() . 'affiliate/offers?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'affiliate/offers');
        }
    }

}
