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
class Automail extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_automail', 'obautomail');
    }

    function index() {
        $data['automail'] = $this->obautomail->getAutomails();
        $this->load->view('dashboard/header');
        $this->load->view('email-templates', $data);
        $this->load->view('dashboard/footer');
    }

//    function add() {
//        $this->load->view('dashboard/header');
//        $this->load->view('add-email-template');
//        $this->load->view('dashboard/footer');
//    }
//    function create() {
//        $post = $this->input->post();
//        $this->obautomail->create($post);
//        header('location:' . site_url() . 'automail?msg=I');
//    }

    function edit($aid) {
        $data['template'] = $this->obautomail->getAutomail($aid);
        $this->load->view('dashboard/header');
        $this->load->view('edit-email-template', $data);
        $this->load->view('dashboard/footer');
    }

    function update() {
        $post = $this->input->post();
        $this->obautomail->update($post);
        header('location:' . site_url() . 'automail?msg=U');
    }

//    function action() {
//        $type = $this->input->post('actionType');
//        if ($type == "Delete") {
//            $msg = $this->obautomail->setAction();
//            if ($msg) {
//                header('location:' . site_url() . 'automail?msg=D');
//            } else {
//                header('location:' . site_url() . 'automail');
//            }
//        }
//    }
}
