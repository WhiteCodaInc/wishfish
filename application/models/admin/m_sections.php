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
class M_sections extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getPages() {
        $query = $this->db->get('sections');
        return $query->result();
    }

    function getContent($sectionid) {
        $query = $this->db->get_where('sections', array('section_id' => $sectionid));
        return $query->row()->content;
    }

    function update($post) {
        $this->db->update('sections', array('content' => $post['content']), array('section_id' => $post['sectionid']));
    }

}
