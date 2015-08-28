<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of trigger
 *
 * @author Laxmisoft
 */
class Plan_trigger extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_trigger', 'objtrigger');
        $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
    }

    function index() {
        $res = $this->objtrigger->getPlanDetail();
        echo '<pre>';
        foreach ($res as $value) {
            $uInfo = $this->wi_common->getUserInfo($value->user_id);
            print_r($uInfo);
            $this->db->update('wi_plan_detail', array('cancel_by' => 0), array('id' => $value->id));
//            $customer = Stripe_Customer::retrieve($uInfo->customer_id);
//            if (isset($customer->subscriptions->data[0]->id)) {
//                $subs = $customer->subscriptions->data[0]->id;
//                $customer->subscriptions->retrieve($subs)->cancel();
//            }
        }
    }

}
