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
class Contact_groups extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");
        
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->contacts) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_admin_contact_groups', 'objgrp');
        }
    }

    function index() {
        $data['groups'] = $this->objgrp->getContactGroups("simple");
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/contact-group', $data);
        $this->load->view('admin/admin_footer');
    }

    function addContactGroup() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-contact-group');
        $this->load->view('admin/admin_footer');
    }

    function createContactGroup() {
        $post = $this->input->post();
        $this->objgrp->createContactGroup($post);
        header('location:' . site_url() . 'admin/contact_groups?msg=I');
    }

    function editContactGroup($gid) {
        $data['groups'] = $this->objgrp->getContactGroup($gid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-contact-group', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateContactGroup() {
        $post = $this->input->post();
        $this->objgrp->updateContactGroup($post);
        header('location:' . site_url() . 'admin/contact_groups?msg=U');
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objgrp->setAction();
        }
        header('location:' . site_url() . 'admin/contact_groups?msg=D');
    }

}
