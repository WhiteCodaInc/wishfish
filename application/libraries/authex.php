<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Authex {

    private $_CI;

    function __construct() {
        $this->_CI = & get_instance();
    }

    function logged_in() {

        return ($this->_CI->session->userdata("profileid") ) ? true : false;
    }

//    function clogged_in() {
//        
//        return ($this->_CI->session->userdata("clientid")) ? true : false;
//    }
//
//    function slogged_in() {
//        
//        return ($this->_CI->session->userdata("staffid")) ? true : false;
//    }
//    function alogged_in() {
//        
//        return ($this->_CI->session->userdata("uname")) ? true : false;
//    }

    function login($where) {

        unset($where['remember']);
        $query = $this->_CI->db->get_where("admin_profile", $where);
        if ($query->num_rows() !== 1) {
            /* their username and password combination
             * were not found in the databse */
            return FALSE;
        } else {
            $last_login = date("Y-m-d H-i-s");
            $data = array(
                "last_login" => $last_login
            );
            $this->_CI->db->update("admin_profile", $data, array('userid' => $query->row()->userid));
            $where['userid'] = $query->row()->userid;
            $query = $this->_CI->db->get_where('admin_profile', $where);
            $res = $query->row();
            $this->_CI->session->set_userdata('profileid', $res->profile_id);
//            $this->_CI->session->set_userdata('userid', $res->profile_id);
            $this->_CI->session->set_userdata('name', $res->fname . ' ' . $res->lname);
            $this->_CI->session->set_userdata('email', $res->email);
            $this->_CI->session->set_userdata('phone', $res->phone);
            $this->_CI->session->set_userdata('avatar', $res->admin_avatar);
            unset($res);
            return TRUE;
        }
    }

    function logout() {

        $this->_CI->session->sess_destroy();
    }

    function can_register($userid) {


        $query = $this->_CI->db->get_where("admin_profile", array("userid" => $userid));

        return ($query->num_rows() < 1) ? true : false;
    }

    function isTrue($password) {

        $this->_CI->db->select('password');
        $query = $this->_CI->db->get_where("admin_profile", array("userid" => $this->_CI->session->userdata("userid")));

        return ($password == $query->row()->password) ? true : false;
    }

}
