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

    function getSections() {
        $query = $this->db->get('sections');
        return $query->result();
    }

    function getContent($sectionid) {
        $query = $this->db->get_where('sections', array('section_id' => $sectionid));
        $section['title'] = $query->row()->title;
        $section['content'] = $query->row()->content;
        echo json_encode($section);
    }

    function update($post) {
        $secid = $post['sectionid'];
        unset($post['sectionid']);
        $this->db->update('sections', $post, array('section_id' => $secid));
    }

}
