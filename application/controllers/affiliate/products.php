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
class Products extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->wi_authex->alogged_in()) {
            header('location:' . site_url() . 'affiliate/login');
        } else {
            $this->load->model('affiliate/m_products', 'objproduct');
        }
    }

    function index() {
        $affid = $this->session->userdata('a_affid');
        $data['product'] = $this->objproduct->getProductDetail();
        $data['affInfo'] = $this->common->getAffInfo($affid);
        $this->load->view('admin/admin_header');
        $this->load->view('affiliate/affiliate_top');
        $this->load->view('affiliate/affiliate_navbar');
        $this->load->view('affiliate/products');
        $this->load->view('admin/admin_footer');
    }

}
