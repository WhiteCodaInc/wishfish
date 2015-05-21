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
class Comment extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->cms) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_comment', 'objcomment');
            $this->load->model('admin/m_cms', 'objcms');
        }
    }

    function index() {
        $data['blogs'] = $this->objcms->getBlogDetail();
        $data['comments'] = $this->objcomment->getCommentDetail();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/comments', $data);
        $this->load->view('admin/admin_footer');
    }

    function search() {
        $data['searchResult'] = $this->objcomment->searchResult();
        $data['blogs'] = $this->objcms->getBlogDetail();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/comments', $data);
        $this->load->view('admin/admin_footer');
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete" || $type == "Approve" || $type == "Disapprove") {
            $msg = $this->objcomment->setAction($type);
        }
        header('location:' . site_url() . 'admin/comment?msg=' . $msg);
    }

}
