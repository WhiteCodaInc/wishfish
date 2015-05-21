<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_admin_login
 *
 * @author Laxmisoft
 */
class M_trigger extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    function getEvents($curr_date) {
        $where = array(
            'date' => $curr_date,
            'status' => 1,
            'notification' => 1
        );
        $this->db->select('*,HOUR(time) as h,MINUTE(time) as m');
        $query = $this->db->get_where('schedule', $where);
        return $query->result();
    }

    function updateStatus($eventid) {
        $set = array(
            'status' => 0,
            'color' => '#00a65a'
        );
        $this->db->update('schedule', $set, array('event_id' => $eventid));
    }

    function getRepeatedEvent() {
        $where = array(
            'occurance !=' => 0,
            'notification' => 1,
            'is_repeat' => 1
        );
        $this->db->select('*,HOUR(time) as h,MINUTE(time) as m');
        $query = $this->db->get_where('schedule', $where);
        return $query->result();
    }

    function updateOccurance($eid, $occur) {
        $this->db->update('schedule', array('occurance' => --$occur), array('event_id' => $eid));
        return true;
    }

}
