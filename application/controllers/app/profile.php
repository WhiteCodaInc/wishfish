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
class Profile extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'home');
        } else {
            $this->load->helper('date');
            $this->load->library('parser');
            $this->load->model('dashboard/m_profile', 'objprofile');
        }
    }

    function index() {
        $data['user'] = $this->objprofile->getProfile();
        $data['card'] = $this->objprofile->getCardDetail();
        $data['gatewayInfo'] = $this->common->getPaymentGatewayInfo("PAYPAL");

        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');

        $this->load->view('dashboard/user-profile', $data);
        $this->load->view('dashboard/footer');
    }

    function updateProfile() {
        $post = $this->input->post();
        $msg = $this->objprofile->updateProfile($post);
        header('location:' . site_url() . 'app/dashboard');
    }

    function updateCard() {
        $token = $this->input->post('stripeToken');
        $this->objprofile->updateCard($token);
        header('location:' . site_url() . 'app/profile');
    }

    function cancelAccount() {
        $this->objprofile->cancelCurrentPlan();
    }

    function pay() {
        $this->objprofile->cancelCurrentPlan();
        $data['error'] = $this->session->flashdata('error');
        $data['msg'] = $this->session->flashdata('msg');
        $this->load->view('client/twocheckout_success', $data);
    }

    function upload() {
        echo ($this->objprofile->upload()) ? 1 : 0;
    }

    function updateProfileSetup() {
        $post = $this->input->post();
        echo ($this->objprofile->updateProfileSetup($post)) ? 1 : 0;
    }

}
