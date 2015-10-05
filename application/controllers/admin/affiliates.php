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

    private $p;

    function __construct() {
        parent::__construct();
        $this->p = $this->common->getPermission();
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->p->affi && !$this->p->affu && !$this->p->affd) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->library('parser');
            $this->load->model('admin/m_affiliates', 'objaffiliate');
            $this->load->model('admin/m_payout', 'objpayout');
            $this->load->model('admin/m_affiliate_groups', 'objgroup');
            $this->load->model('admin/m_affiliate_offers', 'objoffer');
            $this->load->model('admin/m_admin_sms_template', 'objsmstmplt');
            $this->load->model('admin/m_admin_email_template', 'objemailtmplt');
        }
    }

    function index() {
        if ($this->p->affi || $this->p->affu || $this->p->affd) {
            $data['affiliates'] = $this->objaffiliate->getAffiliateDetail();
            $data['groups'] = $this->objgroup->getAffiliateGroups();
            $data['zodiac'] = $this->common->getZodiacs();
            $data['p'] = $this->p;
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/affiliate-detail', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function search() {
        $data['searchResult'] = $this->objaffiliate->searchResult();
        $data['groups'] = $this->objgroup->getAffiliateGroups();
        $data['zodiac'] = $this->common->getZodiacs();
        $data['p'] = $this->p;
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
        $data['aoffer'] = $res[2];

        $data['groups'] = $this->objgroup->getAffiliateGroups();
        $data['offers'] = $this->objoffer->getOffers();
        $data['sms_template'] = $this->objsmstmplt->getTemplates();
        $data['email_template'] = $this->objemailtmplt->getTemplates();
        $data['p'] = $this->p;
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/affiliate-profile-view', $data);
        $this->load->view('admin/admin_footer');
    }

    function addAffiliate() {
        if ($this->p->affi) {
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/add-affiliate');
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function createAffiliate() {
        if ($this->p->affi) {
            $post = $this->input->post();
            $this->objaffiliate->createAffiliate($post);
            header('location:' . site_url() . 'admin/affiliates?msg=I');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editAffiliate($aid) {
        if ($this->p->affu) {
            $res = $this->objaffiliate->getAffiliate($aid);
            $data['affiliates'] = $res[0];
            $data['agroup'] = $res[1];
            $data['groups'] = $this->objgroup->getAffiliateGroups();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/edit-affiliate', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateAffiliate() {
        if ($this->p->affu) {
            $post = $this->input->post();
            $msg = $this->objaffiliate->updateAffiliate($post);
            header('location:' . site_url() . 'admin/affiliates?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function editSetting($aid) {
        if ($this->p->affs) {
            $data['affInfo'] = $this->common->getAffInfo($aid);
            $data['payout'] = $this->objpayout->getPayoutSetting();
            $this->load->view('admin/admin_header');
            $this->load->view('admin/admin_top');
            $this->load->view('admin/admin_navbar');
            $this->load->view('admin/edit-payout-setting', $data);
            $this->load->view('admin/admin_footer');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function updateSetting() {
        if ($this->p->affs) {
            $post = $this->input->post();
            $this->objaffiliate->updateSetting($post);
            header('location:' . site_url() . 'admin/affiliates?msg=US');
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function action() {
        if ($this->p->affu || $this->p->affd) {
            $post = $this->input->post();
            $type = $post['actionType'];
            $action = array("Delete", "Active", "Deactive", "Add", "Remove");
            if (in_array($type, $action)) {
                $msg = $this->objaffiliate->setAction($post);
            } else {
                $msg = "F";
            }
            header('location:' . site_url() . 'admin/affiliates?msg=' . $msg);
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
    }

    function loginAsUser($aid) {
        if ($this->p->affu) {
            $affilaite = $this->common->getAffInfo($aid);
            if ($affilaite->status) {
                $aid = $this->encryption->encode($affilaite->affiliate_id);
                $url = 'https://wish-fish.com/affiliate/dashboard?d=direct&aid=' . $aid;
                header('location:' . $url);
            } else {
                echo '<script>alert("Affilaite account currently was deactivated..!");close();</script>';
            }
        } else {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        }
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
        return $this->common->sendMail($affiliate->email, $subject, $body, NULL, "mikhail@wish-fish.com");
    }

}
