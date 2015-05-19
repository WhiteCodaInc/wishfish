<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Authex {

    private $_CI;

    function Authex() {
        $this->_CI = & get_instance();
    }

    function logged_in() {
        return ($this->_CI->session->userdata("userid") ) ? true : false;
    }

//    function clogged_in() {
//        $CI = & get_instance();
//        return ($CI->session->userdata("clientid")) ? true : false;
//    }
//
//    function slogged_in() {
//        $CI = & get_instance();
//        return ($CI->session->userdata("staffid")) ? true : false;
//    }
//    function alogged_in() {
//        $CI = & get_instance();
//        return ($CI->session->userdata("uname")) ? true : false;
//    }


    function login($where) {
        $query = $this->_CI->db->get_where("user_mst", $where);
        if ($query->num_rows() !== 1) {
            /* their username and password combination
             * were not found in the databse */
            return FALSE;
        } else {
            $last_login = date("Y-m-d H-i-s");
            $data = array(
                "last_login" => $last_login
            );
            $this->_CI->db->update("user_mst", $data, array('user_id' => $query->row()->user_id));
            $where['user_id'] = $query->row()->user_id;
            $query = $this->_CI->db->get_where('user_mst', $where);
            $res = $query->row();
            $this->_CI->session->set_userdata('userid', $res->user_id);
            $this->_CI->session->set_userdata('name', $res->name);
            $this->_CI->session->set_userdata('email', $res->email);
            $this->_CI->session->set_userdata('profile_pic', $res->profile_pic);
            $this->_CI->session->set_userdata('timezone', $res->timezones);
            $this->_CI->session->set_userdata('date_format', $res->date_format);
            unset($res);
            return TRUE;
        }
    }

    function isActivePlan() {
        $userid = $this->_CI->session->userdata('userid');
        $this->_CI->db->select('id');
        $query = $this->_CI->db->get_where('plan_detail', array('user_id' => $userid, 'plan_status' => 1));
        $query->result();
        return ($query->num_rows() > 0) ? true : false;
    }

    function logout() {
        $CI = & get_instance();
        if ($CI->session->userdata('token')) {
            header('location:' . site_url() . 'register/logout');
        } else {
            $CI->session->sess_destroy();
            header('location:' . site_url() . 'login');
        }
    }

    function can_register($email) {
        $query = $this->_CI->db->get_where("user_mst", array("email" => $email));
        return ($query->num_rows() > 0) ? FALSE : TRUE;
    }

    function isTrue($password) {
        $this->_CI->db->select('password');
        $query = $this->_CI->db->get_where("login", array("login_id" => $this->_CI->session->userdata("loginid")));
        return ($password == $query->row()->password) ? true : false;
    }

    function loginBySocial($gid) {
        $query = $this->_CI->db->get_where("user_mst", array("user_unique_id" => $gid));
        $res = $query->row();

        if ($query->num_rows() == 1) {
            $this->_CI->session->set_userdata('userid', $res->user_id);
            $this->_CI->session->set_userdata('name', $res->name);
            $this->_CI->session->set_userdata('email', $res->email);
            $this->_CI->session->set_userdata('profile_pic', $res->profile_pic);
            $this->_CI->session->set_userdata('timezone', $res->timezones);
            $this->_CI->session->set_userdata('date_format', $res->date_format);
            return TRUE;
        } else {
            return FALSE;
        }
    }

//    function loginByFacebook($fid) {
//        $query = $this->_CI->db->get_where("user_mst", array("user_unique_id" => $fid));
//        $res = $query->row();
//        if ($query->num_rows() == 1) {
//            $this->_CI->session->set_userdata('userid', $res->user_id);
//            $this->_CI->session->set_userdata('name', $res->name);
//            $this->_CI->session->set_userdata('email', $res->email);
//            $this->_CI->session->set_userdata('profile_pic', $res->profile_pic);
//            $this->_CI->session->set_userdata('timezone', $res->timezones);
//            $this->_CI->session->set_userdata('date_format', $res->date_format);
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
}
