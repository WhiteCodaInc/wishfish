<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paypal extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('paypal_lib');
    }

    function index() {
        $post = $this->input->post();
        $this->session->set_userdata($post);
        $gatewayInfo = $this->common->getPaymentGatewayInfo("PAYPAL");
        $this->paypal_lib->set_acct_info($gatewayInfo->api_username, $gatewayInfo->api_password, $gatewayInfo->api_signature);

        $requestParams = array(
            'RETURNURL' => site_url() . 'paypal/consolidate',
            'CANCELURL' => site_url() . 'home',
        );

        $recurring = array(
            'L_BILLINGTYPE0' => 'RecurringPayments',
            'L_BILLINGAGREEMENTDESCRIPTION0' => $post['item_name']
        );
        $response = $this->paypal_lib->request('SetExpressCheckout', $requestParams + $recurring);

        if (is_array($response) && $response['ACK'] == 'Success') { //Request successful
            $token = $response['TOKEN'];

            if ($this->paypal_lib->is_sandbox)
                echo 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token);
            else
                echo 'https://www.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token);
        } else {
            return false;
        }
    }

    function consolidate() {

        echo '<pre>';
        print_r($this->session->all_userdata());
        die();

        if ($this->input->get('token')) { // Token parameter exists
            $gatewayInfo = $this->common->getPaymentGatewayInfo("PAYPAL");
            $this->paypal_lib->set_acct_info(
                    $gatewayInfo->api_username, $gatewayInfo->api_password, $gatewayInfo->signature
            );

            $checkoutDetails = $this->paypal_lib->request('GetExpressCheckoutDetails', array('TOKEN' => $this->input->get('token')));

            // Complete the checkout transaction
            $requestParams = array(
                'TOKEN' => $this->input->get('token'),
                'PROFILESTARTDATE' => $checkoutDetails['TIMESTAMP'],
                'DESC' => 'Recurring Profile',
                'BILLINGPERIOD' => 'Month',
                'BILLINGFREQUENCY' => 1,
                'TOTALBILLINGCYCLES' => 0,
                'AMT' => 9.99,
                'INITAMT' => 9.99,
                'CURRENCYCODE' => 'USD',
                'MAXFAILEDPAYMENTS' => 3,
                'FAILEDINITAMTACTION' => 'CancelOnFailure'
            );

            $response = $this->paypal_lib->request('CreateRecurringPaymentsProfile', $requestParams);
            if (is_array($response) && $response['ACK'] == 'Success') { // Payment successful
                //$this->objrecurring->expressCO($set['recurid']);
                $this->session->set_flashdata('msg', "success");
            } else {
                $this->session->set_flashdata('error', $response['ACK']);
            }
            header('Location:' . site_url() . 'app/profile/expressCO');
        }
    }

    function cancelled() {
        header('location:' . site_url() . 'client/client_recurring');
    }

}

/* End of file welcome.php */
    /* Location: ./application/controllers/welcome.php */    