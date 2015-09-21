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
class Media extends CI_Controller {

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->medi && !$this->p->medu && !$this->p->medd) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_media', 'objmedia');
        }
    }

    function index() {
        if ($this->p->medi || $this->p->medu || $this->p->medd) {
            $data['media'] = $this->objmedia->getMediaDetail();
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/media', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function search() {
        $data['media'] = $this->objmedia->searchResult();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/media', $data);
        $this->load->view('admin/admin_footer');
    }

    function addMedia() {
        if ($this->p->medi) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-media');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createMedia() {
        if ($this->p->medi) {
            $post = $this->input->post();
            if (is_array($post) && count($post)) {
                $this->objmedia->createMedia($post);
                echo 'File Upload Succesffully....!';
            } else {
                header('location:' . site_url() . 'admin/media');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editMedia($mid) {
        if ($this->p->medu) {
            $data['media'] = $this->objmedia->getMedia($mid);
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-media', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateMedia() {
        if ($this->p->medu) {
            $post = $this->input->post();
            if (is_array($post) && count($post)) {
                $this->objmedia->updateMedia($post);
                echo 'File Upload Succesffully....!';
            } else {
                header('location:' . site_url() . 'admin/media');
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->medd) {
            $type = $this->input->post('actionType');
            if ($type == "Delete") {
                $msg = $this->objmedia->setAction($type);
                if ($msg) {
                    header('location:' . site_url() . 'admin/media?msg=D');
                } else {
                    header('location:' . site_url() . 'admin/media');
                }
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function getMedia() {
        $mid = $this->input->post('mediaid');
        $data['media'] = $this->objmedia->getMedia($mid);
        $this->load->view('admin/media-preview', $data);
    }

}
