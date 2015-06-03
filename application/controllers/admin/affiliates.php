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
class Affiliates extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("authex");
        $this->load->library("common");
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->affiliates) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->library('parser');
            $this->load->model('admin/m_affiliates', 'objaffiliate');
            $this->load->model('admin/m_affiliate_groups', 'objgroup');
            $this->load->model('admin/m_admin_sms_template', 'objsmstmplt');
            $this->load->model('admin/m_admin_email_template', 'objemailtmplt');
        }
    }

    function index() {
        $data['affiliates'] = $this->objaffiliate->getAffiliateDetail();
        $data['groups'] = $this->objgroup->getAffiliateGroups();
        $data['zodiac'] = $this->common->getZodiacs();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/affiliate-detail', $data);
        $this->load->view('admin/admin_footer');
    }

    function search() {
        $data['searchResult'] = $this->objaffiliate->searchResult();
        $data['groups'] = $this->objgroup->getAffiliateGroups();
        $data['zodiac'] = $this->common->getZodiacs();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/affiliate-detail', $data);
        $this->load->view('admin/admin_footer');
    }

    function profile($cid) {
        $res = $this->objaffiliate->getAffiliate($cid);
        $data['affiliate'] = $res[0];
        $data['agroup'] = $res[1];

        $data['groups'] = $this->objgroup->getAffiliateGroups();
        $data['sms_template'] = $this->objsmstmplt->getTemplates();
        $data['email_template'] = $this->objemailtmplt->getTemplates();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/affiliate-profile-view', $data);
        $this->load->view('admin/admin_footer');
    }

    function addAffiliate() {
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/add-affiliate');
        $this->load->view('admin/admin_footer');
    }

    function createAffiliate() {
        $post = $this->input->post();
        $this->objaffiliate->createAffiliate($post);
        header('location:' . site_url() . 'admin/affiliates?msg=I');
    }

    function editAffiliate($aid) {
        $res = $this->objaffiliate->getAffiliate($aid);
        $data['affiliates'] = $res[0];
        $data['agroup'] = $res[1];
        $data['groups'] = $this->objgroup->getAffiliateGroups();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/edit-affiliate', $data);
        $this->load->view('admin/admin_footer');
    }

    function updateAffiliate() {
        $post = $this->input->post();
        $msg = $this->objaffiliate->updateAffiliate($post);
        header('location:' . site_url() . 'admin/affiliates?msg=' . $msg);
    }

    function action() {
        $type = $this->input->post('actionType');
        if ($type == "Delete") {
            $this->objaffiliate->setAction();
        }
        header('location:' . site_url() . 'admin/affiliates?msg=D');
    }

    function getZodiac($dt) {
        $zodiac = $this->common->getZodiac($dt);
        echo $zodiac;
    }

    //----------------Affiliate Profile Functionality--------------------------//

    function send_message() {
        $post = $this->input->post();
        $affiliate = $this->objaffiliate->getAffiliateInfo($post['aid']);
        $tag = $this->common->setToken($affiliate);
        $body = $this->parser->parse_string($post['body'], $tag, TRUE);
        $this->sendSMS($affiliate->phone, $body);
        header('location:' . site_url() . 'admin/affiliates/profile/' . $post['aid']);
    }

    function send_email() {
        $post = $this->input->post();
        $affiliate = $this->objaffiliate->getAffiliateInfo($post['aid']);
        $tag = $this->common->setToken($affiliate);
        $this->sendMail($affiliate, $tag, $post);
        header('location:' . site_url() . 'admin/affiliates/profile/' . $post['aid']);
    }

    function sendSMS($to, $body) {
        return $this->common->sendSMS($to, $body);
    }

    function sendMail($affiliate, $tag, $post) {
        $subject = $this->parser->parse_string($post['subject'], $tag, TRUE);
        $body = $this->parser->parse_string($post['body'], $tag, TRUE);
        return $this->common->sendMail($affiliate->email, $subject, $body);
    }

}
