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
        $this->load->model('m_trigger', 'objtrigger');
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
        $this->addGoogleEvent($post);
        die();
        $data = $this->objcal->addEvent($post);
        if ($data) {
//            echo ($this->addGoogleEvent($post)) ? 1 : 0;
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

    //---------------Google Calender Event Function---------------------------//

    function connect() {
        if (!$this->input->cookie('userid')) {
            $userid = array(
                'name' => 'userid',
                'value' => $this->encryption->encode($this->session->userdata('userid')),
                'expire' => time() + 86500,
                'domain' => '.wish-fish.com'
            );
            $this->input->set_cookie($userid);
        }
        $this->setClient();
        header('location:' . $this->client->createAuthUrl());
    }

    function setClient() {
        require_once APPPATH . 'third_party/google-api/Google_Client.php';
        require_once APPPATH . 'third_party/google-api/contrib/Google_CalendarService.php';

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
                return TRUE;
            }
        } catch (Exception $exc) {
            $this->close();
            return FALSE;
        }
    }

    function close() {
        delete_cookie('token', '.wish-fish.com', '/');
    }

    function getCalenderId() {
        if ($this->refresh()) {
            $calendarList = $this->service->calendarList->listCalendarList();
            return $calendarList['items'][0]['id'];
        } else {
            return false;
        }
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

    function addGoogleEvent($post = NULL) {

        $calId = $this->getCalenderId();
        if ($this->refresh() && $calId) {
            try {
                $timezone = $this->session->userdata('timezone');
                $timestamp = timezones($timezone);
                date_default_timezone_set($this->timezone_by_offset($timestamp));

                $currDateTime = $this->wi_common->getUTCDateWithTime($timezone);
                $eventDt = date('Y-m-d', strtotime($currDateTime)) . ' ' . $post['time'] . ':00';
                $ev_dt = date(DATE_RFC3339, strtotime($eventDt));

                $is_repeat = (isset($post['is_repeat']) && $post['is_repeat'] == "on") ? 1 : 0;

                print_r($post);

                switch ($post['assign']) {

                    case 'all_c':

                        $contactInfo = $this->wi_common->getContactInfo($post['contact_id']);

                        $attendee = new Google_EventAttendee();
                        $attendee->setEmail($contactInfo->email);
                        $attendee->setDisplayName($contactInfo->fname . ' ' . $contactInfo->lname);

                        echo $ev_dt . '\n';
//                        $createdEvent = $this->makeEvent($calId, $post, $attendee, $ev_dt);
                        if ($is_repeat) {
                            if ($post['freq_type'] != "-1" && $post['freq_no'] != "-1" && is_numeric($post['occurance'])) {
                                for ($i = $post['occurance'] - 1; $i > 0; $i--) {
                                    $total = $post['freq_no'] * ($post['occurance'] - $i);
                                    $dt = $this->wi_common->getNextDate($post['date'], $total . ' ' . $post['freq_type']);
                                    $evDt = $dt . ' ' . $post['time'] . ':00';
                                    echo $evDt . '<br>';
                                }
                            }
                        }
                        break;
                    case 'all_gc':
                        $res = $this->objtrigger->getGroupContact($post['group_id']);
                        $cids = $res[1];
                        foreach ($cids as $key => $cid) {
                            $contactInfo = $this->wi_common->getContactInfo($cid);
                            $attendee[$key] = new Google_EventAttendee();
                            $attendee[$key]->setEmail($contactInfo->email);
                            $attendee[$key]->setDisplayName($contactInfo->fname . ' ' . $contactInfo->lname);
                        }
                        $createdEvent = $this->makeEvent($calId, $post, $attendee, $ev_dt);
                        break;
                }

                // print_r($createdEvent);
            } catch (Google_Exception $exc) {
                $error = $exc->getMessage();
                echo $error;
//                print_r($exc);
                return FALSE;
            }
        } else {
            echo 'NOT CALLED';
            print_r($post);
            return FALSE;
        }
        die();
    }

    function makeEvent($calId, $post, $attendee, $ev_dt) {

        $body = ($post['event_type'] == "sms" || $post['event_type'] == "notification") ? $post['smsbody'] : $post['emailbody'];

        $event = new Google_Event();
        $event->setSummary($post['event']);
        $event->setDescription($body);
        $event->setColorId(9);

        $start = new Google_EventDateTime();
        $start->setDateTime($ev_dt);
        $event->setStart($start);

        $end = new Google_EventDateTime();
        $end->setDateTime($ev_dt);
        $event->setEnd($end);

        $event->attendees = array($attendee);

        return $this->service->events->insert($calId, $event);
    }

    function timezone_by_offset($offset) {
        $abbrarray = timezone_abbreviations_list();
        $offset = ($offset + 1) * 60 * 60;
        foreach ($abbrarray as $abbr) {
            foreach ($abbr as $city) {
                if ($city['offset'] == $offset && $city['dst'] == FALSE) {
                    return $city['timezone_id'];
                }
            }
        }
    }

}
