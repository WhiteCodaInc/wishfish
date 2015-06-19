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

        $this->service = new Google_CalendarService($this->client);

        if ($this->input->get('error') == "access_denied") {
            header('location:' . site_url() . 'app/dashboard');
        } else if ($this->input->get('code') != "") {
            $this->client->authenticate($this->input->get('code'));
            $this->session->set_userdata('token', $this->client->getAccessToken());
        }
    }

    function index() {
        $this->client->setApprovalPrompt('auto');
        header('location:' . $this->client->createAuthUrl());
    }

    public function events() {

        if ($this->client->getAccessToken()) {
            try {
                $calendarList = $this->service->calendarList->listCalendarList();
                echo '<pre>';
                print_r($calendarList);
                die();
                while (true) {
                    foreach ($calendarList['items'] as $calendarListEntry) {

                        echo $calendarListEntry['summary'] . "<br>\n";
                        // get events 
                        $events = $this->service->events->listEvents($calendarListEntry['id']);
                        print_r($events);

//                            foreach ($events->getItems() as $event) {
//                                echo "-----" . $event->getSummary() . "<br>";
//                            }
                    }
                    die();
                    $pageToken = $calendarList->getNextPageToken();
                    if ($pageToken) {
                        $optParams = array('pageToken' => $pageToken);
                        $calendarList = $this->service->calendarList->listCalendarList($optParams);
                    } else {
                        break;
                    }
                }
            } catch (Google_ServiceException $exc) {
                $error = $exc->getErrors();
                echo $error[0]['message'];
            }
        }
    }

    function addEvent() {
        $token = $this->session->userdata('token');
        echo 'TOKEN :' . $this->session->userdata('token') . '<br>';
        if ($this->client->isAccessTokenExpired()) {
            $this->client->revokeToken();
            echo 'EXPIRED<br>';
            if ($this->client->isAccessTokenExpired()) {
                echo 'EXPIRED';
            } else {
                echo 'Not Expired..!';
            }
        } else {
            echo 'Not Expired..!';
        }
    }

}
