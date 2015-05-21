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
class Affiliate_groups extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");
        $rule = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$rule->affiliates) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_affiliate_groups', 'objgroup');
        }
    }

    function index() {
        $data['groups'] = $this->objgroup->getAffiliateGroups();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/affiliate-group', $data);
        $this->load->view('admin/admin_footer');
    }

    function addAffiliateGroup() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-affiliate-group');
        $this->load->view('admin/admin_footer');
    }

    function createAffiliateGroup() {
        $post = $this->input->post();
        $this->objgroup->createAffiliateGroup($post);
        header('location:' . site_url() . 'admin/affiliate_groups?msg=I');
    }

    function editAffiliateGroup($gid) {
        $data['groups'] = $this->objgroup->getAffiliateGroup($gid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-affiliate-group', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateAffiliateGroup() {
        $post = $this->input->post();
        $this->objgroup->updateAffiliateGroup($post);
        header('location:' . site_url() . 'admin/affiliate_groups?msg=U');
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objgroup->setAction();
        }
        header('location:' . site_url() . 'admin/affiliate_groups?msg=D');
    }

}
