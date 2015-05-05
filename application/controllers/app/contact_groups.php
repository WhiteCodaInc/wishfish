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
class Contact_groups extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'home');
        } else {
            $this->load->model('dashboard/m_contact_groups', 'objgroup');
        }
    }

    function index() {
        $data['groups'] = $this->objgroup->getContactGroups("simple");
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        
        $this->load->view('dashboard/contact-group', $data);
        $this->load->view('dashboard/footer');
    }

    function addContactGroup() {
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        
        $this->load->view('dashboard/add-contact-group');
        $this->load->view('dashboard/footer');
    }

    function createContactGroup() {
        $post = $this->input->post();
        $this->objgroup->createContactGroup($post);
        header('location:' . site_url() . 'app/contact_groups?msg=I');
    }

    function editContactGroup($gid) {
        $data['groups'] = $this->objgroup->getContactGroup($gid);
        if ($data['groups']) {
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/top');
            
            $this->load->view('dashboard/add-contact-group', $data);
            $this->load->view('dashboard/footer');
        } else {
            header('location:' . site_url() . 'app/contact_groups?msg=NE');
        }
    }

    function updateContactGroup() {
        $post = $this->input->post();
        $this->objgroup->updateContactGroup($post);
        header('location:' . site_url() . 'app/contact_groups?msg=U');
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objgroup->setAction();
        }
        header('location:' . site_url() . 'app/contact_groups?msg=D');
    }

}
