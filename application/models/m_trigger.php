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

    function getEvents() {
        $where = array(
            'status' => 1,
            'notification' => 1
        );
        $this->db->select('*,HOUR(time) as h,MINUTE(time) as m');
        $query = $this->db->get_where('wi_schedule', $where);
        return $query->result();
    }

    function updateStatus($eventid) {
        $set = array(
            'status' => 0,
            'color' => '#00a65a'
        );
        $this->db->update('wi_schedule', $set, array('event_id' => $eventid));
    }

    function getRepeatedEvent() {
        $where = array(
            'occurance !=' => 0,
            'notification' => 1,
            'is_repeat' => 1
        );
        $this->db->select('*,HOUR(time) as h,MINUTE(time) as m');
        $query = $this->db->get_where('wi_schedule', $where);
        return $query->result();
    }

    function updateOccurance($eid, $occur) {
        $this->db->update('wi_schedule', array('occurance' => --$occur), array('event_id' => $eid));
        return true;
    }

    function getGroupContact($gid) {
        $res = array();
        $query = $this->db->get_where('wi_contact_groups', array('group_id' => $gid));
        $res[] = $query->row();

        $this->db->select('contact_id');
        $query = $this->db->get_where('wi_multiple_contact_group', array('group_id' => $gid));
        $contact = array();
        foreach ($query->result() as $value) {
            $contact[] = $value->contact_id;
        }
        $res[] = $contact;
        return $res;
    }

}
