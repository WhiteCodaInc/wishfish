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
class M_upgrade extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->userid = $this->session->userdata('u_userid');
    }

    function insertPlanDetail($planid, $customer, $set) {
        $amount = $customer->subscriptions->data[0]->plan->amount / 100;
        $planInfo = $this->wi_common->getPlan($planid);

        $startDt = date('Y-m-d', $customer->subscriptions->data[0]->current_period_start);

        if ($set['coupon'] != "") {
            $coupon = $this->getCoupon($set['coupon']);
            $amount = ($coupon->disc_type == "F") ?
                    $amount - $coupon->disc_amount :
                    $amount - ($amount * ($coupon->disc_amount / 100));
        }

        $plan_set = array(
            'user_id' => $this->userid,
            'plan_id' => $planid,
            'contacts' => $planInfo->contacts,
            'sms_events' => $planInfo->sms_events,
            'email_events' => $planInfo->email_events,
            'group_events' => $planInfo->group_events,
            'amount' => $amount,
            'plan_status' => 1,
            'start_date' => $startDt
        );
        $this->db->insert('wi_plan_detail', $plan_set);
        return $this->db->insert_id();
    }

    function getCoupon($code) {
        $where = array(
            'coupon_code' => $code
        );
        $query = $this->db->get_where('coupons', $where);
        return $query->row();
    }

}
