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

    private $profileid;

    function __construct() {
        parent::__construct();
        $this->profileid = $this->session->userdata('profileid');
    }

    function getProducts() {
        $query = $this->db->get('products');
        return $query->result();
    }

    function getProduct($pid) {
        $query = $this->db->get_where('products', array('product_id' => $pid));
        return $query->row();
    }

    function createProduct($set) {
        $this->db->insert('products', $set);
        return TRUE;
    }

    function updateProduct($set) {
        $pid = $set['productid'];
        unset($set['productid']);
        $this->db->update('products', $set, array('product_id' => $pid));
        return TRUE;
    }

    function setAction() {
        $ids = $this->input->post('products');
        foreach ($ids as $value) {
            $this->db->delete('products', array('product_id' => $value));
        }
    }

}
