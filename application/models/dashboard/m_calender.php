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
class M_calender extends CI_Model {

    private $userid;

    function __construct() {
        parent::__construct();
        $this->userid = $this->session->userdata('userid');
    }

    function getSMSTemplate($tmpid) {
        $where = array(
            'template_id' => $tmpid,
            'user_id' => $this->userid
        );
        $query = $this->db->get_where('sms_template', $where);
        $res = $query->result_array();
        echo json_encode($res[0]);
    }

    function getEmailTemplate($tmpid) {
        $where = array(
            'template_id' => $tmpid,
            'user_id' => $this->userid
        );
        $query = $this->db->get_where('email_template', $where);
        $res = $query->result_array();
        echo json_encode($res[0]);
    }

    function createEvent($contactid) {
        $where = array(
            'contact_id' => $contactid,
            'user_id' => $this->userid
        );
        $query = $this->db->get_where('contact_detail', $where);
        if ($query->num_rows() == 1) {
            $res = $query->row();
        } else {
            $res = FALSE;
        }
        return $res;
    }

    function addEvent($post) {
        switch ($post['assign']) {
            case 'all_c':
                $post['group_type'] = "individual";
                break;
            case 'all_gc':
                unset($post['contact_id']);
                $post['group_type'] = "simple";
                break;
            default:
                break;
        }
        if (isset($post['contactid'])) {
            $post['contact_id'] = $post['contactid'];
            unset($post['contactid']);
        }

        $post['date'] = $this->common->getMySqlDate($post['date'], $this->session->userdata('date_format'));
        $post['is_repeat'] = (isset($post['is_repeat']) && $post['is_repeat'] == "on") ? 1 : 0;
        $post['body'] = ($post['event_type'] == "sms" || $post['event_type'] == "notification") ? $post['smsbody'] : $post['emailbody'];
        $post['notification'] = ($post['event_type'] == "notification") ? 0 : 1;
        $post['occurance'] = ($post['occurance'] != "") ? $post['occurance'] : NULL;
        $post['user_id'] = $this->userid;
        unset($post['assign']);
        unset($post['smsbody']);
        unset($post['emailbody']);

        $this->db->trans_start();
        $post['color'] = "#0073b7";
        $this->db->insert('schedule', $post);
        $insertid = $this->db->insert_id();
        if ($post['freq_type'] != "-1" && $post['freq_no'] != "-1" && is_numeric($post['occurance'])) {
            $post['refer_id'] = $insertid;
            $dt = $post['date'];
            for ($i = $post['occurance'] - 1; $i > 0; $i--) {
                $post['is_repeat'] = 0;
                $total = $post['freq_no'] * ($post['occurance'] - $i);
                $post['date'] = $this->common->getNextDate($dt, $total . ' ' . $post['freq_type']);
                $this->db->insert('schedule', $post);
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getCards() {
        $res = array();

        $start = date('Y-m-01'); // hard-coded '01' for first day
        $end = date('Y-m-t');
//        $start = ($post['start'] != "") ? gmdate("Y-m-d", $post['start']) : date('Y-m-01');
//        $end = ($post['end'] != "") ? gmdate("Y-m-d", $post['end']) : date('Y-m-t');
//        
        //-------------------Get Total Event In Month------------------------//
        $where = array(
            'date >=' => $start,
            'date <=' => $end,
            'user_id' => $this->userid
        );
        $this->db->select('event_id,event,date,color,concat(DATE_FORMAT(date,"%M %d")," at ",TIME_FORMAT(time, "%h:%i %p")) as format_date,DATE_FORMAT(date,"%d-%m-%Y") as cal_dt', FALSE);
        $query = $this->db->get_where('schedule', $where);
//        $res['totalM'] = $query->row()->totalM;
        $res['totalM'] = $query->result();

        //-------------------Get Total Event In Year------------------------//
        $where = array(
            'YEAR(date)' => date('Y', strtotime($start)),
            'user_id' => $this->userid
        );
        $this->db->select('event_id,event,date,color,concat(DATE_FORMAT(date,"%M %d")," at ",TIME_FORMAT(time, "%h:%i %p")) as format_date,DATE_FORMAT(date,"%d-%m-%Y") as cal_dt', FALSE);
        $query = $this->db->get_where('schedule', $where);
//        $res['totalY'] = $query->row()->totalY;
        $res['totalY'] = $query->result();

        //-------------------Get Total Event In Week------------------------//
        $where = array(
            'date >=' => (date('D') != 'Sun') ? date('Y-m-d', strtotime('last Sunday')) : date('Y-m-d'),
            'date <=' => (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d'),
            'user_id' => $this->userid
        );
        $this->db->select('event_id,event,date,color,concat(DATE_FORMAT(date,"%M %d")," at ",TIME_FORMAT(time, "%h:%i %p")) as format_date,DATE_FORMAT(date,"%d-%m-%Y") as cal_dt', FALSE);
        $query = $this->db->get_where('schedule', $where);
//        $res['totalW'] = $query->row()->totalW;
        $res['totalW'] = $query->result();

        //-------------------Get Total Event In Day------------------------//
        $where = array(
            'date' => date('Y-m-d'),
            'user_id' => $this->userid
        );
        $this->db->select('event_id,event,date,color,concat(DATE_FORMAT(date,"%M %d")," at ",TIME_FORMAT(time, "%h:%i %p")) as format_date,DATE_FORMAT(date,"%d-%m-%Y") as cal_dt', FALSE);
        $query = $this->db->get_where('schedule', $where);
//        $res['totalD'] = $query->row()->totalD;
        $res['totalD'] = $query->result();
        return $res;
    }

    function getEvents($post) {
        $start = gmdate("Y-m-d", $post['start']);
        $end = gmdate("Y-m-d", $post['end']);

        $where = array(
            'date >=' => $start,
            'date <' => $end,
            'user_id' => $this->userid
        );
        $this->db->select('event_id,event,concat(date," ",time) as date,color', FALSE);
        $query = $this->db->get_where('schedule', $where);
        echo json_encode($query->result_array());
    }

    function getEvent($eid) {
        $this->db->select('*,concat(fname," ",lname) as name,concat(DATE_FORMAT(date,"%M %d")," at ",TIME_FORMAT(time, "%h:%i %p")) as date,date as format_date', FALSE);
        $this->db->from('schedule as S');
        $this->db->join('contact_detail as C', 'S.contact_id = C.contact_id', 'left outer');
        $this->db->join('contact_groups as G', 'S.group_id = G.group_id', 'left outer');
        $this->db->where('event_id', $eid);
        $query = $this->db->get();
        $result = $query->row();
        $result->format_date = $this->common->getUTCDate($result->format_date);
        return $result;
    }

    function deleteEvent($eid) {
        if ($this->db->delete('schedule', array('event_id' => $eid))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function updateEvent($set) {
        $flag = FALSE;
        $checkFlag = TRUE;
        $msg = "";
        $eid = $set['eventid'];
        unset($set['eventid']);
        $query = $this->db->get_where('schedule', array('event_id' => $eid));
        $result = $query->result_array();
        $res = $result[0];

        //---------------Check Total Event For Updating New Event-------------//
        $currPlan = $this->common->getCurrentPlan();
        $total = $this->checkTotalEvent($res['contact_id']);
        switch ($set['event_type']) {
            case "email":
                if (isset($total['email']) && $total['email'] >= $currPlan->email_events + 1)
                    $checkFlag = FALSE;
                break;
            case "sms":
                if (isset($total['sms']) && $total['sms'] >= $currPlan->sms_events + 1)
                    $checkFlag = FALSE;
                break;
        }
        //--------------------------------------------------------------------//
        if ($checkFlag) {
            $this->db->trans_start();
            $set['date'] = ($set['date'] != "") ?
                    $this->common->getMySqlDate($set['date'], $this->session->userdata('date_format')) :
                    $res['date'];
            $set['is_repeat'] = (isset($set['is_repeat']) && $set['is_repeat'] == "on") ? 1 : 0;
            $set['body'] = ($set['event_type'] == "sms" || $set['event_type'] == "notification") ?
                    $set['smsbody'] :
                    $set['emailbody'];
            $set['notification'] = (isset($set['notification']) && $set['notification'] == "on") ? 0 : 1;
            unset($set['smsbody']);
            unset($set['emailbody']);

            if ($res['is_repeat'] == 0 && is_null($res['refer_id'])) {
                if ($set['is_repeat']) {
                    $flag = TRUE;
                } else {
                    $set['occurance'] = NULL;
                    $set['end_type'] = NULL;
                }
            } else if ($res['is_repeat'] == 1 && $set['is_repeat'] == 0) {
                $this->db->delete('schedule', array('refer_id' => $eid));
                $flag = FALSE;
            } else if ($res['is_repeat'] == 1 && $set['is_repeat'] == 1) {
                if ($res['occurance'] != $set['occurance']) {
                    $this->db->delete('schedule', array('refer_id' => $eid));
                    $flag = TRUE;
                }
            } else if ($res['is_repeat'] == 0 && $set['is_repeat'] == 0 && !is_null($res['refer_id'])) {
                $set['occurance'] = NULL;
                $set['end_type'] = NULL;
                $flag = FALSE;
            }
            if ($flag) {
                $res = array_merge($res, $set);
                $res['refer_id'] = $res['event_id'];
                unset($res['event_id']);
                $res['is_repeat'] = 0;
                for ($i = $set['occurance'] - 1; $i > 0; $i--) {
                    $total = $set['freq_no'] * ($set['occurance'] - $i);
                    $res['date'] = $this->common->getNextDate($set['date'], $total . ' ' . $set['freq_type']);
                    $this->db->insert('schedule', $res);
                }
            }
            $set['color'] = "#0073b7";
            $this->db->update('schedule', $set, array('event_id' => $eid));
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $msg = "U";
            } else {
                $msg = "UF";
            }
        } else {
            $msg = "NA";
        }
        return $msg;
    }

    function checkTotalEvent($contactid) {
        $res = array();
        $this->db->select('event_type,count(event_type) as total');
        $this->db->group_by('event_type');
        $query = $this->db->get_where('schedule', array('contact_id' => $contactid));
        foreach ($query->result() as $value) {
            $res[$value->event_type] = $value->total;
        }
        return $res;
    }

    function checkTotalGroupEvent($groupid) {
        $this->db->select('count(event_id) as total');
        $query = $this->db->get_where('schedule', array('user_id' => $this->userid, 'group_id' => $groupid));
        return ($query->num_rows() == 1) ? $query->row() : FALSE;
    }

}
