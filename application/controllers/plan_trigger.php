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

        foreach ($res as $value) {
            $uInfo = $this->wi_common->getUserInfo($value->user_id);
            $customer = Stripe_Customer::retrieve($uInfo->customer_id);

//            $this->db->update('wi_plan_detail', array('cancel_by' => 0), array('id' => $value->id));
//            echo '<pre>';
//            print_r($res);
//            print_r($customer);
//            die();

            $set = array(
                'cancel_by' => 0,
                'plan_status' => 0,
                'cancel_date' => date('Y-m-d')
            );
            $where = array(
                'id' => $value->id
            );
            $this->db->update('wi_plan_detail', $set, $where);

            if (isset($customer->subscriptions->data[0]->id)) {

                $subs = $customer->subscriptions->data[0]->id;

//                $myfile = fopen(FCPATH . 'canceled.txt', "a");
//                fwrite($myfile, "\n-----------------$subs------------------- \n");
//                fwrite($myfile, "User Id :" . $uInfo->user_id . "\n");
//                fwrite($myfile, "Name :" . $uInfo->name . "\n");

                $customer->subscriptions->retrieve($subs)->cancel();
            }

            if ($uInfo->is_bill) {
                $pid = $this->insertPlanDetail($uInfo->user_id, 2);
                $data = array('planid' => $pid, 'userid' => $uInfo->user_id);
                $this->updateCardDetail($customer, $data);
                $customer->subscriptions->create(array("plan" => "wishfish-personal"));
            }
        }
    }

    function insertPlanDetail($userid, $planid) {

        $planInfo = $this->wi_common->getPlan($planid);
        $startDt = date('Y-m-d');
        $plan_set = array(
            'user_id' => $userid,
            'plan_id' => $planid,
            'contacts' => $planInfo->contacts,
            'sms_events' => $planInfo->sms_events,
            'email_events' => $planInfo->email_events,
            'group_events' => $planInfo->group_events,
            'amount' => $planInfo->amount,
            'plan_status' => 1,
            'start_date' => $startDt
        );
        $this->db->insert('wi_plan_detail', $plan_set);
        return $this->db->insert_id();
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
