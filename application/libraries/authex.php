<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Authex {

    function Authex() {
        $CI = & get_instance();
    }

    function logged_in() {
        $CI = & get_instance();
        return ($CI->session->userdata("profileid") ) ? true : false;
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
        $CI = & get_instance();
        unset($where['remember']);
        $query = $CI->db->get_where("admin_profile", $where);
        if ($query->num_rows() !== 1) {
            /* their username and password combination
             * were not found in the databse */
            return FALSE;
        } else {
            $last_login = date("Y-m-d H-i-s");
            $data = array(
                "last_login" => $last_login
            );
            $CI->db->update("admin_profile", $data, array('userid' => $query->row()->userid));
            $where['userid'] = $query->row()->userid;
            $query = $CI->db->get_where('admin_profile', $where);
            $res = $query->row();
            $CI->session->set_userdata('profileid', $res->profile_id);
            $CI->session->set_userdata('userid', $res->profile_id);
            $CI->session->set_userdata('name', $res->fname . ' ' . $res->lname);
            $CI->session->set_userdata('email', $res->email);
            $CI->session->set_userdata('phone', $res->phone);
            $CI->session->set_userdata('avatar', $res->admin_avatar);
            unset($res);
            return TRUE;
        }
    }

    function logout() {
        $CI = & get_instance();
        $CI->session->sess_destroy();
    }

    function can_register($userid) {
        $CI = & get_instance();

        $query = $CI->db->get_where("admin_profile", array("userid" => $userid));

        return ($query->num_rows() < 1) ? true : false;
    }

    function isTrue($password) {
        $CI = & get_instance();
        $CI->db->select('password');
        $query = $CI->db->get_where("admin_profile", array("userid" => $CI->session->userdata("userid")));

        return ($password == $query->row()->password) ? true : false;
    }

}
