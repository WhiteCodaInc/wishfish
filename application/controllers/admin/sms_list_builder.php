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
class Sms_list_builder extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");
        
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->sms) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_list_builder', 'objbuilder');
            $this->load->model('admin/m_contacts', 'objcontact');
            $this->load->model('admin/m_contact_groups', 'objgroup');
        }
    }

    function index() {
        $data['groups'] = $this->objbuilder->getGroups("sms");
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/sms-list-builder', $data);
        $this->load->view('admin/admin_footer');
    }

    function addList() {
        $data['contacts'] = $this->objcontact->getContactDetail();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-sms-list-builder', $data);
        $this->load->view('admin/admin_footer');
    }

    function createList() {
        $post = $this->input->post();
        $this->objbuilder->createList($post);
        header('location:' . site_url() . 'admin/sms_list_builder?msg=I');
    }

    function addContacts($gid) {
        $res = $this->objbuilder->getGroupContact($gid);
        $data['group'] = $res[0];
        $data['gcontacts'] = $res[1];
        if (count($res[0]) > 0) {
            $data['contacts'] = $this->objcontact->getContactDetail();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-sms-list-builder', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/sms_list_builder');
        }
    }

    function addGroups($gid) {
        $res = $this->objbuilder->getListSubGroup($gid);
        $data['group'] = $res[0];
        $data['subgroup'] = $res[1];
        if (count($res[0]) > 0) {
            $data['groups'] = $this->objgroup->getContactGroups("simple");
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-sms-list-builder', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/sms_list_builder');
        }
    }

    function updateList() {
        $post = $this->input->post();
        $this->objbuilder->updateList($post);
        header('location:' . site_url() . 'admin/sms_list_builder?msg=U');
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objbuilder->setAction();
        }
        header('location:' . site_url() . 'admin/sms_list_builder?msg=D');
    }

}
