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

    function stripe($payment) {

        /*if (file_exists('stripedata.txt')) {
            $myfile = fopen(FCPATH . 'stripedata.txt', "a");
            fwrite($myfile, "Customer : " . $payment . "\n");
        } else {
            $myfile = fopen(FCPATH . 'stripedata.txt', "w");
            fwrite($myfile, "Customer : " . $payment . "\n");
        }*/

        $planid = $payment->metadata->planid;

//        fwrite($myfile, "PLAN ID : " . $planid . "\n");

        if (isset($payment->metadata->userid)) {
            $userid = $payment->metadata->userid;
//            fwrite($myfile, "USER Exists : " . $userid . "\n");
        } else {
//            fwrite($myfile, "USER Not Exists..!\n");
        }
        $amount = $payment->subscriptions->data[0]->plan->amount / 100;



        if (isset($userid)) {
            $where = array(
                'U.user_id' => $userid,
                'P.plan_status' => 1
            );
        } else {
            $where = array(
                'U.email' => $payment->email,
                'P.plan_status' => 1
            );
        }
        $this->db->select('*');
        $this->db->from('plan_detail as P');
        $this->db->join('user_mst as U', 'P.user_id = U.user_id');
        $this->db->where($where);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
//            fwrite($myfile, "Record Exists..!\n");
            // Deactive Old Plan
            $deactive_set = array(
                'plan_status' => 0
            );
            $deactive_where = array(
                'id' => $query->row()->id
            );
            $this->db->update('plan_detail', $deactive_set, $deactive_where);
        }
//        fwrite($myfile, "Record Not Exists..!\n");
        //-------Insert User Data----------------------//
        $this->db->trans_start();
        if (isset($userid)) {
            $uid = $userid;
//            fwrite($myfile, " {$uid} Record Found..!\n");
        } else {
            $user_set = array(
                'email' => $payment->email,
                'password' => $this->generateRandomString(5),
                'register_date' => date('Y-m-d', $payment->subscriptions->data[0]->current_period_start)
            );
            $this->db->insert('user_mst', $user_set);
            $uid = $this->db->insert_id();
//            fwrite($myfile, " {$uid} Record Inserted..!\n");
        }
        //--------------------------------------------//
        //-------Insert Plan Detail----------------------//
        $planInfo = $this->common->getPlan($planid);
//        fwrite($myfile, " Plan {$planInfo->plan_name} ..!\n");
        $plan_set = array(
            'user_id' => $uid,
            'plan_id' => $planid,
            'contacts' => $planInfo->contacts,
            'events' => $planInfo->events,
            'amount' => $amount,
            'plan_status' => 1,
            'start_date' => date('Y-m-d', $payment->subscriptions->data[0]->current_period_start),
            'expiry_date' => date('Y-m-d', $payment->subscriptions->data[0]->current_period_end)
        );
        $this->db->insert('plan_detail', $plan_set);
        $pid = $this->db->insert_id();
//        fwrite($myfile, " {$pid} Plan Detail Inserted..!\n");
        //--------------------------------------------//
        //-------Insert Payment Detail----------------------//
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
        $payid = $this->db->insert_id();
//        fwrite($myfile, " {$payid} Payment Inserted..!\n");
        //--------------------------------------------//
        $this->db->trans_complete();
        $this->sendMail($user_set);
    }

    function stripeCancel($payment) {
        $customerid = $payment->id;
        if ($payment->deleted == "true") {
            $this->db->select('*');
            $query = $this->db->get_where('payment_mst', array('payer_id' => $customerid));
            $this->db->update('plan_detail', array('plan_status' => 0, 'cancel_date' => date('Y-m-d')), array('id' => $query->row()->id));
        }
        return true;
    }

    function generateRandomString($length = 5) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
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
