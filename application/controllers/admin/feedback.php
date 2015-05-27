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
class Feedback extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else {
            $this->load->model('admin/m_feedback', 'objfeedback');
        }
    }

    function index() {
        $data['comments'] = $this->objfeedback->getFeedbackDetail();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/feedback', $data);
        $this->load->view('admin/admin_footer');
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $msg = $this->objfeedback->setAction($type);
        }
        header('location:' . site_url() . 'admin/feedback?msg=' . $msg);
    }

}
