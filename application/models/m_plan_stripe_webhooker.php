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
        $gatewayInfo = $this->common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
    }

    function stripe($event_json) {
        $event = $event_json->type;
        $myfile = fopen(FCPATH . 'events.txt', "a");
        fwrite($myfile, "Event :" . $event . "\n");
        fwrite($myfile, "\n");
        switch ($event) {
            case "customer.subscription.created":
                $customer = Stripe_Customer::retrieve($event_json->data->object->customer);
                $pname = $event_json->object->plan->id;
                $planid = ($pname == "wishfish-free") ? 1 :
                        (($pname == "wishfish-personal") ? 2 : 3);
                if ($pname != "test") {
                    $user_set = array(
                        'email' => $customer->email,
                        'password' => $this->generateRandomString(5),
                        'customer_id' => $customer->id,
                        'register_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_start)
                    );
                    $this->db->insert('user_mst', $user_set);
                    $uid = $this->db->insert_id();
                    $pid = $this->insertPlanDetail($uid, $planid, $customer);
                    $this->insertPaymentDetail($pid, $customer);
                    $this->updateCardDetail($customer, $uid, $pid);
                    $this->sendMail($user_set);
                } else {
                    $pid = $customer->metadata->planid;
                    $this->insertPaymentDetail($pid, $customer);
                }
                break;
            case "invoice.payment_succeeded":
                /*
                  $customer = Stripe_Customer::retrieve($event_json->data->object->customer);
                  $pname = $event_json->lines->data[0]->plan->id;
                  $planid = ($pname == "wishfish-free") ? 1 :
                  (($pname == "wishfish-personal") ? 2 : 3);
                  if (isset($customer->metadata->userid)) {
                  $userid = $customer->metadata->userid;
                  $check_where = array(
                  'user_id' => $userid
                  );
                  $query = $this->db->get_where('plan_detail', $check_where);
                  if ($query->num_rows() > 1) {
                  $check_where['plan_status'] = 1;
                  $set = array(
                  'plan_status' => 0
                  );
                  $query = $this->db->get_where('plan_detail', $check_where);
                  $this->db->update('plan_detail', $set, array('id' => $query->row()->id));

                  $pid = $this->insertPlanDetail($userid, $planid, $customer);
                  $this->insertPaymentDetail($pid, $customer);
                  }
                  } else {
                  $user_set = array(
                  'email' => $customer->email,
                  'password' => $this->generateRandomString(5),
                  'customer_id' => $customer->id,
                  'register_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_start)
                  );
                  $this->db->insert('user_mst', $user_set);
                  $uid = $this->db->insert_id();
                  $pid = $this->insertPlanDetail($uid, $planid, $customer);
                  $this->insertPaymentDetail($pid, $customer);
                  $this->updateCardDetail($customer, $uid);
                  $this->sendMail($user_set);
                  }
                 * 
                 */
                break;
            case "customer.subscription.deleted":
                $customer = Stripe_Customer::retrieve($event_json->data->object->customer);
                $subsid = $event_json->data->object->id;
                $userid = $customer->metadata->userid;
                $userInfo = $this->common->getUserInfo($userid);

                $this->db->select('*');
                $query = $this->db->get_where('payment_mst', array('transaction_id' => $subsid));
                $set = array(
                    'plan_status' => 0,
                    'cancel_date' => date('Y-m-d')
                );
                $where = array(
                    'id' => $query->row()->id
                );
                $this->db->update('plan_detail', $set, $where);

                if ($this->isFreePlan($query->row())) {
                    if ($userInfo->is_bill) {
                        $customer->subscriptions->create(array("plan" => "wishfish-personal"));
                    }
                }
                break;

            case "customer.subscription.trial_will_end":
                /*
                  $userid = $customer->metadata->userid;
                  $userInfo = $this->common->getUserInfo($userid);
                  $subs = $customer->subscriptions->data[0]->id;
                  $customer->subscriptions->retrieve($subs)->cancel();
                  if ($userInfo->is_bill) {
                  $customer->subscriptions->create(array("plan" => "wishfish-personal"));
                  } else {
                  $where = array(
                  'user_id' => $userid,
                  'plan_status' => 1
                  );
                  $this->db->update('plan_detail', array('plan_status' => 0), $where);
                  }
                 * 
                 */
                break;
        }
    }

//    function writeFile() {
//        if (file_exists('stripedata.txt')) {
//            $myfile = fopen(FCPATH . 'stripedata.txt', "a");
//            fwrite($myfile, "Customer : " . $customer);
//            fwrite($myfile, "\n");
//        } else {
//            $myfile = fopen(FCPATH . 'stripedata.txt', "w");
//            fwrite($myfile, "Customer : " . $customer . "\n");
//        }
//    }

    function isFreePlan($res) {
        $query = $this->db->get_where('plan_detail', array('id' => $res->id));
        ($query->row()->plan_id == 1) ? TRUE : FALSE;
    }

    function generateRandomString($length = 5) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    function insertPlanDetail($userid, $planid, $customer) {
        $amount = $customer->subscriptions->data[0]->plan->amount / 100;
        $planInfo = $this->common->getPlan($planid);
        $plan_set = array(
            'user_id' => $userid,
            'plan_id' => $planid,
            'contacts' => $planInfo->contacts,
            'events' => $planInfo->events,
            'amount' => $amount,
            'plan_status' => 1,
            'start_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_start),
            'expiry_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_end)
        );
        $this->db->insert('plan_detail', $plan_set);
        return $this->db->insert_id();
    }

    function insertPaymentDetail($pid, $customer) {
        $amount = $customer->subscriptions->data[0]->plan->amount / 100;
        $insert_set = array(
            'id' => $pid,
            'transaction_id' => $customer->subscriptions->data[0]->id,
            'payer_id' => $customer->id,
            'payer_email' => $customer->email,
            'mc_gross' => $amount,
            'mc_fee' => ($amount * 0.029) + 0.30,
            'payment_date' => date('Y-m-d', $customer->subscriptions->data[0]->current_period_start)
        );
        $this->db->insert('payment_mst', $insert_set);
    }

    function updateCardDetail($customer, $uid) {
        try {
            $customer->metadata = array('userid' => $uid);
            $customer->save();
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }

    function sendMail($post) {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => "ssl://smtp.googlemail.com",
            'smtp_port' => "465",
            'smtp_user' => "sanjayvekariya18@gmail.com", // change it to yours
            'smtp_pass' => "MyD@te18021991" // change it to yours
        );
        $subject = "Welcome To our Wish-Fish, Login Details";
        $body = "Dear User," . '<br>';
        $body .= "Thank you for register on Wish-Fish." . '<br>';
        $body .= "Your account login detail is below : " . '<br>';
        $body .= "Email  : {$post['email']} " . '<br>';
        $body .= "Password  : {$post['password']} " . '<br>';

        $this->load->library('email', $config);
        $this->email->from("info@mikhailkuznetsov.com", "Mikhail");
        $this->email->to($post['email']);
        $this->email->subject($subject);
        $this->email->message($body);
        if ($this->email->send()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
