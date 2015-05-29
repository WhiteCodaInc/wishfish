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
class Pages extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else {
            $this->load->model('admin/m_pages', 'objpage');
        }
    }

    function index() {
        $data['pages'] = $this->objpage->getPages();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/pages', $data);
        $this->load->view('admin/admin_footer');
    }

    function getContent() {
        $pageid = $this->input->post('pageid');
        echo $this->objpage->getContent($pageid);
    }

    function getTerm() {
        $data['page'] = $this->objpage->getTerm();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/page-term-service', $data);
        $this->load->view('admin/admin_footer');
    }

    function update() {
        $post = $this->input->post();
        $this->objpage->update($post);
    }

    function updateTerm() {
        $post = $this->input->post();
        $this->objpage->updateTerm($post);
        header('location:' . site_url() . 'admin/pages/getTerm');
    }

}
