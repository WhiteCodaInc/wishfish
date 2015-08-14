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

    function __construct() {
        parent::__construct();

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
            //} else if (!$this->common->getPermission()->cms) {
            //    header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_media', 'objmedia');
        }
    }

    function index() {
        $data['media'] = $this->objmedia->getMediaDetail();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/media', $data);
        $this->load->view('admin/admin_footer');
    }

    function addMedia() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-media');
        $this->load->view('admin/admin_footer');
    }

    function createMedia() {
        $post = $this->input->post();
        $msg = $this->objmedia->createMedia($post);
        header('location:' . site_url() . 'admin/media?msg=' . $msg);
    }

    function editMedia($mid) {
        $data['media'] = $this->objmedia->getMedia($mid);
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-media', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateMedia() {
        $post = $this->input->post();
        $msg = $this->objmedia->updateMedia($post);
        header('location:' . site_url() . 'admin/media?msg=' . $msg);
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $msg = $this->objmedia->setAction($type);
            if ($msg) {
                header('location:' . site_url() . 'admin/media?msg=' . $msg);
            } else {
                header('location:' . site_url() . 'admin/media');
            }
        }
    }

    function getMedia() {
        $mid = $this->input->post('mediaid');
        $data['media'] = $this->objmedia->getMedia($mid);
        $this->load->view('admin/media-preview', $data);
    }

    //--------------------------Upload Video----------------------------------//
    function video() {
        $data['video'] = $this->objmedia->getVideos();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/video', $data);
        $this->load->view('admin/admin_footer');
    }

    function upload_video() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/upload-video');
        $this->load->view('admin/admin_footer');
    }

    function upload() {
        $post = $this->input->post();
        $this->objmedia->upload($post);
        header('location:' . site_url() . 'admin/media/video?msg=I');
    }

    function deleteVideo() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objmedia->deleteVideo();
        }
        header('location:' . site_url() . 'admin/media/video?msg=D');
    }

}
