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
class M_products extends CI_Model {

    private $affid;

    function __construct() {
        parent::__construct();
        $this->affid = $this->session->userdata('a_affid');
    }

    function getProductDetail() {
        $this->db->select('*');
        $this->db->distinct('M.offer_id');
        $this->db->from('multiple_affiliate_offer as M');
        $this->db->join('affiliate_offers as O', 'M.offer_id = O.offer_id', 'left outer');
        $this->db->join('products as P', 'O.product_id = P.product_id', 'left outer');
        $this->db->join('payment_plan as PL', 'O.payment_plan_id = PL.payment_plan_id', 'left outer');
        $this->db->where('M.affiliate_id', $this->affid);
        $this->db->where('O.status', '1');
        $query = $this->db->get();
//        echo '<pre>';
//        print_r($query->result());
//        die();
        return $query->result();
    }

}
