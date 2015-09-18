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
class M_admin_access extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getAdminAccessClass() {
        $query = $this->db->get_where('privilage');
        return $query->result();
    }

    function addClass($post) {
        if ($this->db->insert('privilage', $post)) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    function getPermission($post) {
        $query = $this->db->get_where('privilage', array('class_id' => $post['class_id']));
        return $query->row();
    }

    function addPermission($post) {
        $set = array(
            'admin' => (isset($post['admin']) ? 1 : 0),
            'cal' => (isset($post['cal']) ? 1 : 0),
            'coni' => (isset($post['coni']) ? 1 : 0),
            'conu' => (isset($post['conu']) ? 1 : 0),
            'cond' => (isset($post['cond']) ? 1 : 0),
            'congi' => (isset($post['congi']) ? 1 : 0),
            'congu' => (isset($post['congu']) ? 1 : 0),
            'congd' => (isset($post['congd']) ? 1 : 0),
            'cbl' => (isset($post['cbl']) ? 1 : 0),
            'affi' => (isset($post['affi']) ? 1 : 0),
            'affu' => (isset($post['affu']) ? 1 : 0),
            'affd' => (isset($post['affd']) ? 1 : 0),
            'affgi' => (isset($post['affgi']) ? 1 : 0),
            'affgu' => (isset($post['affgu']) ? 1 : 0),
            'affgd' => (isset($post['affgd']) ? 1 : 0),
            'cusu' => (isset($post['cusu']) ? 1 : 0),
            'cusd' => (isset($post['cusd']) ? 1 : 0),
            'cusgi' => (isset($post['cusgi']) ? 1 : 0),
            'cusgu' => (isset($post['cusgu']) ? 1 : 0),
            'cusgd' => (isset($post['cusgd']) ? 1 : 0),
            'smsi' => (isset($post['smsi']) ? 1 : 0),
            'smsb' => (isset($post['smsb']) ? 1 : 0),
            'smslbi' => (isset($post['smslbi']) ? 1 : 0),
            'smslbu' => (isset($post['smslbu']) ? 1 : 0),
            'smslbd' => (isset($post['smslbd']) ? 1 : 0),
            'smsti' => (isset($post['smsti']) ? 1 : 0),
            'smstu' => (isset($post['smstu']) ? 1 : 0),
            'smstd' => (isset($post['smstd']) ? 1 : 0),
            'emailm' => (isset($post['emailm']) ? 1 : 0),
            'emailb' => (isset($post['emailb']) ? 1 : 0),
            'emaillbi' => (isset($post['emaillbi']) ? 1 : 0),
            'emaillbu' => (isset($post['emaillbu']) ? 1 : 0),
            'emaillbd' => (isset($post['emaillbd']) ? 1 : 0),
            'emailti' => (isset($post['emailti']) ? 1 : 0),
            'emailtu' => (isset($post['emailtu']) ? 1 : 0),
            'emailtd' => (isset($post['emailtd']) ? 1 : 0),
            'emailn' => (isset($post['emailn']) ? 1 : 0),
            'emailai' => (isset($post['emailai']) ? 1 : 0),
            'emailau' => (isset($post['emailau']) ? 1 : 0),
            'emailad' => (isset($post['emailad']) ? 1 : 0),
            'smssi' => (isset($post['smssi']) ? 1 : 0),
            'smssu' => (isset($post['smssu']) ? 1 : 0),
            'cals' => (isset($post['cals']) ? 1 : 0),
            'pays' => (isset($post['pays']) ? 1 : 0),
            'faqi' => (isset($post['faqi']) ? 1 : 0),
            'faqu' => (isset($post['faqu']) ? 1 : 0),
            'faqd' => (isset($post['faqd']) ? 1 : 0),
            'faqci' => (isset($post['faqci']) ? 1 : 0),
            'faqcu' => (isset($post['faqcu']) ? 1 : 0),
            'faqcd' => (isset($post['faqcd']) ? 1 : 0),
            'webp' => (isset($post['webp']) ? 1 : 0),
            'homes' => (isset($post['homes']) ? 1 : 0),
            'feed' => (isset($post['feed']) ? 1 : 0),
            'coui' => (isset($post['coui']) ? 1 : 0),
            'couu' => (isset($post['couu']) ? 1 : 0),
            'coud' => (isset($post['coud']) ? 1 : 0),
            'totalp' => (isset($post['totalp']) ? 1 : 0),
            'totalu' => (isset($post['totalu']) ? 1 : 0),
            'totalnu' => (isset($post['totalnu']) ? 1 : 0),
            'admr' => (isset($post['admr']) ? 1 : 0),
            'probi' => (isset($post['probi']) ? 1 : 0),
            'probu' => (isset($post['probu']) ? 1 : 0),
            'probd' => (isset($post['probd']) ? 1 : 0),
            'paypi' => (isset($post['paypi']) ? 1 : 0),
            'paypu' => (isset($post['paypu']) ? 1 : 0),
            'paypd' => (isset($post['paypd']) ? 1 : 0),
            'offi' => (isset($post['offi']) ? 1 : 0),
            'offu' => (isset($post['offu']) ? 1 : 0),
            'offd' => (isset($post['offd']) ? 1 : 0),
            'pagb' => (isset($post['pagb']) ? 1 : 0),
            'medi' => (isset($post['medi']) ? 1 : 0),
            'medu' => (isset($post['medu']) ? 1 : 0),
            'medd' => (isset($post['medd']) ? 1 : 0),
            'funi' => (isset($post['funi']) ? 1 : 0),
            'funv' => (isset($post['funv']) ? 1 : 0)
        );
        $where = array('class_id' => $post['class_id']);
        if ($this->db->update('privilage', $set, $where)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
