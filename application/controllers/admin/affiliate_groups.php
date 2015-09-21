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

    private $p;

    function __construct() {
        parent::__construct();

        $this->p = $this->common->getPermission();

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->affgi && !$this->p->affgu && !$this->p->affgd) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_affiliate_groups', 'objgroup');
        }
    }

    function index() {
        if ($this->p->affgi || $this->p->affgu || $this->p->affgd) {
            $data['groups'] = $this->objgroup->getAffiliateGroups();
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/affiliate-group', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addAffiliateGroup() {
        if ($this->p->affgi) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-affiliate-group');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createAffiliateGroup() {
        if ($this->p->affgi) {
            $post = $this->input->post();
            $this->objgroup->createAffiliateGroup($post);
            header('location:' . site_url() . 'admin/affiliate_groups?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editAffiliateGroup($gid) {
        if ($this->p->affgu) {
            $data['groups'] = $this->objgroup->getAffiliateGroup($gid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-affiliate-group', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateAffiliateGroup() {
        if ($this->p->affgu) {
            $post = $this->input->post();
            $this->objgroup->updateAffiliateGroup($post);
            header('location:' . site_url() . 'admin/affiliate_groups?msg=U');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->affgd) {
            $type = $this->input->post('actionType');
            if ($type == "Delete") {
                $this->objgroup->setAction();
            }
            header('location:' . site_url() . 'admin/affiliate_groups?msg=D');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
