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
        $this->db->order_by('title', 'asc');
        $query = $this->db->get('pages');
        return $query->result();
    }

    function getContent($pageid) {
        $query = $this->db->get_where('pages', array('page_id' => $pageid));
        if ($query->num_rows()) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function update($post) {
        $this->db->update('pages', array('content' => $post['content']), array('page_id' => $post['pageid']));
    }

}
