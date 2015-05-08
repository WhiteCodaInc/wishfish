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
    }

    function stripe($payment, $event_type) {

        switch ($event_type) {
            case "invoice.payment_succeeded":
                $pname = $payment->subscriptions->data[0]->plan->id;


                $planid = ($pname == "wishfish-free") ? 1 :
                        (($pname == "wishfish-personal") ? 2 : 3);

                if (isset($payment->metadata->userid)) {
                    $userid = $payment->metadata->userid;
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

                        $pid = $this->insertPlanDetail($userid, $planid, $payment);
                        $this->insertPaymentDetail($pid, $payment);
                    }
                } else {
                    $user_set = array(
                        'email' => $payment->email,
                        'password' => $this->generateRandomString(5),
                        'customer_id' => $payment->id,
                        'register_date' => date('Y-m-d', $payment->subscriptions->data[0]->current_period_start)
                    );
                    $this->db->insert('user_mst', $user_set);
                    $uid = $this->db->insert_id();
                    $pid = $this->insertPlanDetail($uid, $planid, $payment);
                    $this->insertPaymentDetail($pid, $payment);
                    $this->updateCardDetail($payment, $uid);
                    $this->sendMail($user_set);
                }
                break;
            case "customer.subscription.deleted":
                $customerid = $payment->id;
                if ($payment->deleted == "true") {
                    $this->db->select('*');
                    $query = $this->db->get_where('payment_mst', array('payer_id' => $customerid));
                    $this->db->update('plan_detail', array('plan_status' => 0, 'cancel_date' => date('Y-m-d')), array('id' => $query->row()->id));
                }
                break;
        }
    }

    function generateRandomString($length = 5) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    function insertPlanDetail($userid, $planid, $payment) {
        $amount = $payment->subscriptions->data[0]->plan->amount / 100;
        $planInfo = $this->common->getPlan($planid);
        $plan_set = array(
            'user_id' => $userid,
            'plan_id' => $planid,
            'contacts' => $planInfo->contacts,
            'events' => $planInfo->events,
            'amount' => $amount,
            'plan_status' => 1,
            'start_date' => date('Y-m-d', $payment->subscriptions->data[0]->current_period_start),
            'expiry_date' => date('Y-m-d', $payment->subscriptions->data[0]->current_period_end)
        );
        $this->db->insert('plan_detail', $plan_set);
        return $this->db->insert_id();
    }

    function insertPaymentDetail($pid, $payment) {
        $amount = $payment->subscriptions->data[0]->plan->amount / 100;
        $insert_set = array(
            'id' => $pid,
            'payer_id' => $payment->id,
            'payer_email' => $payment->email,
            'mc_gross' => $amount,
            'mc_fee' => ($amount * 0.029) + 0.30,
            'gateway' => "STRIPE",
            'payment_date' => date('Y-m-d', $payment->subscriptions->data[0]->current_period_start)
        );
        $this->db->insert('payment_mst', $insert_set);
    }

    function updateCardDetail($payment, $uid) {
        $gatewayInfo = $this->common->getPaymentGatewayInfo("STRIPE");
        require_once(FCPATH . 'stripe/lib/Stripe.php');
        Stripe::setApiKey($gatewayInfo->secret_key);
        $customer = Stripe_Customer::retrieve($payment->id);
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
