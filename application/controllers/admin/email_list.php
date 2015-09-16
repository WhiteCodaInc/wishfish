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
class Email_list extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
//        } else if (!$this->common->getPermission()->customers) {
//            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_email_list', 'objlist');
        }
    }

    function index() {
        $data['lists'] = $this->objlist->getEmailLists();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/email-list', $data);
        $this->load->view('admin/admin_footer');
    }

    function addEmailList() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-email-list');
        $this->load->view('admin/admin_footer');
    }

    function createEmailList() {
        $post = $this->input->post();
        $this->objlist->createEmailList($post);
        header('location:' . site_url() . 'admin/email_list?msg=I');
    }

    function editEmailList($listid) {
        $data['lists'] = $this->objlist->getEmailList($listid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-email-list', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateEmailList() {
        $post = $this->input->post();
        $this->objlist->updateEmailList($post);
        header('location:' . site_url() . 'admin/email_list?msg=U');
    }

    function view($listid) {
        $data['listInfo'] = $this->objlist->getEmailList($listid);
        $data['contacts'] = $this->objlist->getListContacts($listid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/email-list-contacts', $data);
        $this->load->view('admin/admin_footer');
    }

    function action() {
        $post = $this->input->post();
        if ($post['actionType'] == "Delete") {
            $this->objlist->setAction($post);
            header('location:' . site_url() . 'admin/email_list/view/' . $post['listid'] . '?msg=D');
        } else {
            header('location:' . site_url() . 'admin/email_list');
        }
    }

}
