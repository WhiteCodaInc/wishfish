<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Wi_authex {

    private $_CI;

    function __construct() {
        $this->_CI = & get_instance();
    }

    function logged_in() {
        return ($this->_CI->session->userdata("u_userid") ) ? true : false;
    }

    function alogged_in() {
        return ($this->_CI->session->userdata("a_affid") ) ? true : false;
    }

    function login($where) {

        (isset($where['password'])) ? $where['password'] = sha1($where['password']) : '';

        $query = $this->_CI->db->get_where('wi_user_mst', $where);

        if ($query->num_rows() !== 1) {
            /* their username and password combination
             * were not found in the databse */
            return FALSE;
        } else if ($query->row()->status) {
//            $last_login = date("Y-m-d H-i-s");
            $last_login = $this->_CI->wi_common->getUTCDateWithTime($query->row()->timezones);
            $data = array(
                "is_login" => 1,
                "last_login" => $last_login
            );
            $this->_CI->db->update('wi_user_mst', $data, array('user_id' => $query->row()->user_id));
            $where['user_id'] = $query->row()->user_id;
            $query = $this->_CI->db->get_where('wi_user_mst', $where);
            $res = $query->row();
            $this->_CI->session->set_userdata('u_userid', $res->user_id);
            $this->_CI->session->set_userdata('u_name', $res->name);
            $this->_CI->session->set_userdata('u_email', $res->email);
            $this->_CI->session->set_userdata('u_profile_pic', $res->profile_pic);
            $this->_CI->session->set_userdata('u_timezone', $res->timezones);
            $this->_CI->session->set_userdata('u_date_format', $res->date_format);
            unset($res);
            return TRUE;
        } else {
            return -1;
        }
    }

    function alogin($where) {

        (isset($where['password'])) ? $where['password'] = sha1($where['password']) : '';

        $query = $this->_CI->db->get_where('affiliate_detail', $where);

        if ($query->num_rows() !== 1) {
            /* their username and password combination
             * were not found in the databse */
            return FALSE;
        } else if ($query->row()->status) {
            $last_login = date("Y-m-d H-i-s");
            $last_login = $this->_CI->wi_common->getUTCDateWithTime($query->row()->timezones);
            $data = array(
//                "is_login" => 1,
                "last_login" => $last_login
            );
            $this->_CI->db->update('affiliate_detail', $data, array('affiliate_id' => $query->row()->affiliate_id));
            $where['affiliate_id'] = $query->row()->affiliate_id;
            $query = $this->_CI->db->get_where('affiliate_detail', $where);
            $res = $query->row();
            $this->_CI->session->set_userdata('a_affid', $res->affiliate_id);
            $this->_CI->session->set_userdata('a_name', $res->fname . ' ' . $res->lname);
            $this->_CI->session->set_userdata('a_email', $res->email);
            $this->_CI->session->set_userdata('a_avatar', $res->affiliate_avatar);
            $this->_CI->session->set_userdata('a_timezone', $res->timezones);
            $this->_CI->session->set_userdata('a_date_format', $res->date_format);
            unset($res);
            return TRUE;
        } else {
            return -1;
        }
    }

    function isActivePlan() {
        $userid = $this->_CI->session->userdata('u_userid');
        $where = array(
            'user_id' => $userid,
            'plan_status' => 1
        );
        $this->_CI->db->select('*');
        $query = $this->_CI->db->get_where('wi_plan_detail', $where);
        return ($query->num_rows() && $query->row()->is_lifetime != '0') ? true : false;
    }

    function logout() {
        $CI = & get_instance();
        $uid = $this->_CI->session->userdata("u_userid");
        $data = array(
            "is_login" => 0
        );
        $this->_CI->db->update('wi_user_mst', $data, array('user_id' => $uid));
        $sess = array(
            'u_userid' => '',
            'u_name' => '',
            'u_email' => '',
            'u_profile_pic' => '',
            'u_timezone' => '',
            'u_date_format' => ''
        );
        $CI->session->unset_userdata($sess);
    }

    function alogout() {
        $CI = & get_instance();
        $sess = array(
            'a_affid' => '',
            'a_name' => '',
            'a_email' => '',
            'a_avatar' => '',
            'a_timezone' => '',
            'a_date_format' => ''
        );
        $CI->session->unset_userdata($sess);
    }

    function can_register($email) {
        $query = $this->_CI->db->get_where("wi_user_mst", array("email" => $email));
        $res = $query->row();
        if ($query->num_rows() !== 1) {
            return false;
        } else {
            if ($res->join_type == NULL) {
                return "RN";
            } else if ($res->join_type == "google") {
                return "RG";
            } else if ($res->join_type == "facebook") {
                return "RF";
            }
        }
//        return ($query->num_rows() > 0) ? FALSE : TRUE;
    }

    function aff_can_register($email) {
        $query = $this->_CI->db->get_where("affiliate_detail", array("email" => $email));
        return ($query->num_rows() > 0) ? FALSE : TRUE;
    }

    function email_exists($email) {
        $query = $this->_CI->db->get_where("wi_user_mst", array("email" => $email));
        return ($query->num_rows() === 1) ? true : false;
    }

    function aemail_exists($email) {
        $query = $this->_CI->db->get_where("affiliate_detail", array("email" => $email));
        return ($query->num_rows() === 1) ? true : false;
    }

    function isTrue($password) {
        $this->_CI->db->select('password');
        $query = $this->_CI->db->get_where("login", array("login_id" => $this->_CI->session->userdata("loginid")));
        return ($password == $query->row()->password) ? true : false;
    }

    function loginBySocial($gid) {
        $query = $this->_CI->db->get_where("wi_user_mst", array("user_unique_id" => $gid));
        $res = $query->row();
        if ($query->num_rows() !== 1) {
            return false;
        } else if ($res->status) {
            $this->_CI->session->set_userdata('u_userid', $res->user_id);
            $this->_CI->session->set_userdata('u_name', $res->name);
            $this->_CI->session->set_userdata('u_email', $res->email);
            $this->_CI->session->set_userdata('u_profile_pic', $res->profile_pic);
            $this->_CI->session->set_userdata('u_timezone', $res->timezones);
            $this->_CI->session->set_userdata('u_date_format', $res->date_format);
            return TRUE;
        } else {
            return -1;
        }
    }

}
