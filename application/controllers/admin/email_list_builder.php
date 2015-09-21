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
class Email_list_builder extends CI_Controller {

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->emaillbi && !$this->p->emaillbu && !$this->p->emaillbd) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_list_builder', 'objbuilder');
            $this->load->model('admin/m_admin_contacts', 'objcon');
            $this->load->model('admin/m_admin_contact_groups', 'objgrp');
        }
    }

    function index() {
        if ($this->p->emaillbi || $this->p->emaillbu || $this->p->emaillbd) {
            $data['groups'] = $this->objbuilder->getGroups("email");
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/email-list-builder', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addList() {
        if ($this->p->emaillbi) {
            $data['contacts'] = $this->objcon->getContactDetail();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-email-list-builder', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createList() {
        if ($this->p->emaillbi) {
            $post = $this->input->post();
            $this->objbuilder->createList($post);
            header('location:' . site_url() . 'admin/email_list_builder?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addContacts($gid) {
        if ($this->p->emaillbu) {
            $res = $this->objbuilder->getGroupContact($gid);
            $data['group'] = $res[0];
            $data['gcontacts'] = $res[1];
            if (count($res[0]) > 0) {
                $data['contacts'] = $this->objcon->getContactDetail();
                $this->load->view('admin/admin_header');
                $this->load->view('admin/admin_top');
                $this->load->view('admin/admin_navbar');
                $this->load->view('admin/add-email-list-builder', $data);
                $this->load->view('admin/admin_footer');
            } else {
                header('location:' . site_url() . 'admin/email_list_builder');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addGroups($gid) {
        if ($this->p->emaillbu) {
            $res = $this->objbuilder->getListSubGroup($gid);
            $data['group'] = $res[0];
            $data['subgroup'] = $res[1];
            if (count($res[0]) > 0) {
                $data['groups'] = $this->objgrp->getContactGroups("simple");
                $this->load->view('admin/admin_header');
                $this->load->view('admin/admin_top');
                $this->load->view('admin/admin_navbar');
                $this->load->view('admin/add-email-list-builder', $data);
                $this->load->view('admin/admin_footer');
            } else {
                header('location:' . site_url() . 'admin/email_list_builder');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateList() {
        if ($this->p->emaillbu) {
            $post = $this->input->post();
            $this->objbuilder->updateList($post);
            header('location:' . site_url() . 'admin/email_list_builder?msg=U');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->emaillbd) {
            $type = $this->input->post('actionType');
            if ($type == "Delete") {
                $this->objbuilder->setAction();
            }
            header('location:' . site_url() . 'admin/email_list_builder?msg=D');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function getGroupInfo() {
        $gid = $this->input->get('id');
        $res = $this->objbuilder->getGroupContact($gid);
        $gcontacts = $res[1];
        $gsubgroup = $this->objbuilder->getSubGroup($gid);
        $data['contacts'] = (count($gcontacts) > 0) ? $gcontacts : array();
        $data['groups'] = (count($gsubgroup) > 0) ? $gsubgroup : array();
//        echo '<pre>';
//        print_r($data);
//        die();
//        $this->load->view('admin/admin_header');
//        $this->load->view('admin/admin_top');
//        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/email-list-info', $data);
//        $this->load->view('admin/admin_footer');
    }

//    function delete($type) {
//        $post = $this->input->post();
//        $this->objbuilder->delete($type, $post);
//        $msg = ($type == "contacts") ? "DC" : "DG";
//        header('location:' . site_url() . 'admin/email_list_builder/getGroupInfo?msg=' . $msg . '&id=' . $post['groupid']);
//    }
}
