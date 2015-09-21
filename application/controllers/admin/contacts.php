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
class Contacts extends CI_Controller {

    private $p;

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->coni && !$this->p->conu && !$this->p->cond && !$this->p->cbl) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->library('parser');
            $this->load->model('admin/m_admin_contacts', 'objcon');
            $this->load->model('admin/m_admin_contact_groups', 'objgrp');
            $this->load->model('admin/m_sms', 'objsms');
            $this->load->model('admin/m_admin_sms_template', 'objsmstmplt');
            $this->load->model('admin/m_admin_email_template', 'objemailtmplt');
        }
    }

    function index() {
        if ($this->p->coni || $this->p->conu || $this->p->cond) {
            $data['contacts'] = $this->objcon->getContactDetail();
            $data['groups'] = $this->objgrp->getContactGroups("simple");
            $data['zodiac'] = $this->common->getZodiacs();
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/contact-detail', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function search() {
        $data['searchResult'] = $this->objcon->searchResult();
        $data['groups'] = $this->objgrp->getContactGroups("simple");
        $data['zodiac'] = $this->common->getZodiacs();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/contact-detail', $data);
        $this->load->view('admin/admin_footer');
    }

    function profile($cid) {
        $res = $this->objcon->getContact($cid, 'simple');
        $data['contact'] = $res[0];
        $data['cgroup'] = $res[1];
        $data['groups'] = $this->objgrp->getContactGroups("simple");
        $data['sms_template'] = $this->objsmstmplt->getTemplates();
        $data['email_template'] = $this->objemailtmplt->getTemplates();
        $data['p'] = $this->p;
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/contact-profile-view', $data);
        $this->load->view('admin/admin_footer');
    }

    function addContact() {
        if ($this->p->coni) {
            $data['groups'] = $this->objgrp->getContactGroups("simple");
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-contact', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createContact() {
        if ($this->p->coni) {
            $post = $this->input->post();
            $this->objcon->createContact($post);
            header('location:' . site_url() . 'admin/contacts?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editContact($cid) {
        if ($this->p->conu) {
            $res = $this->objcon->getContact($cid, 'simple');
            $data['contacts'] = $res[0];
            $data['cgroup'] = $res[1];
            $data['groups'] = $this->objgrp->getContactGroups("simple");
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/edit-contact', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateContact() {
        if ($this->p->conu) {
            $post = $this->input->post();
            $msg = $this->objcon->updateContact($post);
            header('location:' . site_url() . 'admin/contacts?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->conu || $this->p->cond) {
            $post = $this->input->post();
            $type = $post['actionType'];
            if ($type == "Delete" || $type == "Add" || $type == "Remove") {
                $msg = $this->objcon->setAction($post);
            } else {
                $msg = "F";
            }
            header('location:' . site_url() . 'admin/contacts?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function getZodiac($dt) {
        $zodiac = $this->common->getZodiac($dt);
        echo $zodiac;
    }

    //----------------Contact Profile Functionality--------------------------//

    function send_message() {
        $post = $this->input->post();
        $contact = $this->objcon->getContactInfo($post['cid']);
        if ($contact->phone != NULL) {
            $tag = $this->common->setToken($contact);
            $body = $this->parser->parse_string($post['body'], $tag, TRUE);

            $sid = $this->sendSMS($contact->phone, $body);
            if ($sid) {
                if ($this->objcon->isExist($contact->phone)) {
                    $this->objsms->updateInbox($contact->phone, $body);
                } else if ($sid != "") {
                    $this->objcon->addMsgInbox($contact, $body, $sid);
                }
                header('location:' . site_url() . 'admin/contacts/profile/' . $post['cid'] . '?msg=T');
            } else {
                header('location:' . site_url() . 'admin/contacts/profile/' . $post['cid'] . '?msg=F');
            }
        } else {
            header('location:' . site_url() . 'admin/contacts/profile/' . $post['cid'] . '?msg=F');
        }
    }

    function send_email() {
        $post = $this->input->post();
        $contact = $this->objcon->getContactInfo($post['cid']);
        $tag = $this->common->setToken($contact);
        $this->sendMail($contact, $tag, $post);
        header('location:' . site_url() . 'admin/contacts/profile/' . $post['cid']);
    }

    function sendSMS($to, $body) {
        return $this->common->sendSMS($to, $body);
    }

    function sendMail($contact, $tag, $post) {
        $subject = $this->parser->parse_string($post['subject'], $tag, TRUE);
        $body = $this->parser->parse_string($post['body'], $tag, TRUE);
        return $this->common->sendMail($contact->email, $subject, $body, NULL, "mikhail@wish-fish.com");
    }

    //---------------Block Contacts------------------------------------------//
    function block_list() {
        $res = $this->objcon->getBlockContacts();
        $data['contacts'] = $this->objcon->getContactDetail();
        if ($res) {
            $data['group'] = $res[0];
            $data['gcontacts'] = $res[1];
        }
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/block-contact-group', $data);
        $this->load->view('admin/admin_footer');
    }

    function createList() {
        if ($this->p->cbl) {
            $post = $this->input->post();
            $this->objcon->createList($post);
            header('location:' . site_url() . 'admin/contacts/block_list?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateList() {
        if ($this->p->cbl) {
            $post = $this->input->post();
            $this->objcon->updateList($post);
            header('location:' . site_url() . 'admin/contacts/block_list?msg=U');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

}
