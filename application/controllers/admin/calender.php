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
        $this->load->library("authex");
        $this->load->library('common');
        if (!$this->authex->logged_in()) {
            header('location:' . site_url() . 'admin/admin_login');
        } else if (!$this->common->getPermission()->calender) {
            header('location:' . site_url() . 'admin/dashboard/error/500');
        } else {
            $this->load->model('admin/m_admin_contacts', 'objcontact');
            $this->load->model('admin/m_admin_contact_groups', 'objgrp');
            $this->load->model('admin/m_admin_sms_template', 'objsmstmplt');
            $this->load->model('admin/m_admin_email_template', 'objemailtmplt');
            $this->load->model('admin/m_sms', 'objsms');
            $this->load->model('admin/m_email', 'objemail');
            $this->load->model('admin/m_setting', 'objsetting');
            $this->load->model('admin/m_admin_calender', 'objcal');
        }
    }

    function index() {
        $get = $this->input->get();
        if (isset($get['error']) && $get['error'] == "access_denied") {
            header('location:' . site_url() . 'admin/calender');
        } else if (isset($get['code']) && $get['code'] != "") {
            $this->setClient();
            $this->client->authenticate($this->input->get('code'));
            $token = json_decode($this->client->getAccessToken());
            $tokenizer = array(
                'name' => 'atoken',
                'value' => $this->encryption->encode($token->access_token),
                'expire' => time() + 86500,
                'domain' => '.wish-fish.com'
            );
            $this->input->set_cookie($tokenizer);
            header('location:' . site_url() . 'admin/calender?a=sync');
        }
        if (isset($get['a']) && $get['a'] == "sync") {
            $this->addLocalEvent();
        }
        $data['individual'] = $this->objcontact->getContactDetail();
        $data['template'] = $this->objsmstmplt->getTemplates();
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/calender', $data);
        $this->load->view('admin/admin_footer');
    }

    function createEvent($type, $userid) {
        $t = $this->input->get('type');
        $res = $this->objcal->createEvent($type, $userid);
        if ($res) {
            $data['individual'] = $this->objcontact->getContactDetail();
            $data['template'] = $this->objsmstmplt->getTemplates();
            $data['contactInfo'] = $res;
        } else {
            $data['contactInfo'] = FALSE;
        }
        $data['flag'] = ($t == "bday") ? TRUE : FALSE;
        $this->load->view('admin/admin_header');
        $this->load->view('admin/admin_top');
        $this->load->view('admin/admin_navbar');
        $this->load->view('admin/calender', $data);
        $this->load->view('admin/admin_footer');
    }

    function allGroup() {
        $group = $this->objgrp->getContactGroups("simple");
        echo '<select  name="group_id" class="form-control">';
        foreach ($group as $value) {
            echo "<option value='$value->group_id'>$value->group_name</option>";
        }
        echo '</select>';
    }

    function allSMSList() {
        $group = $this->objgrp->getContactGroups("sms");
        echo '<select  name="group_id" class="form-control">';
        foreach ($group as $value) {
            echo "<option value='$value->group_id'>$value->group_name</option>";
        }
        echo '</select>';
    }

    function getTemplate($type, $tmpid) {
        if ($type == "sms" || $type == "notification") {
            $this->objsms->getTemplate($tmpid);
        } else if ($type == "email") {
            $this->objemail->getTemplate($tmpid);
        }
    }

    function getTemplates($type) {
        if ($type == "sms" || $type == "notification") {
            $templates = $this->objsmstmplt->getTemplates();
        } else if ($type == "email") {
            $templates = $this->objemailtmplt->getTemplates();
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
        $this->objcal->getCards();
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
                echo 'NC';
            } else {
                $this->updateGoogleEvent($set);
                $msg = $this->objcal->updateEvent($set);
                echo ($msg) ? 1 : 0;
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

    //---------------Google Calender Event Function---------------------------//

    function connect() {
        $this->setClient();
        header('location:' . $this->client->createAuthUrl());
    }

    function setClient() {
        require_once APPPATH . 'third_party/google-api/Google_Client.php';
        require_once APPPATH . 'third_party/google-api/contrib/Google_CalendarService.php';

        $setting = $this->objsetting->getCalenderSetting();

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
        } else {
            header('location:' . site_url() . 'admin/setting/calender');
        }
    }

    function refresh() {
        try {
            $this->setClient();
            if ($this->client->isAccessTokenExpired() && $this->input->cookie('atoken')) {
                $tkn = $this->encryption->decode($this->input->cookie('atoken', TRUE));
                $this->client->refreshToken($tkn);
                return TRUE;
            }
        } catch (Exception $exc) {
            $this->close();
            return FALSE;
        }
    }

    function close() {
        delete_cookie('atoken', '.wish-fish.com', '/');
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
            $this->refresh();
            $calendarList = $this->service->calendarList->listCalendarList();
            echo '<pre>';
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
        } catch (Google_ServiceException $exc) {
            $error = $exc->getErrors();
            echo $error[0]['message'];
        }
    }

    function addGoogleEvent($post) {
        $calId = $this->getCalenderId();
        if ($this->refresh() && $calId) {
            try {
                $timestamp = "Pacific/Pitcairn";
                date_default_timezone_set($timestamp);
                $eventDt = $this->common->getMySqlDate(date('Y-m-d'), "mm-dd-yyyy") . ' ' . $post['time'] . ':00';
                $ev_dt = date(DATE_RFC3339, strtotime($eventDt));

                $is_repeat = (isset($post['is_repeat']) && $post['is_repeat'] == "on") ? 1 : 0;

                switch ($post['assign']) {
                    case 'all_c':
                        $contactInfo = $this->common->getContactInfo($post['user_id']);
                        $attendee = new Google_EventAttendee();
                        $attendee->setEmail($contactInfo->email);
                        $attendee->setDisplayName($contactInfo->fname . ' ' . $contactInfo->lname);
                        break;
                    case 'all_gc':
                        $res = $this->objtrigger->getGroupContact($post['group_id']);
                        $cids = $res[1];
                        foreach ($cids as $key => $cid) {
                            $contactInfo = $this->common->getContactInfo($cid);
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
            $timestamp = "Pacific/Pitcairn";
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
                        $contactInfo = $this->common->getContactInfo($ev['user_id']);
                        $attendee = new Google_EventAttendee();
                        $attendee->setEmail($contactInfo->email);
                        $attendee->setDisplayName($contactInfo->fname . ' ' . $contactInfo->lname);
                        break;
                    case 'simple':
                        $res = $this->objtrigger->getGroupContact($ev['group_id']);
                        $cids = $res[1];
                        foreach ($cids as $key => $cid) {
                            $contactInfo = $this->common->getContactInfo($cid);
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
                    $timestamp = "Pacific/Pitcairn";
                    date_default_timezone_set($timestamp);

                    $d = (isset($post['date'])) ?
                            $this->common->getMySqlDate($post['date'], "mm-dd-yyyy") :
                            $post['date'];
                    $eventDt = $d . ' ' . $post['time'];
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
