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
class M_pages extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getPages() {
        $this->db->where_not_in('name', array('terms-of-services', 'commercial-terms'));
        $query = $this->db->get('pages');
        return $query->result();
    }

    function getTerm() {
        $query = $this->db->get_where('pages', array('name' => 'terms-of-services'));
        return $query->row();
    }

    function getCommercialTerm() {
        $query = $this->db->get_where('pages', array('name' => 'commercial-terms'));
        return $query->row();
    }

    function getContent($pageid) {
        $query = $this->db->get_where('pages', array('page_id' => $pageid));
        return $query->row()->content;
    }

    function update($post) {
        $this->db->update('pages', array('content' => $post['content']), array('page_id' => $post['pageid']));
    }

    function updateTerm($post) {
        $this->db->update('pages', array('content' => $post['content']), array('name' => 'terms-of-services'));
    }

    function updateCommercialTerm($post) {
        $this->db->update('pages', array('content' => $post['content']), array('name' => 'commercial-terms'));
    }

}
