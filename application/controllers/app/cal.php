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
        $this->client->setScopes("https://www.googleapis.com/auth/calendar.readonly");

        $this->service = new Google_CalendarService($this->client);
    }

    function index() {
        $this->client->setApprovalPrompt('auto');
        header('location:' . $this->client->createAuthUrl());
    }

    public function events() {
        if ($this->input->get('error') == "access_denied") {
            header('location:' . site_url() . 'app/dashboard');
        }
        $code = $this->input->get('code');

        if (isset($code) && $code != "") {
            $this->client->authenticate($code);
            $this->session->set_userdata('token', $this->client->getAccessToken());
            if ($this->client->getAccessToken()) {
                try {
                    $calendarList = $this->service->calendarList->listCalendarList();
                    print_r($calendarList);
                    die();
                    while (true) {
                        foreach ($calendarList->getItems() as $calendarListEntry) {

                            echo $calendarListEntry->getSummary() . "<br>\n";


                            // get events 
                            $events = $this->service->events->listEvents($calendarListEntry->id);


                            foreach ($events->getItems() as $event) {
                                echo "-----" . $event->getSummary() . "<br>";
                            }
                        }
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
    }

}
