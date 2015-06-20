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
class Setting extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!$this->wi_authex->logged_in()) {
            header('location:' . site_url() . 'home');
        } else {
            $this->load->model('dashboard/m_profile', 'objprofile');
            $this->load->model('m_register', 'objregister');
        }
    }

    function index() {
        $data['setting'] = $this->objprofile->getUserSetting();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        $this->load->view('dashboard/user-setting', $data);
        $this->load->view('dashboard/footer');
    }

    function updateSetting() {
        $post = $this->input->post();
        if (is_array($post) && count($post) > 0) {
            $this->objprofile->updateUserSetting($post);
            $this->session->set_flashdata('msg', 'U');
            header('location:' . site_url() . 'app/setting');
        } else {
            header('location:' . site_url() . 'app/setting');
        }
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
