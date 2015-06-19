<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author Laxmisoft
 */
class Cal extends CI_Controller {

    var $sess_data = array(), $userid;

//put your code here
    function __construct() {
        parent::__construct();
        require APPPATH . 'third_party/google-api/Google_Client.php';
        require APPPATH . 'third_party/google-api/contrib/Google_CalendarService.php';
        $this->config->load('googlecalender');

        $this->client = new Google_Client();
        $this->client->setApplicationName($this->config->item('application_name', 'googlecalender'));
        $this->client->setClientId($this->config->item('client_id', 'googlecalender'));
        $this->client->setClientSecret($this->config->item('client_secret', 'googlecalender'));
        $this->client->setRedirectUri($this->config->item('redirect_uri', 'googlecalender'));
        $this->client->setDeveloperKey($this->config->item('api_key', 'googlecalender'));
        $this->client->setScopes("https://www.googleapis.com/auth/calendar");
        $this->client->setAccessType('offline');

        $this->service = new Google_CalendarService($this->client);

        if ($this->input->get('error') == "access_denied") {
            header('location:' . site_url() . 'app/dashboard');
        } else if ($this->input->get('code') != "") {
            $this->client->authenticate($this->input->get('code'));
            $token = json_decode($this->client->getAccessToken());
            $this->session->set_userdata('token', $token->access_token);
        }
    }

    function index() {
        echo $this->session->userdata('token');
    }

    function getCalender() {
        $this->client->setApprovalPrompt('auto');
        header('location:' . $this->client->createAuthUrl());
    }

    public function events() {
        try {
            if ($this->client->isAccessTokenExpired()) {
                $this->client->refreshToken($this->session->userdata('token'));
            }
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

    function addEvent() {
        echo date_default_timezone_set('Asia/Kolkata');
        echo date(DATE_RFC3339);
        echo DateTime::RFC3339;

//        $event = new Google_Service_Calendar_Event(array(
//            'summary' => 'BirthDay',
//            'description' => 'Happy Birthday Sanjay Vekariya.',
//            'start' => array(
//                'dateTime' => DateTime::ATOM,
//                'timeZone' => date_default_timezone_get(),
//            ),
//            'end' => array(
//                'dateTime' => DateTime::ATOM,
//                'timeZone' => date_default_timezone_get(),
//            ),
////            'recurrence' => array(
////                'RRULE:FREQ=DAILY;COUNT=2'
////            ),
//            'attendees' => array(
//                array(
//                    'email' => 'sanjayvekariya18@gmail.com',
//                    'title' => 'Birthday',
//                ),
//            ),
//            'reminders' => array(
//                'useDefault' => FALSE,
//                'overrides' => array(
//                    array('method' => 'email', 'minutes' => 24 * 60),
//                    array('method' => 'sms', 'minutes' => 10),
//                ),
//            ),
//        ));
//
//        $calendarId = 'primary';
//        $event = $service->events->insert($calendarId, $event);
//        printf('Event created: %s\n', $event->htmlLink);
    }

}
