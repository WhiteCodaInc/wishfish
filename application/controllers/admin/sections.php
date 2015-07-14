<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author Laxmisoft
 */
class Sections extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else {
            $this->load->model('admin/m_sections', 'objsection');
        }
    }

    function index() {
        $data['sections'] = $this->objsection->getSections();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/sections', $data);
        $this->load->view('admin/admin_footer');
    }

    function getContent() {
        $sectionid = $this->input->post('sectionid');
        $this->objsection->getContent($sectionid);
    }

    function update() {
        $post = $this->input->post();
        $this->objsection->update($post);
    }

}
