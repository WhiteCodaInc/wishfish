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
            $uid = $this->input->cookie('userid', TRUE);
            delete_cookie('userid', '.wish-fish.com', '/');
            $this->session->set_userdata('userid', $this->encryption->decode($uid));
            $this->setClient();
            $this->client->authenticate($this->input->get('code'));
            $token = json_decode($this->client->getAccessToken());
            $tokenizer = array(
                'name' => 'token',
                'value' => $this->encryption->encode($token->access_token),
                'expire' => time() + 86500,
                'domain' => '.wish-fish.com'
            );
            $this->input->set_cookie($tokenizer);
            header('location:' . site_url() . 'app/calender');
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
            echo ($this->addGoogleEvent($post)) ? 1 : 0;
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

    //---------------Google Calender Event Function---------------------------//

    function connect() {
        $userid = array(
            'name' => 'userid',
            'value' => $this->encryption->encode($this->session->userdata('userid')),
            'expire' => time() + 86500,
            'domain' => '.wish-fish.com'
        );
        $this->input->set_cookie($userid);
        $this->setClient();
        header('location:' . $this->client->createAuthUrl());
    }

    function setClient() {
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

    function refresh() {
        try {
            $this->setClient();
            if ($this->client->isAccessTokenExpired() && $this->input->cookie('token')) {
                $tkn = $this->encryption->decode($this->input->cookie('token', TRUE));
                $this->client->refreshToken($tkn);
            }
        } catch (Google_ServiceException $exc) {
            $error = $exc->getErrors();
            echo $error[0]['message'];
        }
    }

    function close() {
        delete_cookie('token', '.wish-fish.com', '/');
    }

    public function events() {
        try {
            $this->refresh();
            $calendarList = $this->service->calendarList->listCalendarList();
            echo '<pre>';
//            print_r($calendarList);
//            die();
            foreach ($calendarList['items'] as $calendarListEntry) {
                echo '<br>-------------------------------------------------------<br>';
                echo "ID : " . $calendarListEntry['id'] . "<br>\n";
                echo "SUMMARY : " . $calendarListEntry['summary'] . "<br>\n";
                // get events 
                $events = $this->service->events->listEvents($calendarListEntry['id']);
                //print_r($events);
                foreach ($events['items'] as $event) {
//                        echo "-----" . $event['summary'] . "<br>";
                    print_r($event);
                    die();
                }
            }
        } catch (Google_ServiceException $exc) {
            $error = $exc->getErrors();
            echo $error[0]['message'];
        }
    }

    function addGoogleEvent($post) {

//        switch ($post['assign']) {
//            case 'all_c':
//                
//                break;
//            case 'all_gc':
//                unset($post['contact_id']);
//
//                break;
//        }
//        if (isset($post['contactid'])) {
//            $post['contact_id'] = $post['contactid'];
//            unset($post['contactid']);
//        }
//        $post['date'] = $this->wi_common->getMySqlDate($post['date'], $this->session->userdata('date_format'));
//        $post['is_repeat'] = (isset($post['is_repeat']) && $post['is_repeat'] == "on") ? 1 : 0;
//        $post['body'] = ($post['event_type'] == "sms" || $post['event_type'] == "notification") ? $post['smsbody'] : $post['emailbody'];
//        $post['notification'] = ($post['event_type'] == "notification") ? 0 : 1;
//        $post['occurance'] = ($post['occurance'] != "") ? $post['occurance'] : NULL;
//        $post['user_id'] = $this->userid;
//        unset($post['assign']);
//        unset($post['smsbody']);
//        unset($post['emailbody']);
//
//        $this->db->trans_start();
//        $post['color'] = "#0073b7";
//        $this->db->insert('wi_schedule', $post);
//        $insertid = $this->db->insert_id();
//        if ($post['freq_type'] != "-1" && $post['freq_no'] != "-1" && is_numeric($post['occurance'])) {
//            $post['refer_id'] = $insertid;
//            $dt = $post['date'];
//            for ($i = $post['occurance'] - 1; $i > 0; $i--) {
//                $post['is_repeat'] = 0;
//                $total = $post['freq_no'] * ($post['occurance'] - $i);
//                $post['date'] = $this->wi_common->getNextDate($dt, $total . ' ' . $post['freq_type']);
//                $this->db->insert('wi_schedule', $post);
//            }
//        }
//        $this->db->trans_complete();
//        if ($this->db->trans_status()) {
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//        date_default_timezone_set('Asia/Kolkata');
        echo date(DATE_RFC3339, gmt_to_local(time(), $this->session->userdata('timezone'), TRUE));
        echo date(DATE_RFC3339) . '<br>';
        echo date(DateTime::RFC3339) . '<br>';
        die();
        $event = new Google_Event();
        $event->setSummary('Happy BirthDay');
        $event->setLocation('The Neighbourhood');
        $event->setColorId(1);

        $start = new Google_EventDateTime();
//        $start->setDateTime(date(DATE_RFC3339));
        $start->setDateTime('2015-06-20T03:00:00.000-07:00');
//        $start->setTimeZone('Asia/Samarkand');
        $event->setStart($start);

        $end = new Google_EventDateTime();
//        $end->setDateTime(date(DATE_RFC3339));
        $end->setDateTime('2015-06-20T03:00:00.000-07:00');
//        $end->setTimeZone('Asia/Samarkand');
        $event->setEnd($end);

        $attendee1 = new Google_EventAttendee();
        $attendee1->setEmail('sanjayvekariya18@gmail.com');
        $attendee1->setDisplayName('Sanjay Vekariya');
        $attendee1->setId(1);

        $attendees = array($attendee1);
        $event->attendees = $attendees;

        print_r($event);
        try {
            if ($this->client->isAccessTokenExpired()) {
                $this->client->refreshToken($this->session->userdata('token'));
            }
            $createdEvent = $this->service->events->insert("vishaltesting7@gmail.com", $event); //Returns array not an object
            print_r($createdEvent);
        } catch (Google_ServiceException $exc) {
            $error = $exc->getErrors();
            echo $error[0]['message'];
        }
    }

}
