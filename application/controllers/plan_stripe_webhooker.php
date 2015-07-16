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
class Plan_stripe_webhooker extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_register', 'objregister');
        $this->load->model('m_plan_stripe_webhooker', 'objpayment');
    }

    function index() {

        require_once(FCPATH . 'stripe/lib/Stripe.php');
        $event_json = json_decode(@file_get_contents('php://input', true));

        $data = $this->wi_common->getPaymentGatewayInfo("STRIPE");
        Stripe::setApiKey($data->secret_key);
//        $customer_id = $event_json->data->object->customer;
//        $customer = Stripe_Customer::retrieve($customer_id);
//        $myfile = fopen(FCPATH . 'events.txt', "a");
//        fwrite($myfile, "Event :" . $customer . "\n");
        $this->objpayment->stripe($event_json);
    }

}
