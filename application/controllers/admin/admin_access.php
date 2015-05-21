<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin_access
 *
 * @author Laxmisoft
 */
class Admin_access extends CI_Controller {

//put your code here
    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");
        
             
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->admin) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_admin_profile', 'objprofile');
            $this->load->model('admin/m_admin_access', 'objclass');
        }
    }

    function index() {
        $data['role'] = $this->objprofile->getProfiles();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/configure-admin-access', $data);
        $this->load->view('admin/admin_footer');
    }

    function access_class() {
        $data['class'] = $this->objclass->getAdminAccessClass();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/admin-access-class', $data);
        $this->load->view('admin/admin_footer');
    }

    function addClass() {
        $post = $this->input->post();
        if ($this->objclass->addClass($post)) {
            echo "1";
        } else {
            echo "0";
        }
    }

    function permission() {
        $post = $this->input->post();
        $result = $this->objclass->getPermission($post);
        echo json_encode($result);
    }

    function addPermission() {
        $post = $this->input->post();
        $res = $this->objclass->addPermission($post);
        if ($res) {
            $data['msg'] = "U";
            $data['id'] = $res;
        } else {
            $data['id'] = "-1";
            $data['msg'] = "F";
        }
        $data['class'] = $this->objclass->getAdminAccessClass();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/admin-access-class', $data);
        $this->load->view('admin/admin_footer');
    }

}
