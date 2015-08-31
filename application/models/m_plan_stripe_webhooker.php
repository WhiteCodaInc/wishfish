<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of stripe_webhooker
 *
 * @author Laxmisoft
 */
class M_plan_stripe_webhooker extends CI_Model {

//put your code here
    function __construct() {
        parent::__construct();
        $gatewayInfo = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
    }

    function stripe($event_json) {
        $event = $event_json->type;

//        $customer_id = $event_json->data->object->customer;
//        $customer = Stripe_Customer::retrieve($customer_id);
//        
//        $myfile = fopen(FCPATH . 'events.txt', "a");
//        fwrite($myfile, "\n-----------------$event------------------- \n");
//        fwrite($myfile, "Event :" . json_encode($event_json) . "\n");


        switch ($event) {
            case "invoice.payment_succeeded":
                $inv = $event_json->data->object;

                $customer = Stripe_Customer::retrieve($inv->customer);
                $uid = $customer->metadata->userid;
                $pid = $customer->metadata->planid;
//                $curPlan = $this->wi_common->getCurrentPlan($uid);

                if ($inv->lines->data[0]->amount != '0') {
                    $this->insertPaymentDetail($pid, $inv->charge, $customer);
                    if (isset($customer->metadata->coupon)) {
                        $data = array('planid' => $pid, 'userid' => $uid);
                        $this->updateCardDetail($customer, $data);
                    }
                }
                break;
            case "customer.subscription.deleted":
                $customer = Stripe_Customer::retrieve($event_json->data->object->customer);
                $subsid = $event_json->data->object->id;
//                $userid = $customer->metadata->userid;
//                $userInfo = $this->wi_common->getUserInfo($userid);
                $this->db->select('*');
                $query = $this->db->get_where('wi_payment_mst', array('transaction_id' => $subsid));
                $res = $query->row();
                $set = array(
                    'plan_status' => 0,
                    'cancel_date' => date('Y-m-d')
                );
                $where = array(
                    'id' => $res->id
                );
                $this->db->update('wi_plan_detail', $set, $where);

                /* if ($this->isFreePlan($res)) {
                  if ($userInfo->is_bill) {
                  $customer->subscriptions->create(array(
                  "plan" => "wishfish-personal",
                  "metadata" => array("userid" => $userid)
                  ));
                  }
                  } */
                break;
            case "customer.subscription.trial_will_end":
                /*
                  $userid = $customer->metadata->userid;
                  $userInfo = $this->wi_common->getUserInfo($userid);
                  $subs = $customer->subscriptions->data[0]->id;
                  $customer->subscriptions->retrieve($subs)->cancel();
                  if ($userInfo->is_bill) {
                  $customer->subscriptions->create(array("plan" => "wishfish-personal"));
                  } else {
                  $where = array(
                  'user_id' => $userid,
                  'plan_status' => 1
                  );
                  $this->db->update('wi_plan_detail', array('plan_status' => 0), $where);
                  }
                 * 
                 */
                break;
        }
    }

    function isFreePlan($res) {
        $query = $this->db->get_where('wi_plan_detail', array('id' => $res->id));
        return ($query->row()->plan_id == 1) ? TRUE : FALSE;
    }

    function insertPaymentDetail($pid, $charge, $customer) {
        $this->timezone = "UM8";
        $datetime = date('Y-m-d H:i:s', gmt_to_local(time(), $this->timezone, TRUE));

        $amount = $customer->subscriptions->data[0]->plan->amount / 100;

        if (isset($customer->metadata->coupon)) {
            $coupon = $this->getCoupon($customer->metadata->coupon);
            $amount = ($coupon->disc_type == "F") ?
                    $amount - $coupon->disc_amount :
                    $amount - ($amount * ($coupon->disc_amount / 100));
        }
        $insert_set = array(
            'id' => $pid,
            'transaction_id' => $customer->subscriptions->data[0]->id,
            'invoice_id' => $charge,
            'payer_id' => $customer->id,
            'payer_email' => $customer->email,
            'mc_gross' => $amount,
            'mc_fee' => ($amount != 0) ? ($amount * 0.029) + 0.30 : 0,
            'gateway' => "STRIPE",
            'payment_date' => $datetime
//            'payment_date' => date('Y-m-d H:i:s', $customer->subscriptions->data[0]->current_period_start)
        );
        $this->db->insert('wi_payment_mst', $insert_set);
    }

    function updateCardDetail($customer, $data) {
        try {
            $customer->metadata = $data;
            $customer->save();
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }

}
