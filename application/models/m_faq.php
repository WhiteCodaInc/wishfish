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
class M_faq extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function search($queid) {
        $query = $this->db->get_where('wi_faqs', array('faq_id' => $queid));
        return ($query->num_rows() > 0) ? $query->result() : FALSE;
    }

    function getSearchTerm() {
        $json_arr = array();
        $display_json = array();
        $get = $this->input->get();
        $this->db->like('question', $get['term']);
        $query = $this->db->get('wi_faqs');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $value) {
                $json_arr['url'] = site_url() . 'faq/search?id=' . $value->faq_id;
                $json_arr['value'] = $value->question;
                array_push($display_json, $json_arr);
            }
        } else {
            $json_arr["url"] = "#";
            $json_arr["value"] = "No Result Found !";
            array_push($display_json, $json_arr);
        }
        $jsonWrite = json_encode($display_json); //encode that search data
        print $jsonWrite;
    }

    function getFirst() {
        $this->db->limit(1);
        $this->db->order_by('order', 'asc');
        $query = $this->db->get('wi_faq_categories');
        if ($query->num_rows() > 0) {
            $res['category'] = $query->row();
            $query = $this->db->get_where('wi_faqs', array('category_id' => $res['category']->category_id));
            $res['questions'] = $query->result();
            return $res;
        } else {
            return false;
        }
    }

    function getAllQuestions() {
        $query = $this->db->get('wi_faqs');
        return $query->result();
    }

    function getQuestions($catid) {
        $query = $this->db->get_where('wi_faqs', array('category_id' => $catid));
        return $query->result();
    }

    function getFaqDetail() {
        $this->db->select('*');
        $this->db->from('faqs as F');
        $this->db->join('faq_categories as C', 'F.category_id = C.category_id');
        $query = $this->db->get();
        return $query->result();
    }

    function getFaq($fid) {
        $this->db->where('faq_id', $fid);
        $query = $this->db->get('wi_faqs');
        return $query->row();
    }

    function createFaq($set) {
        $this->db->insert('wi_faqs', $set);
        return "I";
    }

    function updateFaq($set) {
        $faqid = $set['faqid'];
        unset($set['faqid']);
        $this->db->update('wi_faqs', $set, array('faq_id' => $faqid));
        return "U";
    }

    function setAction() {

        $ids = $this->input->post('faq');
        if (is_array($ids) && count($ids) > 0) {
            foreach ($ids as $value) {
                $this->db->delete('wi_faqs', array('faq_id' => $value));
            }
            $msg = "D";
        } else {
            $msg = FALSE;
        }
        return $msg;
    }

    //----------------------------Blog Category-------------------------------//
    function getFaqCategoryDetail() {
        $this->db->select('C.category_id,category_name,order,count(F.category_id) as totalQ');
        $this->db->from('faq_categories as C');
        $this->db->join('faqs as F', 'C.category_id = F.category_id', 'left outer');
        $this->db->group_by('F.category_id');
        $this->db->order_by('order', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function getFaqCategory($cid) {
        $this->db->where('category_id', $cid);
        $query = $this->db->get('wi_faq_categories');
        return $query->row();
    }

    function createFaqCategory($set) {
        $this->db->insert('wi_faq_categories', $set);
        return TRUE;
    }

    function updateFaqCategory($set) {
        $cid = $set['categoryid'];
        unset($set['categoryid']);
        $this->db->update('wi_faq_categories', $set, array('category_id' => $cid));
        return TRUE;
    }

    function delete($type) {
        $msg = "";
        $post = $this->input->post();
        if ($type == "Order") {
            foreach ($post['catid'] as $key => $value) {
                $set['order'] = $post['order'][$key];
                $where['category_id'] = $value;
                $this->db->update('wi_faq_categories', $set, $where);
            }
            $msg = "OU";
        } else if ($type == "Delete") {
            $ids = $post['category'];
            foreach ($ids as $value) {
                $this->db->delete('wi_faq_categories', array('category_id' => $value));
            }
            $msg = "D";
        }
        return $msg;
    }

}
