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

    private $p;

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");
        $this->p = $this->common->getPermission();

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->congi && !$this->p->congu && !$this->p->congd) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_admin_contact_groups', 'objgrp');
        }
    }

    function index() {
        if ($this->p->congi || $this->p->congu || $this->p->congd) {
            $data['groups'] = $this->objgrp->getContactGroups("simple");
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/contact-group', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addContactGroup() {
        if ($this->p->congi) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-contact-group');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createContactGroup() {
        if ($this->p->congi) {
            $post = $this->input->post();
            $this->objgrp->createContactGroup($post);
            header('location:' . site_url() . 'admin/contact_groups?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editContactGroup($gid) {
        if ($this->p->congu) {
            $data['groups'] = $this->objgrp->getContactGroup($gid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-contact-group', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateContactGroup() {
        if ($this->p->congu) {
            $post = $this->input->post();
            $this->objgrp->updateContactGroup($post);
            header('location:' . site_url() . 'admin/contact_groups?msg=U');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->cond) {
            $type = $this->input->post('actionType');
            if ($type == "Delete") {
                $this->objgrp->setAction();
            }
            header('location:' . site_url() . 'admin/contact_groups?msg=D');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
