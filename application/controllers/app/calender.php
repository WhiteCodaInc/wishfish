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

    private $client;

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
        $get = $this->input->get();
        if (isset($get['error']) && $get['error'] == "access_denied") {
            header('location:' . site_url() . 'app/calender');
        } else if (isset($get['code']) && $get['code'] != "") {
            $uid = $this->input->cookie('user', TRUE);
            delete_cookie('userid', '.wish-fish.com', '/');
            $this->session->set_userdata('u_userid', $this->encryption->decode($uid));
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
            header('location:' . site_url() . 'app/calender?a=sync');
        }
        if (isset($get['a']) && $get['a'] == "sync") {
            $this->addLocalEvent();
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
        if (!$res || $currPlan->group_events == '-1' || $res->total < $currPlan->group_events) {
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
                    if (!isset($res['email']) || $currPlan->email_events == '-1' || $res['email'] < $currPlan->email_events + 1) {
                        $user[$key] = $value->fname . '  ' . $value->lname . ' || ' . $value->email;
                        $ids[$key] = $value->contact_id;
                    }
                    break;
                case "sms":
                    if (!isset($res['sms']) || $currPlan->sms_events == '-1' || $res['sms'] < $currPlan->sms_events + 1) {
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
        $eventData = $this->addGoogleEvent($post);
        $data = (!$eventData) ?
                $this->objcal->addEvent($post) :
                $this->objcal->addEvent($post, $eventData->id);
        echo ($data) ? 1 : 0;
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
            $eventInfo = $this->objcal->getEventInfo($set['eventid']);
            if ($eventInfo->google_event_id != "" && !$this->refresh()) {
                $msg = "NC";
            } else {
                $this->updateGoogleEvent($set);
                $msg = $this->objcal->updateEvent($set);
            }
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
                case "NC":
                    echo "This event is connect with Google Calender. Please connect calender with google.";
                    break;
            }
        } else {
            header('location' . site_url() . 'app/calender');
        }
    }

    function deleteEvent($eid) {
        $event = $this->objcal->getGoogleEventId($eid);
        ($event) ? $this->delete($event->google_event_id) : '';
        $flag = $this->objcal->deleteEvent($eid);
        echo ($flag) ? 1 : 0;
    }

    function sendActivationEmail() {
        $uid = $this->session->userdata('u_userid');
        $userInfo = $this->wi_common->getUserInfo($uid);
        $post = array(
            'name' => $userInfo->name,
            'email' => $userInfo->email
        );
        echo ($this->objregister->sendMail($post, $uid)) ? 1 : 0;
    }

//---------------Google Calender Event Function---------------------------//

    function connect() {
        if ($this->setClient()) {
            $userid = array(
                'name' => 'user',
                'value' => $this->encryption->encode($this->session->userdata('u_userid')),
                'expire' => time() + (3600 * 24),
                'domain' => '.wish-fish.com'
            );
            $this->input->set_cookie($userid);
            header('location:' . $this->client->createAuthUrl());
        } else {
            header('location:' . site_url() . 'app/setting');
        }
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
            $this->client->setUseObjects(true);

            $this->service = new Google_CalendarService($this->client);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function refresh() {
        try {
            if ($this->setClient() && $this->client->isAccessTokenExpired() && $this->input->cookie('token')) {
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
            return $calendarList->items[0]->id;
        } else {
            return false;
        }
    }

    function events() {
        try {
            if ($this->refresh()) {
                $calendarList = $this->service->calendarList->listCalendarList();
//                echo '<pre>';
//            print_r($calendarList);
//            die();
                foreach ($calendarList->items as $calendarListEntry) {
                    echo '<br>-------------------------------------------------------<br>';
                    echo "ID : " . $calendarListEntry->id . "<br>\n";
                    echo "SUMMARY : " . $calendarListEntry->summary . "<br>\n";
                    // get events 
                    $events = $this->service->events->listEvents($calendarListEntry->id);
                    //print_r($events);
                    foreach ($events->items as $event) {
                        echo "-----" . $event->summary . "<br>";
                        print_r($event);
                    }
                    die();
                }
            }
        } catch (Google_ServiceException $exc) {
            $error = $exc->getErrors();
            echo $error[0]['message'];
        }
    }

    function addGoogleEvent($post) {
        $calId = $this->getCalenderId();
        if ($this->refresh() && $calId) {
            try {
                $timezone = $this->session->userdata('u_timezone');
                $timestamp = $this->timezone_by_offset($timezone);
                date_default_timezone_set($timestamp);

                $currDateTime = $this->wi_common->getUTCDateWithTime($timezone);
                $eventDt = date('Y-m-d', strtotime($currDateTime)) . ' ' . $post['time'] . ':00';
                $ev_dt = date(DATE_RFC3339, strtotime($eventDt));

                $is_repeat = (isset($post['is_repeat']) && $post['is_repeat'] == "on") ? 1 : 0;

                switch ($post['assign']) {
                    case 'all_c':
                        $contactInfo = $this->wi_common->getContactInfo($post['contact_id']);
                        $attendee = new Google_EventAttendee();
                        $attendee->setEmail($contactInfo->email);
                        $attendee->setDisplayName($contactInfo->fname . ' ' . $contactInfo->lname);
                        break;
                    case 'all_gc':
                        $res = $this->objtrigger->getGroupContact($post['group_id']);
                        $cids = $res[1];
                        $attendee = array();
                        foreach ($cids as $key => $cid) {
                            $contactInfo = $this->wi_common->getContactInfo($cid);
                            $attendee[$key] = new Google_EventAttendee();
                            $attendee[$key]->setEmail($contactInfo->email);
                            $attendee[$key]->setDisplayName($contactInfo->fname . ' ' . $contactInfo->lname);
                        }
                        break;
                }
                if (!$is_repeat) {
                    $createdEvent = $this->makeEvent($calId, $post, $attendee, $ev_dt, $timestamp);
                } else {
                    switch ($post['freq_type']) {
                        case "days":
                            $freq = "DAILY";
                            break;
                        case "weeks":
                            $freq = "WEEKLY";
                            break;
                        case "months":
                            $freq = "MONTHLY";
                            break;
                        case "years":
                            $freq = "YEARLY";
                            break;
                    }
                    if ($post['end_type'] == "never") {
                        $recur = "RRULE:FREQ={$freq};INTERVAL={$post['freq_no']}";
                    } else if ($post['end_type'] == "after") {
                        $recur = "RRULE:FREQ={$freq};INTERVAL={$post['freq_no']};COUNT={$post['occurance']}";
                    } else {
                        $recur = NULL;
                    }
                    $createdEvent = $this->makeEvent($calId, $post, $attendee, $ev_dt, $timestamp, $recur);
                }
                return $createdEvent;
            } catch (Google_Exception $exc) {
//                $error = $exc->getMessage();
//                echo $error;
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function addLocalEvent() {
        $calId = $this->getCalenderId();
        if ($this->refresh() && $calId) {
            $timezone = $this->session->userdata('u_timezone');
            $timestamp = $this->timezone_by_offset($timezone);
            date_default_timezone_set($timestamp);
            $events = $this->objcal->loadLocalEvent();
//            echo '<pre>';
//            print_r($events);
//            die();
            foreach ($events as $ev) {
                $eventDt = $ev['date'] . ' ' . $ev['time'];
                $ev_dt = date(DATE_RFC3339, strtotime($eventDt));
                switch ($ev['group_type']) {
                    case 'individual':
                        $uInfo = ($ev['notify'] == "them") ?
                                $this->wi_common->getContactInfo($ev['contact_id']) :
                                $this->wi_common->getUserInfo($ev['contact_id']);
                        $name = ($ev['notify'] == "them") ?
                                $uInfo->fname . ' ' . $uInfo->lname :
                                $uInfo->name;
                        $attendee = new Google_EventAttendee();
                        $attendee->setEmail($uInfo->email);
                        $attendee->setDisplayName($name);
                        break;
                    case 'simple':
                        $res = $this->objtrigger->getGroupContact($ev['group_id']);
                        $cids = $res[1];
                        foreach ($cids as $key => $cid) {
                            $contactInfo = $this->wi_common->getContactInfo($cid);
                            $attendee[$key] = new Google_EventAttendee();
                            $attendee[$key]->setEmail($contactInfo->email);
                            $attendee[$key]->setDisplayName($contactInfo->fname . ' ' . $contactInfo->lname);
                        }
                        break;
                }
                if (!$ev['is_repeat']) {
//                    echo "<br>-----Event ID : {$ev['event_id']}--------<br>";
//                    print_r($attendee);
//                    echo $ev_dt . '<br>';
//                    echo "<br>-------END--------<br>";
                    $createdEvent = $this->makeEvent($calId, $ev, $attendee, $ev_dt, $timestamp);
                } else {
                    switch ($ev['freq_type']) {
                        case "days":
                            $freq = "DAILY";
                            break;
                        case "weeks":
                            $freq = "WEEKLY";
                            break;
                        case "months":
                            $freq = "MONTHLY";
                            break;
                        case "years":
                            $freq = "YEARLY";
                            break;
                    }
                    if ($ev['end_type'] == "never") {
                        $recur = "RRULE:FREQ={$freq};INTERVAL={$ev['freq_no']}";
                    } else if ($ev['end_type'] == "after") {
                        $recur = "RRULE:FREQ={$freq};INTERVAL={$ev['freq_no']};COUNT={$ev['occurance']}";
                    } else {
                        $recur = NULL;
                    }
//                    echo "<br>-----Event ID : {$ev['event_id']}--------<br>";
//                    print_r($attendee);
//                    echo $ev_dt . '<br>';
//                    echo "<br>-------END--------<br>";
                    $createdEvent = $this->makeEvent($calId, $ev, $attendee, $ev_dt, $timestamp, $recur);
                }
                if ($createdEvent)
                    $this->objcal->updateGoogleEvent($createdEvent, $ev);
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function delete($id) {
        $calId = $this->getCalenderId();
        if ($calId) {
            try {
                $this->service->events->delete($calId, $id);
                return TRUE;
            } catch (Google_Exception $exc) {
//                $error = $exc->getMessage();
//                echo $error;
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function updateGoogleEvent($post) {
        $eventInfo = $this->objcal->getEventInfo($post['eventid']);
        if ($eventInfo->google_event_id != "") {
            $calId = $this->getCalenderId();
            if ($this->refresh() && $calId) {
                try {
                    $event = $this->service->events->get($calId, $eventInfo->google_event_id);
                    $timezone = $this->session->userdata('u_timezone');
                    $timestamp = $this->timezone_by_offset($timezone);
                    date_default_timezone_set($timestamp);

                    $d = (isset($post['event'])) ?
                            $this->wi_common->getMySqlDate($post['date'], $this->session->userdata('u_date_format')) :
                            $post['date'];
                    $eventDt = (isset($post['event'])) ?
                            $d . ' ' . $post['time'] :
                            $d . ' ' . $eventInfo->time;
                    $ev_dt = date(DATE_RFC3339, strtotime($eventDt));

                    if (isset($post['event'])) {
                        $is_repeat = (isset($post['is_repeat']) && $post['is_repeat'] == "on") ? 1 : 0;
                        $body = ($post['event_type'] == "sms" || $post['event_type'] == "notification") ? $post['smsbody'] : $post['emailbody'];
                        $title = $post['event'];
                        $freq_type = $post['freq_type'];
                        $end_type = $post['end_type'];
                        $freq_no = $post['freq_no'];
                        $occur = $post['occurance'];
                    } else {
                        $is_repeat = $eventInfo->is_repeat;
                        $body = $eventInfo->body;
                        $title = $eventInfo->event;
                        $freq_type = $eventInfo->freq_type;
                        $end_type = $eventInfo->end_type;
                        $freq_no = $eventInfo->freq_no;
                        $occur = $eventInfo->occurance;
                    }

                    $event->setSummary($title);
                    $event->setDescription($body);

                    $start = new Google_EventDateTime();
                    $start->setDateTime($ev_dt);
                    $start->setTimeZone($timestamp);
                    $event->setStart($start);

                    $end = new Google_EventDateTime();
                    $end->setDateTime($ev_dt);
                    $end->setTimeZone($timestamp);
                    $event->setEnd($end);

                    if ($is_repeat) {
                        switch ($freq_type) {
                            case "days":
                                $freq = "DAILY";
                                break;
                            case "weeks":
                                $freq = "WEEKLY";
                                break;
                            case "months":
                                $freq = "MONTHLY";
                                break;
                            case "years":
                                $freq = "YEARLY";
                                break;
                        }
                        if ($end_type == "never") {
                            $recur = "RRULE:FREQ={$freq};INTERVAL={$freq_no}";
                        } else if ($end_type == "after") {
                            $recur = "RRULE:FREQ={$freq};INTERVAL={$freq_no};COUNT={$occur}";
                        }
                        $event->setRecurrence(array($recur));
                    } else {
                        $event->setRecurrence(array());
                    }
                    $this->service->events->update($calId, $event->getId(), $event);
                    return TRUE;
                } catch (Google_Exception $exc) {
//                    $error = $exc->getMessage();
//                    echo $error;
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
    }

    function makeEvent($calId, $post, $attendee, $ev_dt, $timezone, $recur = NULL) {
        if (isset($post['smsbody']) || isset($post['emailbody'])) {
            $body = ($post['event_type'] == "sms" || $post['event_type'] == "notification") ?
                    $post['smsbody'] : $post['emailbody'];
        } else {
            $body = $post['body'];
        }

        try {
            $event = new Google_Event();
            $event->setSummary($post['event']);
            $event->setDescription($body);
            $event->setColorId(9);

            $start = new Google_EventDateTime();
            $start->setDateTime($ev_dt);
            $start->setTimeZone($timezone);
            $event->setStart($start);

            $end = new Google_EventDateTime();
            $end->setDateTime($ev_dt);
            $end->setTimeZone($timezone);
            $event->setEnd($end);

            $event->attendees = array($attendee);

            if ($recur != NULL)
                $event->setRecurrence(array($recur));

            return $this->service->events->insert($calId, $event);
        } catch (Google_Exception $exc) {
            return false;
        }
    }

    function timezone_by_offset($timezone) {
        $timestamp = timezones($timezone);
        $abbrarray = timezone_abbreviations_list();
        $offset = ($timestamp + 1) * 60 * 60;
        foreach ($abbrarray as $abbr) {
            foreach ($abbr as $city) {
                if ($city['offset'] == $offset && $city['dst'] == FALSE) {
                    return $city['timezone_id'];
                }
            }
        }
    }

}
