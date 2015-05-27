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
        $this->load->library("authex");
        $this->load->library("common");

        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->contacts) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->library('parser');
            $this->load->model('admin/m_contacts', 'objcontact');
            $this->load->model('admin/m_contact_groups', 'objgroup');
            $this->load->model('admin/m_sms', 'objsms');
            $this->load->model('admin/m_sms_template', 'objsmstemplate');
            $this->load->model('admin/m_email_template', 'objemailtemplate');
        }
    }

    function index() {
        $data['contacts'] = $this->objcontact->getContactDetail();
        $data['groups'] = $this->objgroup->getContactGroups("simple");
        $data['zodiac'] = $this->common->getZodiacs();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/contact-detail', $data);
        $this->load->view('admin/admin_footer');
    }

    function search() {
        $data['searchResult'] = $this->objcontact->searchResult();
        $data['groups'] = $this->objgroup->getContactGroups("simple");
        $data['zodiac'] = $this->common->getZodiacs();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/contact-detail', $data);
        $this->load->view('admin/admin_footer');
    }

    function profile($cid) {
        $res = $this->objcontact->getContact($cid, 'simple');
        $data['contact'] = $res[0];
        $data['cgroup'] = $res[1];

        $data['groups'] = $this->objgroup->getContactGroups("simple");
        $data['sms_template'] = $this->objsmstemplate->getTemplates();
        $data['email_template'] = $this->objemailtemplate->getTemplates();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/contact-profile-view', $data);
        $this->load->view('admin/admin_footer');
    }

    function addContact() {
        $data['groups'] = $this->objgroup->getContactGroups("simple");
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-contact', $data);
        $this->load->view('admin/admin_footer');
    }

    function createContact() {
        $post = $this->input->post();
        $this->objcontact->createContact($post);
        header('location:' . site_url() . 'admin/contacts?msg=I');
    }

    function editContact($cid) {
        $res = $this->objcontact->getContact($cid, 'simple');
        $data['contacts'] = $res[0];
        $data['cgroup'] = $res[1];
        $data['groups'] = $this->objgroup->getContactGroups("simple");
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/edit-contact', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateContact() {
        $post = $this->input->post();
        $msg = $this->objcontact->updateContact($post);
        header('location:' . site_url() . 'admin/contacts?msg=' . $msg);
    }

    function action() {
        $post = $this->input->post();
        $type = $post['actionType'];
        if ($type == "Delete" || $type == "Add" || $type == "Remove") {
            $msg = $this->objcontact->setAction($post);
        } else {
            $msg = "F";
        }
        header('location:' . site_url() . 'admin/contacts?msg=' . $msg);
    }

    function getZodiac($dt) {
        $zodiac = $this->common->getZodiac($dt);
        echo $zodiac;
    }

    //----------------Contact Profile Functionality--------------------------//

    function send_message() {
        $post = $this->input->post();
        $contact = $this->objcontact->getContactInfo($post['cid']);
        if ($contact->phone != NULL) {
            $tag = $this->common->setToken($contact);
            $body = $this->parser->parse_string($post['body'], $tag, TRUE);

            $sid = $this->sendSMS($contact->phone, $body);
            if ($sid) {
                if ($this->objcontact->isExist($contact->phone)) {
                    $this->objsms->updateInbox($contact->phone, $body);
                } else if ($sid != "") {
                    $this->objcontact->addMsgInbox($contact, $body, $sid);
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
        $contact = $this->objcontact->getContactInfo($post['cid']);
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
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/block-contact-group', $data);
        $this->load->view('admin/admin_footer');
    }

    function createList() {
        $post = $this->input->post();
        $this->objcontact->createList($post);
        header('location:' . site_url() . 'admin/contacts/block_list?msg=I');
    }

    function updateList() {
        $post = $this->input->post();
        $this->objcontact->updateList($post);
        header('location:' . site_url() . 'admin/contacts/block_list?msg=U');
    }

}
