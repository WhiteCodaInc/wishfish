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
class M_comment extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profile_id');
    }

    function getCommentDetail() {
        $this->db->select('comment_id,blog_id,name,email,comment,status,DATE(date) as dt');
        $this->db->order_by('date', 'desc');
        $query = $this->db->get('blog_comment');
        return $query->result();
    }

    function searchResult() {
        $post = $this->input->post();
        $name = $post['name_search'];
        $email = $post['email_search'];
        $from = $post['from_search'];
        $to = $post['to_search'];
        $blog = $post['blog_search'];
        $status = $post['status_search'];

        ($name != "") ? $this->db->like('name', $name) : '';
        ($email != "") ? $this->db->like('email', $email) : '';
        ($from != "") ? $where['DATE(date) >='] = date('Y-m-d', strtotime($from)) : '';
        ($to != "") ? $where['DATE(date) <='] = date('Y-m-d', strtotime($to)) : '';
        ($status != "" && $status != "-1") ? $where['status'] = $status : '';
        ($blog != "" && $blog != "-1") ? $where['blog_id'] = $blog : '';

        $this->db->select('comment_id,blog_id,name,email,comment,status,DATE(date) as dt');
        $this->db->from('blog_comment');
        $this->db->order_by('date', 'desc');
        (isset($where) && is_array($where)) ? $this->db->where($where) : '';
        $query = $this->db->get();
        return $query->result();
    }

    function setAction($type) {
        $msg = "";
        switch ($type) {
            case "Delete":
                $ids = $this->input->post('comment');
                if (is_array($ids) && count($ids) > 0) {
                    foreach ($ids as $value) {
                        $this->db->delete('blog_comment', array('comment_id' => $value));
                    }
                    $msg = "D";
                } else {
                    $msg = FALSE;
                }
                break;
            case "Approve":
                $ids = $this->input->post('comment');
                if (is_array($ids) && count($ids) > 0) {
                    $this->db->where_in('comment_id', $ids);
                    $this->db->update('blog_comment', array('status' => 1));
                    $msg = "A";
                } else {
                    $msg = FALSE;
                }
                break;
            case "Disapprove":
                $ids = $this->input->post('comment');
                if (is_array($ids) && count($ids) > 0) {
                    $this->db->where_in('comment_id', $ids);
                    $this->db->update('blog_comment', array('status' => 0));
                    $msg = "DA";
                } else {
                    $msg = FALSE;
                }
                break;
        }
        return $msg;
    }

}
