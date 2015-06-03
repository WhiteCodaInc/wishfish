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
class Admin_profile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->output->set_header('cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header("cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        $this->load->library("authex");
        $this->load->library("common");
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->admin) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->library('parser');
            $this->load->model('admin/m_admin_profile', 'objprofile');
            $this->load->model('admin/m_admin_access', 'objclass');
            $this->load->model('admin/m_admin_sms_template', 'objsmstmplt');
            $this->load->model('admin/m_admin_email_template', 'objemailtmplt');
            $this->load->model('admin/m_cpanel', 'objcpanel');
        }
    }

    function index() {
        $data['class'] = $this->objclass->getAdminAccessClass();
        $data['profile'] = $this->objprofile->getProfiles();
        $data['zodiac'] = $this->common->getZodiacs();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/admin-profile', $data);
        $this->load->view('admin/admin_footer');
    }

    function search() {
        $data['searchResult'] = $this->objprofile->searchResult();
        $data['zodiac'] = $this->common->getZodiacs();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/admin-profile', $data);
        $this->load->view('admin/admin_footer');
    }

    function profile($pid) {
        $data['profile'] = $this->objprofile->getProfile($pid);
        $data['sms_template'] = $this->objsmstmplt->getTemplates();
        $data['email_template'] = $this->objemailtmplt->getTemplates();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/admin-profile-view', $data);
        $this->load->view('admin/admin_footer');
    }

    function addProfile() {
        $data['class'] = $this->objclass->getAdminAccessClass();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-profile', $data);
        $this->load->view('admin/admin_footer');
    }

    function createProfile() {
        $post = $this->input->post();
        $this->objprofile->createProfile($post);
        header('location:' . site_url() . 'admin/admin_profile?msg=I');
    }

    function editProfile($pid) {
        $data['class'] = $this->objclass->getAdminAccessClass();
        $data['profile'] = $this->objprofile->getProfile($pid);
        $data['accounts'] = $this->objcpanel->getAccounts();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/edit-profile', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateProfile() {
        $post = $this->input->post();
        $msg = $this->objprofile->updateProfile($post);
        header('location:' . site_url() . 'admin/admin_profile?msg=' . $msg);
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objprofile->setAction();
        }
        header('location:' . site_url() . 'admin/admin_profile?msg=D');
    }

    //----------------Admin Profile Functionality--------------------------//

    function send_message() {
        $post = $this->input->post();
        $profile = $this->objprofile->getProfile($post['pid']);
        if ($profile->phone) {
            $tag = $this->common->setToken($profile);
            $body = $this->parser->parse_string($post['body'], $tag, TRUE);
            $this->sendSMS($profile->phone, $body);
        }

        header('location:' . site_url() . 'admin/admin_profile/profile/' . $post['pid']);
    }

    function send_email() {
        $post = $this->input->post();
        $profile = $this->objprofile->getProfile($post['pid']);
        if ($profile->email) {
            $tag = $this->common->setToken($profile);
            $this->sendMail($profile, $tag, $post);
        }
        header('location:' . site_url() . 'admin/admin_profile/profile/' . $post['pid']);
    }

    function sendSMS($to, $body) {
        return $this->common->sendSMS($to, $body);
    }

    function sendMail($profile, $tag, $post) {
        $subject = $this->parser->parse_string($post['subject'], $tag, TRUE);
        $body = $this->parser->parse_string($post['body'], $tag, TRUE);
        return $this->common->sendMail($profile->email, $subject, $body);
    }

}
