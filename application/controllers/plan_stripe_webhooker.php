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
        $this->load->library('email');
        $this->load->library('parser');
        $this->load->helper('date');
        $this->load->library('common');
        $this->load->library('authex');
        $this->load->model('m_register', 'objregister');
        $this->load->model('m_plan_stripe_webhooker', 'objpayment');
    }

    function index() {

        require_once(FCPATH . 'stripe/lib/Stripe.php');


        $event_json = json_decode(@file_get_contents('php://input', true));

        $data = $this->common->getPaymentGatewayInfo("STRIPE");
        Stripe::setApiKey($data->secret_key);

        $customer_id = $event_json->data->object->customer;
        $customer = Stripe_Customer::retrieve($customer_id);

        $event = $event_json->type;

        $this->objpayment->stripe($customer, $event);

//        if ($event == "customer.subscription.deleted") {
//            $this->objpayment->stripeCancel($customer);
//        } else if ($event == "invoice.payment_succeeded") {
//            $this->objpayment->stripe($customer);
//        }
    }

}
