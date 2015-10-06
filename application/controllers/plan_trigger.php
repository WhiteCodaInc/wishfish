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

            $this->db->update('wi_plan_detail', array('cancel_by' => 0), array('id' => $value->id));

//            echo '<pre>';
//            print_r($res);
//            print_r($customer);
//            die();


            if (isset($customer->subscriptions->data[0]->id)) {

                $subs = $customer->subscriptions->data[0]->id;

                $myfile = fopen(FCPATH . 'canceled.txt', "a");
                fwrite($myfile, "\n-----------------$subs------------------- \n");
                fwrite($myfile, "User Id :" . $uInfo->user_id . "\n");
                fwrite($myfile, "Name :" . $uInfo->name . "\n");

                $customer->subscriptions->retrieve($subs)->cancel();
                echo 'Old Plan Canceled..!';
            }

            if ($uInfo->is_bill) {
                $customer->subscriptions->create(array("plan" => "wishfish-personal"));
                echo 'New Plan Registered..!';
            }
        }
    }

}
