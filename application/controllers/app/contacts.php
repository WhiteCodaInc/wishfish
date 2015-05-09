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

    function __construct() {
        parent::__construct();

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'home');
        } elseif (!$this->authex->isActivePlan()) {
            header('location:' . site_url() . 'app/upgrade');
        } else {
            $this->load->library('parser');
            $this->load->model('dashboard/m_contacts', 'objcontact');
            $this->load->model('dashboard/m_contact_groups', 'objgroup');
//            $this->load->model('m_sms_template', 'objsmstemplate');
//            $this->load->model('m_email_template', 'objemailtemplate');
        }
    }

    function index() {
        $data['contacts'] = $this->objcontact->getContactDetail();
        $data['groups'] = $this->objgroup->getContactGroups("simple");
        $data['zodiac'] = $this->common->getZodiacs();
        if (!$this->objcontact->checkTotalContact()) {
            $data['limit'] = 0;
        }
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');

        $this->load->view('dashboard/contact-detail', $data);
        $this->load->view('dashboard/footer');
    }

    function search() {
        $data['searchResult'] = $this->objcontact->searchResult();
        $data['groups'] = $this->objgroup->getContactGroups("simple");
        $data['zodiac'] = $this->common->getZodiacs();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');

        $this->load->view('dashboard/contact-detail', $data);
        $this->load->view('dashboard/footer');
    }

    function profile($cid) {
        $res = $this->objcontact->getContact($cid, 'simple');
        if ($res) {
            $data['contact'] = $res[0];
            $data['cgroup'] = $res[1];
            $data['groups'] = $this->objgroup->getContactGroups("simple");
//        $data['sms_template'] = $this->objsmstemplate->getTemplates();
//        $data['email_template'] = $this->objemailtemplate->getTemplates();
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/top');

            $this->load->view('dashboard/contact-profile-view', $data);
            $this->load->view('dashboard/footer');
        } else {
            header('location:' . site_url() . 'app/contacts?msg=NE');
        }
    }

    function addContact() {
        if ($this->objcontact->checkTotalContact()) {
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/top');
            $this->load->view('dashboard/add-contact');
            $this->load->view('dashboard/footer');
        } else {
            header('location:' . site_url() . 'app/contacts');
        }
    }

    function createContact() {
        $type = $this->input->get('type');
        $post = $this->input->post();
        $this->objcontact->createContact($post);
        if ($type != "" && $type == "ajax") {
            $post['birthday'] = ($post['birthday'] != "") ?
                    $this->common->getMySqlDate($post['birthday'], $this->session->userdata('date_format')) :
                    NULL;
            $dt = $this->objcontact->getFutureDate($post['birthday']);
            header('location:' . site_url() . 'app/calender?date=' . $dt);
        } else {
            header('location:' . site_url() . 'app/contacts?msg=I');
        }
    }

    function editContact($cid) {
        $res = $this->objcontact->getContact($cid, 'simple');
        if ($res) {
            $data['contacts'] = $res[0];
            $data['cgroup'] = $res[1];
            $data['groups'] = $this->objgroup->getContactGroups("simple");
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/top');

            $this->load->view('dashboard/edit-contact', $data);
            $this->load->view('dashboard/footer');
        } else {
            header('location:' . site_url() . 'app/contacts?msg=NE');
        }
    }

    function updateContact() {
        $post = $this->input->post();
        $msg = $this->objcontact->updateContact($post);
        header('location:' . site_url() . 'app/contacts?msg=' . $msg);
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objcontact->setAction();
        }
        header('location:' . site_url() . 'app/contacts?msg=D');
    }

    function getZodiac($dt) {
        $zodiac = $this->common->getZodiac($dt);
        echo $zodiac;
    }

    //----------------Contact Profile Functionality--------------------------//

    function send_message() {
        $post = $this->input->post();
        $contact = $this->objcontact->getContactInfo($post['cid']);
        $tag = $this->common->setToken($contact);
        $body = $this->parser->parse_string($post['body'], $tag, TRUE);
        $this->sendSMS($contact->phone, $body);
        header('location:' . site_url() . 'app/contacts/profile/' . $post['cid']);
    }

    function send_email() {
        $post = $this->input->post();
        $contact = $this->objcontact->getContactInfo($post['cid']);
        $tag = $this->common->setToken($contact);
        $this->sendMail($contact, $tag, $post);
        header('location:' . site_url() . 'app/contacts/profile/' . $post['cid']);
    }

    function sendSMS($to, $body) {
        return $this->common->sendSMS($to, $body);
    }

    function sendMail($contact, $tag, $post) {
        $subject = $this->parser->parse_string($post['subject'], $tag, TRUE);
        $body = $this->parser->parse_string($post['body'], $tag, TRUE);
        return $this->common->sendMail($contact->email, $subject, $body);
    }

    //---------------Block Contacts------------------------------------------//
    function block_list() {
        $res = $this->objcontact->getBlockContacts();
        $data['contacts'] = $this->objcontact->getContactDetail();
        if ($res) {
            $data['group'] = $res[0];
            $data['gcontacts'] = $res[1];
        }
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');

        $this->load->view('dashboard/block-contact-group', $data);
        $this->load->view('dashboard/footer');
    }

    function createList() {
        $post = $this->input->post();
        $this->objcontact->createList($post);
        header('location:' . site_url() . 'app/contacts/block_list?msg=I');
    }

    function updateList() {
        $post = $this->input->post();
        $this->objcontact->updateList($post);
        header('location:' . site_url() . 'app/contacts/block_list?msg=U');
    }

}
