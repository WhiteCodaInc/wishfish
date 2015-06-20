<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin_access
 *
 * @author Laxmisoft
 */
class Calender extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();

        $code = $this->input->get('code');
        if ($code == "") {
            if (!$this->wi_authex->logged_in()) {
                header('location:' . site_url() . 'home');
            } elseif (!$this->wi_authex->isActivePlan()) {
                header('location:' . site_url() . 'app/upgrade');
            }
            echo '<pre>';
            print_r($this->session->all_userdata());
            die();
        } else {
            echo '<pre>';
            print_r($this->session->all_userdata());
            die();
        }

        $this->load->model('dashboard/m_contacts', 'objcontact');
        $this->load->model('dashboard/m_contact_groups', 'objgroup');
        $this->load->model('dashboard/m_sms_template', 'objsmstemplate');
        $this->load->model('dashboard/m_email_template', 'objemailtemplate');
        $this->load->model('dashboard/m_calender', 'objcal');
        $this->load->model('dashboard/m_profile', 'objprofile');
        $this->load->model('m_register', 'objregister');
    }

    function index() {
        if ($this->input->get('error') == "access_denied") {
            header('location:' . site_url() . 'app/calender');
        } else if ($this->input->get('code') != "") {
            $this->con();
            $this->client->authenticate($this->input->get('code'));
            $token = json_decode($this->client->getAccessToken());
            $this->session->set_userdata('token', $token->access_token);
        }
        $data['template'] = $this->objsmstemplate->getTemplates();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        $this->load->view('dashboard/calender', $data);
        $this->load->view('dashboard/footer');
    }

    function createEvent($contactid) {
        $t = $this->input->get('type');
        $res = $this->objcal->createEvent($contactid);
        if ($res) {
            $data['individual'] = $this->objcontact->getContactDetail();
            $data['template'] = $this->objsmstemplate->getTemplates();
            $data['contactInfo'] = $res;
        } else {
            $data['contactInfo'] = FALSE;
        }
        $data['flag'] = ($t == "bday") ? TRUE : FALSE;
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/top');
        $this->load->view('dashboard/calender', $data);
        $this->load->view('dashboard/footer');
    }

    function allGroup() {
        $currPlan = $this->wi_common->getCurrentPlan();
        $res = $this->objcal->checkTotalGroupEvent();
        if (!$res || $res->total < $currPlan->group_events) {
            $group = $this->objgroup->getContactGroups("simple");
            echo '<select  name="group_id" class="form-control">';
            foreach ($group as $value) {
                echo "<option value='$value->group_id'>$value->group_name</option>";
            }
            echo '</select>';
        } else {
            echo 0;
        }
    }

    function allContacts($type) {
        $ids = $user = array();
        $individual = $this->objcontact->getContactDetail();
        $currPlan = $this->wi_common->getCurrentPlan();
        foreach ($individual as $key => $value) {
            $res = $this->objcal->checkTotalEvent($value->contact_id);
            switch ($type) {
                case "email":
                    if (!isset($res['email']) || (isset($res['email']) && $res['email'] < $currPlan->email_events + 1)) {
                        $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $value->email;
                        $ids[$key] = $value->contact_id;
                    }
                    break;
                case "sms":
                    if (!isset($res['sms']) || (isset($res['sms']) && $res['sms'] < $currPlan->sms_events + 1)) {
                        $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $value->phone;
                        $ids[$key] = $value->contact_id;
                    }
                    break;
                default:
                    $adds = ($type == "email") ? $value->email : $value->phone;
                    $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $adds;
                    $ids[$key] = $value->contact_id;
                    break;
            }
        }
        $data['user'] = $user;
        $data['ids'] = $ids;
        echo json_encode($data);
    }

    function getTemplate($type, $tmpid) {
        if ($type == "sms" || $type == "notification") {
            $this->objcal->getSMSTemplate($tmpid);
        } else if ($type == "email") {
            $this->objcal->getEmailTemplate($tmpid);
        }
    }

    function getTemplates($type) {
        if ($type == "sms" || $type == "notification") {
            $templates = $this->objsmstemplate->getTemplates();
        } else if ($type == "email") {
            $templates = $this->objemailtemplate->getTemplates();
        } else {
            echo 0;
        }
        echo '<option value="-1">--Select--</option>';
        foreach ($templates as $value) {
            echo "<option value='$value->template_id'>";
            echo ($type == "sms") ? $value->title : $value->name;
            echo "</option>";
        }
    }

    function addEvent() {
        $post = $this->input->post();
        $data = $this->objcal->addEvent($post);
        if ($data) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function getEvents() {
        $post = $this->input->post();
        $this->objcal->getEvents($post);
    }

    function getCards() {
        $post = $this->input->post();
        $this->objcal->getCards($post);
    }

    function getEvent($eid) {
        $event = $this->objcal->getEvent($eid);
        echo json_encode($event);
    }

    function updateEvent() {
        $set = $this->input->post();
        if (is_array($set)) {
            $msg = $this->objcal->updateEvent($set);
            switch ($msg) {
                case "U":
                    echo 1;
                    break;
                case "UF":
                    echo 0;
                    break;
                case "NA":
                    $title = ($set['event_type'] == "sms") ? "SMS" : "Email";
                    echo "You have already reach your {$title} event  limit..!\nYou can not add more..!";
                    break;
            }
        } else {
            header('location' . site_url() . 'app/calender');
        }
    }

    function deleteEvent($eid) {
        $flag = $this->objcal->deleteEvent($eid);
        echo ($flag) ? 1 : 0;
    }

    function sendActivationEmail() {
        $uid = $this->session->userdata('userid');
        $userInfo = $this->wi_common->getUserInfo($uid);
        $post = array(
            'name' => $userInfo->name,
            'email' => $userInfo->email
        );
        echo ($this->objregister->sendMail($post, $uid)) ? 1 : 0;
    }

    function connect() {
        $this->con();
        header('location:' . $this->client->createAuthUrl());
    }

    function con() {
        require APPPATH . 'third_party/google-api/Google_Client.php';
        require APPPATH . 'third_party/google-api/contrib/Google_CalendarService.php';

        $setting = $this->objprofile->getUserSetting();
        if ($setting->app_name != NULL && $setting->client_id != NULL && $setting->client_secret != NULL && $setting->api_key != NULL) {
            $this->client = new Google_Client();
            $this->client->setApplicationName($setting->app_name);
            $this->client->setClientId($setting->client_id);
            $this->client->setClientSecret($setting->client_secret);
            $this->client->setRedirectUri($setting->redirect_uri);
            $this->client->setDeveloperKey($setting->api_key);
            $this->client->setScopes("https://www.googleapis.com/auth/calendar");
            $this->client->setAccessType('offline');
            $this->client->setApprovalPrompt('auto');

            $this->service = new Google_CalendarService($this->client);
        } else {
            header('location:' . site_url() . 'app/setting');
        }
    }

}
