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

    function __construct() {
        parent::__construct();
    }

    function createEvent($type, $userid) {
        switch ($type) {
            case 'admin':
                $query = $this->db->get_where('admin_profile', array('profile_id' => $userid));
                break;
            case 'contact':
                $query = $this->db->get_where('contact_detail', array('contact_id' => $userid));
                break;
            case 'affiliate':
                $query = $this->db->get_where('affiliate_detail', array('affiliate_id' => $userid));
                break;
            case 'customer':
                $query = $this->db->get_where('customer_detail', array('customer_id' => $userid));
                break;
        }
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
                unset($post['user_id']);
                $post['group_type'] = "simple";
                break;
            case 'all_l':
                $post['group_type'] = $post['event_type'];
                break;
            default:
                break;
        }
        if (isset($post['userid'])) {
            $post['user_id'] = $post['userid'];
            $post['date'] = date('Y-m-d', strtotime($post['date']));
            unset($post['userid']);
        }
        $post['is_repeat'] = (isset($post['is_repeat']) && $post['is_repeat'] == "on") ? 1 : 0;
        $post['body'] = ($post['event_type'] == "sms" || $post['event_type'] == "notification") ? $post['smsbody'] : $post['emailbody'];
        $post['notification'] = ($post['event_type'] == "notification") ? 0 : 1;
        $post['occurance'] = ($post['occurance'] != "") ? $post['occurance'] : NULL;
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
        //-------------------Get Total Event In Month------------------------//
        $where = array(
            'date >=' => $start,
            'date <' => $end
        );
        $this->db->select('count(*) as totalM');
        $query = $this->db->get_where('schedule', $where);
        $res['totalM'] = $query->row()->totalM;

        //-------------------Get Total Event In Year------------------------//
        $where = array(
            'YEAR(date)' => date('Y', strtotime($start))
        );
        $this->db->select('count(*) as totalY');
        $query = $this->db->get_where('schedule', $where);
        $res['totalY'] = $query->row()->totalY;

        //-------------------Get Total Event In Week------------------------//
        $where = array(
            'date >=' => (date('D') != 'Sun') ? date('Y-m-d', strtotime('last Sunday')) : date('Y-m-d'),
            'date <=' => (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d')
        );
        $this->db->select('count(*) as totalW');
        $query = $this->db->get_where('schedule', $where);
        $res['totalW'] = $query->row()->totalW;

        //-------------------Get Total Event In Day------------------------//
        $where = array(
            'date' => date('Y-m-d')
        );
        $this->db->select('count(*) as totalD');
        $query = $this->db->get_where('schedule', $where);
        $res['totalD'] = $query->row()->totalD;
        return $res;
    }

    function getEvents($post) {
        $start = gmdate("Y-m-d", $post['start']);
        $end = gmdate("Y-m-d", $post['end']);

        $where = array(
            'date >=' => $start,
            'date <' => $end
        );
        $this->db->select('event_id,event,concat(date," ",time) as date,color', FALSE);
        $query = $this->db->get_where('schedule', $where);
        echo json_encode($query->result_array());
    }

    function getEvent($eid) {
        $query = $this->db->get_where('schedule', array('event_id' => $eid));
        $res = $query->row();
        switch ($res->user) {
            case "1":
                $this->db->select('*,concat(fname," ",lname) as name,concat(DATE_FORMAT(date,"%M %d")," at ",TIME_FORMAT(time, "%h:%i %p")) as date,DATE_FORMAT(date,"%d-%m-%Y") as cal_dt', FALSE);
                $this->db->from('schedule as S');
                $this->db->join('admin_profile as A', 'S.user_id = A.profile_id', 'left outer');
                $this->db->where('event_id', $eid);
                $query = $this->db->get();
                $result = $query->row();
                break;
            case "2":
                $this->db->select('*,concat(fname," ",lname) as name,concat(DATE_FORMAT(date,"%M %d")," at ",TIME_FORMAT(time, "%h:%i %p")) as date,DATE_FORMAT(date,"%d-%m-%Y") as cal_dt', FALSE);
                $this->db->from('schedule as S');
                $this->db->join('contact_detail as C', 'S.user_id = C.contact_id', 'left outer');
                $this->db->join('contact_groups as G', 'S.group_id = G.group_id', 'left outer');
                $this->db->where('event_id', $eid);
                $query = $this->db->get();
                $result = $query->row();
                break;
            case "3":
                $this->db->select('*,concat(fname," ",lname) as name,concat(DATE_FORMAT(date,"%M %d")," at ",TIME_FORMAT(time, "%h:%i %p")) as date,DATE_FORMAT(date,"%d-%m-%Y") as cal_dt', FALSE);
                $this->db->from('schedule as S');
                $this->db->join('affiliate_detail as A', 'S.user_id = A.affiliate_id', 'left outer');
                $this->db->join('affiliate_groups as G', 'S.group_id = G.group_id', 'left outer');
                $this->db->where('event_id', $eid);
                $query = $this->db->get();
                $result = $query->row();
                break;
            case "4":
                $this->db->select('*,concat(fname," ",lname) as name,concat(DATE_FORMAT(date,"%M %d")," at ",TIME_FORMAT(time, "%h:%i %p")) as date,DATE_FORMAT(date,"%d-%m-%Y") as cal_dt', FALSE);
                $this->db->from('schedule as S');
                $this->db->join('customer_detail as C', 'S.user_id = C.customer_id', 'left outer');
                $this->db->join('customer_groups as G', 'S.group_id = G.group_id', 'left outer');
                $this->db->where('event_id', $eid);
                $query = $this->db->get();
                $result = $query->row();
                break;
        }
        return $result;
    }

    function deleteEvent($eid) {
        if ($this->db->delete('schedule', array('event_id' => $eid))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function updateEvent() {
        $flag = FALSE;
        $set = $this->input->post();
        $eid = $set['eventid'];
        unset($set['eventid']);
        $query = $this->db->get_where('schedule', array('event_id' => $eid));
        $result = $query->result_array();
        $res = $result[0];
        $this->db->trans_start();
        if (isset($set['event'])) {
            $set['date'] = ($set['date'] != "") ? date('Y-m-d', strtotime($set['date'])) : $res['date'];
            $set['is_repeat'] = (isset($set['is_repeat']) && $set['is_repeat'] == "on") ? 1 : 0;
            $set['body'] = ($set['event_type'] == "sms" || $set['event_type'] == "notification") ?
                    $set['smsbody'] :
                    $set['emailbody'];
            $set['notification'] = (isset($set['notification']) && $set['notification'] == "on") ? 0 : 1;
            unset($set['smsbody']);
            unset($set['emailbody']);

            //print_r($res);
            //print_r($set);
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
                //die("RES[IS_REPEAT] : 1 && SET[IS_REPEAT] == 0");
            } else if ($res['is_repeat'] == 1 && $set['is_repeat'] == 1) {
                if ($res['occurance'] != $set['occurance']) {
                    $this->db->delete('schedule', array('refer_id' => $eid));
                    $flag = TRUE;
                }
                //die("IS REPEAT : 1 && SET[IS_REPEAT] == 1");
            } else if ($res['is_repeat'] == 0 && $set['is_repeat'] == 0 && !is_null($res['refer_id'])) {
                $set['occurance'] = NULL;
                $set['end_type'] = NULL;
                $flag = FALSE;
                //die("RES[IS REPEAT] : 0 && SET[IS_REPEAT] == 0 && RES[REFER_ID] != NULL");
            }
            //print_r($res);
            //print_r($set);
            //die();

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
        }
        $set['color'] = "#0073b7";
        $this->db->update('schedule', $set, array('event_id' => $eid));
        $this->db->trans_complete();
        if ($this->db->trans_status()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
