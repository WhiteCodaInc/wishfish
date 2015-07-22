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
        $myfile = fopen(FCPATH . 'events.txt', "a");
        fwrite($myfile, "\n-----------------$event------------------- \n");
        fwrite($myfile, "Event :" . json_encode($event_json) . "\n");


        switch ($event) {
//            case "customer.created":
//                $cus = $event_json->data->object;
//                $pname = $cus->subscriptions->data[0]->plan->id;
////                fwrite($myfile, "\n----------Plan : $pname---------------- \n");
//                if ($pname != "wishfish-free") {
//                    $user_set = array(
//                        'email' => $cus->email,
//                        'password' => $this->generateRandomString(5),
//                        'customer_id' => $cus->id,
//                        'gateway' => "STRIPE",
//                        'is_set' => 1,
//                        'register_date' => date('Y-m-d H:i:s', $cus->created)
//                    );
//                    $this->db->insert('wi_user_mst', $user_set);
//                    $uid = $this->db->insert_id();
//
//                    $customer = Stripe_Customer::retrieve($cus->id);
//                    $data = array('userid' => $uid);
//                    $this->updateCardDetail($customer, $data);
//                    $customer->metadata = array('userid' => $uid);
//                    $customer->save();
//
//                    $this->sendMail($user_set, $uid);
//                }
//                break;
            case "customer.subscription.created":
//                $customer = Stripe_Customer::retrieve($event_json->data->object->customer);
//                $uid = $customer->metadata->userid;
//                $pname = $event_json->data->object->plan->id;
//
//                $plan_array = array("wishfish-free", "wishfish-personal", "wishfish-enterprise");
//
//                if (in_array($pname, $plan_array)) {
//
//                    $planid = ($pname == "wishfish-free") ? 1 :
//                            (($pname == "wishfish-personal") ? 2 : 3);
//
//                    $pid = $this->insertPlanDetail($uid, $planid, $customer);
//
//                    $data = array('planid' => $pid, 'userid' => $uid);
//                    $this->updateCardDetail($customer, $data);
//                    if ($planid != 1 && !isset($event_json->data->object->metadata->userid)) {
//                        $user_set = array(
//                            'email' => $customer->email,
//                            'password' => $this->generateRandomString(5),
//                            'customer_id' => $customer->id,
//                            'gateway' => "STRIPE",
//                            'is_set' => 1,
//                            'register_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_start)
//                        );
//                        $this->db->insert('wi_user_mst', $user_set);
//                        $uid = $this->db->insert_id();
//
//                        $pid = $this->insertPlanDetail($uid, $planid, $customer);
//                        $this->insertUserSetting($uid);
//                        $this->insertPaymentDetail($pid, $customer);
//                        $this->updateCardDetail($customer, $uid, $pid);
//                        $this->sendMail($user_set, $uid);
//                    } else {
//                        if (isset($event_json->data->object->metadata->userid)) {
//                            $uid = $event_json->data->object->metadata->userid;
//                            $pid = $this->insertPlanDetail($uid, $planid, $customer);
//                        } else {
//                            $pid = $customer->metadata->planid;
//                        }
//                        $this->insertPaymentDetail($pid, $customer);
//                    }
//                } else {
//                    $ptype = $event_json->data->object->metadata->payment_type;
//                    $uid = $event_json->data->object->metadata->userid;
//                    $planid = $event_json->data->object->metadata->planid;
//                    fwrite($myfile, "------------$ptype------------\n");
//                    fwrite($myfile, "------------$uid------------\n");
//                    fwrite($myfile, "------------$planid------------\n");
//                    $pid = $this->insertPlanDetail($uid, $planid, $customer, $ptype);
//                    $this->insertPaymentDetail($pid, $customer);
//                }
                break;
            case "invoice.payment_succeeded":
                $inv = $event_json->data->object;
                fwrite($myfile, "------------CUSTOMER : $inv->customer------------\n");
                $customer = Stripe_Customer::retrieve($inv->customer);
                $uid = $customer->metadata->userid;
                $pid = $customer->metadata->planid;
                fwrite($myfile, "------------PLAN ID : $pid------------\n");
                $this->insertPaymentDetail($pid, $inv->charge, $customer);
                if (isset($customer->metadata->coupon)) {
                    $data = array('planid' => $pid, 'userid' => $uid);
                    $this->updateCardDetail($customer, $data);
                }
                break;
//            case "customer.subscription.deleted":
//                $customer = Stripe_Customer::retrieve($event_json->data->object->customer);
//                $subsid = $event_json->data->object->id;
//                $userid = $customer->metadata->userid;
//
//                $userInfo = $this->wi_common->getUserInfo($userid);
//                $this->db->select('*');
//                $query = $this->db->get_where('wi_payment_mst', array('transaction_id' => $subsid));
//                $res = $query->row();
//                $set = array(
//                    'plan_status' => 0,
//                    'cancel_date' => date('Y-m-d')
//                );
//                $where = array(
//                    'id' => $res->id
//                );
//                $this->db->update('wi_plan_detail', $set, $where);
//
//                if ($this->isFreePlan($res)) {
//                    if ($userInfo->is_bill) {
//                        $customer->subscriptions->create(array(
//                            "plan" => "wishfish-personal",
//                            "metadata" => array("userid" => $userid)
//                        ));
//                    }
//                }
//                break;
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

//    function generateRandomString($length = 5) {
//        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
//    }

    function insertPaymentDetail($pid, $charge, $customer) {

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
            'payment_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_start)
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
