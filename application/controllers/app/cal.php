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

    var $client, $service;

//put your code here
    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->connect();
        if ($this->input->get('error') == "access_denied") {
            echo 'Access Denied..!';
        } else if ($this->input->get('code') != "") {
            $this->client->authenticate($this->input->get('code'));
            $token = json_decode($this->client->getAccessToken());
            $this->session->set_userdata('token', $token->access_token);
        }
    }

    function getCalender() {
        $this->connect();
        $this->client->setApprovalPrompt('auto');
        header('location:' . $this->client->createAuthUrl());
    }

    function connect() {
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
    }

    public function events() {
        try {
            $this->connect();
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
        echo "<pre>";

        date_default_timezone_set('Asia/Kolkata');
        echo date(DATE_RFC3339) . '<br>';
        echo date(DateTime::RFC3339) . '<br>';


        $event = new Google_Event();
        $event->setSummary('Happy BirthDay');
        $event->setLocation('The Neighbourhood');

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

    function logout() {
        $this->session->unset_userdata('token');
    }

}
