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
class M_offers extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getOffers() {
        $this->db->select('*');
        $this->db->from('offers as O');
        $this->db->join('products as P', 'O.product_id = P.product_id', 'left outer');
        $this->db->join('payment_plan as PL', 'O.payment_plan_id = O.payment_plan_id', 'left outer');
        $query = $this->db->get();
        return $query->result();
    }

    function getOffer($oid) {
        $query = $this->db->get_where('offers', array('offer_id' => $oid));
        return $query->row();
    }

    function createOffer($set) {
        $this->db->insert('offers', $set);
        return TRUE;
    }

    function updatePlan($set) {
        $oid = $set['offerid'];
        unset($set['offerid']);
        $this->db->update('offers', $set, array('offer_id' => $oid));
        return TRUE;
    }

    function setAction($type, $ids) {
        $msg = "";
        $where = 'offer_id IN (' . implode(',', $ids) . ')';
        $this->db->where($where);
        switch ($type) {
            case "Active":
                $this->db->update('offers', array('status' => 1));
                $msg = "A";
                break;
            case "Deactive":
                $this->db->update('offers', array('status' => 0));
                $msg = "DA";
                break;
            case "Delete":
                $this->db->delete('offers');
                $msg = "D";
                break;
        }
        return $msg;
    }

}
