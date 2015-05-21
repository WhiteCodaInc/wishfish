<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of birthday
 *
 * @author Laxmisoft
 */
class Birthday extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->library('common');
    }

    function index() {
        $query = $this->db->get('contact_detail');
        echo "<pre>";
        foreach ($query->result() as $value) {
            if ($value->birthday != NULL && !$this->isAlreadySchedule($value)) {
                $event_data = array(
                    'event' => 'Birthday : ' . $value->fname,
                    'event_type' => "notification",
                    'group_type' => "individual",
                    'user_id' => $value->contact_id,
                    'user' => "2",
                    'color' => "#BDBDBD",
                    'notification' => "0",
                    'notify' => "them"
                );



                $curr = date('Y');
                $bdate = date('Y', strtotime($value->birthday));
                $diff = $curr - $bdate;
                echo "<br>DIFF : " . $diff . '<br>';

                if (date('m-d', strtotime($value->birthday)) >= date('m-d')) {

                    echo "<br>--Smaller--<br>";
                    echo "<br>Birthday : {$value->birthday}<br>";
                    echo "DIFF_UPDATE : {$diff}<br>";

                    $date = new DateTime($value->birthday);
                    date_add($date, date_interval_create_from_date_string("{$diff} years"));
                    $event_data['date'] = date_format($date, 'Y-m-d');
                    print_r($event_data);
                } else {
                    $diff++;
                    echo "<br>--Bigger--<br>";
                    echo "<br>Birthday : {$value->birthday}<br>";
                    echo "DIFF_UPDATE : {$diff}<br>";
                    $date = new DateTime($value->birthday);
                    date_add($date, date_interval_create_from_date_string("{$diff} years"));
                    $event_data['date'] = date_format($date, 'Y-m-d');
                    print_r($event_data);
                }
                $this->db->insert('schedule', $event_data);
            } else {
                echo "<br>------------Skipped----------------<br>";
                echo "{$value->fname} {$value->lname}";
            }
        }
    }

    function isAlreadySchedule($contact) {
        $where = array(
            'user_id' => $contact->contact_id,
            'event' => "Birthday : " . $contact->fname,
            'user' => 2
        );
        $query = $this->db->get_where('schedule', $where);
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
