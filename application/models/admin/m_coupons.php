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
class M_coupons extends CI_Model {

    private $profileid;

    function __construct() {
        parent::__construct();
        $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
        $this->profileid = $this->session->userdata('profile_id');
    }

    function getCoupons() {
        $query = $this->db->get('coupons');
        return $query->result();
    }

    function getCoupon($gid) {
        $query = $this->db->get_where('coupons', array('coupon_id' => $gid));
        return $query->row();
    }

    function createCoupon($set) {

        $coupon = array(
            "id" => $set['coupon_code'],
            "max_redemptions" => $set['no_of_use']
        );
        if ($set['expire'] == "expire") {
            $date = new DateTime($set['expiry_date']);
            $coupon['redeem_by'] = $date->getTimestamp();
            $set['expiry_date'] = date('Y-m-d', strtotime($set['expiry_date']));
        }
        unset($set['expire']);
        $coupon['duration'] = ($set['coupon_validity'] == "1") ? "once" :
                (($set['coupon_validity'] == "2") ? "repeating" : "forever");
        ($set['coupon_validity'] == "2") ?
                        $coupon['duration_in_months'] = $set['month_duration'] : "";
        ($set['disc_type'] == "F") ?
                        $coupon['amount_off'] = $set['disc_amount'] * 100 :
                        $coupon['percent_off'] = $set['disc_amount'];
        ($set['disc_type'] == "F") ? $coupon['currency'] = "USD" : "";

        try {
            Stripe_Coupon::create($coupon);

            $this->db->insert('coupons', $set);
            return TRUE;
        } catch (Stripe_Error $e) {
            $this->session->set_userdata('error', $e->getMessage());
            return FALSE;
        }
    }

    function updateCoupon($set) {
        $gid = $set['couponid'];
        unset($set['couponid']);
        $set['expiry_date'] = date('Y-m-d', strtotime($set['expiry_date']));
        $this->db->update('coupons', $set, array('coupon_id' => $gid));
        return TRUE;
    }

    function setAction($type, $post) {
        $msg = "";
        $where = 'coupon_id in (' . implode(',', $post['coupon']) . ')';
        $this->db->where($where);
        switch ($type) {
            case "Active":
                $this->db->update('coupons', array('status' => 1));
                $msg = "A";
                break;
            case "Deactive":
                $this->db->update('coupons', array('status' => 0));
                $msg = "DA";
                break;
            case "Delete":
                foreach ($post['coupon'] as $key => $value) {
                    try {
                        $cpn = Stripe_Coupon::retrieve($post['code'][$key]);
                        $cpn->delete();
                        $this->db->delete('coupons', array('coupon_id' => $value));
                    } catch (Stripe_Error $e) {
                        
                    }
                }
                $msg = "D";
                break;
        }
        return $msg;
    }

    function isExistCoupon($code) {
        $query = $this->db->get_where('coupons', array('coupon_code' => $code));
        return ($query->num_rows()) ? TRUE : FALSE;
    }

}
