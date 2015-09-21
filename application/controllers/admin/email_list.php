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

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->funi && !$this->p->funu && !$this->p->funv) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_email_list', 'objlist');
        }
    }

    function index() {
        if ($this->p->funi || $this->p->funu || $this->p->funv) {
            $data['lists'] = $this->objlist->getEmailLists();
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/email-list', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function addEmailList() {
        if ($this->p->funi) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-email-list');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createEmailList() {
        if ($this->p->funi) {
            $post = $this->input->post();
            $this->objlist->createEmailList($post);
            header('location:' . site_url() . 'admin/email_list?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editEmailList($listid) {
        if ($this->p->funu) {
            $data['lists'] = $this->objlist->getEmailList($listid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-email-list', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateEmailList() {
        if ($this->p->funu) {
            $post = $this->input->post();
            $this->objlist->updateEmailList($post);
            header('location:' . site_url() . 'admin/email_list?msg=U');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function view($listid) {
        if ($this->p->funv) {
            $data['listInfo'] = $this->objlist->getEmailList($listid);
            $data['contacts'] = $this->objlist->getListContacts($listid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/email-list-contacts', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->fund) {
            $post = $this->input->post();
            if ($post['actionType'] == "Delete") {
                $this->objlist->setAction($post);
                header('location:' . site_url() . 'admin/email_list/view/' . $post['listid'] . '?msg=D');
            } else {
                header('location:' . site_url() . 'admin/email_list');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
